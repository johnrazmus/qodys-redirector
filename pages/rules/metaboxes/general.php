<?php 
global $post, $custom;

$custom['action_trigger_type'] = $custom['action_trigger_type'] ? $custom['action_trigger_type'] : 'leave';
$custom['action_type'] = $custom['action_type'] ? $custom['action_type'] : 'redirect';
$custom['enable_redirect'] = $custom['enable_redirect'] ? $custom['enable_redirect'] : 'yes';
$custom['url_type'] = $custom['url_type'] ? $custom['url_type'] : 'url';
$custom['action_trigger_click_eligibility'] = $custom['action_trigger_click_eligibility'] ? $custom['action_trigger_click_eligibility'] : 'all';
$custom['redirect_again'] = $custom['redirect_again'] ? $custom['redirect_again'] : 'yes';

$custom['alert_ok_action'] = $custom['alert_ok_action'] ? $custom['alert_ok_action'] : 'url_type';
$custom['alert_cancel_action'] = $custom['alert_cancel_action'] ? $custom['alert_cancel_action'] : 'stay';
?>

<fieldset>
	<legend>General</legend>
	
	<?php $nextItem = 'post_title'; ?>
	<?php $nextValue = $this->Helper('tools')->Clean( $post ? $post->post_title : 'New redirect rule' ); ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Rule Name</label>
		<div class="controls">
			<input type="text" class="span10" id="<?php echo $nextItem; ?>" name="<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>">
			<span class="help-block">Used internally for recognition</span>
		</div>
	</div>
	
	<?php $nextItem = 'priority'; ?>
	<?php $nextValue = $custom[ $nextItem ] ? $custom[ $nextItem ] : 10; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Rule Priority <?php $this->DocLink('http://docs.qody.co/plugins/specific-products/alejandro-qodys-redirector/redirect-rules/priority/'); ?></label>
		<div class="controls">
			<div class="input-prepend">
				<span class="add-on">
					<i class="icon-star-empty"></i>
				</span>
				<input type="text" class="span4" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>">				
			</div>
			<span class="help-block">Higher priority rules supersede lower priority rules</span>
		</div>
	</div>
	
	<?php $nextItem = 'enable_redirect'; ?>
	<?php $nextValue = $custom[ $nextItem ]; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Enable Redirection</label>
		<div class="controls">
			
			<label class="radio">
				<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="jQuery('.redirector_content').slideDown();" <?php echo $nextValue == 'yes' ? 'checked="checked"' : ''; ?> value="yes">
				Yes - will enable redirection features & options
			</label>
			
			<label class="radio">
				<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="jQuery('.redirector_content').slideUp();" <?php echo $nextValue == 'no' || !$nextValue ? 'checked="checked"' : ''; ?> value="no">
				No - redirection of any kind will be disabled
			</label>
			<span class="help-block"><strong>Note:</strong> theme must have <code>wp_footer()</code> to work (most do).</span>
			
		</div>
	</div>

</fieldset>

