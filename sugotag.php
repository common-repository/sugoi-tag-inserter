<?php
/*
Plugin Name: Sugoi Tag Inserter: Google Tag Manager(GTM) & gtag.js Made Easy 
Plugin URI: https://github.com/akiras7171/sugoi-tag-inserter
Description: Instert tags in hearders & footers made easy, especially for Google Ads/Analytics/GTM 
Version: 1.0.6
Author: akira.s7171
License: GPL2
*/
class SugoiTagInserter{
	public function __construct(){
		// test
		add_action('wp_head', array($this, 'test'));
		$basename = plugin_basename( __FILE__ );
		//add_filter('plugin_action_links', array($this, 'add_action_links'), 10, 2);
	
		// details
        $this->plugin               = new stdClass;
        $this->plugin->name         = 'sugoi-tag-inserter';
        $this->plugin->displayName  = 'Sugoi Tag Inserter for Google Ads & Analytics';
        $this->plugin->version      = '1.1';
        $this->plugin->folder       = plugin_dir_path( __FILE__ );
        $this->plugin->url          = plugin_dir_url( __FILE__ );

        // Dashboard Submodule
        if (!class_exists('sugotagDashBoard')) {
            require_once($this->plugin->folder.'/_modules/dashboard.php');
        }
        $this->dashboard = new sugotagDashBoard($this->plugin); 
                
        // Hooks
        add_action('admin_init', array($this, 'registerSettings'));
        add_action('admin_menu', array($this, 'adminPanelsAndMetaBoxes'));
                
        // Frontend Hooks
		add_action('wp_head', array($this, 'frontendHeader'));
		add_action('wp_footer', array($this, 'frontendFooter'));

		add_action('wp_head', array($this, 'hiddenHeader'));
		add_action('wp_footer', array($this, 'hiddenFooter'));
	}

	/**
    * Register the plugin settings panel
    */
    function adminPanelsAndMetaBoxes() {
    	add_submenu_page('options-general.php', $this->plugin->displayName, $this->plugin->displayName, 'manage_options', $this->plugin->name, array(&$this, 'adminPanel'));
    }
    
    /** 
     * Register Settings
 	 */
	function registerSettings() {
	    register_setting($this->plugin->name, 'sugotag_insert_header', 'trim');
	    register_setting($this->plugin->name, 'sugotag_insert_footer', 'trim');
	    register_setting($this->plugin->name, 'sugotag_gtm_id', 'trim');
	    register_setting($this->plugin->name, 'sugotag_aw_id', 'trim');
	    register_setting($this->plugin->name, 'sugotag_ga_id', 'trim');
	    register_setting($this->plugin->name, 'sugotag_gtm_enabled', 'trim');
	    register_setting($this->plugin->name, 'sugotag_aw_enabled', 'trim');
	    register_setting($this->plugin->name, 'sugotag_ga_enabled', 'trim');
		register_setting($this->plugin->name, 'sugotag_insert_hidden_header', 'trim');
	    register_setting($this->plugin->name, 'sugotag_insert_hidden_footer', 'trim');
	    register_setting($this->plugin->name, 'sugotag_cross_domain_enabled', 'trim');
		register_setting($this->plugin->name, 'sugotag_cross_domain_1st', 'trim');
	    register_setting($this->plugin->name, 'sugotag_cross_domain_2nd', 'trim');
	}

