<?php
$frame_url = $custom['remote_url'];
$destination_url = $custom['destination_url'];
$rule_id = $custom['redirect_rule'];
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title></title>
<style>
body {
	padding:0px;
	margin:0px;
	height:100%;
	width:100%;
	overflow:hidden;
}
iframe {
	height:100%;
	width:100%;
}
.core_iframe {
	width:100%;
	height:100%;
	position:absolute;
	top:0; 
	left:0; 
	right:0; 
	bottom:0;
	z-index:2;
}
.container {
	height:100%;
	width:100%;
	position:absolute;
	top:0; 
	left:0; 
	right:0; 
	bottom:0;
	z-index:888;
}
</style>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>

	<script src="<?php echo $this->GetRegisteredSrc( 'bootstrap-everything', 'script' ); ?>"></script>
	<link href="<?php echo $this->GetRegisteredSrc( 'restricted-bootstrap' ); ?>" rel="stylesheet">
	<link href="<?php echo $this->DataType( 'rule' )->GetAsset( 'css', 'action_type_modal', 'css', 'url' ); ?>" rel="stylesheet">
</head>
<body class="qody_only_area">
	<iframe class="core_iframe" src="<?php echo $frame_url; ?>" height="100%" width="100%" frameborder="0" scrolling="yes" style="border:none;"></iframe>
	
	<?php
	$this->DataType( 'rule' )->PrintRedirectVariables( $rule_id, $is_remote=true );
	?>
	
</body>
</html>