<div class="redirector_content" style="display:<?php echo $custom['enable_redirect'] == 'yes' ? 'block' : 'none'; ?>;">
	<fieldset>
		<legend>Triggers <small>Where & When it happens <?php $this->DocLink('http://docs.qody.co/plugins/specific-products/alejandro-qodys-redirector/redirect-rules/triggers/'); ?></small></legend>
		
		<?php $nextItem = 'page_triggers'; ?>
		<?php $nextValue = is_array( $custom[ $nextItem ] ) ? $custom[ $nextItem ] : array(); ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Posts/Pages</label>
			<div class="controls">
				
				<select name="field_<?php echo $nextItem; ?>[]" class="chzn-select" multiple data-placeholder="Select page(s)">
					<option></option>
					<?php
					$fields = array();
					$fields['all'] = 'Entire Site';
					$fields['home'] = 'Home Page';
					$fields['search'] = 'Search Page';
					?>
					<optgroup label="General">
					<?php
					foreach( $fields as $key => $value )
					{	
						if( in_array( $key, $nextValue ) )
							$selected = 'selected="selected"';
						else
							$selected = ''; ?>
					<option <?php echo $selected; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
					<?php
					} ?>
					
					</optgroup>
					
					<?php
					$data = get_post_types( null, 'objects' );
					
					if( $data )
					{
						global $wpdb;
						foreach( $data as $key => $value )
						{
							$posts = $wpdb->get_results( "SELECT ID, post_title FROM $wpdb->posts WHERE post_type = '".$value->name."'" );
							
							if( !$posts || $value->name == 'attachment' || $value->name == 'nav_menu_item' )
								continue;
							
							$slug = 'post_type::'.$value->name;
							
							if( in_array( $slug, $nextValue ) )
								$selected = 'selected="selected"';
							else
								$selected = '';
							?>
					<optgroup label="<?php echo $value->labels->name; ?>">
						<option value="<?php echo $slug; ?>" <?php echo $selected; ?>>All <?php echo $value->labels->name; ?></option>
							<?php
							if( $posts )
							{
								foreach( $posts as $key2 => $value2 )
								{	
									if( in_array( $value2->ID, $nextValue ) )
										$selected = 'selected="selected"';
									else
										$selected = ''; ?>
						<option <?php echo $selected; ?> value="<?php echo $value2->ID; ?>"><?php echo $value2->post_title; ?></option>
								<?php
								}
							} ?>
					</optgroup>
						<?php
						}
					} ?>
				</select>
				
			</div>
		</div>
		
		<?php $nextItem = 'category_triggers'; ?>
		<?php $nextValue = is_array( $custom[ $nextItem ] ) ? $custom[ $nextItem ] : array(); ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Categories</label>
			<div class="controls">
				
				<select name="field_<?php echo $nextItem; ?>[]" class="chzn-select" multiple data-placeholder="Select categories">
					<option></option>
					<option value="all" <?php echo in_array( 'all', $nextValue ) ? 'selected="selected"' : ''; ?>>All Categories</option>
					
					<?php
					$blog_categories = $this->GetBlogCategories();
					
					if( $blog_categories )
					{
						foreach( $blog_categories as $key => $value )
						{
							if( in_array( $value->cat_ID, $nextValue ) )
								$selected = 'selected="selected"';
							else
								$selected = '';
							?>
					<option <?php echo $selected; ?> value="<?php echo $value->cat_ID; ?>"><?php echo $value->cat_name; ?></option>
						<?php
						}
					} ?>
				</select>
				
			</div>
		</div>
		
		<?php $nextItem = 'specific_url_triggers'; ?>
		<?php $nextValue = $custom[ $nextItem ]; ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Specific URLs</label>
			<div class="controls">
				<textarea class="span10" style="height:60px;" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" placeholder="<?php echo get_bloginfo('url'); ?>/about-us/"><?php echo $nextValue; ?></textarea>
				<span class="help-block">Pages matching these URLs will trigger this redirect rule</span>
				<span class="help-block"><strong>Note:</strong> one per line, or separated by <code>,</code></span>
			</div>
		</div>
		
		<?php $nextItem = 'action_trigger_type'; ?>
		<?php $nextValue = $custom[ $nextItem ]; ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Action Trigger</label>
			<div class="controls">
				
				<label class="radio">
					<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="CustomGroupToggle( '', '.action_trigger_type' );jQuery('#url_type_clicked_url').slideUp();" <?php echo $nextValue == 'leave' ? 'checked="checked"' : ''; ?> value="leave">
					Mouse leaves page
				</label>
				
				<label class="radio">
					<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="CustomGroupToggle( '', '.action_trigger_type' );jQuery('#url_type_clicked_url').slideUp();" <?php echo $nextValue == 'load' ? 'checked="checked"' : ''; ?> value="load">
					Page loads
				</label>
				
				<label class="radio">
					<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="CustomGroupToggle( '#action_trigger_type_click', '.action_trigger_type' );jQuery('#url_type_clicked_url').slideDown();" <?php echo $nextValue == 'click' ? 'checked="checked"' : ''; ?> value="click">
					Content link clicked
				</label>
				
			</div>
		</div>
		
		<div id="action_trigger_type_click" class="action_trigger_type" style="display:<?php echo $custom['action_trigger_type'] == 'click' ? 'block' : 'none'; ?>;">
			
			<?php $nextItem = 'action_trigger_click_eligibility'; ?>
			<?php $nextValue = $custom[ $nextItem ]; ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">Eligable Links</label>
				<div class="controls">
					
					<label class="radio">
						<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="CustomGroupToggle( '#click_trigger_rule_specifics', '.click_trigger_link_rules' );" <?php echo $nextValue == 'specific' ? 'checked="checked"' : ''; ?> value="specific">
						Specific urls - only a few links redirect
					</label>
					
					<label class="radio">
						<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="CustomGroupToggle( '#click_trigger_rule_exclusions', '.click_trigger_link_rules' );" <?php echo $nextValue == 'all' ? 'checked="checked"' : ''; ?> value="all">
						All urls - most links redirect
					</label>
					
				</div>
			</div>
			
			<div id="click_trigger_rule_specifics" class="click_trigger_link_rules" style="display:<?php echo $custom['action_trigger_click_eligibility'] == 'specific' ? 'block' : 'none'; ?>;">
				<?php $nextItem = 'click_trigger_specifics'; ?>
				<?php $nextValue = $custom[ $nextItem ]; ?>
				<div class="control-group">
					<label class="control-label" for="<?php echo $nextItem; ?>">Specific Links</label>
					<div class="controls">
						<textarea class="span10" style="height:60px;" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" placeholder="/product2/, http://othersite.com"><?php echo $nextValue; ?></textarea>
						<span class="help-block">Only links matching these full/partial urls will be eligable for redirection</span>
						<span class="help-block"><strong>Note:</strong> one per line, or separated by <code>,</code></span>
					</div>
				</div>
			</div>
			<div id="click_trigger_rule_exclusions" class="click_trigger_link_rules" style="display:<?php echo $custom['action_trigger_click_eligibility'] == 'all' ? 'block' : 'none'; ?>;">
				<?php $nextItem = 'click_trigger_exclusions'; ?>
				<?php $nextValue = $custom[ $nextItem ]; ?>
				<div class="control-group">
					<label class="control-label" for="<?php echo $nextItem; ?>">Link Exclusions<br>(optional)</label>
					<div class="controls">
						<textarea class="span10" style="height:60px;" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" placeholder="/product2/, http://othersite.com"><?php echo $nextValue; ?></textarea>
						<span class="help-block">Links matching the urls in this list won't be eligable to trigger a redirect</span>
						<span class="help-block"><strong>Note:</strong> one per line, or separated by <code>,</code></span>
					</div>
				</div>
			</div>
			
		</div>
		
		<!--<p>Categories</p>
		<p>Tags</p>
		<p>Post types</p>
		<p>Specific post/page</p>
		<p>taxonomies?</p>-->
		
	</fieldset>
