<?php
require_once( dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))).'/wp-load.php' );

$response = array();

$post_id = $_GET['post_id'];

if( $post_id )
{
	if( $qodys_pinner->DataType('account')->UpdateBoards( $post_id ) )
	{
		$response['results'][] = 'Pin boards fetched, created, and updated successfully';
	}
	else
	{
		$response['errors'][] = 'Unable to fetch or update pin boards; please try again';
	}
}

$qodys_pinner->Helper('postman')->SetMessage( $response );

$url = $qodys_pinner->Helper('tools')->GetPreviousPage();

header( "Location: ".$url );
exit;
?>