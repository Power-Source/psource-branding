<?php
/**
 * Extract literal gettext calls without bootstrapping WordPress.
 * Usage: php scripts/extract-translations.php
 */
$root = dirname( __DIR__ );
$signatures = array(
	'__' => array( 1 ), '_e' => array( 1 ),
	'esc_html__' => array( 1 ), 'esc_attr__' => array( 1 ),
	'esc_html_e' => array( 1 ), 'esc_attr_e' => array( 1 ),
	'_x' => array( 2, 1 ), '_ex' => array( 2, 1 ),
	'esc_html_x' => array( 2, 1 ), 'esc_attr_x' => array( 2, 1 ),
	'_n' => array( 3, null, 1 ), '_nx' => array( 4, 3, 1 ),
	'_n_noop' => array( 2, null, 1 ), '_nx_noop' => array( 3, 2, 1 ),
);
$decode = static function ( $literal ) {
	$text = str_replace( array( "\r\n", "\r" ), "\n", substr( $literal, 1, -1 ) );
	if ( "'" === $literal[0] ) {
		return str_replace( array( '\\\\', "\\'" ), array( '\\', "'" ), $text );
	}
	return preg_replace_callback(
		'/\\\\(?:[nrtvef\\\\$"]|[0-7]{1,3}|x[0-9a-fA-F]{1,2})/',
		static function ( $match ) {
			$escapes = array( 'n' => "\n", 'r' => "\r", 't' => "\t", 'v' => "\v", 'e' => "\x1b", 'f' => "\f", '\\' => '\\', '$' => '$', '"' => '"' );
			$escaped = substr( $match[0], 1 );
			return $escapes[ $escaped ] ?? chr( 'x' === $escaped[0] ? hexdec( substr( $escaped, 1 ) ) : octdec( $escaped ) );
		},
		$text
	);
};
$files = array( $root . '/psource-branding.php' );
foreach ( array( 'etc', 'inc', 'views' ) as $directory ) {
	foreach ( new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $root . '/' . $directory, FilesystemIterator::SKIP_DOTS ) ) as $file ) {
		if ( 'php' === $file->getExtension() ) {
			$files[] = $file->getPathname();
		}
	}
}
sort( $files );
$entries = array();
$errors = array();
foreach ( $files as $file ) {
	$tokens = token_get_all( file_get_contents( $file ) );
	foreach ( $tokens as $index => $token ) {
		if ( ! is_array( $token ) || T_STRING !== $token[0] ) {
			continue;
		}
		$function = $token[1];
		if ( ! isset( $signatures[ $function ] ) && ! in_array( $function, array( 'sprintf', 'esc_html', 'esc_attr' ), true ) ) {
			continue;
		}
		$cursor = $index + 1;
		while ( isset( $tokens[ $cursor ] ) && is_array( $tokens[ $cursor ] ) && T_WHITESPACE === $tokens[ $cursor ][0] ) {
			$cursor++;
		}
		if ( '(' !== ( $tokens[ $cursor ] ?? null ) ) {
			continue;
		}
		$args = array( '' );
		$literal = array( true );
		$argument = 0;
		$depth = 1;
		for ( $cursor++; $cursor < count( $tokens ); $cursor++ ) {
			$part = $tokens[ $cursor ];
			if ( '(' === $part || '[' === $part ) {
				$depth++;
				$literal[ $argument ] = false;
			} elseif ( ')' === $part || ']' === $part ) {
				if ( 0 === --$depth ) {
					break;
				}
			} elseif ( ',' === $part && 1 === $depth ) {
				$args[ ++$argument ] = '';
				$literal[ $argument ] = true;
			} elseif ( is_array( $part ) && T_CONSTANT_ENCAPSED_STRING === $part[0] && 1 === $depth ) {
				$args[ $argument ] .= $decode( $part[1] );
			} elseif ( '.' === $part || ( is_array( $part ) && in_array( $part[0], array( T_WHITESPACE, T_COMMENT, T_DOC_COMMENT ), true ) ) ) {
				continue;
			} else {
				$literal[ $argument ] = false;
			}
		}
		$reference = substr( $file, strlen( $root ) + 1 ) . ':' . $token[2];
		if ( ! isset( $signatures[ $function ] ) ) {
			if ( 2 === count( $args ) && $literal[0] && $literal[1] && 'ub' === $args[1] ) {
				$errors[] = $reference . ': ' . $function . ' is not a translation function.';
			}
			continue;
		}
		$signature = $signatures[ $function ];
		if ( 'ub' !== ( $args[ $signature[0] ] ?? null ) ) {
			continue;
		}
		$context = isset( $signature[1] ) ? $args[ $signature[1] ] : null;
		if ( ! $literal[0] || ( isset( $signature[1] ) && ! $literal[ $signature[1] ] ) || ( isset( $signature[2] ) && ! $literal[ $signature[2] ] ) ) {
			$errors[] = $reference . ': gettext messages and contexts must be literal strings.';
			continue;
		}
		$key = ( null === $context ? '' : $context . "\x04" ) . $args[0];
		if ( ! isset( $entries[ $key ] ) ) {
			$entries[ $key ] = array(
				'msgid' => $args[0],
				'plural' => isset( $signature[2] ) ? $args[ $signature[2] ] : null,
				'context' => $context,
				'references' => array(),
			);
		} elseif ( isset( $signature[2] ) ) {
			if ( null !== $entries[ $key ]['plural'] && $entries[ $key ]['plural'] !== $args[ $signature[2] ] ) {
				$errors[] = $reference . ': conflicting plural definitions for ' . $args[0];
			}
			$entries[ $key ]['plural'] = $args[ $signature[2] ];
		}
		$entries[ $key ]['references'][] = $reference;
	}
}
echo json_encode( array( 'entries' => array_values( $entries ), 'errors' => $errors ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR ) . "\n";
