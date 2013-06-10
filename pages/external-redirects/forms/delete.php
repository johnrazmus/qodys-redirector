<?php
require_once( dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))).'/wp-load.php' );

$response = array();
		
$post_data = array_merge( $_GET, $_POST );

if( $post_data )
{
	$post_ids = $post_data['post_ids'];
	
	if( !$post_ids )
	{
		$response['errors'][] = 'No items selected for deletion';
	}
	else
	{
		$qodys_redirector->DataType( 'external-redirect' )->DeletePosts( $post_ids );
		
		$response['results'][] = count( $post_ids ).' item'.(count( $post_ids ) > 1 ? 's' : '').' '.(count( $post_ids ) > 1 ? 'have' : 'has').' been deleted';
		
		$url = $post_data['success_url'] ? $post_data['success_url'] : $qodys_redirector->Page( 'external-redirects' )->AdminUrl();
	}
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