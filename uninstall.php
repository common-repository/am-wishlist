<?php
/**
 * Security check to prevent unauthorised user
 */
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}

/**
 * Drop table on plugin delete
 */
global $wpdb;
$amwl_table = $wpdb->prefix . esc_attr("amwl_wishlist_items");

$wpdb->query("DROP TABLE IF EXISTS $amwl_table");

/**
 * General options
 */
 delete_option('amwl_plugin_status');

/**
 * Add to wishlist options
 */
 delete_option('amwl_btn_position');
 delete_option('amwl_after_add_to_wishlist_behaviour_add');
 delete_option('amwl_btn_text');
 delete_option('amwl_btn_view_text');
 delete_option('amwl_btn_remove_text');
 delete_option('amwl_btn_already_in');
 delete_option('amwl_pro_added_text');

 delete_option('amwl_btn_archive');
 delete_option('amwl_btn_archive_position');
 delete_option('amwl_btn_style');
 delete_option('amwl_btn_icon');
 delete_option('amwl_btn_custom_css');

 delete_option('amwl_icon_upload');

/**
 * Wishlist page options
 */
 delete_option('amwl_wishlist_page');
 delete_option('amwl_wishlist_name');
 delete_option('amwl_remove_from_wishlist');     
 delete_option('amwl_redirect_to_cart');
 delete_option('amwl_success_notice');

 delete_option('amwl_show_prod_image');
 delete_option('amwl_show_prod_title');
 delete_option('amwl_show_prod_price');
 delete_option('amwl_show_prod_stock');
 delete_option('amwl_show_date_added');
 delete_option('amwl_cart_style');
 delete_option('amwl_cart_text');
 delete_option('amwl_show_remove_icon');

 delete_option('amwl_share_text');
 delete_option('amwl_share_fb');
 delete_option('amwl_share_twitter');
 delete_option('amwl_share_pinterest');
 delete_option('amwl_share_email');
 delete_option('amwl_share_whatsapp');
 delete_option('amwl_share_clipboard');
 delete_option('amwl_share_title');

 delete_option('amwl_fb_icon');
 delete_option('amwl_twitter_icon');
 delete_option('amwl_pint_icon');
 delete_option('amwl_email_icon');
 delete_option('amwl_wapp_icon');
 delete_option('amwl_cb_icon');
?>