<?php 
$adv_redirectPage = $this->get_option( 'adv_redirectPage' ); // on and off
$adv_redirectDelay = $this->get_option( 'adv_redirectDelay' ); //time delay
$headerTrackCode = $this->get_option( 'headerTrackCode' );
$footerTrackCode = $this->get_option( 'footerTrackCode' );
$redirect_padding = $this->Helper('tools')->CleanForInput( $this->get_option( 'redirect_padding' ) );
$redirect_detection = $this->Helper('tools')->CleanForInput( $this->get_option( 'redirect_detection' ) );

$mouse_direction = $this->get_option( 'mouse_direction' );
$redirect_left_margin = $this->Helper('tools')->CleanForInput( $this->get_option( 'redirect_left_margin' ) );
$redirect_right_margin = $this->Helper('tools')->CleanForInput( $this->get_option( 'redirect_right_margin' ) );

$ignore_specifics = $this->get_option( 'ignore_specifics' );

// disable
$adv_redirectPage = -1;
?>
<table class="form-table">
	<tbody>
		<tr>
		<?php $nextItem = 'redirect_padding'; ?>
			<th><label for="<?php echo $nextItem; ?>">Vertical Trigger Padding</label></th>
			<td><!-- cartpage_id -->
				<input class="widefat" type="text" value="<?php echo $redirect_padding; ?>" class="full" name="<?php echo $nextItem; ?>" size="35" style="width:75px;" id="<?php echo $nextItem; ?>"> pixels
				<span class="howto">This measures how far from the top of the browser tab the users mouse must be to 
				activate the redirect.  The higher the pixels, the further down from the top of the page the redirect will trigger.
				15 is recommend for normal use, or if you want it to trigger quicker, set it to 50-100.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label>Horizontal Trigger Margin</label></th>
			<td>
				<div style="margin-right:40px; display:inline;">
					Left-side: <input class="widefat" type="text" value="<?php echo $redirect_left_margin; ?>" class="full" name="redirect_left_margin" size="35" style="width:75px;"> pixels
				</div>
				
				Right-side: <input class="widefat" type="text" value="<?php echo $redirect_right_margin; ?>" class="full" name="redirect_right_margin" size="35" style="width:75px;"> pixels				
				
				<span class="howto">This measures how far from the left or right the browser window a user CAN'T be to trigger the redirect.
				Use this if you don't want the redirect happening when a user tries to use the right-side browser scrollbar for instance,
				so setting a 100px right margin would prevent the redirect from triggering if the user was within 100px of the right side 
				of the screen, even if their mouse went above the standard verticle trigger-padded area.</span>
			</td>
		</tr>
		<tr>
			<?php $nextItem = 'mouse_direction'; ?>
			<th><label for="capY">Mouse Movement Direction</label></th>
			<td>
				<label>
					<input type="radio" name="<?php echo $nextItem; ?>" value="both" <?php if( $mouse_direction == 'both' ) echo 'checked="checked"'; ?>>
					Either Direction
				</label>
				<label>
					<input type="radio" name="<?php echo $nextItem; ?>" value="up" <?php if( $mouse_direction == 'up' || !$mouse_direction ) echo 'checked="checked"'; ?>>
					Upward Movement
				</label>
				<label>
					<input type="radio" name="<?php echo $nextItem; ?>" value="down" <?php if( $mouse_direction == 'down' ) echo 'checked="checked"'; ?>>
					Downward Movement
				</label>
				<span class="howto">Set which mouse movement type a user must perform to trigger the redirect</span>
			</td>
		</tr>
		<tr>
			<?php $nextItem = 'ignore_specifics'; ?>
			<th><label for="capY">Ignore page-specific settings?</label></th>
			<td>
				<label>
					<input type="radio" name="<?php echo $nextItem; ?>" value="yes" <?php if( $ignore_specifics == 'yes' ) echo 'checked="checked"'; ?>>
					Yes
				</label>
				<label>
					<input type="radio" name="<?php echo $nextItem; ?>" value="no" <?php if( $ignore_specifics == 'no' || !$ignore_specifics ) echo 'checked="checked"'; ?>>
					No
				</label>
				<span class="howto">Set if you want to ignore specificity. This can be useful for split-testing global vs page-specific options in bulk.</span>
			</td>
		</tr>
		<!--<tr>
		<?php $nextItem = 'redirect_detection'; ?>
			<th><label for="<?php echo $nextItem; ?>">Initialization Delay</label></th>
			<td>
				<input class="widefat" type="text" value="<?php echo $redirect_detection; ?>" class="full" name="<?php echo $nextItem; ?>" size="35" style="width:75px;" id="<?php echo $nextItem; ?>" > Seconds
				<span class="howto">Set a delay in seconds to wait after the page loads for a visitor before 
				detecting & checking for a redirect action to happen. This is useful when you want the visitor 
				to see a video or read a paragraph before accidentally sending them off.  1 second is recommended for normal use, 
				or if you want the user to stay on the page longer before triggering, 10-30+ seconds should suffice.</span>
			</td>
		</tr>-->
		
		<!--<tr>
		<?php $nextItem = 'adv_redirectPage'; ?>
			<th><label for="capY">Use Tracking Page?</label></th>
			<td><label>
					<input onclick="jQuery('#capdiv').show();" type="radio" name="<?php echo $nextItem; ?>" value="1" id="capY" <?php if( $adv_redirectPage == '1' ) echo 'checked="checked"'; ?>>
					Yes</label>
				<label>
					<input onclick="jQuery('#capdiv').hide();" type="radio" name="<?php echo $nextItem; ?>" value="-1" id="capN" <?php if ($adv_redirectPage == '-1' || !$adv_redirectPage) echo 'checked="checked"'; ?>>
					No</label>
				<span class="howto">click "Yes"  to enable advanced goal tracking options</span></td>
		</tr>-->
	</tbody>
