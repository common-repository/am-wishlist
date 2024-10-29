<?php
if(isset($_POST['amwl_general_panel'])){
	$amwl_success = esc_html__('Successfully settings saved.', AMWL_DOMAIN);

	if(!empty($_POST['amwl_plugin_status'])){
		$amwl_plugin_status = sanitize_text_field($_POST['amwl_plugin_status']);
	}else{
		$amwl_plugin_status = sanitize_text_field('0');
	}

	$amwl_options = array(
		esc_html__('amwl_plugin_status', AMWL_DOMAIN) => $amwl_plugin_status,
	);

	/**
 	 * Call function for save options
     */
	AMWL_settings_submit($amwl_options, $amwl_success);
}

/**
 * Do action for general settings
 */
do_action(AMWL_PREFIX . '_general_options');
?>