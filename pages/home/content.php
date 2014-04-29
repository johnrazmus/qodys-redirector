<?php
$plugin_data = $this->GetPluginData();

$fields = array();
$fields['p'] = 'qodys-redirector';
$fields['blog'] = get_bloginfo('url');

$frame_url = 'http://razmus.net/frames/plugin_home.php?'.http_build_query( $fields );
?>

<div class="wrap qody_only_area">
	
	<div class="page-header">
		<h1><?php echo $plugin_data['Name']; ?> <small>version <?php echo $plugin_data['Version']; ?></small></h1>
	</div>
	
	<?php $this->Helper('postman')->DisplayMessages(); ?>
	
	<div class="row-fluid" style="height:100%;">
		<div class="span12" style="height:100%;">
			
			<iframe src="<?php echo $frame_url; ?>" style="height:80%; width:100%; border:none;"></iframe>
			
		</div>
	</div>
	
</div>