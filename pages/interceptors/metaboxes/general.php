<?php 
global $post, $custom;

$custom['static_iframe'] = maybe_unserialize( $custom['static_iframe'] );
$custom['static_iframe']['url_type'] = $custom['static_iframe']['url_type'] ? $custom['static_iframe']['url_type'] : 'interception';
$custom['static_iframe']['no_thanks_url_type'] = $custom['static_iframe']['no_thanks_url_type'] ? $custom['static_iframe']['no_thanks_url_type'] : 'interception';

$link_rotations = $this->DataType( 'link-rotation' )->Get();
?>

<fieldset class="theme_specific_settings" id="theme_none" style="display:<?php echo $custom['interceptor_theme'] == 'none' ? 'block' : 'none'; ?>;">
	
	<p>none</p>
	
</fieldset>
<fieldset class="theme_specific_settings" id="theme_static_blank" style="display:<?php echo $custom['interceptor_theme'] == 'static_blank' ? 'block' : 'none'; ?>;">
	
	<p>none</p>
	
</fieldset>
<fieldset class="theme_specific_settings" id="theme_static_iframe_fullscreen" style="display:<?php echo $custom['interceptor_theme'] == 'static_iframe_fullscreen' ? 'block' : 'none'; ?>;">
	
	<?php $nextItem = 'destination_url'; ?>
	<?php $nextValue = $custom['static_iframe_fullscreen'][ $nextItem ]; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">iFrame Url</label>
		<div class="controls">
			<input type="text" class="span10" id="<?php echo $nextItem; ?>" name="field_static_iframe_fullscreen[<?php echo $nextItem; ?>]" value="<?php echo $nextValue; ?>" placeholder="ex. http://sales.com/product">
			<span class="help-block">This is the url of who's content to show</span>			
		</div>
	</div>
	
	<?php $nextItem = 'title'; ?>
	<?php $nextValue = $custom['static_iframe_fullscreen'][ $nextItem ]; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Page Title</label>
		<div class="controls">
			<input type="text" class="span10" id="<?php echo $nextItem; ?>" name="field_static_iframe_fullscreen[<?php echo $nextItem; ?>]" value="<?php echo $nextValue; ?>" placeholder="ex. Awesome Page">
			<span class="help-block">Goes into the page's <code><?php echo htmlentities('<title></title>'); ?></code> tags</span>			
		</div>
	</div>
	
	<?php $nextItem = 'description'; ?>
	<?php $nextValue = $custom['static_iframe_fullscreen'][ $nextItem ]; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Page Description</label>
		<div class="controls">
			<textarea class="span10" id="<?php echo $nextItem; ?>" name="field_static_iframe_fullscreen[<?php echo $nextItem; ?>]"><?php echo $nextValue; ?></textarea>
			<span class="help-block">Goes into the page's <code><?php echo htmlentities('<meta name="description" content="">'); ?></code> tag</span>			
		</div>
	</div>
	
	<?php $nextItem = 'social_image_url'; ?>
	<?php $nextValue = $custom['static_iframe_fullscreen'][ $nextItem ]; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Image Url</label>
		<div class="controls">
			<div class="input-append">
				<input type="text" class="span12" placeholder="ex. http://sales.com/product1.jpg" id="<?php echo $nextItem; ?>" name="field_static_iframe_fullscreen[<?php echo $nextItem; ?>]" value="<?php echo $nextValue; ?>" /><button id="<?php echo $nextItem; ?>_trigger" class="btn" type="button">Upload</button>
			</div>
			<span class="help-block">Used in social media tags (like Facebook)</span>
		</div>
	</div>
	
