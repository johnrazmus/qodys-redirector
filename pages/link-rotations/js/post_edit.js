function ToggleRotationTypeSettings( thing_to_show )
{
	jQuery('.rotation_type_options').each( function(e) {
		
		if( jQuery(this).attr('id') != jQuery(thing_to_show).attr('id') )
			jQuery(this).slideUp();
		else
			jQuery(thing_to_show).slideDown();
	} );
}

function ShowWeights()
{
	jQuery('.weight_container').fadeIn();
}
function HideWeights()
{
	jQuery('.weight_container').fadeOut();
}

function ShowHits()
{
	jQuery('.hit_container').fadeIn();
}
function HideHits()
{
	jQuery('.hit_container').fadeOut();
}

jQuery(document).ready( function() {

	//DoAmazonBrowsenode();
	
	jQuery('.chzn-select').chosen( {
		allow_single_deselect: true
	});
	
	
	
} );