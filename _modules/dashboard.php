<?php
/**
* Dashboard Widget
*/
class sugotagDashBoard {     
	/**
	* Constructor
	*
	* @param object $plugin Plugin Object (name, displayName, version, folder, url)
	*/
	function __construct($plugin) {
		// Plugin Details
        $this->dashboard = $plugin;
        $this->dashboardURL = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
		// Hooks
		add_action('admin_enqueue_scripts', array(&$this, 'adminScriptsAndCSS'));
	} 
	
	/**
    * Register and enqueue dashboard CSS
    */
    function adminScriptsAndCSS() {    
    	// CSS snd JS
    	// This will only enqueue once, despite this hook being called by up to several plugins,
    	// as we have set a single, distinct name
        wp_enqueue_style('admin', $this->dashboardURL.'./css/admin.css'); 
		wp_enqueue_style('bootstrap', $this->dashboardURL.'./css/bootstrap.min.css'); 
		wp_enqueue_script('setting',  $this->dashboardURL."./page_settings.js");
	} 	
}
?>