</fieldset>
<fieldset class="theme_specific_settings" id="theme_static_iframe" style="display:<?php echo $custom['interceptor_theme'] == 'static_iframe' ? 'block' : 'none'; ?>;">
	<legend>Content Source</legend>
	
	<?php $nextItem = 'url_type'; ?>
	<?php $nextValue = $custom['static_iframe'][ $nextItem ]; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">iFrame Url</label>
		<div class="controls">
			
			<label class="radio">
				<input type="radio" name="field_static_iframe[<?php echo $nextItem; ?>]" onclick="ToggleStaticIframeUrlTypeSettings( '' );" <?php echo $nextValue == 'interception' ? 'checked="checked"' : ''; ?> value="interception">
				Intercepted Destination
			</label>
			
			<label class="radio">
				<input type="radio" name="field_static_iframe[<?php echo $nextItem; ?>]" onclick="ToggleStaticIframeUrlTypeSettings( '#static_iframe_url_type_single' );" <?php echo $nextValue == 'url' ? 'checked="checked"' : ''; ?> value="url">
				Custom Url
			</label>
			
			<label class="radio">
				<input type="radio" name="field_static_iframe[<?php echo $nextItem; ?>]" onclick="ToggleStaticIframeUrlTypeSettings( '#static_iframe_url_type_rotation' );" <?php echo $nextValue == 'rotation' ? 'checked="checked"' : ''; ?> value="rotation">
				Link Rotation
			</label>
			<span class="help-block">This decides the source of content for the main iframe</span>
			
		</div>
	</div>
	
	<div id="static_iframe_url_type_single" class="static_iframe_url_type_options" style="display:<?php echo $custom['static_iframe']['url_type'] == 'url' ? 'block' : 'none'; ?>;">
	
		<?php $nextItem = 'destination_url'; ?>
		<?php $nextValue = $custom['static_iframe'][ $nextItem ]; ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Destination Url</label>
			<div class="controls">
				<input type="text" class="span10" id="<?php echo $nextItem; ?>" name="field_static_iframe[<?php echo $nextItem; ?>]" value="<?php echo $nextValue; ?>" placeholder="ex. http://sales.com/product">
				<span class="help-block">This is the url of where visitors will be sent to</span>			
			</div>
		</div>
		
	</div>
	<div id="static_iframe_url_type_rotation" class="static_iframe_url_type_options" style="display:<?php echo $custom['static_iframe']['url_type'] == 'rotation' ? 'block' : 'none'; ?>;">
	
		<?php $nextItem = 'link_rotation'; ?>
		<?php $nextValue = $custom['static_iframe'][ $nextItem ]; ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Link Rotation</label>
			<div class="controls">
				
				<select name="field_static_iframe[<?php echo $nextItem; ?>]" class="chzn-select" data-placeholder="Select link rotation">
					<option></option>
					
					<?php
					if( $link_rotations )
					{
						foreach( $link_rotations as $key => $value )
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
			</div>
		</div>
		
	</div>
	
	<legend>Exit Settings</legend>
	
	<?php $nextItem = 'no_thanks_text'; ?>
	<?php $nextValue = $custom['static_iframe'][ $nextItem ] ? $custom['static_iframe'][ $nextItem ] : 'No thanks, please take me to my destination.'; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">"No Thanks" Text</label>
		<div class="controls">
			<input type="text" class="span10" id="<?php echo $nextItem; ?>" name="field_static_iframe[<?php echo $nextItem; ?>]" value="<?php echo $nextValue; ?>" placeholder="ex. No thanks, please take me to my destination.">
		</div>
	</div>
	
	<?php $nextItem = 'no_thanks_url_type'; ?>
	<?php $nextValue = $custom['static_iframe'][ $nextItem ]; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">"No Thanks" Link Url</label>
		<div class="controls">
			
			<label class="radio">
				<input type="radio" name="field_static_iframe[<?php echo $nextItem; ?>]" onclick="CustomGroupToggle( '', '.static_iframe_no_thanks_url_type_options' );" <?php echo $nextValue == 'interception' ? 'checked="checked"' : ''; ?> value="interception">
				Intercepted Destination
			</label>
			
			<label class="radio">
				<input type="radio" name="field_static_iframe[<?php echo $nextItem; ?>]" onclick="CustomGroupToggle( '#static_iframe_no_thanks_url_type_single', '.static_iframe_no_thanks_url_type_options' );" <?php echo $nextValue == 'url' ? 'checked="checked"' : ''; ?> value="url">
				Custom Url
			</label>
			
			<label class="radio">
				<input type="radio" name="field_static_iframe[<?php echo $nextItem; ?>]" onclick="CustomGroupToggle( '#static_iframe_no_thanks_url_type_rotation', '.static_iframe_no_thanks_url_type_options' );" <?php echo $nextValue == 'rotation' ? 'checked="checked"' : ''; ?> value="rotation">
				Link Rotation
			</label>
			<span class="help-block">This decides where the visitor goes when clicking the "no thanks" text</span>
			
		</div>
	</div>
	
	<div id="static_iframe_no_thanks_url_type_single" class="static_iframe_no_thanks_url_type_options" style="display:<?php echo $custom['static_iframe']['no_thanks_url_type'] == 'url' ? 'block' : 'none'; ?>;">
	
		<?php $nextItem = 'no_thanks_destination_url'; ?>
		<?php $nextValue = $custom['static_iframe'][ $nextItem ]; ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Destination Url</label>
			<div class="controls">
				<input type="text" class="span10" id="<?php echo $nextItem; ?>" name="field_static_iframe[<?php echo $nextItem; ?>]" value="<?php echo $nextValue; ?>" placeholder="ex. http://sales.com/product">
				<span class="help-block">This is the url of where visitors will be sent to</span>			
			</div>
		</div>
		
	</div>
	<div id="static_iframe_no_thanks_url_type_rotation" class="static_iframe_no_thanks_url_type_options" style="display:<?php echo $custom['static_iframe']['no_thanks_url_type'] == 'rotation' ? 'block' : 'none'; ?>;">
	
		<?php $nextItem = 'no_thanks_link_rotation'; ?>
		<?php $nextValue = $custom['static_iframe'][ $nextItem ]; ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Link Rotation</label>
			<div class="controls">
				
				<select name="field_static_iframe[<?php echo $nextItem; ?>]" class="chzn-select" data-placeholder="Select link rotation">
					<option></option>
					
					<?php
					if( $link_rotations )
					{
						foreach( $link_rotations as $key => $value )
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
			</div>
		</div>
		
	</div>
	
</fieldset>
	