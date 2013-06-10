<form action="<?php echo $this->GetAsset( 'forms', 'save', 'url' ); ?>" method="post" id="" class="form-horizontal">
	
	<input type="hidden" name="post_id" value="<?php echo $_GET['id']; ?>">
	<input type="hidden" name="success_url" value="<?php echo $this->AdminUrl(); ?>">
	
	<div id="poststuff">			
		
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">
				
				<div id="titlediv">
					<div id="titlewrap" class="row-fluid">
						<input type="text" class="span12" name="post_title" tabindex="1" value="<?php echo $post->post_title; ?>" placeholder="Enter title here" />
					</div>
				</div>
				
				<div id="postdivrich" class="postarea">
					
					<?php the_editor( $this->Helper('tools')->Clean( $post->post_content ) ); ?>
					
					<table id="post-status-info" cellspacing="0">
						<tbody>
							<tr>
								<td id="wp-word-count">
									Word count: <span class="word-count"><?php echo str_word_count( $post->post_content ); ?></span>
								</td>
								<td class="autosave-info">
									<span class="autosave-message">&nbsp;</span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div id="postbox-container-1" class="postbox-container">
				<div id="side-sortables" class="meta-box-sortables ui-sortable">
					
					<div class="row-fluid">
						<?php $this->do_meta_boxes( 'side' ); ?>
					</div>
				</div>
			</div>
			<div id="postbox-container-2" class="postbox-container">
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