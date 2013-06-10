<?php
class qodyPage_RedirectorLinkRotations extends QodyPage
{
	function __construct()
	{
		$this->SetOwner( func_get_args() );
		$this->m_raw_file = __FILE__;
		
		$this->SetPriority( 12 );		
		$this->SetParent( 'home' );
		//$this->m_icon_url = '';
		
		$this->SetDataType( 'link-rotation' );
		
		$this->SetTitle( 'Link Rotations' );
		
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
	
	function GetRotationTypeIcon( $slug )
	{
		switch( $slug )
		{
			case 'random': return '<i class="icon-random" title="Random"></i>';
			case 'least_hit': return '<i class="icon-screenshot" title="Hits"></i>';
			case 'sequential': return '<i class="icon-list" title="Sequential"></i>';
			case 'weighted': return '<i class="icon-leaf" title="Weight"></i>';
		}
	}
	
}
?>