<?php
class qodyController_RedirectorInterceptor extends QodyContentController
{
	function __construct()
	{
		$this->SetOwner( func_get_args() );
		
		parent::__construct();
	}
	
	// for custom post type
	function WhenOnPage()
    {
		if( !parent::WhenOnPage() )
			return;
		
    }
	
	function GetRealTheme()
	{
		$interceptor_id = $this->DataType( 'interceptor' )->FetchId();		
		$custom = $this->get_datatype_custom( $interceptor_id, 'interceptor' );
		
		$theme = $custom['interceptor_theme'];
		
		return $theme;
	}
	
	function GetThemeCustom()
	{
		$interceptor_id = $this->DataType( 'interceptor' )->FetchId();
		$custom = $this->get_datatype_custom( $interceptor_id, 'interceptor' );
		
		$real_theme = $this->GetRealTheme();
		$theme_custom = maybe_unserialize( $custom[ $real_theme ] );
		
		return $theme_custom;
	}
	
	function FixPost()
	{
		global $post;
		
		$interceptor_id = $this->DataType( 'interceptor' )->FetchId();
		$post = $this->DataType( 'interceptor' )->get_post( $interceptor_id );
	}
	
	function GetNoThanksUrl()
	{		
		$theme_custom = $this->GetThemeCustom();
		
		switch( $theme_custom['no_thanks_url_type'] )
		{
			case 'rotation':
				
				$url = $this->DataType( 'link-rotation' )->Rotate( $theme_custom['no_thanks_link_rotation'] );
				
				break;
			
			case 'url':
				
				$url = $theme_custom['no_thanks_destination_url'];
				
				break;
			
			case 'interception':
				
				$url = $_GET['qrd_to'] ? $_GET['qrd_to'] : 'http://thebest404pageever.com/swf/spacejelly_tk.swf';
				
				break;
		}
		
		return $url;
	}
	
	function GetFrameUrl()
	{		
		$theme_custom = $this->GetThemeCustom();
		
		switch( $theme_custom['url_type'] )
		{
			case 'rotation':
				
				$frame_url = $this->DataType( 'link-rotation' )->Rotate( $theme_custom['link_rotation'] );
				
				break;
			
			case 'url':
				
				$frame_url = $theme_custom['destination_url'];
				
				break;
			
			case 'interception':
				
				$frame_url = $_GET['qrd_to'] ? $_GET['qrd_to'] : 'http://thebest404pageever.com/swf/spacejelly_tk.swf';
				
				break;
		}
		
		return $frame_url;
	}
}










?>