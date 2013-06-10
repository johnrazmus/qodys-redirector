<?php
require_once( dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))).'/wp-load.php' );

$response = array();

$data = $qodys_redirector->DataType( 'record' )->Get();

if( $data )
{
	foreach( $data as $key => $value )
	{
		$qodys_redirector->DataType('record')->DeletePosts( $value->ID );
	}
}

$response['results'][] = 'Database has been cleared of '.count( $data ).' records';


$qodys_redirector->Helper('postman')->SetMessage( $response );

if( !$url )
	$url = $qodys_redirector->Helper('tools')->GetPreviousPage();

header( "Location: ".$url );
exit;
?>