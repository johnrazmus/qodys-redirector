<?php
require_once( dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))).'/wp-load.php' );

$response = array();

$post_id = $_POST['post_id'];
$data = $qodys_pinner->DataType( 'pin-history' )->Get( -1, 'account_id', $post_id );

if( $data )
{
	foreach( $data as $key => $value )
	{
		$qodys_pinner->DataType('pin-history')->DeletePosts( $value->ID );
	}
}

$response['results'][] = 'Account has been successfully cleared of '.count( $data ).' logged history items';


$qodys_pinner->Helper('postman')->SetMessage( $response );

if( !$url )
	$url = $qodys_pinner->Helper('tools')->GetPreviousPage();

header( "Location: ".$url );
exit;
?>