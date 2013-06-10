<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $theme_custom['title']; ?></title>
<meta name="description" content="<?php echo $theme_custom['description']; ?>">

<meta property="og:url" content="<?php echo $this->DataType( 'interceptor' )->GetRemoteLink( $post->ID ); ?>" />
<meta property="og:title" content="<?php echo $theme_custom['title']; ?>"/>
<meta property="og:description" content="<?php echo $theme_custom['description']; ?>"/>
<meta property="og:image" content="<?php echo $theme_custom['social_image_url']; ?>"/>

<meta itemprop="name" content="<?php echo $theme_custom['title']; ?>">
<meta itemprop="description" content="<?php echo $theme_custom['description']; ?>">
<meta itemprop="image" content="<?php echo $theme_custom['social_image_url']; ?>">
<style>
body {
	padding:0px;
	margin:0px;
	height:100%;
	width:100%;
	overflow:hidden;
}
.core_iframe {
	width:100%;
	height:100%;
	/*height:97%;
	bottom:-41px;
	top:41px; */
	position:absolute;
	left:0; 
	right:0; 
	z-index:2;
}

@media (max-width: 979px) {
	.navbar-fixed-top {
		margin-bottom:0px !important;
		position:fixed !important;
	}
	.navbar-fixed-top .navbar-inner {
		padding:0px !important;
	}
}
@media (max-width: 767px) {
	.navbar-fixed-top, .navbar-fixed-bottom, .navbar-static-top {
		margin-left: 0px !important;
		margin-right: 0px !important;
	}
}
ul.nav {
	
}
ul.nav.pull-right li {
	padding:8px 0px 0px 0px;
	margin-left:10px;
}
ul.nav.pull-left li {
	padding:8px 0px 0px 0px;
	margin-right:10px;
}
</style>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>

	<script src="<?php echo $this->GetRegisteredSrc( 'bootstrap-everything', 'script' ); ?>"></script>
	<link href="<?php echo $this->GetRegisteredSrc( 'restricted-bootstrap' ); ?>" rel="stylesheet">
	<link href="<?php echo $this->DataType( 'rule' )->GetAsset( 'css', 'action_type_modal', 'css', 'url' ); ?>" rel="stylesheet">
	
	<?php echo $theme_custom['header_paste']; ?>
	
</head>
<body class="qody_only_area">
	
	<iframe class="core_iframe" src="<?php echo $theme_custom['destination_url']; ?>" height="100%" width="100%" frameborder="0" scrolling="yes" style="border:none;"></iframe>
	
</body>
</html>