<?php
//the_post();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php wp_title(); ?></title>
<style>
html,body {
	padding:0px;
	margin:0px;
	height:100%;
	width:100%;
	overflow:hidden;
}
.fancy_box {
	-moz-box-shadow: 0 0 15px 5px #888;
	-webkit-box-shadow: 0 0 15px 5px#888;
	box-shadow: 0 0 15px 5px #888;
	margin: 15px 0;
	padding:0px;
}

</style>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>

	<script src="<?php echo $this->GetRegisteredSrc( 'bootstrap-everything', 'script' ); ?>"></script>
	<link href="<?php echo $this->GetRegisteredSrc( 'restricted-bootstrap' ); ?>" rel="stylesheet">
</head>
<body class="qody_only_area">
	<div class="container fancy_box">
		<div style="padding:15px;">
			
			<?php echo apply_filters( 'the_content', $this->Helper('tools')->Clean( $post->post_content ) ); ?>
			
		</div>
	</div>
	
</body>
</html>