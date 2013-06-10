<?php
require_once( dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))).'/wp-load.php' );

$response = array();

if( $_POST )
{
	if( !$_POST['enable_redirect'] )
		$_POST['enable_redirect'] = '';
	
	if( !$_POST['redirect_again'] )
		$_POST['redirect_again'] = '';
	
	foreach( $_POST as $key => $value )
	{
		$qodys_redirector->update_option( $key, $value );
	}
	
	$response['results'][] = 'Settings have been saved';
}
else
{
	$response['errors'][] = 'Any unexpected error occured; please try again';
}

$qodys_redirector->Helper('postman')->SetMessage( $response );

$url = $qodys_redirector->Helper('tools')->GetPreviousPage();

header( "Location: ".$url );
exit;
?>