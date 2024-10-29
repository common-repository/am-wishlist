<?php

/*

 * Plugin Name: AM Wishlist

 * Description: Allow Customer to add Product in wishlist for future parchase.

 * Version: 1.0.0

 * Author: WebMyra

 * Author URI: https://webmyra.com/

 * License: GPLv2 or later

 * Text Domain: am-wishlist

 */

/**

  Copyright 2020  WebMyra

  This program is free software; you can redistribute it and/or modify

  it under the terms of the GNU General Public License, version 2, as

  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,

  but WITHOUT ANY WARRANTY; without even the implied warranty of

  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License

  along with this program; if not, write to the Free Software

  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * If this file is called directly, abort
 */
if ( ! defined( 'ABSPATH' ) ) { die(); }

/**

 * Define variable for plugin path

 */

if ( ! defined( 'AMWL_URL' ) ) { define( 'AMWL_URL', plugins_url( '/', __FILE__ ) );}

/**

 * Define variable for plugin path

 */

if ( ! defined( 'AMWL_PATH' ) ) { define( 'AMWL_PATH', plugin_dir_path( __FILE__ ) );}

/**

 * Define variable for plugin dir path

 */

if ( ! defined( 'AMWL_DIR_PATH' ) ) { define( 'AMWL_DIR_PATH', plugin_dir_url( __FILE__ ) );}

/**

 * Define variable for includes dir

 */

if ( ! defined( 'AMWL_INCLUDES' ) ) { define( 'AMWL_INCLUDES', AMWL_PATH . 'includes/' );}

/**

 * Define variable for admin dir

 */

if ( ! defined( 'AMWL_INCLUDES_ADMIN' ) ) { define( 'AMWL_INCLUDES_ADMIN', AMWL_INCLUDES . 'admin/' );}

/**

 * Define variable for admin image dir

 */

if ( ! defined( 'AMWL_ADMIN_IMG' ) ) { define( 'AMWL_ADMIN_IMG', AMWL_DIR_PATH . 'includes/admin/image/' );}

/**

 * Define variable for admin inc dir

 */

if ( ! defined( 'AMWL_ADMIN_INC' ) ) { define( 'AMWL_ADMIN_INC', AMWL_INCLUDES_ADMIN . 'inc/' );}

/**

 * Define variable for admin js dir

 */

if ( ! defined( 'AMWL_ADMIN_JS' ) ) { define( 'AMWL_ADMIN_JS', AMWL_INCLUDES_ADMIN . 'js/' );}

/**

 * Define variable for inc functions dir

 */

if ( ! defined( 'AMWL_INC_FUNCTIONS' ) ) { define( 'AMWL_INC_FUNCTIONS', AMWL_ADMIN_INC . 'functions/' );}

/**

 * Define variable for public dir

 */

if ( ! defined( 'AMWL_INCLUDES_PUBLIC' ) ) { define( 'AMWL_INCLUDES_PUBLIC', AMWL_INCLUDES . 'public/' );}

/**

 * Define variable for public inc dir

 */

if ( ! defined( 'AMWL_PUBLIC_INC' ) ) { define( 'AMWL_PUBLIC_INC', AMWL_INCLUDES_PUBLIC . 'inc/' );}

/**

 * Define variable for public css dir

 */

if ( ! defined( 'AMWL_PUBLIC_CSS' ) ) { define( 'AMWL_PUBLIC_CSS', AMWL_URL . 'includes/public/css/' );}

/**

 * Define variable for prefix

 */

if ( ! defined( 'AMWL_PREFIX' ) ) { define( 'AMWL_PREFIX', 'amwl' );}

/**

 * Define variable for text-domain 

 */

if ( ! defined( 'AMWL_DOMAIN' ) ) { define( 'AMWL_DOMAIN', esc_html__('am-wishlist' ) );}

/**

 * Define variable for free version

 */

