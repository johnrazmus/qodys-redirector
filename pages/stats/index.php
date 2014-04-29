<?php
class qodyPage_RedirectorStats extends QodyPage
{
	function __construct()
	{
		$this->SetOwner( func_get_args() );
		$this->m_raw_file = __FILE__;
		
		$this->SetPriority( 16 );
		$this->SetParent( 'home' );
		//$this->m_icon_url = '';
		
		$this->SetTitle( 'Stats' );
		
		parent::__construct();
	}
	
	function LoadMetaboxes()
	{
		//$this->AddMetabox( 'announcements', 'Announcements', 'side' );
	}
}
?>