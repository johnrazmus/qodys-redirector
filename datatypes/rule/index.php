<?php
class qodyDatatype_RedirectorRule extends QodyDataType
{
	function __construct()
    {
        $this->SetOwner( func_get_args() );
		$this->m_raw_file = __FILE__;
		
		$this->m_table_slug = 'rules';
		
		add_action( 'template_redirect', array( $this, 'QueueRedirect' ) );
		add_action( 'wp_footer', array( $this, 'PrintRedirectVariables' ), 99999999999 );
		
        parent::__construct();
    }
	
	function GetActiveRules()
	{
		$data = $this->Get( -1, 'enable_redirect', 'yes', '', '' );
		
		if( !$data )
			return;
		
		usort( $data, array( $this, 'SortRules' ) );
		
		return $data;
	}
	
	function SortRules( $rule_1, $rule_2 )
	{
		$custom1 = $this->get_datatype_custom( $rule_1->ID );
		$custom2 = $this->get_datatype_custom( $rule_2->ID );
		
		if( $custom1['priority'] == $custom2['priority'] )
			return 0;
		
		return $custom1['priority'] < $custom2['priority'] ? 1 : -1;
	}
	
	function GetApplicableRule()
	{
		global $post;
		
		// fetch currently enabled rules
		$rules = $this->GetActiveRules();
		
		// if no rules, quit
		if( !$rules )
			return;
		
		foreach( $rules as $key => $value )
		{
			$custom = $this->get_datatype_custom( $value->ID );
			
			if( $custom['page_triggers'] )
			{
				foreach( $custom['page_triggers'] as $key2 => $value2 )
				{
					if( is_numeric( $value2 ) && $post->ID == $value2 ) // specific page/post
					{
						return $value->ID;
					}
					else if( strpos( $value2, 'post_type' ) ) // all of a certain page type
					{
						$bits = explode( '::', $value2 );
						
						if( $bits[1] == $post->post_type )
							return $value->ID;
					}
					else // custom things
					{
						switch( $value2 )
						{
							case 'home':
								
								if( is_home() || is_front_page() )
									return $value->ID;
								
								break;
								
							case 'search':
								
								if( is_search() )
									return $value->ID;
								
								break;
								
							case 'all':
								
								return $value->ID;
								
								break;
						}
					}
				}
			}
			
			if( $custom['category_triggers'] )
			{
				foreach( $custom['category_triggers'] as $key2 => $value2 )
				{
					if( is_numeric( $value2 ) && (in_category( $value2 ) || is_category( $value2 )) ) // specific page/post
					{
						return $value->ID;
					}
					else // custom things
					{
						switch( $value2 )
						{
							case 'all':	
								
								if( has_category() )
									return $value->ID;
								
								break;
						}
					}
				}
			}
			
			if( $custom['specific_url_triggers'] )
			{
				$bits = explode( ',', $custom['specific_url_triggers'] );
				
				if( $bits )
				{
					$current_url = $this->Helper('tools')->GetCurrentPageUrl();
					
					foreach( $bits as $key2 => $value2 )
					{
						if( strpos( $current_url, trim($value2) ) !== false )
						{
							return $value->ID;
						}
					}
				}
			}
		}
	}
	
	function QueueRedirect()
	{
		$data = $this->GetRedirectData();
		
		if( $data['enabled'] == 'yes' )
		{
			$this->EnqueueScript( 'jquery' );
		}
		
		if( $data['action_type'] == 'modal' )
		{
			$this->EnqueueScript( 'bootstrap-everything' );
			
			$this->EnqueueStyle( 'bootstrap-modal' );
			$this->EnqueueStyle( 'action_type_modal' );
		}
	}
	
	function GetRedirectData( $rule_id = '', $is_remote = false )
	{
		global $redirection_data;
		
		if( $redirection_data )
			return $redirection_data;
		
		if( !$rule_id )
			$rule_id = $this->GetApplicableRule();
		
		if( !$rule_id )
			return;
		
		$defaults = $this->GetRuleDefaults();
		$data = $this->GetRuleRedirectVariables( $rule_id );
		
		$data = wp_parse_args( $data, $defaults );
		
		if( $is_remote )
		{
			$data['is_remote'] = 'yes';
		}
		
		if( $data['enabled'] == 'yes' )
		{
			$data['enabled'] = $this->PassesReferralSettings( $data );
		}
		
		$redirection_data = $data;
		
		return $redirection_data;
	}
	
