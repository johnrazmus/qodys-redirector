<?php 
global $post, $custom;

$custom['interceptor_theme'] = $custom['interceptor_theme'] ? $custom['interceptor_theme'] : 'none';

$themes = $this->GetThemes();
?>
			
<?php $nextItem = 'interceptor_theme'; ?>
<?php $nextValue = $custom[ $nextItem ]; ?>
<div class="control-group">

	<div class="controls" style="margin-left:0px;">
		
	<?php
	array_unshift( $themes, 'none' );
	
	if( $themes )
	{
		foreach( $themes as $key => $value )
		{
			if( $nextValue == $value )
				$selected = 'checked="checked"';
			else
				$selected = ''; ?>
		<label class="radio">
			<input type="radio" name="field_<?php echo $nextItem; ?>" onclick="ToggleThemeSpecificSettings( '#theme_<?php echo $value; ?>' );" <?php echo $selected; ?> value="<?php echo $value; ?>">
			<?php echo $this->Helper('tools')->GetFromSlug($value); ?>
		</label>
		<?php
		}
	} ?>
		<!--<span class="help-block" style="margin-top:10px; background-color:transparent;">Learn about creating themes</span>-->
	</div>
</div>