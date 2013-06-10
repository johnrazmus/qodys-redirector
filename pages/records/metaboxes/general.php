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
	
	<?php $nextItem = 'remote_url'; ?>
	<?php $nextValue = $custom[ $nextItem ]; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Remote Url</label>
		<div class="controls">
			<input type="text" class="span5" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>" placeholder="ex. http://othersite.com/article">
			<span class="help-block">This is the url of the page you want <strong>visitors</strong> to see</span>			
		</div>
	</div>
	
</fieldset>

<fieldset>
	<legend>Redirect Settings</legend>
	
	<?php $nextItem = 'destination_url'; ?>
	<?php $nextValue = $custom[ $nextItem ]; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Destination Url</label>
		<div class="controls">
			<input type="text" class="span5" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>" placeholder="ex. http://sales.com/product">
			<span class="help-block">This is the url of the page you want <strong>leavers</strong> to see</span>			
		</div>
	</div>
	
	<?php $nextItem = 'action_type'; ?>
	<?php $nextValue = $custom[ $nextItem ]; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">"Leaving" Action Type</label>
		<div class="controls">
			<label class="radio">
				<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'redirect' ? 'checked="checked"' : ''; ?> value="redirect" onclick="jQuery('#action_type_popup').slideUp();">
				Redirect - takes user directly to the destination
			</label>
			
			<label class="radio">
				<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'popup' ? 'checked="checked"' : ''; ?> value="popup" onclick="jQuery('#action_type_popup').slideDown();">
				Popup - displays lightbox popup of destination
			</label>
		</div>
	</div>
	
</fieldset>

<fieldset id="action_type_popup" style="display:<?php echo $custom['action_type'] == 'popup' ? 'block' : 'none'; ?>;">
	<legend>Popup Action Settings</legend>
	
	<?php $nextItem = 'popup_width'; ?>
	<?php $nextValue = $custom[ $nextItem ] ? $custom[ $nextItem ] : 85; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Popup Width</label>
		<div class="controls">
			<div class="input-append">
				<input type="text" class="span1" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>">
				<span class="add-on">
					%
				</span>
			</div>
		</div>
	</div>
	
	<?php $nextItem = 'popup_height'; ?>
	<?php $nextValue = $custom[ $nextItem ] ? $custom[ $nextItem ] : 85; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Popup Height</label>
		<div class="controls">
			<div class="input-append">
				<input type="text" class="span1" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>">
				<span class="add-on">
					%
				</span>
			</div>
		</div>
	</div>
	
</fieldset>
	
	
<div class="form-actions">
	<button type="submit" class="btn btn-primary">Save changes</button>
	<a href="<?php echo $this->AdminUrl(); ?>" class="btn">Cancel</a>
</div>