	function PrintRedirectVariables( $rule_id = '', $is_remote = false )
	{
		$data = $this->GetRedirectData( $rule_id, $is_remote );
		
		if( !$data )
			return;
			
		// now that we have our info, print out the scripts & javascript variables
		echo '<script>';
		foreach( $data as $key => $value )
		{
			echo 'var redirector_'.$key.' = '.(is_numeric( $value ) ? $value : "'$value'").';';
		}		
		echo '</script>';
		
		echo '<script type="text/javascript" src="'.$this->GetAsset( 'includes', 'action', 'url' ).'"></script>';
		
		if( $data['action_type'] == 'modal' )
			$this->PrintPopupModal( $data['redirect_url'] );
		
		if( $data['action_type'] == 'popup' )
			$this->PrintTabLink( $data['redirect_url'] );
	}
	
	function PrintPopupModal( $destination_url )
	{ ?>
	<!-- sample modal content -->
	<div id="qody_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-body">
			<iframe class="modal_iframe the_qody_modal_iframe" src="<?php echo $destination_url; ?>" height="100%" width="100%" frameborder="0" scrolling="yes" style="border:none;"></iframe>
		</div>
	</div>
	<?php
	}
	
	function PassesReferralSettings( $data )
	{
		$referrer = $data['referrer'];
			
		if( !$referrer && $data['redirect_ref_if_blank'] == 'no' )
		{
			return 'no';
		}
		else if( $referrer && $data['redirect_ref_only_if'] )
		{
			$data['redirect_ref_only_if'] = str_replace( ' ', ',', $data['redirect_ref_only_if'] );
			$bits = explode( ',', $data['redirect_ref_only_if'] );
			
			$found = false;
			foreach( $bits as $key => $value )
			{
				$value = trim( $value );
				
				if( !$value )
					continue;
				
				if( strpos( $referrer, $value ) !== false )
				{
					$found = true;
					break;
				}
			}	
			
			if( !$found )
				return 'no';	
		}
		else if( $referrer && $data['redirect_ref_only_if_not'] )
		{
			$data['redirect_ref_only_if_not'] = str_replace( ' ', ',', $data['redirect_ref_only_if_not'] );
			$bits = explode( ',', $data['redirect_ref_only_if_not'] );
			
			foreach( $bits as $key => $value )
			{
				$value = trim( $value );
				
				if( !$value )
					continue;
					
				if( strpos( $referrer, $value ) !== false )
				{
					return 'no';
				}
			}				
		}
		
		return 'yes';
	}
	
	function GetRuleRedirectVariables( $rule_id )
	{
		$custom = $this->get_datatype_custom( $rule_id );
		
		if( $custom['url_type'] == 'url' )
		{
			$destination_url = $custom['destination_url'];
		}
		else if( $custom['url_type'] == 'rotation' )
		{
			$destination_url = $this->DataType( 'link-rotation' )->Rotate( $custom['link_rotation'] );
		}
		else if( $custom['url_type'] == 'clicked_url' )
		{
			$destination_url = '@@@qrdip@@@';
		}
		
		// if using interception for this rule
		if( $custom['interception_page'] ) 
		{
			$interception_url = $this->DataType( 'interceptor' )->GetRemoteLink( $custom['interception_page'] );
			
			// not the best way, cause interception url might have variables in it?
			$destination_url = $interception_url.'&qrd_to='.$destination_url; 
		}
		
		$fields = array();
		$fields['rule_id']				= $rule_id;
		$fields['enabled'] 				= $custom['enable_redirect'];
		$fields['redirect_url'] 		= $destination_url;
		$fields['redirect_again'] 		= $custom['redirect_again'];
		$fields['cookie_scope'] 		= $custom['cookie_scope'];
		$fields['redirect_wait_period'] = $custom['redirect_wait_period'];
		$fields['action_type'] 			= $custom['action_type'];
		
		$fields['action_trigger_type'] 		= $custom['action_trigger_type'];
		$fields['click_trigger_specifics'] 	= $custom['click_trigger_specifics'];
		$fields['click_trigger_exclusions'] = $custom['click_trigger_exclusions'];
		
		$fields['alert_text'] 			= $custom['alert_text'];
		$fields['alert_ok_action'] 		= $custom['alert_ok_action'];
		$fields['alert_cancel_action']	= $custom['alert_cancel_action'];
		$fields['alert_ok_action_destination_url'] 		= $custom['alert_ok_action_destination_url'];
		$fields['alert_cancel_action_destination_url'] 	= $custom['alert_cancel_action_destination_url'];
		
		return $fields;
	}
	
