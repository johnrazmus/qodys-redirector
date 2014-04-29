<?php
require_once(ABSPATH . 'wp-admin/includes/plugin.php'); //for plugins_api..

// Install Qody's Framework, incase it's not uploaded already
if( !file_exists( $framework_file ) )
{
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	require_once(ABSPATH . 'wp-admin/includes/template.php');
	require_once(ABSPATH . 'wp-admin/includes/misc.php');
	require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
	include_once(ABSPATH . 'wp-admin/includes/screen.php');
	
	if( !class_exists( 'Bulk_Plugin_Upgrader_Skin' ) )
	{
		echo "Must upgrade to at least Wordpress version 3.0.1 to use this plugin"; 
	}
	else
	{
		if( !class_exists('Blank_Skin') )
		{
			class Blank_Skin extends Bulk_Plugin_Upgrader_Skin {
			
				function __construct($args = array()) {
					parent::__construct($args);
				}
				
				function header() {}
				function footer() {}
				function error($errors) {}
				function feedback($string) {}
				function before() {}
				function after() {}
				function bulk_header() {}
				function bulk_footer() {}
				function show_message() {}
				
				function flush_output() {
					ob_end_clean();
				}
			}
		}
		
		$plugin_url = 'http://razmus.net/api/download.php?p=qodys-owlnest';
		//$api = plugins_api('plugin_information', array('slug' => 'qodys-owlnest', 'fields' => array('sections' => false) ) ); //Save on a bit of bandwidth.
		
		ob_start();
		$upgrader = new Plugin_Upgrader( new Blank_Skin() );
		$upgrader->install( $plugin_url );
		ob_end_clean();
	}
}

$fields = array();
$fields['qodys-owlnest'] = '4.0.0';

foreach( $fields as $key => $value )
{
	$installed_plugins = get_plugins( '/'.$key );
	//echo "<pre>".print_r( $installed_plugins, true )."</pre>";
	
	if( !$installed_plugins )
		continue;
	
	foreach( $installed_plugins as $key2 => $value2 )
	{
		if( version_compare($value2['Version'], $value, "<") )
		{
			$framework_problem = true;
		}
	}
}
?>