<?php
/*
Plugin Name: Plugin Name
Plugin URI: https://plugin-url.com
Description: Plugin Description 
Version: 1.0
Author: plugin author
Author URI: https://author-url.com
License: GPLv2 or later
Text Domain: plugin-textdomain
Domain Path: /languages/
*/

define( "PLUGIN_ASSETS_DIR", plugin_dir_url( __FILE__ ) . "assets/" );
define( "PLUGIN_ASSETS_PUBLIC_DIR", plugin_dir_url( __FILE__ ) . "assets/public" );
define( "PLUGIN_ASSETS_ADMIN_DIR", plugin_dir_url( __FILE__ ) . "assets/admin" );

class PluginName{
    private $version;
    function __construct(){
		$this->version =time();
		add_action('init',array($this,'plugin_init'));
		add_action('plugins_loaded',array($this,'load_textdomain'));
		add_action('wp_enqueue_scripts',array($this,'load_front_assets'));
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_assets' ) );
    }
    
    public function plugin_init(){
        wp_register_style('fontawesome-css','//use.fontawesome.com/releases/v5.2.0/css/all.css');
        wp_register_script('tinyslider-js','//cdn.jsdelivr.net/npm/tiny-slider@2.8.5/dist/tiny-slider.min.js',null,'1.0',true);
    }

    public function load_textdomain(){
        load_plugin_textdomain('plugin-textdomain',false,plugin_dir_url(__FILE__)."/languages");
    }

    public function load_front_assets(){
        wp_enqueue_style('plugin-front-main-css',PLUGIN_ASSETS_PUBLIC_DIR."/css/main.css",null,$this->version);
        wp_enqueue_script( 'plugin-front-main-js', PLUGIN_ASSETS_PUBLIC_DIR . "/js/main.js", array(
            'jquery',
            'plugin-front-another-js'
        ), $this->version, true );
    }

    public function load_admin_assets($screen){
        $_screen = get_current_screen();
		if ( 'edit.php' == $_screen && ('page' == $_screen->post_type || 'book' == $_screen->post_type) ) {
			wp_enqueue_script( 'plugin-admin-js', PLUGIN_ASSETS_ADMIN_DIR . "/js/admin.js", array( 'jquery' ), $this->version, true );
		}
    }
}

new PluginName();