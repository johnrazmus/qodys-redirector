<?php
wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false );
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false );
?>

<div class="wrap qody_only_area">
	
	<div class="page-header">
		<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div>
		<h2><?php echo $this->m_page_title; ?> <small><?php echo $this->Helper('tools')->Clean( $page_title ); ?></small></h2>
	</div>
	
	<?php $this->Helper('postman')->DisplayMessages(); ?>
	
	<form action="<?php echo $this->GetAsset( 'forms', 'save', 'url' ); ?>" method="post" id="" class="form-horizontal">
	
		<div id="poststuff" class="metabox-holder has-right-sidebar">			
			<div id="side-info-column" class="inner-sidebar">
				 <?php $this->do_meta_boxes( 'side' ); ?>
			</div>
			<div id="post-body" class="has-sidebar">
				<div id="post-body-content" class="has-sidebar-content">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">
						
						<div class="row-fluid">
							<?php $this->do_meta_boxes( 'normal' ); ?>
							<?php $this->do_meta_boxes( 'advanced' ); ?>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
	</form>
			
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