	function GetRuleDefaults()
	{
		global $post, $testing;
		
		$defaults = array();
		// ********************************************
		// ENABLE OR NOT ENABLE SETTINGS
		// ********************************************
		$defaults['enabled'] = 'no';
		$defaults['redirect_url'] = '';
		$defaults['post_id'] = $post->ID;
		$defaults['is_remote'] = 'no';
		$defaults['redirect_ref_only_if'] = '';
		$defaults['redirect_ref_only_if_not'] = '';
		$defaults['redirect_ref_if_blank'] = '';
		// ********************************************
		// FUNCTIONAL SETTINGS
		// ********************************************
		$defaults['action_type'] = 'redirect';
		$defaults['object_to_detect'] = 'body';
		$defaults['redirect_delay'] = 0;
		$defaults['redirect_again'] = 'no';
		$defaults['mouse_direction'] = 'up';
		$defaults['redirect_padding'] = 15;
		$defaults['redirect_left_margin'] = 0;
		$defaults['redirect_right_margin'] = 0;
		$defaults['redirect_type'] = 'mouse';
		$defaults['redirect_wait_period'] = 60*60 * 24 * 30;
		$defaults['referrer'] = $_SERVER['HTTP_REFERER'];
		$defaults['log_url'] = $this->GetAsset( 'ajax', 'log_redirect', 'url' );
		$defaults['modal_width'] = 85;
		$defaults['modal_height'] = 85;
		$defaults['popup_width'] = 980;
		$defaults['popup_height'] = 680;
		$defaults['popunder_width'] = 980;
		$defaults['popunder_height'] = 680;
		$defaults['alert_text'] = 'Are you sure you want to leave?';
		$defaults['alert_ok_action'] = 'url_type';
		$defaults['alert_cancel_action'] = 'stay';
		$defaults['alert_ok_action_destination_url'] = '';
		$defaults['alert_cancel_action_destination_url'] = '';
		$defaults['already_triggered'] = -1;
		
		$from_settings = $this->GetRedirectVariablesFromSettings();
		
		$data = wp_parse_args( $from_settings, $defaults );
		
		return $data;
	}
	
	function GetRedirectVariablesFromSettings()
	{
		$fields = array();
		
		$fields['redirect_ref_only_if'] = trim( $this->get_option( 'redirect_ref_only_if' ) );
		$fields['redirect_ref_only_if_not'] = trim( $this->get_option( 'redirect_ref_only_if_not' ) );
		$fields['redirect_ref_if_blank'] = $this->get_option( 'redirect_ref_if_blank' );
		
		// ********************************************
		// FUNCTIONAL SETTINGS
		// ********************************************
		//$redirect_detection 	= $qodys_redirector->get_option( 'redirect_detection' );
		$fields['mouse_direction'] = $this->get_option( 'mouse_direction' );
		
		$fields['redirect_padding'] = $this->get_option( 'redirect_padding' );
		$fields['redirect_left_margin'] = $this->get_option( 'redirect_left_margin' );
		$fields['redirect_right_margin'] = $this->get_option( 'redirect_right_margin' );
		
		if( $fields['redirect_padding'] )
			$fields['redirect_padding'] += 1;
		
		return $fields;
	}
	
	function GetPostRedirectVariables( $post_id )
	{
		// ********************************************
		// ENABLE OR NOT ENABLE SETTINGS
		// ********************************************
		$fields = array();
		$fields['enabled'] = $this->get_option( 'enable_redirect' );
		$fields['redirect_url'] = $this->get_option( 'redirect_url' );
		
		$custom = $this->get_post_custom( $post_id );
		
		if( is_home() || is_front_page() )
		{
			$post_id = -1;
			
			$fields['redirect_url'] = $this->get_option( 'redirect_home' ) ? $this->get_option( 'redirect_home' ) : $fields['redirect_url'];
		}
		else
		{
			if( $this->get_option( 'ignore_specifics' ) != 'yes' )
			{
				$fields['enabled'] = $custom['enable_redirect'] == 'no' ? 'no' : $fields['enabled'];
				$fields['redirect_url'] = $custom['redirect_url'] ? $custom['redirect_url'] : $fields['redirect_url'];
			}
		}
		
		
		
		return $fields;
	}
}
?>