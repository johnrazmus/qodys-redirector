function ToggleThemeSpecificSettings( thing_to_show )
{
	jQuery('.theme_specific_settings').each( function(e) {
		
		if( jQuery(this).attr('id') != jQuery(thing_to_show).attr('id') )
			jQuery(this).slideUp();
		else
			jQuery(thing_to_show).slideDown();
	} );
}

function ToggleStaticIframeUrlTypeSettings( thing_to_show )
{
	jQuery('.static_iframe_url_type_options').each( function(e) {
		
		if( jQuery(this).attr('id') != jQuery(thing_to_show).attr('id') )
			jQuery(this).slideUp();
		else
			jQuery(thing_to_show).slideDown();
	} );
}

jQuery(document).ready( function() {

	//DoAmazonBrowsenode();
	
	jQuery('.chzn-select').chosen( {
		allow_single_deselect: true
	});
	
	tinyMCE.init({
		mode : "exact",
		elements: "a_nice_textarea",
		theme : "simple"
	});
	
	jQuery('#social_image_url_trigger').click( function()
	{
		formfield = jQuery('#social_image_url').attr('name');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	} );
	 
	window.send_to_editor = function(html)
	{
		imgurl = jQuery('img',html).attr('src');
		
		jQuery('#social_image_url').val(imgurl);
		tb_remove();
	}
	
} );