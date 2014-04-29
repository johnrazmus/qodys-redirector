<?php
wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false );
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false );

$save_file = $this->GetAsset( 'forms', 'save' );

$page_variables = $_GET;

if( $_GET['id'] )
{
	global $post, $custom;
	
	$post = $this->GetDataType()->get_post( $_GET['id'] );
	$custom = $this->GetDataType()->get_datatype_custom( $post->ID );
}

switch( $_GET['content'] )
{
	case 'add':
		
		$page_title = 'Add New';
		$content_include = $this->GetAsset( 'content', 'add', 'dir' );
		
		break;
	
	case 'view':
		
		$page_title = $this->get_the_title( $post->ID );
		$content_include = $this->GetAsset( 'content', 'view', 'dir' );
		
		break;
	
	default:

		//$page_title = '<a href="'.$this->AdminUrl( array( 'content' => 'add' ) ).'" class="button add-new-h2">Add new</a>';
		$content_include = $this->GetAsset( 'content', 'list', 'dir' );
		
		break;
}
?>

<div class="wrap qody_only_area">
	
	<div class="page-header">
		<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div>
		<h2><?php echo $this->m_page_title; ?> <small><?php echo $this->Helper('tools')->Clean( $page_title ); ?></small></h2>
	</div>
	
	<?php $this->Helper('postman')->DisplayMessages(); ?>
	
	<?php include( $content_include ); ?>
			
			
</div>

<script type="text/javascript">
//<![CDATA[
jQuery(document).ready( function($) {
	// close postboxes that should be closed
	$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
	// postboxes setup
	postboxes.add_postbox_toggles('<?php echo $pagehook; ?>');
});
//]]>
</script>