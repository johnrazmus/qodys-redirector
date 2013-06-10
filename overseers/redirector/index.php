<?php
class qodyOverseer_Redirector extends QodyOverseer
{
	function __construct()
	{
		$this->SetOwner( func_get_args() );
		
		$this->m_raw_file = __FILE__;
		
		//$this->SetParent( 'home' );
		//$this->m_icon_url = '';
		
		//$this->SetTitle( 'Settings' );
		
		add_action( 'admin_init', array( $this, 'ImportStuffFromOlderRedirector' ) );
		
		parent::__construct();
	}
	
	function ImportStuffFromOlderRedirector()
	{
		if( $this->get_option('ran_three_point_oh_import') != 1 )
		{
			$this->update_option( 'ran_three_point_oh_import', 1 );
			
			// import general settings
			$enable_redirect = $this->get_option( 'enable_redirect' );
			$redirect_again = $this->get_option( 'redirect_again' );
			
			$redirect_url = $this->get_option( 'redirect_url' );
			$redirect_home = $this->get_option( 'redirect_home' );
			
			// import site-wide redirect settings
			if( $redirect_url )
			{
				$fields = array();
				$fields['post_title'] = 'Imported redirect';
				$fields['field_url_type'] = 'url';
				$fields['field_action_type'] = 'redirect';
				$fields['field_page_triggers'][] = 'all';
				$fields['field_priority'] = 5;
				$fields['field_destination_url'] = $redirect_url;
				$fields['field_enable_redirect'] = $enable_redirect == 1 ? 'yes' : 'no';
				$fields['field_redirect_again'] = $redirect_again == 1 ? 'yes' : 'no';
				$fields['field_redirect_wait_period'] = 60*60*24*30;
				
				$this->DataType( 'rule' )->SavePost( $fields );
			}
			
			// import homepage redirect settings
			if( $redirect_home )
			{
				$fields = array();
				$fields['post_title'] = 'Imported redirect';
				$fields['field_url_type'] = 'url';
				$fields['field_action_type'] = 'redirect';
				$fields['field_page_triggers'][] = 'home';
				$fields['field_priority'] = 10;
				$fields['field_destination_url'] = $redirect_url;
				$fields['field_enable_redirect'] = $enable_redirect == 1 ? 'yes' : 'no';
				$fields['field_redirect_again'] = $redirect_again == 1 ? 'yes' : 'no';
				$fields['field_redirect_wait_period'] = 60*60*24*30;
				
				$this->DataType( 'rule' )->SavePost( $fields );
			}
			
			// import post-specific settings
			$fields = array();
			$fields['post_type'] = 'post';
			$fields['numberposts'] = -1;
			
			$data = get_posts( $fields );
			
			if( $data )
			{
				foreach( $data as $key => $value )
				{
					$custom = $this->get_post_custom( $value->ID );
					
					if( $custom['enable_redirect'] == -1 )
						continue;
					
					if( !$custom['redirect_url'] )
						continue;
					
					$fields = array();
					$fields['post_title'] = 'Imported redirect';
					$fields['field_url_type'] = 'url';
					$fields['field_action_type'] = 'redirect';
					$fields['field_page_triggers'][] = $value->ID;
					$fields['field_priority'] = 20;
					$fields['field_destination_url'] = $custom['redirect_url'];
					$fields['field_enable_redirect'] = $enable_redirect == 1 ? 'yes' : 'no';
					$fields['field_redirect_again'] = $redirect_again == 1 ? 'yes' : 'no';
					$fields['field_redirect_wait_period'] = 60*60*24*30;
					
					$this->DataType( 'rule' )->SavePost( $fields );
				}
			}
			
			// import page-specific settings
			$fields = array();
			$fields['post_type'] = 'page';
			$fields['numberposts'] = -1;
			
			$data = get_posts( $fields );
			
			if( $data )
			{
				foreach( $data as $key => $value )
				{
					$custom = $this->get_post_custom( $value->ID );
					
					if( $custom['enable_redirect'] == -1 )
						continue;
					
					if( !$custom['redirect_url'] )
						continue;
					
					$fields = array();
					$fields['post_title'] = 'Imported redirect';
					$fields['field_url_type'] = 'url';
					$fields['field_action_type'] = 'redirect';
					$fields['field_page_triggers'][] = $value->ID;
					$fields['field_priority'] = 20;
					$fields['field_destination_url'] = $custom['redirect_url'];
					$fields['field_enable_redirect'] = $enable_redirect == 1 ? 'yes' : 'no';
					$fields['field_redirect_again'] = $redirect_again == 1 ? 'yes' : 'no';
					$fields['field_redirect_wait_period'] = 60*60*24*30;
					
					$this->DataType( 'rule' )->SavePost( $fields );
				}
			}
			
			
		}
	}
}
?>