<?php
if(AMWL_get_option('amwl_plugin_status') == sanitize_text_field('1')){
	if(AMWL_get_option('amwl_btn_archive') == sanitize_text_field('true')){
		/**
		 * Do action for loop pages
		 */
		do_action( AMWL_PREFIX . '_btn_in_archive' );	
	}
	/**
     * Do action for details pages
	 */
	do_action( AMWL_PREFIX . '_btn_in_details' );
}

if(!is_admin() && AMWL_get_option('amwl_plugin_status') == sanitize_text_field('1')){
		
	if(AMWL_get_option('amwl_wishlist_page') != sanitize_text_field('0')){
		/**
    	 * Add shortcode for show wishlist table
		 */
    	add_shortcode( 'amwl_wishlist', 'AMWL_show_wishlist_html' );
	}	

	if(AMWL_get_option('amwl_btn_custom_css') != ''){
		/**
    	 * Add shortcode for add custom css
		 */
    	add_action( 'wp_footer', 'AMWL_add_custom_css' );
	}	
}
?>