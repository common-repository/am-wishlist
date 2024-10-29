<?php
if(isset($_POST['amwl_add_wishlist_panel'])){
	$amwl_success = esc_html__('Successfully settings saved.', AMWL_DOMAIN);

	/**
	 * Get "Add to Wishlist" fields
	 */
	if(!empty($_POST['amwl_btn_position'])){
		$amwl_btn_position = sanitize_text_field($_POST['amwl_btn_position']);
	}else{
		$amwl_btn_position = sanitize_text_field('amwl_btn_after');
	}
	
	if(!empty($_POST['amwl_after_add_to_wishlist_behaviour_add'])){
		$amwl_after_atw_behaviour = sanitize_text_field($_POST['amwl_after_add_to_wishlist_behaviour_add']);
	}else{
		$amwl_after_atw_behaviour = sanitize_text_field('amwl_remove');
	}

	if(!empty($_POST['amwl_btn_text'])){
		$amwl_btn_text = sanitize_text_field($_POST['amwl_btn_text']);
	}else{
		$amwl_btn_text = sanitize_text_field('Add to Wishlist');
	}

	if(!empty($_POST['amwl_btn_view_text'])){
		$amwl_btn_view_text = sanitize_text_field($_POST['amwl_btn_view_text']);
	}else{
		$amwl_btn_view_text = sanitize_text_field('View Wishlist');
	}

	if(!empty($_POST['amwl_btn_remove_text'])){
		$amwl_btn_remove_text = sanitize_text_field($_POST['amwl_btn_remove_text']);
	}else{
		$amwl_btn_remove_text = sanitize_text_field('Remove From List');
	}

	if(!empty($_POST['amwl_btn_already_in'])){
		$amwl_btn_already_in = sanitize_text_field($_POST['amwl_btn_already_in']);
	}else{
		$amwl_btn_already_in = sanitize_text_field('Already In Wishlist');
	}

	if(!empty($_POST['amwl_pro_added_text'])){
		$amwl_pro_added_text = sanitize_text_field($_POST['amwl_pro_added_text']);
	}else{
		$amwl_pro_added_text = sanitize_text_field('Product added!');
	}

	/**
	 * Get loop fields
	 */
	if(!empty($_POST['amwl_btn_archive'])){
		$amwl_btn_archive = sanitize_text_field($_POST['amwl_btn_archive']);
	}else{
		$amwl_btn_archive = sanitize_text_field('false');
	}

	if(!empty($_POST['amwl_btn_archive_position'])){
		$amwl_btn_archive_position = sanitize_text_field($_POST['amwl_btn_archive_position']);
	}else{
		$amwl_btn_archive_position = sanitize_text_field('amwl_btn_archive_after');
	}
	
	/**
	 * get "Add to Wishlist" btn style fields
	 */
	if(!empty($_POST['amwl_btn_style'])){
		$amwl_btn_style = sanitize_text_field($_POST['amwl_btn_style']);
	}else{
		$amwl_btn_style = sanitize_text_field('amwl_style_link');
	}
	
	if(!empty($_POST['amwl_btn_icon'])){
		$amwl_btn_icon = sanitize_text_field($_POST['amwl_btn_icon']);
	}else{
		$amwl_btn_icon = sanitize_text_field('amwl_icon_heart');
	}

	if(!empty($_POST['amwl_btn_custom_css'])){
		$amwl_btn_custom_css = sanitize_text_field($_POST['amwl_btn_custom_css']);
	}else{
		$amwl_btn_custom_css = sanitize_text_field('');
	}

	/**
	 * create array of fields values
	 */
	$amwl_options = array(
		esc_html__('amwl_btn_position', AMWL_DOMAIN) => $amwl_btn_position,
		esc_html__('amwl_after_add_to_wishlist_behaviour_add', AMWL_DOMAIN) => $amwl_after_atw_behaviour,
		esc_html__('amwl_btn_text', AMWL_DOMAIN) => $amwl_btn_text,
		esc_html__('amwl_btn_view_text', AMWL_DOMAIN) => $amwl_btn_view_text,
		esc_html__('amwl_btn_remove_text', AMWL_DOMAIN) => $amwl_btn_remove_text,
		esc_html__('amwl_btn_already_in', AMWL_DOMAIN) => $amwl_btn_already_in,
		esc_html__('amwl_pro_added_text', AMWL_DOMAIN) => $amwl_pro_added_text,

		esc_html__('amwl_btn_archive', AMWL_DOMAIN) => $amwl_btn_archive,
		esc_html__('amwl_btn_archive_position', AMWL_DOMAIN) => $amwl_btn_archive_position,

		esc_html__('amwl_btn_style', AMWL_DOMAIN) => $amwl_btn_style,
		esc_html__('amwl_btn_icon', AMWL_DOMAIN) => $amwl_btn_icon,
		esc_html__('amwl_btn_custom_css', AMWL_DOMAIN) => $amwl_btn_custom_css,
	);
	
	/**
 	 * Call function for save options
     */
	AMWL_settings_submit($amwl_options, $amwl_success);	
}

/**
 * Do action for add to wishlist settings
 */
do_action( AMWL_PREFIX . '_add_wishlist_options' );
?>