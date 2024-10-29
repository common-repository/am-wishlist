<?php
/**
 * Activation 
 */
function AMWL_activate() {
    /**
     * Flush rewrite rules 
     */
    flush_rewrite_rules();
}

/**
 * Add action for register options
 */
add_action( AMWL_PREFIX . '_register_options', 'AMWL_register_options_callback' );

if ( ! function_exists( 'AMWL_register_options_callback' ) ) {
    function AMWL_register_options_callback() {

    	/**
         * General options
         */
        add_option(esc_html__('amwl_plugin_status', AMWL_DOMAIN), esc_html__('1', AMWL_DOMAIN));
        /**
         * Add to wishlist options
         */
        add_option('amwl_btn_position', esc_html__('amwl_btn_after', AMWL_DOMAIN));
        add_option('amwl_after_add_to_wishlist_behaviour_add', esc_html__('amwl_remove', AMWL_DOMAIN));
        add_option('amwl_btn_text', esc_html__('Add to Wishlist', AMWL_DOMAIN));
        add_option('amwl_btn_view_text', esc_html__('View Wishlist', AMWL_DOMAIN));
        add_option('amwl_btn_remove_text', esc_html__('Remove From List', AMWL_DOMAIN));
        add_option('amwl_btn_already_in', esc_html__('Already In Wishlist', AMWL_DOMAIN));
        add_option('amwl_pro_added_text', esc_html__('Product added!', AMWL_DOMAIN));

        add_option('amwl_btn_archive', esc_html__('false', AMWL_DOMAIN));
        add_option('amwl_btn_archive_position', esc_html__('amwl_btn_archive_after', AMWL_DOMAIN));
        add_option('amwl_btn_style', esc_html__('amwl_style_link', AMWL_DOMAIN));
        add_option('amwl_btn_icon', esc_html__('amwl_icon_heart', AMWL_DOMAIN));
        add_option('amwl_btn_custom_css', esc_html__('', AMWL_DOMAIN));

        add_option('amwl_icon_upload', AMWL_ADMIN_IMG .'heart.png');
        /**
         * Wishlist page options
         */
        add_option('amwl_wishlist_page', esc_html__('0', AMWL_DOMAIN));
        add_option('amwl_wishlist_name', esc_html__('Wishlist', AMWL_DOMAIN));
        add_option('amwl_remove_from_wishlist', esc_html__('true', AMWL_DOMAIN));       
        add_option('amwl_redirect_to_cart', esc_html__('false', AMWL_DOMAIN));
        add_option('amwl_success_notice', esc_html__('Product added successfully in cart!', AMWL_DOMAIN));

        add_option('amwl_show_prod_image', esc_html__('true', AMWL_DOMAIN));
        add_option('amwl_show_prod_title', esc_html__('true', AMWL_DOMAIN));
        add_option('amwl_show_prod_price', esc_html__('true', AMWL_DOMAIN));
        add_option('amwl_show_prod_stock', esc_html__('false', AMWL_DOMAIN));
        add_option('amwl_show_date_added', esc_html__('false', AMWL_DOMAIN));
        add_option('amwl_cart_style', esc_html__('amwl_cart_style_link', AMWL_DOMAIN));
        add_option('amwl_cart_text', esc_html__('Add to Cart', AMWL_DOMAIN));
        add_option('amwl_show_remove_icon', esc_html__('true', AMWL_DOMAIN));

        add_option('amwl_share_text', esc_html__('Share on', AMWL_DOMAIN));
        add_option('amwl_share_fb', esc_html__('true', AMWL_DOMAIN));
        add_option('amwl_share_twitter', esc_html__('true', AMWL_DOMAIN));
        add_option('amwl_share_pinterest', esc_html__('true', AMWL_DOMAIN));
        add_option('amwl_share_email', esc_html__('true', AMWL_DOMAIN));
        add_option('amwl_share_whatsapp', esc_html__('true', AMWL_DOMAIN));
        add_option('amwl_share_clipboard', esc_html__('false', AMWL_DOMAIN));
        add_option('amwl_share_title', esc_html__('My Wishlist', AMWL_DOMAIN));

        add_option('amwl_fb_icon', AMWL_ADMIN_IMG .'facebook.png');
        add_option('amwl_twitter_icon', AMWL_ADMIN_IMG .'twitter.png');
        add_option('amwl_pint_icon', AMWL_ADMIN_IMG .'pinterest.png');
        add_option('amwl_email_icon', AMWL_ADMIN_IMG .'gmail.png');
        add_option('amwl_wapp_icon', AMWL_ADMIN_IMG .'whatsapp.png');
        add_option('amwl_cb_icon', AMWL_ADMIN_IMG .'copy.png');
    }
}

/**
 * Add action for create table
 */
add_action( AMWL_PREFIX . '_create_table', 'AMWL_create_table_callback' );

if ( ! function_exists( 'AMWL_create_table_callback' ) ) {
    function AMWL_create_table_callback() {

            global $wpdb;
            $amwl_table = $wpdb->prefix . esc_attr("amwl_wishlist_items");
            $amwl_charset = $wpdb->get_charset_collate();

            $amwl_sql_items = "CREATE TABLE IF NOT EXISTS $amwl_table (                 
                              `ID` bigint(20) NOT NULL AUTO_INCREMENT,
                              `wishlist_id` bigint(20) DEFAULT NULL,
                              `user_id` bigint(20) DEFAULT NULL,
                              `prod_id` bigint(20) NOT NULL,
                              `quantity` int(11) NOT NULL,
                              `prod_org_price` decimal(9,3) DEFAULT NULL,
                              `prod_org_currency` char(3) CHARACTER SET utf8 DEFAULT NULL,
                              `prod_dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                              `pro_exists` int(11) NOT NULL,
                              `temp_user_data` VARCHAR(255) NOT NULL,
                              PRIMARY KEY (`ID`)
                            ) $amwl_charset;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta($amwl_sql_items);
    }
}
?>