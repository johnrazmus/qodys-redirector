<?php
$plugin_data = $this->GetPluginData();

$doc_url = $_GET['doc_url'] ? $_GET['doc_url'] : 'http://docs.qody.co/plugins/specific-products/alejandro-qodys-redirector/';
?>

<div class="wrap qody_only_area">
	
	<div class="page-header">
		<h1><?php echo $plugin_data['Name']; ?> <small>version <?php echo $plugin_data['Version']; ?></small></h1>
	</div>
	
	
	<?php $this->Helper('postman')->DisplayMessages(); ?>
	
	<div class="row-fluid">
		<div class="span12">
			
			<iframe src="<?php echo $doc_url; ?>" style="height:80%; width:100%; border:none;"></iframe>
			
		</div>
	</div>
	
</div>