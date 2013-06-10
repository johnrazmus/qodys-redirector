<?php
class qodyDatatype_RedirectorExternalRedirects extends QodyDataType
{
	function __construct()
    {
        $this->SetOwner( func_get_args() );
		$this->m_raw_file = __FILE__;
		
		$this->m_table_slug = 'externalrs';
        
		add_action( 'template_redirect', array( $this, 'CheckForUrlSlug' ) );
		
        parent::__construct();
    }
	
	function GetBoards( $account_id )
	{
		$data = $this->DataType( 'pin-board' )->Get( -1, 'account_id', $account_id );
		
		return $data;
	}
	
	function GetRedirectVariables( $post_id )
	{
		if( !$post_id )
			return;
			
		$custom = $this->get_datatype_custom( $post_id );
		
		$fields = array();
		$fields['enabled'] = 'yes';
		$fields['redirect_url'] = $custom['destination_url'];
		$fields['redirect_again'] = 'yes';
		$fields['redirect_padding'] = 30;
		$fields['object_to_detect'] = '.body_container';
		$fields['popup_width'] = is_numeric( $custom['popup_width'] ) ? $custom['popup_width'] : '';
		$fields['popup_height'] = is_numeric( $custom['popup_height'] ) ? $custom['popup_height'] : '';
		$fields['referrer'] = $this->GetRemoteLink( $post_id );
		
		return $fields;
	}
	
	function CheckForUrlSlug()
	{
		$url = preg_replace('#/$#','',urldecode($_SERVER['REQUEST_URI']));
		
		$remote_redirect = $this->IsUrlRemoteRedirect( $url, false );
		
		if( !$remote_redirect )
			return;
			
		$custom = $this->get_datatype_custom( $remote_redirect->ID );
		
		require( $this->GetAsset( 'includes', 'action', 'dir' ) );
		exit;
	}
	
	function IsUrlRemoteRedirect( $url, $check_domain = true )
	{
		$blog_url = get_option('home') ? get_option('home') : get_option('siteurl');
		
		// borrowed from Pretty Links Lite
		if( !$check_domain || preg_match( '#^' . preg_quote( $blog_url ) . '#', $url ) )
		{
			$bits = parse_url( $url );
			$path = $bits['path'];
			
			if( $path )
			{
				$bits = explode( '/', $path );
				$last_url_slug = $bits[ count( $bits ) - 1 ];
				
				if( $last_url_slug && ($data = $this->is_remote_link_slug( $last_url_slug )) )
					return $data;
			}
		}
		
		return false;
	}
	
	function is_remote_link_slug($slug)
	{
		if( !$slug )
			return;
			
		return $this->GetFromSlug( urldecode($slug) );
	}
	
	function GetFromSlug( $slug )
	{
		$fields = array();
		$fields['meta_key'] = 'url_slug';
		$fields['meta_value'] = $slug;
		
		$data = $this->GetPosts( $fields );
		
		return isset( $data ) ? $data[0] : null;
    }
	
	function GetRemoteLink( $remote_redirect_id )
	{
		$custom = $this->get_datatype_custom( $remote_redirect_id );
		$slug = $custom['url_slug'];
		
		if( !$slug )
			return '#';
		
		$url = rtrim( get_bloginfo('url'), '/' ).'/'.$slug;
		
		return $url;
	}
}
?>