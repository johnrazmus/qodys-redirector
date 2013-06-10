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

iframe {
	height:600px;
	width:100%;
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
	<link href="<?php echo $this->DataType( 'rule' )->GetAsset( 'css', 'action_type_modal', 'css', 'url' ); ?>" rel="stylesheet">
</head>
<body class="qody_only_area">
	<div class="container fancy_box"><iframe class="core_iframe" src="<?php echo $static_iframe_url; ?>" frameborder="0" scrolling="yes" style="border:none;"></iframe></div>
	
	<p style="text-align:center; margin-top:20px;">
		<a href="<?php echo $static_iframe_no_thanks_url; ?>" target="_top">
			<?php echo $theme_custom['no_thanks_text']; ?>
		</a>
	</p>
	
	<script>
	jQuery(document).ready( function() {
		
		jQuery('a').click( function(e) {
			
			if( window.opener )
			{
				//window.opener.top.location.href = '<?php echo $static_iframe_no_thanks_url; ?>';
				window.opener.location.href = '<?php echo $static_iframe_no_thanks_url; ?>';
				//window.close();
				self.close();
				//window.close();
			}
			
		} );
		
	} );
	</script>
	
</body>
</html>