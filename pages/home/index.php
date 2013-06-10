<?php
class qodyPage_RedirectorHome extends QodyPage
{
	function __construct()
	{
		$this->SetOwner( func_get_args() );
		
		$this->m_raw_file = __FILE__;
		
		$this->m_priority = 1;
		
		$this->m_icon_url = $this->GetIcon();
		
		$this->SetTitle( $this->Owner()->m_plugin_name );
		
		parent::__construct();
	}
	
	function LoadMetaboxes()
	{
		$this->AddMetabox( 'announcements', 'Announcements', 'side' );
	}
}
?>