</table>
<fieldset>
	<legend>Referrer Settings</legend>
	
		<?php $nextItem = 'redirect_ref_only_if'; ?>
		<?php $nextValue = $this->get_option( $nextItem, true ); ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Redirect <strong>only if</strong><br>referred from here</label>
			<div class="controls">
				<textarea class="span4" id="<?php echo $nextItem; ?>" rows="5" name="<?php echo $nextItem; ?>" placeholder="Comma-separated referrers list"><?php echo $nextValue; ?></textarea>
				<span class="help-inline">(optional)</span>
				<span class="help-block">(ex. google.com, ?p=241, http://somesite.com/whatever)</span>
				<span class="help-block">
					<strong>Note:</strong> if you put something in here, it will trigger redirects 
					<strong>only for referrers in this list</strong>.
				</span>
			</div>
		</div>
		
		<?php $nextItem = 'redirect_ref_only_if_not'; ?>
		<?php $nextValue = $this->get_option( $nextItem, true ); ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Redirect <strong>only if not</strong><br>referred from here</label>
			<div class="controls">
				<textarea class="span4" id="<?php echo $nextItem; ?>" rows="5" name="<?php echo $nextItem; ?>" placeholder="Comma-separated referrers list"><?php echo $nextValue; ?></textarea>
				<span class="help-inline">(optional)</span>
				<span class="help-block">(ex. google.com, ?p=241, http://somesite.com/whatever)</span>
				<span class="help-block">
					<strong>Note:</strong> if you put something in here, it will trigger redirects 
					<strong>only for referrers not in this list</strong>.
				</span>
			</div>
		</div>
		
		<?php $nextItem = 'redirect_ref_if_blank'; ?>
		<?php $nextValue = $this->get_option( $nextItem ); ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Allow blank referrers?</label>
			<div class="controls">
				<label class="radio inline">
					<input type="radio" name="<?php echo $nextItem; ?>" <?php echo $nextValue == 'yes' || !$nextValue ? 'checked="checked"' : ''; ?> value="yes">
					Yes, eligible to redirect
				</label>
				<label class="radio inline">
					<input type="radio" name="<?php echo $nextItem; ?>" <?php echo $nextValue == 'no' ? 'checked="checked"' : ''; ?> value="no">
					No, not eligible to redirect
				</label>
				<span class="help-block">
					<strong>Note:</strong> by setting this to no, anytime someone doesn't have a referrer, they'll never get redirected.
				</span>
			</div>
		</div>
	
</fieldset>




<div id="capdiv" style="display: <?php if( $adv_redirectPage == '1' ) echo 'block'; else echo 'none'; ?>; ">
	<table class="form-table">
		<tbody>
	
		<tr>
		<?php $nextItem = 'adv_redirectDelay'; ?>
			<th><label for="<?php echo $nextItem; ?>">Redirect Delay</label></th>
			<td><!-- cartpage_id -->
				<input class="widefat" type="text" value="<?php echo $adv_redirectDelay; ?>" class="full" name="<?php echo $nextItem; ?>" size="35" style="width:75px;" id="<?php echo $nextItem; ?>"> Seconds
				<span class="howto">Delay in seconds to wait before redirecting. Increase delay if tracking isn't working</span>
			</td>
		</tr>
		
		<tr>
		<?php $nextItem = 'headerTrackCode'; ?>
			<th><label for="<?php echo $nextItem; ?>">Header Tracking Code</label></th>
			<td><!-- cartpage_id -->
				<textarea name="<?php echo $nextItem; ?>" class="widefat" id="<?php echo $nextItem; ?>"><?php echo $headerTrackCode; ?></textarea>
				<!--<span class="howto">For every post & page not specified below</span>-->
				</td>
		</tr>
		
		<tr>
		<?php $nextItem = 'footerTrackCode'; ?>
			<th><label for="<?php echo $nextItem; ?>">Footer Tracking Code</label></th>
			<td><!-- cartpage_id -->
				<textarea name="<?php echo $nextItem; ?>" class="widefat" id="<?php echo $nextItem; ?>" ><?php echo $footerTrackCode; ?></textarea>
				<!--<span class="howto">For every post & page not specified below</span>-->
				</td>
		</tr>
		</tbody>
	</table>
</div>