  /**
    * Output the Administration Panel
    * Save POSTed data from the Administration Panel into a WordPress option
    */
    function adminPanel() {
    	// Save Settings
        if (isset($_POST['submit'])) {
        	// Check nonce
        	if (!isset($_POST[$this->plugin->name.'_nonce'])) {
	        	// Missing nonce	
	        	$this->errorMessage = __('nonce field is missing. Settings NOT saved.', $this->plugin->name);
        	} elseif (!wp_verify_nonce($_POST[$this->plugin->name.'_nonce'], $this->plugin->name)) {
	        	// Invalid nonce
	        	$this->errorMessage = __('Invalid nonce specified. Settings NOT saved.', $this->plugin->name);
        	} else {        	
				// Save
				$header = stripslashes($_POST['sugotag_insert_header']);
				update_option('sugotag_insert_header', wp_check_invalid_utf8($header));
				$footer = stripslashes($_POST['sugotag_insert_footer']);			
			    update_option('sugotag_insert_footer', wp_check_invalid_utf8($footer));
				
				$gtm_id = sanitize_text_field($_POST['sugotag_gtm_id']);
				update_option('sugotag_gtm_id', $gtm_id);
				
				$aw_id = sanitize_text_field($_POST['sugotag_aw_id']);
				update_option('sugotag_aw_id', $aw_id);
			
				$ga_id = sanitize_text_field($_POST['sugotag_ga_id']);
				update_option('sugotag_ga_id', $ga_id);
				
				// TODO: make it boolean
				$is_gtm_enabled = sanitize_text_field($_POST['sugotag_gtm_enabled']);
				update_option('sugotag_gtm_enabled', $is_gtm_enabled);
				$is_aw_enabled = sanitize_text_field($_POST['sugotag_aw_enabled']);
				update_option('sugotag_aw_enabled', $is_aw_enabled);
				$is_ga_enabled = sanitize_text_field($_POST['sugotag_ga_enabled']);
				update_option('sugotag_ga_enabled', $is_ga_enabled);
				$is_cross_domain_enabled = sanitize_text_field($_POST['sugotag_cross_domain_enabled']);
				update_option('sugotag_cross_domain_enabled', $is_cross_domain_enabled);
	
			    $first_domain = sanitize_text_field($_POST['sugotag_cross_domain_1st']);
				update_option('sugotag_cross_domain_1st', $first_domain);

				$second_domain = sanitize_text_field($_POST['sugotag_cross_domain_2nd']);
				update_option('sugotag_cross_domain_2nd', $second_domain);
	
				$hidden_header = stripslashes($_POST['sugotag_insert_hidden_header']);
				update_option('sugotag_insert_hidden_header', wp_check_invalid_utf8($hidden_header));			
				$hidden_footer = stripslashes($_POST['sugotag_insert_hidden_footer']);
				update_option('sugotag_insert_hidden_footer', wp_check_invalid_utf8($hidden_footer));
				
				$this->message = __('Settings Saved.', $this->plugin->name);
            }
		}
        // Get latest settings
		$this->settings = array(
		   'sugotag_insert_header' => is_null(get_option('sugotag_insert_header')) ? '' : stripslashes(get_option('sugotag_insert_header')),
           'sugotag_insert_footer' => is_null(get_option('sugotag_insert_footer')) ? '' : stripslashes(get_option('sugotag_insert_footer')),
           'sugotag_gtm_id' => is_null(get_option('sugotag_gtm_id')) ? '' : stripslashes(get_option('sugotag_gtm_id')),
		   'sugotag_aw_id' => is_null(get_option('sugotag_aw_id')) ? '' : stripslashes(get_option('sugotag_aw_id')),
		   'sugotag_ga_id' => is_null(get_option('sugotag_ga_id')) ? '' : stripslashes(get_option('sugotag_ga_id')),
           'sugotag_gtm_enabled' => is_null(get_option('sugotag_gtm_enabled')) ? '' : stripslashes(get_option('sugotag_gtm_enabled')),
		   'sugotag_aw_enabled' => is_null(get_option('sugotag_aw_enabled')) ? '' : stripslashes(get_option('sugotag_aw_enabled')),
		   'sugotag_ga_enabled' => is_null(get_option('sugotag_ga_enabled')) ? '' : stripslashes(get_option('sugotag_ga_enabled')),
		   'sugotag_cross_domain_enabled' => is_null(get_option('sugotag_cross_domain_enabled')) ? '' : stripslashes(get_option('sugotag_cross_domain_enabled')),
		   'sugotag_cross_domain_1st' => is_null(get_option('sugotag_cross_domain_1st'))? '': stripslashes(get_option('sugotag_cross_domain_1st')),
		   'sugotag_cross_domain_2nd' => is_null(get_option('sugotag_cross_domain_2nd'))? '' : stripslashes(get_option('sugotag_cross_domain_2nd')),
		   'sugotag_insert_hidden_header' => is_null(get_option('sugotag_insert_hidden_header'))?'': stripslashes(get_option('sugotag_insert_hidden_header')),
           'sugotag_insert_hidden_footer' => is_null(get_option('sugotag_insert_hidden_footer'))?'': stripslashes(get_option('sugotag_insert_hidden_footer')),
		);
            
        // Load Settings Form
        include_once(WP_PLUGIN_DIR.'/'.$this->plugin->name.'/_modules/settings.php');  
    }

    /**
	* Loads plugin textdomain
	*/
	// function loadLanguageFiles() {
	//	load_plugin_textdomain($this->plugin->name, false, $this->plugin->name.'/languages/');
	// }

    
    // Functions to fook code into wp_head
	function hiddenHeader() {
	    $this->output('sugotag_insert_hidden_header');
	}

    // Functions to fook code into wp_head
    function hiddenFooter() {
		$this->output('sugotag_insert_hidden_footer');
	}
	
	/**
	* Outputs script / CSS to the frontend header
	*/
	function frontendHeader() {
		$this->output('sugotag_insert_header');
	}
	
	/**
	* Outputs script / CSS to the frontend footer
	*/
	function frontendFooter() {
		$this->output('sugotag_insert_footer');
	}
	
	/**
	* Outputs the given setting, if conditions are met
	*
	* @param string $setting Setting Name
	* @return output
	*/
	function output($setting) {
		// Ignore admin, feed, robots or trackbacks
		if (is_admin() OR is_feed() OR is_robots() OR is_trackback()) {
			return;
		}
		
		// Get meta
		$meta = get_option($setting);
		if (empty($meta)) {
			return;
		}	
		if (trim($meta) == '') {
			return;
		}
		
		// Output
		echo stripslashes($meta);
	}

}

// add action links in the plugin list page 
function add_to_setting_link ($links , $file) {
	$add_link = '<a href="/wp-admin/options-general.php?page=sugoi-tag-inserter">Settings(設定へ)</a>';
	array_unshift($links, $add_link);
	return $links;
}

add_filter('plugin_action_links_' . plugin_basename( __FILE__ ), 'add_to_setting_link', 10, 2);
$sugoiTagInserter = new SugoiTagInserter;
?>