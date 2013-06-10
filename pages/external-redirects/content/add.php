<form action="<?php echo $this->GetAsset( 'forms', 'save', 'url' ); ?>" method="post" id="" class="form-horizontal">
	
	<input type="hidden" name="post_id" value="<?php echo $_GET['id']; ?>">
	<input type="hidden" name="post_content" value="<?php echo $post ? $post->post_content : 'Empty'; ?>">
	<input type="hidden" name="success_url" value="<?php echo $this->AdminUrl(); ?>">
	
	<div id="poststuff" class="metabox-holder has-right-sidebar">			
		<div id="side-info-column" class="inner-sidebar">
			 <?php $this->do_meta_boxes( 'side' ); ?>
		</div>
		<div id="post-body" class="has-sidebar">
			<div id="post-body-content" class="has-sidebar-content">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
					<?php $this->do_meta_boxes( 'normal' ); ?>
					<?php $this->do_meta_boxes( 'advanced' ); ?>
				</div>
			</div>
		</div>
	</div>
	
</form>