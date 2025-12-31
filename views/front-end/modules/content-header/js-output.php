<script type="text/javascript" id="<?php echo esc_attr( $id ); ?>">
var pstoolkit_header_node = document.createElement('div');
<?php
/**
 * ID
 */
?>
var pstoolkit_header = document.createAttribute('id');
pstoolkit_header.value = 'pstoolkit_content_header';
pstoolkit_header_node.setAttributeNode( pstoolkit_header );
<?php
/**
 * style
 */
?>
pstoolkit_header = document.createAttribute('style');
pstoolkit_header.value = '<?php echo esc_attr( $style ); ?>';
pstoolkit_header_node.setAttributeNode( pstoolkit_header );
pstoolkit_header_node.innerHTML = <?php echo json_encode( stripslashes( $content ) ); ?>;
<?php
/**
 * Content
 */
?>
pstoolkit_header = document.getElementsByTagName( '<?php echo esc_attr( $tag ); ?>' )[0];
pstoolkit_header.insertBefore( pstoolkit_header_node, pstoolkit_header.firstChild );
</script>

