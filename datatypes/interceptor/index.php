<?php
class qodyDatatype_RedirectorInterceptor extends QodyDataType
{
	var $m_get_slug = 'rdi';
	
	function __construct()
    {
        $this->SetOwner( func_get_args() );
		$this->m_raw_file = __FILE__;
		
		$this->m_table_slug = 'interceptor';
        
		add_action( 'template_redirect', array( $this, 'WhenShowing' ) );
		
        parent::__construct();
    }
	
	function GetRemoteLink( $post_id )
	{
		$url = get_bloginfo('url').'?'.$this->m_get_slug.'='.$post_id;
		
		return $url;
	}
	
	function FetchId()
	{
		return $_GET[ $this->m_get_slug ];
	}
	
	function WhenShowing()
	{
		if( !isset( $_GET[ $this->m_get_slug ] ) )
			return;
			
		$post_id = $_GET[ $this->m_get_slug ];
		
		if( !$post_id || !is_numeric( $post_id ) )
			return;
		
		$custom = $this->get_datatype_custom( $post_id );
		$theme = $custom['interceptor_theme'];
		
		if( $theme && $theme != 'none' )
		{
			echo $this->Controller('interceptor')->ContentFunction();
			exit();
		}
	}
}
?>