function ToggleActionTypeSettings( thing_to_show )
{
	jQuery('.action_type_options').each( function(e) {
		
		if( jQuery(this).attr('id') != jQuery(thing_to_show).attr('id') )
			jQuery(this).slideUp();
		else
			jQuery(thing_to_show).slideDown();
	} );
}

function ToggleUrlTypeSettings( thing_to_show )
{
	jQuery('.url_type_options').each( function(e) {
		
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
	
	
	
} );