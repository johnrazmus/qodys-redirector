<?php
class qodyPage_RedirectorInterceptors extends QodyPage
{
	function __construct()
	{
		$this->SetOwner( func_get_args() );
		$this->m_raw_file = __FILE__;
		
		$this->SetPriority( 16 );		
		$this->SetParent( 'home' );
		//$this->m_icon_url = '';
		
		$this->SetDataType( 'interceptor' );
		
		$this->SetTitle( 'Interceptors' );
		
		parent::__construct();
	}
	
	function LoadMetaboxes()
	{
		$this->AddMetabox( 'general', 'Settings' );
		
		$this->AddMetabox( 'save', 'Save Settings', 'side' );
		$this->AddMetabox( 'themes', 'Themes', 'side' );
	}
	
	function WhenOnPage()
	{
		if( !parent::WhenOnPage() )
			return;

		$this->EnqueueStyle('chosen');
		$this->EnqueueScript('chosen');
		
		$this->EnqueueStyle( 'jquery-ui' );
        $this->EnqueueScript( 'jquery-ui' );
		
		$this->LoadFancyEditor();
		
		$this->EnqueueStyle( 'thickbox' );
		
		$this->EnqueueScript( 'media-upload' );
		$this->EnqueueScript( 'thickbox' );
	}
	
	function GetBlogCategories()
	{
		$fields = array();
		$fields['hide_empty'] = 0;
		
		$data = get_categories( $fields );
		
		return $data;
	}
	
	function FormatPageTriggers( $data )
	{
		if( !$data )
			return;
		
		$text = array();
		
		foreach( $data as $key => $value )
		{
			if( is_numeric( $value ) ) // specific page/post
			{
				$text[] = '<a target="_blank" href="'.get_permalink( $value ).'">'.get_the_title( $value ).'</a>';
			}
			else if( strpos( $value, 'post_type' ) ) // all of a certain page type
			{
				$bits = explode( '::', $value );
				$post_type = get_post_type_object( $bits[1] );
				
				$text[] = 'All '.$post_type->labels->plural_name;
			}
			else // custom things
			{
				switch( $value )
				{
					case 'home':	$text[] = 'Home'; break;
					case 'search':	$text[] = 'Search Results'; break;
					case 'all':		$text[] = 'Entire Site'; break;
				}
			}
		}
		
		return $text;
	}
	
	function FormatCategoryTriggers( $data )
	{
		if( !$data )
			return;
		
		$text = array();
		
		foreach( $data as $key => $value )
		{
			if( is_numeric( $value ) ) // specific page/post
			{
				$category = get_the_category( $value );
				
				$text[] = '<a target="_blank" href="'.get_category_link( $value ).'">'.$category[0]->name.'</a>';
			}
			else // custom things
			{
				switch( $value )
				{
					case 'all':	$text[] = 'All Categories'; break;
				}
			}
		}
		
		return $text;
	}
}








?>