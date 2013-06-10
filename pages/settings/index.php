<?php
class qodyPage_RedirectorSettings extends QodyPage
{
	function __construct()
	{
		$this->SetOwner( func_get_args() );
		$this->m_raw_file = __FILE__;
		
		$this->SetPriority( 17 );
		$this->SetParent( 'home' );
		
		//$this->m_icon_url = '';
		
		$this->SetTitle( 'Advanced Settings' );
		
		parent::__construct();
		
		$this->FixOptions();
	}
	
	function LoadMetaboxes()
	{
		$this->AddMetabox( 'general', 'Redirect Settings' );
		//$this->AddMetabox( 'advance_features', 'Advance Features' );
		
		$this->AddMetabox( 'save', 'Save Settings', 'side' );
		$this->AddMetabox( 'announcements', 'Announcements', 'side' );
		$this->AddMetabox( 'support_info', 'Not Working? Try this', 'side' );
	}
	
	function FixOptions()
	{
		if( $this->get_option( 'enable_redirect' ) == 1 )
		{
			$this->update_option( 'enable_redirect', 'yes' );
		}
		
		if( $this->get_option( 'redirect_again' ) == 1 )
		{
			$this->update_option( 'redirect_again', 'yes' );
		}
	}
}
?>