
<fieldset>
	<legend>Mouse Options <small>- Advanced</small></legend>
	
	<?php $nextItem = 'redirect_padding'; ?>
	<?php $nextValue = $this->get_option( $nextItem ); ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Vertical Trigger Padding</label>
		<div class="controls">
			<input type="text" class="span4" id="<?php echo $nextItem; ?>" name="<?php echo $nextItem; ?>" value="<?php echo $nextValue ? $nextValue : 30; ?>">
			<span class="help-block">This measures (in pixels) how far from the top of the browser tab the users mouse must be to 
			activate the redirect.  The higher the pixels, the further down from the top of the page the redirect will trigger.
			15 is recommend for normal use, or if you want it to trigger quicker, set it to 50-100.</span>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Horizontal Trigger Margin</label>
		<div class="controls">
			<?php $nextItem = 'redirect_left_margin'; ?>
			<?php $nextValue = $this->get_option( $nextItem ); ?>
			Left-side: <input type="text" class="span3" id="<?php echo $nextItem; ?>" name="<?php echo $nextItem; ?>" value="<?php echo $nextValue ? $nextValue : 0; ?>">
			
			<?php $nextItem = 'redirect_right_margin'; ?>
			<?php $nextValue = $this->get_option( $nextItem ); ?>
			Right-side: <input type="text" class="span3" id="<?php echo $nextItem; ?>" name="<?php echo $nextItem; ?>" value="<?php echo $nextValue ? $nextValue : 0; ?>">
			
			<span class="help-block">This measures how far from the left or right the browser window a user CAN'T be to trigger the redirect.
			Use this if you don't want the redirect happening when a user tries to use the right-side browser scrollbar for instance,
			so setting a 100px right margin would prevent the redirect from triggering if the user was within 100px of the right side 
			of the screen, even if their mouse went above the standard verticle trigger-padded area.</span>
		</div>
	</div>
	
	<?php $nextItem = 'mouse_direction'; ?>
	<?php $nextValue = $this->get_option( $nextItem ); ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Mouse Movement Direction</label>
		<div class="controls">
			
			<label class="radio">
				<input type="radio" name="<?php echo $nextItem; ?>" <?php echo $nextValue == 'both' ? 'checked="checked"' : ''; ?> value="both">
				Either Direction
			</label>
			<label class="radio">
				<input type="radio" name="<?php echo $nextItem; ?>" <?php echo $nextValue == 'up' || !$nextValue ? 'checked="checked"' : ''; ?> value="up">
				Upward Movement
			</label>
			<label class="radio">
				<input type="radio" name="<?php echo $nextItem; ?>" <?php echo $nextValue == 'down' ? 'checked="checked"' : ''; ?> value="down">
				Downward Movement
			</label>
			
			<span class="help-block">Set which mouse movement type a user must perform to trigger the redirect</span>				
		</div>
	</div>

</fieldset>

<fieldset>
	<legend>Referrer Options <small>- Advanced</small></legend>
	
		<?php $nextItem = 'redirect_ref_only_if'; ?>
		<?php $nextValue = $this->get_option( $nextItem, true ); ?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $nextItem; ?>">Redirect <strong>only if</strong><br>referred from here</label>
			<div class="controls">
				<textarea class="span10" id="<?php echo $nextItem; ?>" rows="5" name="<?php echo $nextItem; ?>" placeholder="Comma-separated referrers list"><?php echo $nextValue; ?></textarea>
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
				<textarea class="span10" id="<?php echo $nextItem; ?>" rows="5" name="<?php echo $nextItem; ?>" placeholder="Comma-separated referrers list"><?php echo $nextValue; ?></textarea>
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
				<label class="radio">
					<input type="radio" name="<?php echo $nextItem; ?>" <?php echo $nextValue == 'yes' || !$nextValue ? 'checked="checked"' : ''; ?> value="yes">
					Yes - eligible to redirect
				</label>
				<label class="radio">
					<input type="radio" name="<?php echo $nextItem; ?>" <?php echo $nextValue == 'no' ? 'checked="checked"' : ''; ?> value="no">
					No - not eligible to redirect
				</label>
				<span class="help-block">
					<strong>Note:</strong> by setting this to no, anytime someone doesn't have a referrer, they'll never get redirected.
				</span>
			</div>
		</div>
	
</fieldset>

<div class="form-actions">
	<button type="submit" class="btn btn-primary">Save changes</button>
</div>