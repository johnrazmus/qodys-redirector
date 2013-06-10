<?php 
global $post, $custom;

$custom['rotation_type'] = $custom['rotation_type'] ? $custom['rotation_type'] : 'random';
?>

<?php $nextItem = 'last_processed'; ?>
<input type="hidden" name="field_<?php echo $nextItem; ?>" value="<?php echo $custom[ $nextItem ] ? $custom[ $nextItem ] : 0; ?>">

<fieldset>
	<legend>Rotation Type</legend>
	
	<?php $nextItem = 'post_title'; ?>
	<?php $nextValue = $this->Helper('tools')->Clean( $post ? $post->post_title : 'New link rotation' ); ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Link Rotation Name</label>
		<div class="controls">
			<input type="text" class="span11" id="<?php echo $nextItem; ?>" name="<?php echo $nextItem; ?>" value="<?php echo $nextValue; ?>">
			<span class="help-block">Used internally for recognition</span>
		</div>
	</div>
	
	<?php $nextItem = 'rotation_type'; ?>
	<?php $nextValue = $custom[ $nextItem ]; ?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $nextItem; ?>">Rotation Method</label>
		<div class="controls">
		
			<label class="radio">
				<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'random' ? 'checked="checked"' : ''; ?> value="random" onclick="ToggleRotationTypeSettings('#rotation_type_random'); HideWeights();">
				<?php echo $this->GetRotationTypeIcon( 'random' ); ?> Random
			</label>
			<label class="radio">
				<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'sequential' ? 'checked="checked"' : ''; ?> value="sequential" onclick="ToggleRotationTypeSettings('#rotation_type_sequential');HideWeights();">
				<?php echo $this->GetRotationTypeIcon( 'sequential' ); ?> Sequential
			</label>
			<label class="radio">
				<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'least_hit' ? 'checked="checked"' : ''; ?> value="least_hit" onclick="ToggleRotationTypeSettings('#rotation_type_least_hit'); ShowWeights();">
				<?php echo $this->GetRotationTypeIcon( 'least_hit' ); ?> Least Hit
			</label>
			<label class="radio">
				<input type="radio" name="field_<?php echo $nextItem; ?>" <?php echo $nextValue == 'weighted' ? 'checked="checked"' : ''; ?> value="weighted" onclick="ToggleRotationTypeSettings('#rotation_type_weighted'); ShowWeights();">
				<?php echo $this->GetRotationTypeIcon( 'weighted' ); ?> Weighted
			</label>
			
		</div>
	</div>
	
	<div class="rotation_type_options" id="rotation_type_random" style="display:<?php echo $custom['rotation_type'] == 'random' ? 'block' : 'none'; ?>;">
		
		<div class="control-group">
			<label class="control-label"><i>Explanation</i></label>
			<div class="controls">
				The random rotation method will select a random URL from your list of URLs. Based on the 
				<a target="_blank" href="http://en.wikipedia.org/wiki/Law_of_averages">law of averages</a> 
				your URLs will always receive roughly the same amount of turns.
			</div>
		</div>
		
	</div>
	<div class="rotation_type_options" id="rotation_type_least_hit" style="display:<?php echo $custom['rotation_type'] == 'least_hit' ? 'block' : 'none'; ?>;">
		
		<div class="control-group">
			<label class="control-label"><i>Explanation</i></label>
			<div class="controls">
				<p>The "least hit" method will always select the URL that's received the least amount of turns 
				from your list of URL. This method can be useful if you have just added a new URL to the 
				Link Rotation and you want it to receive more traffic.</p>
				
				<p>Once the turns are equal amongst all URLs, this method will act just like the sequential 
				rotation method.</p>
			</div>
		</div>
		
	</div>
	<div class="rotation_type_options" id="rotation_type_sequential" style="display:<?php echo $custom['rotation_type'] == 'sequential' ? 'block' : 'none'; ?>;">
		
		<div class="control-group">
			<label class="control-label"><i>Explanation</i></label>
			<div class="controls">
				The sequential method will use each URL in order. It evenly distributes traffic between all 
				URLs, guaranteeing them to each have a turn.
			</div>
		</div>
		
	</div>
	<div class="rotation_type_options" id="rotation_type_weighted" style="display:<?php echo $custom['rotation_type'] == 'weighted' ? 'block' : 'none'; ?>;">
		
		<div class="control-group">
			<label class="control-label"><i>Explanation</i></label>
			<div class="controls">
				<p>This method will choose a URL based on it's weight measured against the weight for all other 
				URLs. Think of it as a lottery, and each point of weight is a ticket.</p>
				
				<p>If you have 3 urls and set their weights to 3, 2, 1 this means the first URL would be three 
				times more likely to be chosen than the third URL and the second URL would get picked roughly 
				twice as much as the third URL. Setting the the weights of the URL's to 30,20,10 would produce 
				the exact same result.</p>
			</div>
		</div>
		
	</div>
	
</fieldset>

<fieldset>
	<legend>Destination Urls</legend>
	
	<?php
	for( $i = 1; $i <= 10; $i++ )
	{ ?>
	
	<div class="row-fluid" style="padding-top:5px;">
		<div class="span1">
			<div style="padding-top:5px;"><?php echo $i; ?>)</div>
		</div>
		
		<?php $nextItem = 'destination_url'; ?>
		<?php $nextValue = $custom[ $nextItem ][ $i ]; ?>
		<div class="span8">
			<input type="text" class="span12" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>[<?php echo $i; ?>]" value="<?php echo $nextValue; ?>" placeholder="ex. http://sales.com/product">
		</div>
		
		<div class="span3 weight_container" style="display:<?php echo $custom['rotation_type'] == 'weighted' || $custom['rotation_type'] == 'least_hit' ? 'block' : 'none'; ?>">
			
			<div class="row-fluid">
				<?php $nextItem = 'hits'; ?>
				<?php $nextValue = $custom[ $nextItem ][ $i ]; ?>
				<div class="input-append span6">
					<input type="text" class="span7" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>[<?php echo $i; ?>]" value="<?php echo $nextValue; ?>">
					<span class="add-on">
						<i class="icon-screenshot" title="Hits"></i>
					</span>
				</div>
				
				<?php $nextItem = 'weight'; ?>
				<?php $nextValue = $custom[ $nextItem ][ $i ]; ?>
				<div class="input-prepend span6">
					<span class="add-on">
						<i class="icon-leaf" title="Weight"></i>
					</span>
					<input type="text" class="span6" id="<?php echo $nextItem; ?>" name="field_<?php echo $nextItem; ?>[<?php echo $i; ?>]" value="<?php echo $nextValue; ?>">					
				</div>
			</div>
			
		</div>
	</div>
	
	<?php
	} ?>
	
</fieldset>

<div class="form-actions">
	<button type="submit" class="btn btn-primary">Save changes</button>
	<a href="<?php echo $this->AdminUrl(); ?>" class="btn">Cancel</a>
</div>







