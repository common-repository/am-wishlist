<?php
if(isset($_POST['amwl_wishlist_opt_panel'])){
	$amwl_success = esc_html__('Successfully settings saved.', AMWL_DOMAIN);

	/**
	 * Get wishlist page fields
	 */
	if(!empty($_POST['amwl_wishlist_page'])){
		$amwl_wishlist_page = sanitize_text_field($_POST['amwl_wishlist_page']);
	}else{
		$amwl_wishlist_page = sanitize_text_field('0');
	}
	
	if(!empty($_POST['amwl_wishlist_name'])){
		$amwl_wishlist_name = sanitize_text_field($_POST['amwl_wishlist_name']);
	}else{
		$amwl_wishlist_name = sanitize_text_field('Wishlist');
	}

	if(!empty($_POST['amwl_remove_from_wishlist'])){
		$amwl_remove = sanitize_text_field($_POST['amwl_remove_from_wishlist']);
	}else{
		$amwl_remove = sanitize_text_field('false');
	}

	if(!empty($_POST['amwl_redirect_to_cart'])){
		$amwl_redirect = sanitize_text_field($_POST['amwl_redirect_to_cart']);
	}else{
		$amwl_redirect = sanitize_text_field('false');
	}

	if(!empty($_POST['amwl_success_notice'])){
		$amwl_success_notice = sanitize_text_field($_POST['amwl_success_notice']);
	}else{
		$amwl_success_notice = sanitize_text_field('Product added successfully in cart!');
	}

	/**
	 * Get wishlist table fields
	 */
	if(!empty($_POST['amwl_show_prod_image'])){
		$amwl_prod_img = sanitize_text_field($_POST['amwl_show_prod_image']);
	}else{
		$amwl_prod_img = sanitize_text_field('false');
	}
	
	if(!empty($_POST['amwl_show_prod_title'])){
		$amwl_prod_title = sanitize_text_field($_POST['amwl_show_prod_title']);
	}else{
		$amwl_prod_title = sanitize_text_field('false');
	}

	if(!empty($_POST['amwl_show_prod_price'])){
		$amwl_prod_price = sanitize_text_field($_POST['amwl_show_prod_price']);
	}else{
		$amwl_prod_price = sanitize_text_field('false');
	}

	if(!empty($_POST['amwl_show_prod_stock'])){
		$amwl_prod_stock = sanitize_text_field($_POST['amwl_show_prod_stock']);
	}else{
		$amwl_prod_stock = sanitize_text_field('false');
	}

	if(!empty($_POST['amwl_show_date_added'])){
		$amwl_date_added = sanitize_text_field($_POST['amwl_show_date_added']);
	}else{
		$amwl_date_added = sanitize_text_field('false');
	}	

	if(!empty($_POST['amwl_cart_style'])){
		$amwl_cart_style = sanitize_text_field($_POST['amwl_cart_style']);
	}else{
		$amwl_cart_style = sanitize_text_field('amwl_cart_style_link');
	}

	if(!empty($_POST['amwl_cart_text'])){
		$amwl_cart_text = sanitize_text_field($_POST['amwl_cart_text']);
	}else{
		$amwl_cart_text = sanitize_text_field('Add to Cart');
	}

	if(!empty($_POST['amwl_show_remove_icon'])){
		$amwl_remove_icon = sanitize_text_field($_POST['amwl_show_remove_icon']);
	}else{
		$amwl_remove_icon = sanitize_text_field('false');
	}

	/**
	 * Get share wishlist fields
	 */
	if(!empty($_POST['amwl_share_text'])){
		$amwl_share_text = sanitize_text_field($_POST['amwl_share_text']);
	}else{
		$amwl_share_text = sanitize_text_field('Share on');
	}
	
	if(!empty($_POST['amwl_share_fb'])){
		$amwl_share_fb = sanitize_text_field($_POST['amwl_share_fb']);
	}else{
		$amwl_share_fb = sanitize_text_field('false');
	}

	if(!empty($_POST['amwl_share_twitter'])){
		$amwl_share_twitter = sanitize_text_field($_POST['amwl_share_twitter']);
	}else{
		$amwl_share_twitter = sanitize_text_field('false');
	}

	if(!empty($_POST['amwl_share_pinterest'])){
		$amwl_share_pinterest = sanitize_text_field($_POST['amwl_share_pinterest']);
	}else{
		$amwl_share_pinterest = sanitize_text_field('false');
	}

	if(!empty($_POST['amwl_share_email'])){
		$amwl_share_email = sanitize_text_field($_POST['amwl_share_email']);
	}else{
		$amwl_share_email = sanitize_text_field('false');
	}

	if(!empty($_POST['amwl_share_whatsapp'])){
		$amwl_share_whatsapp = sanitize_text_field($_POST['amwl_share_whatsapp']);
	}else{
		$amwl_share_whatsapp = sanitize_text_field('false');
	}

	if(!empty($_POST['amwl_share_clipboard'])){
		$amwl_share_clipboard = sanitize_text_field($_POST['amwl_share_clipboard']);
	}else{
		$amwl_share_clipboard = sanitize_text_field('false');
	}

	if(!empty($_POST['amwl_share_title'])){
		$amwl_share_title = sanitize_text_field($_POST['amwl_share_title']);
	}else{
		$amwl_share_title = sanitize_text_field('My Wishlist');
	}

	/**
	 * Create array of fields values
	 */
	$amwl_options = array(
		esc_html__('amwl_wishlist_page', AMWL_DOMAIN) => $amwl_wishlist_page,
		esc_html__('amwl_wishlist_name', AMWL_DOMAIN) => $amwl_wishlist_name,
		esc_html__('amwl_remove_from_wishlist', AMWL_DOMAIN) => $amwl_remove,
		esc_html__('amwl_redirect_to_cart', AMWL_DOMAIN) => $amwl_redirect,
		esc_html__('amwl_success_notice', AMWL_DOMAIN) => $amwl_success_notice,

		esc_html__('amwl_show_prod_image', AMWL_DOMAIN) => $amwl_prod_img,
		esc_html__('amwl_show_prod_title', AMWL_DOMAIN) => $amwl_prod_title,
		esc_html__('amwl_show_prod_price', AMWL_DOMAIN) => $amwl_prod_price,
		esc_html__('amwl_show_prod_stock', AMWL_DOMAIN) => $amwl_prod_stock,
		esc_html__('amwl_show_date_added', AMWL_DOMAIN) => $amwl_date_added,
		esc_html__('amwl_cart_style', AMWL_DOMAIN) => $amwl_cart_style,
		esc_html__('amwl_cart_text', AMWL_DOMAIN) => $amwl_cart_text,		
		esc_html__('amwl_show_remove_icon', AMWL_DOMAIN) => $amwl_remove_icon,

		esc_html__('amwl_share_text', AMWL_DOMAIN) => $amwl_share_text,
		esc_html__('amwl_share_fb', AMWL_DOMAIN) => $amwl_share_fb,
		esc_html__('amwl_share_twitter', AMWL_DOMAIN) => $amwl_share_twitter,
		esc_html__('amwl_share_pinterest', AMWL_DOMAIN) => $amwl_share_pinterest,
		esc_html__('amwl_share_email', AMWL_DOMAIN) => $amwl_share_email,
		esc_html__('amwl_share_whatsapp', AMWL_DOMAIN) => $amwl_share_whatsapp,
		esc_html__('amwl_share_clipboard', AMWL_DOMAIN) => $amwl_share_clipboard,
		
		esc_html__('amwl_share_title', AMWL_DOMAIN) => $amwl_share_title,
	);

	/**
 	 * Call function for save options
     */
	AMWL_settings_submit($amwl_options, $amwl_success);	
}

/**
 * Do ation for wishlist page settings
 */
do_action(AMWL_PREFIX . '_wishlist_options');
?>