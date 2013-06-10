<?php
require_once( dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))).'/wp-load.php' );

if( $qodys_redirector )
{
	$ip 			= $qodys_redirector->Helper('tools')->getRealIP();
	$redirect_url 	= $_GET['redirect_url'];
	$post_id 		= $_GET['post_id'];
	$ref 			= $_GET['ref'];

	$fields = array();
	$fields['post_title'] = "Redirect Record";
	
	$new_post_id = $qodys_redirector->DataType( 'record' )->wp_insert_post( $fields );
	
	$qodys_redirector->DataType( 'record' )->update_datatype_meta( $new_post_id, 'ip_address', $ip );
	$qodys_redirector->DataType( 'record' )->update_datatype_meta( $new_post_id, 'from_url', $ref );
	$qodys_redirector->DataType( 'record' )->update_datatype_meta( $new_post_id, 'to_url', $redirect_url );
	$qodys_redirector->DataType( 'record' )->update_datatype_meta( $new_post_id, 'post_id', $post_id );	
}
?>