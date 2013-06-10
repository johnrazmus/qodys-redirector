<?php 
global $post, $custom;

$custom['action_type'] = $custom['action_type'] ? $custom['action_type'] : 'redirect';
?>

<?php $nextItem = 'last_processed'; ?>
<input type="hidden" name="field_<?php echo $nextItem; ?>" value="<?php echo $custom[ $nextItem ] ? $custom[ $nextItem ] : 0; ?>">

<fieldset>
	<legend>General</legend>
	
	<?php $nextItem = 'post_title'; ?>
	<?php $nextValue = $this->Helper('tools')->Clean( $post ? $post->post_title : 'New redirect' ); ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Redirect Name</label>
		<div class="controls">
			<input type="text" class="span5" id="<?php echo $nextItem; ?>" name="<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>">
			<span class="help-block">Strictly used internally for recognition</span>
		</div>
	</div>
	
	<?php $nextItem = 'url_slug'; ?>
	<?php $nextValue = $custom[ $nextItem ]; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Url Slug</label>
		<div class="controls">
			<div class="input-prepend">
				<span class="add-on"><?php echo rtrim( get_bloginfo('url'), '/' ); ?>/</span>
				<input type="text" class="span2" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>">
			</div>
			<span class="help-block">Think link shorteners; something relevant (ex. kittens, obama, weight-loss)</span>			
		</div>
	</div>
	
</fieldset>

<fieldset>
	<legend>Redirect Settings</legend>
	
	<?php $nextItem = 'remote_url'; ?>
	<?php $nextValue = $custom[ $nextItem ]; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Remote Url</label>
		<div class="controls">
			<input type="text" class="span5" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>" placeholder="ex. http://othersite.com/article">
			<span class="help-block">This is the url of the page you want <strong>visitors</strong> to see</span>			
		</div>
	</div>
	
	<?php $nextItem = 'redirect_rule'; ?>
	<?php $nextValue = $custom[ $nextItem ]; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Redirect Rule</label>
		<div class="controls">
			<select name="field_<?php echo $nextItem; ?>" class="chzn-select" data-placeholder="Select a Rule">
				<option></option>
				
				<?php
				$data = $this->DataType( 'rule' )->Get();
				
				if( $data )
				{
					foreach( $data as $key => $value )
					{
						if( $value->ID == $nextValue )
							$selected = 'selected="selected"';
						else
							$selected = '';
						?>
				<option <?php echo $selected; ?> value="<?php echo $value->ID; ?>"><?php echo $value->post_title; ?></option>
					<?php
					}
				} ?>
			</select>
			<span class="help-block">This is the Redirect Rule you want <strong>leavers</strong> to use</span>			
		</div>
	</div>
	
</fieldset>

<div class="form-actions">
	<button type="submit" class="btn btn-primary">Save changes</button>
	<a href="<?php echo $this->AdminUrl(); ?>" class="btn">Cancel</a>
</div>







