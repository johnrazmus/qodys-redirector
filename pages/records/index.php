<?php
class qodyPage_RedirectorRecords extends QodyPage
{
	function __construct()
	{
		$this->SetOwner( func_get_args() );
		$this->m_raw_file = __FILE__;
		
		$this->SetPriority( 15 );		
		$this->SetParent( 'home' );
		//$this->m_icon_url = '';
		
		$this->SetDataType( 'record' );
		
		$this->SetTitle( 'Records' );
		
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
		
		if( !$this->get_option( 'imported_redirect_records' ) )
		{
			$this->DataType( 'record' )->ConvertFromPostType( 'qrd-redirect-record' );
			$this->update_option( 'imported_redirect_records', 1 );
		}
		
		$this->EnqueueStyle('chosen');
		$this->EnqueueStyle( 'jquery-ui' );
		$this->EnqueueStyle( 'nicer-tables' );
		$this->EnqueueStyle( 'smaller-pagination' );
		
		$this->EnqueueScript('chosen');
        $this->EnqueueScript( 'jquery-ui' );
	}
	
}
?>