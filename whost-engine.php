<?php
/*
Plugin Name: Whost Engine
Description: Whost Engine is the core plugin for Whost WordPress Theme. You must install this plugin to get a full fledge Whost WordPress Theme, otherwise you'll miss some cool features.
Plugin URI: http://Whost.wditsolution/
Author: WD IT SOLUTION
Author URI: http://Whost.wditsolution/
Version: 1.3.0
License: GPL2
Text Domain: Whost-engine
Domain Path: /languages
*/

// Prevent direct access
defined( 'ABSPATH' ) || die( 'No Direct Access' );

/*******************************************************************
 * Constants
 *******************************************************************/

/** Whost Engine version  */
define( 'WHOST_ENGINE_VERSION', '1.3.0' );

/** Whost Engine directory path  */
define( 'WHOST_ENGINE_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

/** Whost Engine includes directory path  */
define( 'WHOST_ENGINE_INCLUDES_DIR', trailingslashit( WHOST_ENGINE_DIR . 'includes' ) );

/** Whost Engine shortcodes directory path  */
define( 'WHOST_ENGINE_SHORTCODES_DIR', trailingslashit( WHOST_ENGINE_DIR . 'shortcodes' ) );

/** Whost Engine url  */
define( 'WHOST_ENGINE_URL', trailingslashit(  plugin_dir_url( __FILE__ ) ) );


class WHOST_Engine {

    public function __construct() {
        register_activation_hook( __FILE__, array($this, 'activate') );

        $this->load_helpers();

        $this->load_shortcodes();

        add_action( 'plugins_loaded', array($this, 'load_textdomain') );
    }

    public function activate() {
        if ( ! get_option( 'whost_engine_version' ) ) {
            update_option( 'whost_engine_old', true  );
        }
        update_option( 'whost_engine_version', WHOST_ENGINE_VERSION );

        // flash rewrite rules because of custom post type
        flush_rewrite_rules();
    }

    public function load_textdomain() {
        load_plugin_textdomain( 'whost', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    private function load_helpers() {
        // helper functions
        require_once  WHOST_ENGINE_INCLUDES_DIR . 'functions.php';

        // Whost icons
        require_once  WHOST_ENGINE_INCLUDES_DIR . 'icons.php';

        // custom field type
        require_once  WHOST_ENGINE_INCLUDES_DIR . 'class.tb-vc-preview-field.php';
        require_once  WHOST_ENGINE_INCLUDES_DIR . 'class.tb-vc-gdropdown-field.php';

        // shortcode base
        require_once  WHOST_ENGINE_INCLUDES_DIR . 'class.shortcode.php';

        // custom post type
        require_once  WHOST_ENGINE_INCLUDES_DIR . 'class.custom-types.php';
    }

    /**
     * Include all shortcode files
     * @return null
     */
    private function load_shortcodes() {
        foreach ( glob( WHOST_ENGINE_SHORTCODES_DIR . '*/*.php' ) as $shortcode ) {
            if ( ! file_exists( $shortcode ) ) {
                continue;
            }
            require_once $shortcode;
        }
    }

}

new WHOST_Engine;