<?php
class qodyPage_RedirectorExternalRedirects extends QodyPage
{
	function __construct()
	{
		$this->SetOwner( func_get_args() );
		$this->m_raw_file = __FILE__;
		
		$this->SetPriority( 13 );		
		$this->SetParent( 'home' );
		//$this->m_icon_url = '';
		
		$this->SetDataType( 'external-redirect' );
		
		$this->SetTitle( 'External Redirects' );
		
		parent::__construct();
	}
	
	function LoadMetaboxes()
	{
		$this->AddMetabox( 'general', 'Settings' );
		$this->AddMetabox( 'save', 'Save Settings', 'side' );
	}
	
	function WhenOnPage()
	{
		if( !parent::WhenOnPage() )
			return;

		$this->EnqueueStyle('chosen');
		$this->EnqueueScript('chosen');
		
		$this->EnqueueStyle( 'jquery-ui' );
        $this->EnqueueScript( 'jquery-ui' );
	}
	
}
?>