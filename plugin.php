<?php
/**
 * Plugin Name: Qody's Redirector
 * Plugin URI: http://qody.co
 * Description: Powerful redirection plugin for WordPress.
 * Version: 4.1.5
 * Author: Qody LLC
 * Author URI: http://qody.co
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
$framework_problem = false;
$framework_file = dirname(dirname(__FILE__) ).'/qodys-owlnest/plugin.php';

// Install Qody's Framework, incase it's not uploaded already
require_once( 'frwk.php' );

if( $framework_problem )
{
	// do nothing since we are out of sync with the framework
}
else if( !file_exists( $framework_file ) )
{
	$framework_problem = true;
}
else
{
	// load up the main Qody framework
	require_once( $framework_file );
	
	if( !class_exists('QodyPlugin') )
	{
		$framework_problem = true;
	}
	else if( !class_exists('QodysRedirector') )
	{
		class QodysRedirector extends QodyPlugin
		{
			// general plugin variables
			//var $m_plugin_name;
		
			function __construct()
			{
				$this->m_pre = 'qrd';
				$this->m_owl_name = 'Alejandro';
				$this->m_owl_image = 'http://plugins.qody.co/wp-content/uploads/2011/09/owl5a-320x320.png';
				$this->m_owl_buy_url = 'http://qody.co/owl/alejandro/';
				$this->m_plugin_name = 'Redirector';
				$this->m_plugin_slug = 'qodys-redirector';
				$this->m_plugin_file = plugin_basename(__FILE__);
				$this->m_plugin_folder = dirname(__FILE__);
				$this->m_raw_file = __FILE__;
				
				// Set plugin name, slug, file, and folder
				parent::__construct();
			}
		}
		
		// create an instance of the main class to start the plugin's system.
		$qodys_redirector = new QodysRedirector();
		
		// Register the plugin with Wordpress
		$qodys_redirector->RegisterPlugin();
	}
}

if( !function_exists('qody_framework_warning') )
{
	function qody_framework_warning()
	{
		$data = "
<div class='updated fade'>
	<p><strong>Your plugin by Qody is almost ready.</strong> You must 
	<a href=\"http://qody.co/api/?p=qodys-owlnest&a=download\">install/update the framework plugin</a> for it to work properly.</p>
</div>";
		echo $data;
	}
}

if( $framework_problem )
	add_action('admin_notices', 'qody_framework_warning'); 
?>