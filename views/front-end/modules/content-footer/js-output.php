<script type="text/javascript" id="<?php echo esc_attr( $id ); ?>">
var pstoolkit_footer_node = document.createElement('div');
<?php
/**
 * ID
 */
?>
var pstoolkit_footer = document.createAttribute('id');
pstoolkit_footer.value = 'pstoolkit_content_footer';
pstoolkit_footer_node.setAttributeNode( pstoolkit_footer );
<?php
/**
 * style
 */
?>
pstoolkit_footer = document.createAttribute('style');
pstoolkit_footer.value = '<?php echo esc_attr( $style ); ?>';
pstoolkit_footer_node.setAttributeNode( pstoolkit_footer );
pstoolkit_footer_node.innerHTML = <?php echo json_encode( stripslashes( $content ) ); ?>;
<?php
/**
 * Content
 */
?>
pstoolkit_footer = document.getElementsByTagName( '<?php echo esc_attr( $tag ); ?>' );
if ( pstoolkit_footer.length ) {
	pstoolkit_footer = pstoolkit_footer[ pstoolkit_footer.length - 1 ];
	pstoolkit_footer.appendChild( pstoolkit_footer_node, pstoolkit_footer.firstChild );
}
</script>