</div>

<div class="redirector_content" style="display:<?php echo $custom['enable_redirect'] == 'yes' ? 'block' : 'none'; ?>;">
	
	<fieldset>
		<legend>Actions <small>What happens <?php $this->DocLink('http://docs.qody.co/plugins/specific-products/alejandro-qodys-redirector/redirect-rules/actions/'); ?></small></legend>
	
		<?php $nextItem = 'url_type'; ?>
		<?php $nextValue = $custom[ $nextItem ]; ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Url Type <?php $this->DocLink('http://docs.qody.co/plugins/specific-products/alejandro-qodys-redirector/redirect-rules/actions/url-choices/'); ?></label>
			<div class="controls">
				
				<label class="radio">
					<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="CustomGroupToggle( '#url_type_single', '.url_type_options' );" <?php echo $nextValue == 'url' ? 'checked="checked"' : ''; ?> value="url">
					Custom url destination
				</label>
				<label class="radio">
					<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="CustomGroupToggle( '#url_type_rotation', '.url_type_options' );" <?php echo $nextValue == 'rotation' ? 'checked="checked"' : ''; ?> value="rotation">
					Link Rotation
				</label>
				<label class="radio" id="url_type_clicked_url">
					<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="CustomGroupToggle( '', '.url_type_options' );" <?php echo $nextValue == 'clicked_url' ? 'checked="checked"' : ''; ?> value="clicked_url">
					Clicked link url destination
				</label>
				
			</div>
		</div>
		
		<div id="url_type_single" class="url_type_options" style="display:<?php echo $custom['url_type'] == 'url' ? 'block' : 'none'; ?>;">
			
			<?php $nextItem = 'destination_url'; ?>
			<?php $nextValue = $custom[ $nextItem ]; ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">Destination Url</label>
				<div class="controls">
					<input type="text" class="span10" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>" placeholder="ex. http://sales.com/product">
					<span class="help-block">This is the url of where visitors will be sent to</span>			
				</div>
			</div>
			
		</div>
		<div id="url_type_rotation" class="url_type_options" style="display:<?php echo $custom['url_type'] == 'rotation' ? 'block' : 'none'; ?>;">
		
			<?php $nextItem = 'link_rotation'; ?>
			<?php $nextValue = $custom[ $nextItem ]; ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">Link Rotation</label>
				<div class="controls">
					
					<select name="field_<?php echo $nextItem; ?>" class="chzn-select" data-placeholder="Select link rotation">
						<option></option>
						
						<?php
						$link_rotations = $this->DataType( 'link-rotation' )->Get();
						
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
		
		<?php $nextItem = 'interception_page'; ?>
		<?php $nextValue = $custom[ $nextItem ]; ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Interception<br>(optional) <?php $this->DocLink('http://docs.qody.co/plugins/specific-products/alejandro-qodys-redirector/redirect-rules/actions/interception/'); ?></label>
			<div class="controls">
				
				<select name="field_<?php echo $nextItem; ?>" class="chzn-select" data-placeholder="Select a page">
					<option></option>
					
					<?php
					$link_rotations = $this->DataType( 'interceptor' )->Get();
					
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
				<span class="help-block">Select an Interceptor Page if you plan on using Interception</span>
			</div>
		</div>
		
		<?php $nextItem = 'action_type'; ?>
		<?php $nextValue = $custom[ $nextItem ]; ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Action Type <?php $this->DocLink('http://docs.qody.co/plugins/specific-products/alejandro-qodys-redirector/redirect-rules/actions/action-types/'); ?></label>
			<div class="controls">
				<label class="radio">
					<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'redirect' ? 'checked="checked"' : ''; ?> value="redirect" onclick="ToggleActionTypeSettings('#action_type_redirect');">
					Redirect - takes user directly to the destination
				</label>
				<label class="radio">
					<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'modal' ? 'checked="checked"' : ''; ?> value="modal" onclick="ToggleActionTypeSettings('#action_type_modal');">
					Modal - displays lightbox/modal popup of destination
				</label>
				<!--<label class="radio">
					<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'tab' ? 'checked="checked"' : ''; ?> value="tab" onclick="ToggleActionTypeSettings('#action_type_tab');">
					New Tab - opens destination in a new browser tab <span style="color:#cc0000; font-weight:bold;">*</span>
				</label>-->
				<label class="radio">
					<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'popup' ? 'checked="checked"' : ''; ?> value="popup" onclick="ToggleActionTypeSettings('#action_type_popup');">
					Popup - opens popup in front of browser window <span style="color:#cc0000; font-weight:bold;">*</span>
				</label>
				<label class="radio">
					<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'popunder' ? 'checked="checked"' : ''; ?> value="popunder" onclick="ToggleActionTypeSettings('#action_type_popunder');">
					Popunder - opens popup behind browser window <span style="color:#cc0000; font-weight:bold;">*</span>
				</label>
				<label class="radio">
					<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'alert' ? 'checked="checked"' : ''; ?> value="alert" onclick="ToggleActionTypeSettings('#action_type_alert');">
					Alert Prompt - "are you sure you want to leave?" Ok/Cancel box
				</label>
				<span class="help-block"><strong>Note:</strong> actions marked with <span style="color:#cc0000; font-weight:bold;">*</span> get blocked by modern popup blockers when <strong>not</strong> triggered from the <code>content link clicked</code> Action Trigger</span>
			</div>
		</div>
		
		<div class="action_type_options" id="action_type_redirect" style="display:<?php echo $custom['action_type'] == 'redirect' ? 'block' : 'none'; ?>;">
			
			<!--<?php $nextItem = 'redirect_delay'; ?>
			<?php $nextValue = $custom[ $nextItem ]; ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">Redirect Delay</label>
				<div class="controls">
					<input type="text" class="span1" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue ? $nextValue : 0; ?>" placeholder="ex. 3">
					<span class="help-block">Measures the time in seconds to wait after the page loads for a visitor before 
					detecting & checking for a redirect action to happen; we recommend a value of 1.</span>
				</div>
			</div>-->
			
			<!--<?php $nextItem = 'redirect_type'; ?>
			<?php $nextValue = $custom[ $nextItem ]; ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">Redirect Type</label>
				<div class="controls">
					<label class="radio">
						<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'mouse' || !$nextValue ? 'checked="checked"' : ''; ?> value="mouse">
						Mouse based - triggers when the users mouse leaves the top of the screen
					</label>
					<label class="radio">
						<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'instant' ? 'checked="checked"' : ''; ?> value="instant">
						Instant - triggers when the user views the page
					</label>
				</div>
			</div>-->
			
		</div>
		
		<div class="action_type_options" id="action_type_modal" style="display:<?php echo $custom['action_type'] == 'modal' ? 'block' : 'none'; ?>;">
			
			<?php $nextItem = 'modal_width'; ?>
			<?php $nextValue = $custom[ $nextItem ] ? $custom[ $nextItem ] : 85; ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">Modal Width</label>
				<div class="controls">
					<div class="input-append">
						<input type="text" class="span6" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>">
						<span class="add-on">
							%
						</span>
					</div>
				</div>
			</div>
			
			<?php $nextItem = 'modal_height'; ?>
			<?php $nextValue = $custom[ $nextItem ] ? $custom[ $nextItem ] : 85; ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">Modal Height</label>
				<div class="controls">
					<div class="input-append">
						<input type="text" class="span6" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>">
						<span class="add-on">
							%
						</span>
					</div>
				</div>
			</div>
			
		</div>
		
		<!--<fieldset class="action_type_options" id="action_type_tab" style="display:<?php echo $custom['action_type'] == 'tab' ? 'block' : 'none'; ?>;">
			<legend>New Tab Settings</legend>
			
			
		</fieldset>-->
		
		<div class="action_type_options" id="action_type_popup" style="display:<?php echo $custom['action_type'] == 'popup' ? 'block' : 'none'; ?>;">
			
			<?php $nextItem = 'popup_width'; ?>
			<?php $nextValue = $custom[ $nextItem ] ? $custom[ $nextItem ] : 980; ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">Popup Width</label>
				<div class="controls">
					<div class="input-append">
						<input type="text" class="span4" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>">
						<span class="add-on">
							pixels
						</span>
					</div>
				</div>
			</div>
			
			<?php $nextItem = 'popup_height'; ?>
			<?php $nextValue = $custom[ $nextItem ] ? $custom[ $nextItem ] : 680; ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">Popup Height</label>
				<div class="controls">
					<div class="input-append">
						<input type="text" class="span4" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>">
						<span class="add-on">
							pixels
						</span>
					</div>
				</div>
			</div>
			
		</div>
		
		<div class="action_type_options" id="action_type_popunder" style="display:<?php echo $custom['action_type'] == 'popunder' ? 'block' : 'none'; ?>;">
			
			<?php $nextItem = 'popunder_width'; ?>
			<?php $nextValue = $custom[ $nextItem ] ? $custom[ $nextItem ] : 980; ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">Popunder Width</label>
				<div class="controls">
					<div class="input-append">
						<input type="text" class="span4" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>">
						<span class="add-on">
							pixels
						</span>
					</div>
				</div>
			</div>
			
			<?php $nextItem = 'popunder_height'; ?>
			<?php $nextValue = $custom[ $nextItem ] ? $custom[ $nextItem ] : 680; ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">Popunder Height</label>
				<div class="controls">
					<div class="input-append">
						<input type="text" class="span4" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>">
						<span class="add-on">
							pixels
						</span>
					</div>
				</div>
			</div>
			
		</div>
		
		<div class="action_type_options" id="action_type_alert" style="display:<?php echo $custom['action_type'] == 'alert' ? 'block' : 'none'; ?>;">
			
			<?php $nextItem = 'alert_text'; ?>
			<?php $nextValue = $this->Helper('tools')->Clean( $custom[ $nextItem ] ? $custom[ $nextItem ] : 'Are you sure you want to leave?' ); ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">Alert Text</label>
				<div class="controls">
					<textarea class="span10" style="height:60px;" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" placeholder="Are you sure you want to leave?"><?php echo $nextValue; ?></textarea>
				</div>
			</div>
			
			<?php $nextItem = 'alert_ok_action'; ?>
			<?php $nextValue = $custom[ $nextItem ]; ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">"Ok" Result</label>
				<div class="controls">
					<label class="radio">
						<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="jQuery('#alert_ok_action_content').slideUp();" <?php echo $nextValue == 'stay' ? 'checked="checked"' : ''; ?> value="stay">
						Stay on page
					</label>
					<label class="radio">
						<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="jQuery('#alert_ok_action_content').slideUp();" <?php echo $nextValue == 'url_type' ? 'checked="checked"' : ''; ?> value="url_type">
						Redirect to specified <code>Url Type</code>
					</label>
					<label class="radio">
						<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="jQuery('#alert_ok_action_content').slideDown();" <?php echo $nextValue == 'url' ? 'checked="checked"' : ''; ?> value="url">
						Redirect to custom url
					</label>
				</div>
			</div>
			
			<div id="alert_ok_action_content" style="display:<?php echo $custom['alert_ok_action'] == 'url' ? 'block' : 'none'; ?>;">
				<?php $nextItem = 'alert_ok_action_destination_url'; ?>
				<?php $nextValue = $custom[ $nextItem ]; ?>
				<div class="control-group">
					<label class="control-label" for="<?php echo $nextItem; ?>">Destination Url</label>
					<div class="controls">
						<input type="text" class="span10" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>" placeholder="ex. http://sales.com/product">
						<span class="help-block">This is the url of where visitor will be sent to</span>			
					</div>
				</div>
			</div>
			
			<?php $nextItem = 'alert_cancel_action'; ?>
			<?php $nextValue = $custom[ $nextItem ]; ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">"Cancel" Result</label>
				<div class="controls">
					<label class="radio">
						<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="jQuery('#alert_cancel_action_content').slideUp();" <?php echo $nextValue == 'stay' ? 'checked="checked"' : ''; ?> value="stay">
						Stay on page
					</label>
					<label class="radio">
						<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="jQuery('#alert_cancel_action_content').slideUp();" <?php echo $nextValue == 'url_type' ? 'checked="checked"' : ''; ?> value="url_type">
						Redirect to specified <code>Url Type</code>
					</label>
					<label class="radio">
						<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="jQuery('#alert_cancel_action_content').slideDown();" <?php echo $nextValue == 'url' ? 'checked="checked"' : ''; ?> value="url">
						Redirect to custom url
					</label>
				</div>
			</div>
			
			<div id="alert_cancel_action_content" style="display:<?php echo $custom['alert_cancel_action'] == 'url' ? 'block' : 'none'; ?>;">
				<?php $nextItem = 'alert_cancel_action_destination_url'; ?>
				<?php $nextValue = $custom[ $nextItem ]; ?>
				<div class="control-group">
					<label class="control-label" for="<?php echo $nextItem; ?>">Destination Url</label>
					<div class="controls">
						<input type="text" class="span10" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>" placeholder="ex. http://sales.com/product">
						<span class="help-block">This is the url of where visitor will be sent to</span>			
					</div>
				</div>
			</div>
			
		</div>
		
	</fieldset>

	<fieldset>
		<legend>Repeating <small>How Often it happens <?php $this->DocLink('http://docs.qody.co/plugins/specific-products/alejandro-qodys-redirector/redirect-rules/repeating/'); ?></small></legend>
		
		<?php $nextItem = 'redirect_again'; ?>
		<?php $nextValue = $custom[ $nextItem ]; ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Allow Repeat Redirects</label>
			<div class="controls">
				
				<label class="radio">
					<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="jQuery('#redirect_again_content').slideUp();" <?php echo $nextValue == 'yes' ? 'checked="checked"' : ''; ?> value="yes">
					Yes - visitors can get redirected multiple times
				</label>
				
				<label class="radio">
					<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="jQuery('#redirect_again_content').slideDown();" <?php echo $nextValue == 'no' ? 'checked="checked"' : ''; ?> value="no">
					No - visitors will only get redirected once
				</label>
			</div>
		</div>
		
		<div id="redirect_again_content" style="display:<?php echo $custom['redirect_again'] == 'no' ? 'block' : 'none'; ?>;">
			<?php $nextItem = 'redirect_wait_period'; ?>
			<?php $nextValue = $custom[ $nextItem ]; ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">Wait period</label>
				<div class="controls">
					<select name="field_<?php echo $nextItem; ?>">
						<?php
						if( !$nextValue )
							$nextValue = 60*60*24*30;
							
						for( $i = 1; $i < 31; $i++ )
						{
							$real_value = $i*60*60*24; ?>
						<option <?php echo $nextValue == $real_value ? 'selected="selected"' : ''; ?> value="<?php echo $real_value; ?>">once every <?php echo $i; ?> days</option>
						<?php						
						} ?>
					</select>
					
					<span class="help-block">Choose how long visitors must wait before being redirected again (if consecutive redirect is disabled)</span>
				</div>
			</div>
			
			<?php $nextItem = 'cookie_scope'; ?>
			<?php $nextValue = $custom[ $nextItem ] ? $custom[ $nextItem ] : 'rule'; ?>
			<div class="control-group">
				<label class="control-label" for="<?php echo $nextItem; ?>">Cookie Scope</label>
				<div class="controls">
					
					<label class="radio">
						<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'rule' ? 'checked="checked"' : ''; ?> value="rule">
						Redirect Rule - repeat redirection solely based on this rule
					</label>
					
					<label class="radio">
						<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'global' ? 'checked="checked"' : ''; ?> value="global">
						Global - repeat redirection based on any rule used
					</label>
				</div>
			</div>
			
		</div>
	
	</fieldset>

</div>

	
<div class="form-actions">
	<button type="submit" class="btn btn-primary">Save changes</button>
	<a href="<?php echo $this->AdminUrl(); ?>" class="btn">Cancel</a>
</div>