if ( ! defined( 'AMWL_FVERSION' ) ) { define( 'AMWL_FVERSION', '1.0.0' );}

/**

 * Define variable for free version load

 */

if ( ! defined( 'AMWL_LOAD_FREE' ) ) { define( 'AMWL_LOAD_FREE', plugin_basename( __FILE__ ) );}

/**

 * Check woocommerce plugin activate or not

 */

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {     

/**

 * Define Woocommerce Wishlist main class 

 */

if ( ! class_exists( 'AM_wishlist' ) ) {

    /**

     * Main AM_wishlist Class

     * @since 1.0.0

     */

    class AM_wishlist {

       /**

        * Add all actions & filter

        */

        public function AMWL_register() {

            /**

             * Add admin actions & filters

             */

            if ( is_admin() ) {

                add_action('admin_enqueue_scripts', array($this, 'AMWL_admin_enqueue'));

                add_action('admin_menu', array($this, 'AMWL_register_menu')); 

                add_action('plugins_loaded', array($this, 'AMWL_admin_function'));               

            }

            /**

             * Add frontend actions & filters

             */

            add_action('wp_enqueue_scripts', array($this, 'AMWL_front_enqueue'));                      

        }

        /**

         * Include activation file

         */

        public function AMWL_activate() {

            include_once( AMWL_INCLUDES . AMWL_PREFIX .'-activation.php');

            /**

             * Do action for register options

             */

            do_action(AMWL_PREFIX . '_register_options');

            /**

             * Do action for create table

             */

            do_action(AMWL_PREFIX . '_create_table');           

        }

        /**

         * Include deactivation file

         */

        public function AMWL_deactivate() {

           include_once( AMWL_INCLUDES . AMWL_PREFIX .'-deactivation.php');     

        }

        /**

         * Add admin function

         */

        public function AMWL_admin_function() {

            include_once( AMWL_INC_FUNCTIONS . AMWL_PREFIX .'-functions.php');     

        }      

        /**

         * Include setting menu with submenu in admin dashboard

         */

        public function AMWL_register_menu() {

            add_menu_page(esc_html__('Wishlist', AMWL_DOMAIN), esc_html__('AM Wishlist', AMWL_DOMAIN), 'manage_options', esc_html__('amwl-general', AMWL_DOMAIN), array($this, 'AMWL_general_settings'), 'dashicons-heart', 59);

            add_submenu_page(esc_html__('amwl-general', AMWL_DOMAIN), esc_html__('Add to Wishlist', AMWL_DOMAIN), esc_html__('Add to Wishlist', AMWL_DOMAIN), 'manage_options', esc_html__('amwl-add-wishlist-settings', AMWL_DOMAIN), array($this, 'AMWL_add_to_wishlist_settings'));

            add_submenu_page(esc_html__('amwl-general', AMWL_DOMAIN), esc_html__('Wishlist Page Option', AMWL_DOMAIN), esc_html__('Wishlist Page', AMWL_DOMAIN), 'manage_options', esc_html__('amwl-wishlist-settings', AMWL_DOMAIN), array($this, 'AMWL_wishlist_page_opt_settings'));
        }

        /**

         * Include general setting file

         */

        public function AMWL_general_settings() { include_once( AMWL_ADMIN_INC . AMWL_PREFIX .'-general.php');}

        /**

         * Include add to wishlist setting file

         */

        public function AMWL_add_to_wishlist_settings() { include_once( AMWL_ADMIN_INC . AMWL_PREFIX .'-add-to-wishlist.php');}

        /**

         * Include wishlist page setting file

         */

        public function AMWL_wishlist_page_opt_settings() { include_once( AMWL_ADMIN_INC . AMWL_PREFIX .'-wishlist-page-opt.php');}

        /**

         * Add admin styles and scripts

         */

        public function AMWL_admin_enqueue() {

                /**

                 * Admin style

                 */

                wp_enqueue_style(AMWL_PREFIX .'-admin-css', AMWL_URL . 'includes/admin/css/' . AMWL_PREFIX .'-admin.css');

                /**

                 * Admin script 

                 */

                wp_enqueue_script(AMWL_PREFIX .'-admin', AMWL_URL . 'includes/admin/js/' . AMWL_PREFIX .'-admin.js');

                $amwl_data = array(

                    'upload_url' => admin_url('async-upload.php'),

                    'ajax_url'   => admin_url('admin-ajax.php'),

                    'nonce'      => wp_create_nonce('amwl-form')

                );

                wp_localize_script( AMWL_PREFIX .'-admin', AMWL_PREFIX .'_upload', $amwl_data );
        }

        /**

         * Add frontend styles and scripts

         */

        public function AMWL_front_enqueue() {

            /**

             * Frontend style

             */

            wp_enqueue_style(AMWL_PREFIX .'-frontend-css', AMWL_PUBLIC_CSS . AMWL_PREFIX .'-frontend.css');

            /**

             * Frontend script 

             */

            wp_enqueue_script( 'jquery' );

            wp_enqueue_script(AMWL_PREFIX .'-frontend', AMWL_URL . 'includes/public/js/' . AMWL_PREFIX .'-frontend.js');

            $amwl_admin_url = array('ajax_url' => admin_url('admin-ajax.php'));

            wp_localize_script( AMWL_PREFIX .'-frontend', AMWL_PREFIX .'_addto_wishlist', $amwl_admin_url );

            wp_localize_script( AMWL_PREFIX .'-frontend', AMWL_PREFIX .'_remove_from_wishlist', $amwl_admin_url );

            wp_localize_script( AMWL_PREFIX .'-frontend', AMWL_PREFIX .'_view_wishlist', $amwl_admin_url );

            wp_localize_script( AMWL_PREFIX .'-frontend', AMWL_PREFIX .'_addto_cart', $amwl_admin_url );      

        }

    }

};

/**

 * Define object of class & access method through this 

 */

if (class_exists('AM_wishlist')) {

    /**

     * Define object of class

     */

    $amwl_wishlist = new AM_wishlist();

    /**

     * Call member function of class

     */

    $amwl_wishlist->AMWL_register();

    /**

     * Include function file

     */

    include_once( AMWL_PUBLIC_INC . AMWL_PREFIX .'-functions.php');

    /**

     * Include shortcode file

     */    

    include_once( AMWL_PUBLIC_INC . AMWL_PREFIX .'-shortcode.php');

    /**

     * Register activation hook

     */

    register_activation_hook(__FILE__, array($amwl_wishlist, 'AMWL_activate'));

    /**

     * Register Deactivation hook

     */

    register_deactivation_hook(__FILE__, array($amwl_wishlist, 'AMWL_deactivate'));

}

} else{

    /**

     * Display admin notice if woocommerce plugin not activate

     */

    add_action('admin_notices', 'AMWL_admin_notice');

    /**

     * Callback function for admin notice

     */

    function AMWL_admin_notice() {

        $admin_notice = '';

        $amwl_plugin = plugin_basename(__FILE__);

        $admin_notice .= '<div class="error"><p>'; 

        $admin_notice .= esc_html__('AM Wishlist requires active version of ', AMWL_DOMAIN); 

        $admin_notice .= '<a href="https://wordpress.org/plugins/woocommerce/" target="_blank">'; 

        $admin_notice .= esc_html__('WooCommerce', AMWL_DOMAIN);

        $admin_notice .= '</a>';

        $admin_notice .= esc_html__(' plugin.', AMWL_DOMAIN);

        $admin_notice .= "</p></div>";

        /**

         * Print notice html

         */

        echo $admin_notice;

        /**

         * Do not allow this plugin to activate

         */

        deactivate_plugins( $amwl_plugin );

        /**

         * Unset the $_GET variable which triggers the activation message

         */

        unset($_GET['activate']);
    }
}