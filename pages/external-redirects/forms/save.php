<?php
require_once( dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))).'/wp-load.php' );

$response = array();
		
$post_data = array_merge( $_GET, $_POST );

if( $post_data )
{
	$post_id = $post_data['post_id'];
	$new_post_id = $qodys_redirector->DataType( 'external-redirect' )->SavePost( $post_data, $post_id );
	
	$response['results'][] = 'Saved.';
	
	$url = $post_data['success_url'] ? $post_data['success_url'] : '';
}
else
{
	$response['errors'][] = 'Any unexpected error occured; please try again';
}

$qodys_redirector->Helper('postman')->SetMessage( $response );

if( !$url )
	$url = $qodys_redirector->Helper('tools')->GetPreviousPage();

header( "Location: ".$url );
exit;
?>