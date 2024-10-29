<?php

/**
 * Submit options
 */
function AMWL_settings_submit($amwl_options, $amwl_success) {

    foreach ($amwl_options as $amwl_opt_name => $amwl_opt_value) {
        update_option($amwl_opt_name, $amwl_opt_value);
    }

    AMWL_success_message($amwl_success);
    add_action('admin_notices', 'AMWL_success_message');
}

/**
 * Upload file
 */
function amwl_upload_file() {

    $amwl_file_data = $_FILES['amwl_icon'];
    $amwl_file_name = $amwl_file_data['name'];
    $amwl_file_type = $amwl_file_data['type'];
    $amwl_file_tmp_name = $amwl_file_data['tmp_name'];
    $amwl_file_error = $amwl_file_data['error'];
    $amwl_file_size = $amwl_file_data['size'];

    $amwl_upload = wp_upload_bits($amwl_file_name, null, file_get_contents($amwl_file_tmp_name));
    $amwl_file_url = $amwl_upload['url'];

    $amwl_opt_name = sanitize_text_field($_POST['amwl_option_name']);
    $amwl_opt_value = $amwl_file_url;

    update_option($amwl_opt_name, $amwl_opt_value);

    $data = array('file_url' => $amwl_opt_value);
    $response = json_encode($data);
    echo $response;
    die();
}

add_action('wp_ajax_amwl_upload_file', 'amwl_upload_file');
add_action('wp_ajax_nopriv_amwl_upload_file', 'amwl_upload_file');

/* * *************************************************************************** */

/**
 * Display success message
 */
function AMWL_success_message($amwl_success) {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php echo esc_html__($amwl_success, AMWL_DOMAIN); ?></p>
    </div>
    <?php
}

/**
 * Display error message
 */
function AMWL_error_message($amwl_error) {
    ?>
    <div class="notice notice-error">
        <p><?php echo esc_html__($amwl_error, AMWL_DOMAIN); ?></p>
    </div>
    <?php
}

/* * *************************************************************************** */

/**
 * Add action for general settings
 */
add_action(AMWL_PREFIX . '_general_options', 'AMWL_general_html');

function AMWL_general_html($amwl_ganeral) {
    $amwl_plugin_status = AMWL_get_option('amwl_plugin_status');
    ?>    
    <div class="amwl-admin-panel-content-wrap">
        <form id="amwl-general-form" method="post">
            <h1><?php echo esc_html__('General Settings', AMWL_DOMAIN); ?></h1>
            <div class="amwl-general-section">              
                <table class="amwl-general-form-table">
                    <tbody>
                        <tr valign="top" class="amwl-general-row-tr">                               
                            <td class="amwl-general-td">
                                <label for="amwl_plugin_status"><?php echo esc_html__('Enable Plugin', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-general-td">
                                <input type="checkbox" id="amwl_plugin_status" name="amwl_plugin_status" class="awml-checked" value="<?php echo sanitize_text_field('1'); ?>" <?php checked($amwl_plugin_status, '1'); ?> >
                                <span class="amwl-description"><?php echo esc_html__('Enable/Disable Plugin.', AMWL_DOMAIN); ?></span>
                            </td>                               
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php wp_nonce_field('amwl_general_panel_action', 'amwl_general_panel'); ?>
            <input type="submit" class="button-primary" value="<?php echo esc_html__('Save Changes', AMWL_DOMAIN); ?>" />
        </form>
    </div>
    <?php
}

/* * *************************************************************************** */

/**
 * Add action for add to wishlist settings
 */
add_action(AMWL_PREFIX . '_add_wishlist_options', 'AMWL_add_wishlist_html');

function AMWL_add_wishlist_html() {
    $amwl_btn_position = sanitize_text_field(AMWL_get_option('amwl_btn_position'));
    $amwl_after_atw_behaviour = sanitize_text_field(AMWL_get_option('amwl_after_add_to_wishlist_behaviour_add'));
    $amwl_btn_text = sanitize_text_field(AMWL_get_option('amwl_btn_text'));
    $amwl_btn_view_text = sanitize_text_field(AMWL_get_option('amwl_btn_view_text'));
    $amwl_btn_remove_text = sanitize_text_field(AMWL_get_option('amwl_btn_remove_text'));
    $amwl_btn_already_in = sanitize_text_field(AMWL_get_option('amwl_btn_already_in'));
    $amwl_pro_added_text = sanitize_text_field(AMWL_get_option('amwl_pro_added_text'));

    $amwl_btn_archive = sanitize_text_field(AMWL_get_option('amwl_btn_archive'));
    $amwl_btn_archive_position = sanitize_text_field(AMWL_get_option('amwl_btn_archive_position'));

    $amwl_btn_style = sanitize_text_field(AMWL_get_option('amwl_btn_style'));
    $amwl_btn_icon = sanitize_text_field(AMWL_get_option('amwl_btn_icon'));
    $amwl_icon_upload = esc_url_raw(AMWL_get_option('amwl_icon_upload'));
    $amwl_btn_custom_css = sanitize_text_field(AMWL_get_option('amwl_btn_custom_css'));
    ?>    
    <div class="amwl-admin-panel-content-wrap">
        <form id="amwl-add-wishlist-form" name="amwl-add-wishlist-form" method="post" enctype="multipart/form-data">
            <h1><?php echo esc_html__('Add to Wishlist Settings', AMWL_DOMAIN); ?></h1>
            <div class="amwl-btn-section">
                <h2><?php echo esc_html__('Product page "Add to Wishlist" Button Settings', AMWL_DOMAIN); ?></h2>
                <table class="amwl-add-wislist-form-table">
                    <tbody>
                        <tr valign="top" class="amwl-add-wishlist-tr">
                            <td class="amwl-add-wishlist-td">
                                <label for="amwl_btn_position"><?php echo esc_html__('Button position', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-add-wishlist-td">
                                <select id="amwl_btn_position" name="amwl_btn_position">
                                    <option value="amwl_btn_after" <?php selected($amwl_btn_position, sanitize_text_field('amwl_btn_after')); ?> ><?php echo esc_html__('After "Add to Cart" button', AMWL_DOMAIN); ?></option>
                                    <option value="amwl_btn_before" <?php selected($amwl_btn_position, sanitize_text_field('amwl_btn_before')); ?> ><?php echo esc_html__('Before "Add to Cart" button', AMWL_DOMAIN); ?></option>
                                    <option value="amwl_btn_shortcode" <?php selected($amwl_btn_position, sanitize_text_field('amwl_btn_shortcode')); ?> ><?php echo esc_html__('Custom position with shortcode', AMWL_DOMAIN); ?></option>
                                </select>
                                <span class="amwl-description"><?php echo esc_html__('Choose where to show "Add to wishlist" button on the product page.', AMWL_DOMAIN); ?></span>
                                <span class="amwl-note"><?php echo esc_html__('Copy this shortcode [amwl_add_to_wishlist] and paste it where you want to show the "Add to wishlist" link or button', AMWL_DOMAIN); ?></span>
                            </td>                                   
                        </tr>                           
                        <tr valign="top" class="amwl-add-wishlist-tr">
                            <td class="amwl-add-wishlist-td">
                                <label for="amwl_after_add_to_wishlist_behaviour"><?php echo esc_html__('After product is added to wishlist', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-add-wishlist-td">
                                <div class="input-radio-group">
                                    <input type="radio" id="amwl_after_add_to_wishlist_behaviour_add" name="amwl_after_add_to_wishlist_behaviour_add" value="amwl_already" <?php checked($amwl_after_atw_behaviour, sanitize_text_field('amwl_already')); ?> >
                                    <label for="amwl_after_add_to_wishlist_behaviour_add"><?php echo esc_html__('Show "Already In Wishlist" link', AMWL_DOMAIN); ?></label>
                                </div>
                                <div class="input-radio-group">
                                    <input type="radio" id="amwl_after_add_to_wishlist_behaviour_view" name="amwl_after_add_to_wishlist_behaviour_add" value="amwl_view" <?php checked($amwl_after_atw_behaviour, sanitize_text_field('amwl_view')); ?>>
                                    <label for="amwl_after_add_to_wishlist_behaviour_view"><?php echo esc_html__('Show "View wishlist" link', AMWL_DOMAIN); ?></label>
                                </div>
                                <div class="input-radio-group">
                                    <input type="radio" id="amwl_after_add_to_wishlist_behaviour_remove" name="amwl_after_add_to_wishlist_behaviour_add" value="amwl_remove" <?php checked($amwl_after_atw_behaviour, sanitize_text_field('amwl_remove')); ?>>
                                    <label for="amwl_after_add_to_wishlist_behaviour_remove"><?php echo esc_html__('Show "Remove from list" link', AMWL_DOMAIN); ?></label>
                                </div>
                                <span class="amwl-description"><?php echo esc_html__('Choose the look of the Wishlist button when the product has already been added to a wishlist.', AMWL_DOMAIN); ?></span>
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-add-wishlist-tr">
                            <td class="amwl-add-wishlist-td">
                                <label for="amwl_btn_text"><?php echo esc_html__('"Add to Wishlist" Button Text', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-add-wishlist-td">
                                <input type="text" id="amwl_btn_text" name="amwl_btn_text" value="<?php echo $amwl_btn_text; ?>">
                                <span class="amwl-description"><?php echo esc_html__('Enter a text for "Add to wishlist" button or link', AMWL_DOMAIN); ?></span>
                            </td>                               
                        </tr>

                        <tr valign="top" class="amwl-add-wishlist-tr">
                            <td class="amwl-add-wishlist-td">
                                <label for="amwl_btn_view_text"><?php echo esc_html__('"View Wishlist" Button Text', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-add-wishlist-td">
                                <input type="text" id="amwl_btn_view_text" name="amwl_btn_view_text" value="<?php echo $amwl_btn_view_text; ?>">
                                <span class="amwl-description"><?php echo esc_html__('Enter a text for "View Wishlist" button after product added in wishlist', AMWL_DOMAIN); ?></span>
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-add-wishlist-tr">
                            <td class="amwl-add-wishlist-td">
                                <label for="amwl_btn_remove_text"><?php echo esc_html__('"Remove from list" Button Text', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-add-wishlist-td">
                                <input type="text" id="amwl_btn_remove_text" name="amwl_btn_remove_text" value="<?php echo $amwl_btn_remove_text; ?>">
                                <span class="amwl-description"><?php echo esc_html__('Enter a text for "Remove from list" button after product added in wishlist', AMWL_DOMAIN); ?></span>
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-add-wishlist-tr">
                            <td class="amwl-add-wishlist-td">
                                <label for="amwl_btn_already_in"><?php echo esc_html__('"Already In Wishlist" Text', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-add-wishlist-td">
                                <input type="text" id="amwl_btn_already_in" name="amwl_btn_already_in" value="<?php echo $amwl_btn_already_in; ?>">
                                <span class="amwl-description"><?php echo esc_html__('Enter the text for the message displayed when the user views a product that is already in the wishlist', AMWL_DOMAIN); ?></span>
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-add-wishlist-tr">
                            <td class="amwl-add-wishlist-td">
                                <label for="amwl_pro_added_text"><?php echo esc_html__('"Product added to Wishlist" Text', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-add-wishlist-td">
                                <input type="text" id="amwl_pro_added_text" name="amwl_pro_added_text" value="<?php echo $amwl_pro_added_text; ?>">
                                <span class="amwl-description"><?php echo esc_html__('Enter the text of the message displayed when the user adds a product to the wishlist', AMWL_DOMAIN); ?></span>
                            </td>                                   
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="amwl-loop-section">
                <h2><?php echo esc_html__('Loop Settings', AMWL_DOMAIN); ?></h2>
                <table class="amwl-add-wislist-form-table">
                    <tbody>
                        <tr valign="top" class="amwl-add-wishlist-tr">
                            <td class="amwl-add-wishlist-td">
                                <label for="amwl_btn_archive"><?php echo esc_html__('Show "Add to wishlist" in Shop Page', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-add-wishlist-td">
                                <input type="checkbox" id="amwl_btn_archive" name="amwl_btn_archive" class="awml-checked" value="true"
                                       <?php checked($amwl_btn_archive, sanitize_text_field('true')); ?> >
                                <span class="amwl-description"><?php echo esc_html__('Enable the "Add to wishlist" feature in Archive Pages.', AMWL_DOMAIN); ?>
                                </span>
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-add-wishlist-tr">
                            <td class="amwl-add-wishlist-td">
                                <label for="amwl_btn_archive_position"><?php echo esc_html__('Loop Page Button position', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-add-wishlist-td">
                                <select id="amwl_btn_archive_position" name="amwl_btn_archive_position">
                                    <option value="amwl_btn_archive_after" <?php selected($amwl_btn_archive_position, sanitize_text_field('amwl_btn_archive_after')); ?> ><?php echo esc_html__('After "Add to Cart" button', AMWL_DOMAIN); ?></option>
                                    <option value="amwl_btn_archive_before" <?php selected($amwl_btn_archive_position, sanitize_text_field('amwl_btn_archive_before')); ?> ><?php echo esc_html__('Before "Add to Cart" button', AMWL_DOMAIN); ?></option>
                                    <option value="amwl_btn_archive_shortcode" <?php selected($amwl_btn_archive_position, sanitize_text_field('amwl_btn_archive_shortcode')); ?> ><?php echo esc_html__('Custom position with shortcode', AMWL_DOMAIN); ?></option>
                                </select>
                                <span class="amwl-description"><?php echo esc_html__('Choose where to show "Add to wishlist" button on the Archive page.', AMWL_DOMAIN); ?></span>
                                <span class="amwl-note"><?php echo esc_html__('Copy this shortcode [amwl_add_to_wishlist] and paste it where you want to show the "Add to wishlist" link or button', AMWL_DOMAIN); ?></span>
                            </td>                                   
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="amwl-style-section">
                <h2><?php echo esc_html__('"Add to Wishlist" Button Style Settings', AMWL_DOMAIN); ?></h2>
                <table class="amwl-add-wislist-form-table">
                    <tbody>
                        <tr valign="top" class="amwl-add-wishlist-tr">
                            <td class="amwl-add-wishlist-td">
                                <label for="amwl_btn_style"><?php echo esc_html__('"Add to wishlist" Style', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-add-wishlist-td">
                                <select id="amwl_btn_style" name="amwl_btn_style">
                                    <option value="amwl_style_link" <?php selected($amwl_btn_style, sanitize_text_field('amwl_style_link')); ?>><?php echo esc_html__('Anchor Link', AMWL_DOMAIN); ?></option>
                                    <option value="amwl_style_btn" <?php selected($amwl_btn_style, sanitize_text_field('amwl_style_btn')); ?>><?php echo esc_html__('Button', AMWL_DOMAIN); ?></option>
                                </select>
                                <span class="amwl-description"><?php echo esc_html__('Choose if you want to show a "Add to wishlist" link or a button', AMWL_DOMAIN); ?></span>
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-add-wishlist-tr">
                            <td class="amwl-add-wishlist-td">
                                <label for="amwl_btn_icon"><?php echo esc_html__('"Add to Wishlist" Icon', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-add-wishlist-td">
                                <select id="amwl_btn_icon" name="amwl_btn_icon">
                                    <option value="amwl_icon_heart" <?php selected($amwl_btn_icon, sanitize_text_field('amwl_icon_heart')); ?>><?php echo esc_html__('Heart', AMWL_DOMAIN); ?></option>
                                    <option value="amwl_icon_none" <?php selected($amwl_btn_icon, sanitize_text_field('amwl_icon_none')); ?>><?php echo esc_html__('None', AMWL_DOMAIN); ?></option>
                                    <option value="amwl_icon_custom" <?php selected($amwl_btn_icon, sanitize_text_field('amwl_icon_custom')); ?>><?php echo esc_html__('Custom', AMWL_DOMAIN); ?></option>
                                </select>
                                <span class="amwl-description"><?php echo esc_html__('Select an icon for the "Add to wishlist" link.', AMWL_DOMAIN); ?></span>
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-add-wishlist-tr amwl-wishlist-icon">
                            <td class="amwl-add-wishlist-td">   
                                <label for="amwl_icon_upload"><?php echo esc_html__('Choose File', AMWL_DOMAIN); ?></label>                 
                            </td>
                            <td class="amwl-add-wishlist-td">
                                <div class="icon-preview amwl-icon-preview">
                                    <?php if (!empty($amwl_icon_upload)) { ?><span class="amwl-file"><img src="<?php echo $amwl_icon_upload; ?>"></span><?php } ?>
                                </div>
                                <div class="icon-upload amwl-icon-upload">
                                    <input type="file" id="amwl_icon_upload" name="amwl_icon_upload" accept="image/*" class="icon">
                                    <input type="button" id="amwl_icon_upload_btn" name="amwl_icon_upload_btn" value="<?php echo esc_html__('Upload Icon', AMWL_DOMAIN); ?>" class="button">
                                </div>                                                                      
                                <span class="amwl-upload-desc"><?php echo esc_html__('Upload an icon for the "Add to wishlist" link.', AMWL_DOMAIN); ?></span>
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-add-wishlist-tr">
                            <td class="amwl-add-wishlist-td">
                                <label for="amwl_btn_custom_css"><?php echo esc_html__('Custom CSS', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-add-wishlist-td">
                                <textarea id="amwl_btn_custom_css" name="amwl_btn_custom_css" class="" rows="5" cols="50"><?php echo $amwl_btn_custom_css; ?></textarea>                        
                                <span class="amwl-description"><?php echo esc_html__('Add custom CSS for any elements of this plugin without <style> tag.', AMWL_DOMAIN); ?></span>
                            </td>                                   
                        </tr>
                    </tbody>
                </table>
            </div>

            <?php wp_nonce_field('amwl_add_wishlist_action', 'amwl_add_wishlist_panel'); ?>
            <input type="submit" class="button-primary" value="<?php echo esc_html__('Save Changes', AMWL_DOMAIN); ?>" />

        </form>
    </div>
    <?php
}

/* * *************************************************************************** */

/**
 * Add action for wishlist page settings
 */
add_action(AMWL_PREFIX . '_wishlist_options', 'AMWL_wishlist_html');

function AMWL_wishlist_html() {

    $amwl_wishlist_page = sanitize_text_field(AMWL_get_option('amwl_wishlist_page'));
    $amwl_wishlist_name = sanitize_text_field(AMWL_get_option('amwl_wishlist_name'));
    $amwl_remove = sanitize_text_field(AMWL_get_option('amwl_remove_from_wishlist'));
    $amwl_redirect = sanitize_text_field(AMWL_get_option('amwl_redirect_to_cart'));
    $amwl_success_notice = sanitize_text_field(AMWL_get_option('amwl_success_notice'));

    $amwl_prod_img = sanitize_text_field(AMWL_get_option('amwl_show_prod_image'));
    $amwl_prod_title = sanitize_text_field(AMWL_get_option('amwl_show_prod_title'));
    $amwl_prod_price = sanitize_text_field(AMWL_get_option('amwl_show_prod_price'));
    $amwl_prod_stock = sanitize_text_field(AMWL_get_option('amwl_show_prod_stock'));
    $amwl_date_added = sanitize_text_field(AMWL_get_option('amwl_show_date_added'));
    $amwl_cart_style = sanitize_text_field(AMWL_get_option('amwl_cart_style'));
    $amwl_cart_text = sanitize_text_field(AMWL_get_option('amwl_cart_text'));
    $amwl_remove_icon = sanitize_text_field(AMWL_get_option('amwl_show_remove_icon'));

    $amwl_share_text = sanitize_text_field(AMWL_get_option('amwl_share_text'));
    $amwl_share_fb = sanitize_text_field(AMWL_get_option('amwl_share_fb'));
    $amwl_share_twitter = sanitize_text_field(AMWL_get_option('amwl_share_twitter'));
    $amwl_share_pinterest = sanitize_text_field(AMWL_get_option('amwl_share_pinterest'));
    $amwl_share_email = sanitize_text_field(AMWL_get_option('amwl_share_email'));
    $amwl_share_whatsapp = sanitize_text_field(AMWL_get_option('amwl_share_whatsapp'));
    $amwl_share_clipboard = sanitize_text_field(AMWL_get_option('amwl_share_clipboard'));

    $amwl_fb_icon = esc_url_raw(AMWL_get_option('amwl_fb_icon'));
    $amwl_twitter_icon = esc_url_raw(AMWL_get_option('amwl_twitter_icon'));
    $amwl_pint_icon = esc_url_raw(AMWL_get_option('amwl_pint_icon'));
    $amwl_email_icon = esc_url_raw(AMWL_get_option('amwl_email_icon'));
    $amwl_wapp_icon = esc_url_raw(AMWL_get_option('amwl_wapp_icon'));
    $amwl_cb_icon = esc_url_raw(AMWL_get_option('amwl_cb_icon'));

    $amwl_share_title = sanitize_text_field(AMWL_get_option('amwl_share_title'));

    $amwl_pages = get_pages();
    ?>    
    <div class="amwl-admin-panel-content-wrap">
        <form id="amwl-wishlist-form" method="post">
            <h1><?php echo esc_html__('Wishlist Page Settings', AMWL_DOMAIN); ?></h1>
            <div class="amwl-wishlist-section">
                <table class="amwl-wishlist-form-table">
                    <tbody>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_wishlist_page"><?php echo esc_html__('Wishlist Page', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">                                   
                                <select id="amwl_wishlist_page" name="amwl_wishlist_page">
                                    <option value="0" <?php selected($amwl_wishlist_page, sanitize_text_field('0')); ?>><?php echo esc_html__('Select Page', AMWL_DOMAIN); ?></option>  
                                    <?php foreach ($amwl_pages as $amwl_page) { ?>                                        
                                        <option value="<?php echo $amwl_page->ID; ?>" <?php selected($amwl_wishlist_page, sanitize_text_field($amwl_page->ID)); ?>><?php echo sanitize_text_field($amwl_page->post_title); ?></option>                          
                                    <?php } ?>
                                </select>
                                <span class="amwl-description"><?php echo esc_html__('Choose page where to show "Wishlist Table" and add [amwl_wishlist] shortcode into the page content.', AMWL_DOMAIN); ?></span>
                            </td>                                   
                        </tr>                           
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_wishlist_name"><?php echo esc_html__('Wishlist Name', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="text" id="amwl_wishlist_name" name="amwl_wishlist_name" value="<?php echo $amwl_wishlist_name; ?>">                                    
                                <span class="amwl-description"><?php echo esc_html__('Add name for default wishlist', AMWL_DOMAIN); ?></span>
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_remove_from_wishlist"><?php echo esc_html__('Remove Product from Wishlist after added to cart', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="checkbox" id="amwl_remove_from_wishlist" name="amwl_remove_from_wishlist" class="awml-checked" value="true" <?php checked($amwl_remove, sanitize_text_field('true')); ?> >                                    
                            </td>                               
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_redirect_to_cart"><?php echo esc_html__('Redirect to the cart page from Wishlist after product added to cart', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="checkbox" id="amwl_redirect_to_cart" name="amwl_redirect_to_cart" class="awml-checked" value="true" <?php checked($amwl_redirect, sanitize_text_field('true')); ?> >                                  
                            </td>                               
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_success_notice"><?php echo esc_html__('Successfully added product in cart message', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="text" id="amwl_success_notice" name="amwl_success_notice" value="<?php echo $amwl_success_notice; ?>">
                                <span class="amwl-description"><?php echo esc_html__('Enter a text for "Successfully added product in cart message" which display after product added in cart.', AMWL_DOMAIN); ?></span>
                            </td>                                   
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="amwl-wishlist-table-section">
                <h2><?php echo esc_html__('Wishlist Table Settings', AMWL_DOMAIN); ?></h2>
                <table class="amwl-wishlist-form-table">
                    <tbody>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_show_prod_image"><?php echo esc_html__('Show Product Image', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="checkbox" id="amwl_show_prod_image" name="amwl_show_prod_image" class="awml-checked" value="true"
                                       <?php checked($amwl_prod_img, sanitize_text_field('true')); ?> >
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_show_prod_title"><?php echo esc_html__('Show Product Title', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="checkbox" id="amwl_show_prod_title" name="amwl_show_prod_title" class="awml-checked" value="true"
                                       <?php checked($amwl_prod_title, sanitize_text_field('true')); ?> >                                 
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_show_prod_price"><?php echo esc_html__('Show Product Price', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="checkbox" id="amwl_show_prod_price" name="amwl_show_prod_price" class="awml-checked" value="true"
                                       <?php checked($amwl_prod_price, sanitize_text_field('true')); ?> >
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_show_prod_stock"><?php echo esc_html__('Show Product Stock Status', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="checkbox" id="amwl_show_prod_stock" name="amwl_show_prod_stock" class="awml-checked" value="true"
                                       <?php checked($amwl_prod_stock, sanitize_text_field('true')); ?> >
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_show_date_added"><?php echo esc_html__('Show Date of added', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="checkbox" id="amwl_show_date_added" name="amwl_show_date_added" class="awml-checked" value="true"
                                       <?php checked($amwl_date_added, sanitize_text_field('true')); ?> >
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr amwl_cart_style">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_cart_style"><?php echo esc_html__('"Add to cart" Style', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <select id="amwl_cart_style" name="amwl_cart_style">
                                    <option value="false" <?php selected($amwl_cart_style, sanitize_text_field('0')); ?> >
                                        <?php echo esc_html__('Select', AMWL_DOMAIN); ?></option>
                                    <option value="amwl_cart_style_link" <?php selected($amwl_cart_style, sanitize_text_field('amwl_cart_style_link')); ?> ><?php echo esc_html__('Anchor Link', AMWL_DOMAIN); ?></option>
                                    <option value="amwl_cart_style_btn" <?php selected($amwl_cart_style, sanitize_text_field('amwl_cart_style_btn')); ?> ><?php echo esc_html__('Button', AMWL_DOMAIN); ?></option>
                                </select>
                                <span class="amwl-description"><?php echo esc_html__('Choose if you want to show a "Add to cart" link or a button', AMWL_DOMAIN); ?></span>
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr add-to-cart-btn">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_cart_text"><?php echo esc_html__('"Add to Cart" Text', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="text" id="amwl_cart_text" name="amwl_cart_text" value="<?php echo $amwl_cart_text; ?>">
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_show_remove_icon"><?php echo esc_html__('Show icon to remove the product from the wishlist
                                    ', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="checkbox" id="amwl_show_remove_icon" name="amwl_show_remove_icon" class="awml-checked" value="true" <?php checked($amwl_remove_icon, sanitize_text_field('true')); ?> >
                            </td>                                   
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="amwl-share-section">
                <h2><?php echo esc_html__('Share Wishlist Settings', AMWL_DOMAIN); ?></h2>
                <table class="amwl-wishlist-form-table">
                    <tbody>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_share_text"><?php echo esc_html__('"Share on" Text', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="text" id="amwl_share_text" name="amwl_share_text" value="<?php echo $amwl_share_text; ?>">
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_share_fb"><?php echo esc_html__('Share on Facebook', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="checkbox" id="amwl_share_fb" name="amwl_share_fb" class="awml-checked" value="true"
                                       <?php checked($amwl_share_fb, sanitize_text_field('true')); ?> >
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_share_twitter"><?php echo esc_html__('Tweet on Twitter', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="checkbox" id="amwl_share_twitter" name="amwl_share_twitter" class="awml-checked" value="true"
                                       <?php checked($amwl_share_twitter, sanitize_text_field('true')); ?> >
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_share_pinterest"><?php echo esc_html__('Pin on Pinterest', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="checkbox" id="amwl_share_pinterest" name="amwl_share_pinterest" class="awml-checked" value="true" <?php checked($amwl_share_pinterest, sanitize_text_field('true')); ?> >
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_share_email"><?php echo esc_html__('Share by email', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="checkbox" id="amwl_share_email" name="amwl_share_email" class="awml-checked" value="true"
                                       <?php checked($amwl_share_email, sanitize_text_field('true')); ?> >
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_share_whatsapp"><?php echo esc_html__('Share on WhatsApp', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="checkbox" id="amwl_share_whatsapp" name="amwl_share_whatsapp" class="awml-checked" value="true"
                                       <?php checked($amwl_share_whatsapp, sanitize_text_field('true')); ?> >
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_share_clipboard"><?php echo esc_html__('Share by Copy to Clipboard', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="checkbox" id="amwl_share_clipboard" name="amwl_share_clipboard" class="awml-checked" value="true"
                                       <?php checked($amwl_share_clipboard, sanitize_text_field('true')); ?> >
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_share_title"><?php echo esc_html__('Share Title', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <input type="text" id="amwl_share_title" name="amwl_share_title" value="<?php echo $amwl_share_title; ?>">  
                            </td>                                   
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="amwl-share-icons-section">
                <h2><?php echo esc_html__('Social Share Icon Settings', AMWL_DOMAIN); ?></h2>
                <table class="amwl-wishlist-form-table">
                    <tbody>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">
                                <label for="amwl_fb_icon"><?php echo esc_html__('Facebook Icon', AMWL_DOMAIN); ?></label>                   
                            </td>
                            <td class="amwl-wishlist-td">
                                <div class="icon-preview amwl-fb-icon-preview">
                                    <?php if (!empty($amwl_fb_icon)) { ?><span class="amwl-file"><img src="<?php echo $amwl_fb_icon; ?>"></span><?php } ?>
                                </div>
                                <div class="icon-upload amwl-fb-icon-upload">
                                    <input type="file" id="amwl_fb_icon" name="amwl_fb_icon" class="icon">
                                    <input type="button" id="amwl_fb_upload_btn" name="amwl_fb_upload_btn" value="<?php echo esc_html__('Upload Icon', AMWL_DOMAIN); ?>" class="button">
                                </div>
                            </td>                                   
                        </tr>                           
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">           
                                <label for="amwl_twitter_icon"><?php echo esc_html__('Twitter Icon', AMWL_DOMAIN); ?></label>               
                            </td>
                            <td class="amwl-wishlist-td">
                                <div class="icon-preview amwl-twitter-icon-preview">
                                    <?php if (!empty($amwl_twitter_icon)) { ?><span class="amwl-file"><img src="<?php echo $amwl_twitter_icon; ?>"></span><?php } ?>
                                </div>
                                <div class="icon-upload amwl-twitter-icon-upload">
                                    <input type="file" id="amwl_twitter_icon" name="amwl_twitter_icon" class="icon">
                                    <input type="button" id="amwl_twitter_upload_btn" name="amwl_twitter_upload_btn" value="<?php echo esc_html__('Upload Icon', AMWL_DOMAIN); ?>" class="button">
                                </div>
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">           
                                <label for="amwl_pint_icon"><?php echo esc_html__('Pinterest Icon', AMWL_DOMAIN); ?></label>                
                            </td>
                            <td class="amwl-wishlist-td">
                                <div class="icon-preview amwl-pint-icon-preview">
                                    <?php if (!empty($amwl_pint_icon)) { ?><span class="amwl-file"><img src="<?php echo $amwl_pint_icon; ?>"></span><?php } ?>
                                </div>
                                <div class="icon-upload amwl-pint-icon-upload">
                                    <input type="file" id="amwl_pint_icon" name="amwl_pint_icon" class="icon">
                                    <input type="button" id="amwl_pint_upload_btn" name="amwl_pint_upload_btn" value="<?php echo esc_html__('Upload Icon', AMWL_DOMAIN); ?>" class="button">
                                </div>
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">           
                                <label for="amwl_email_icon"><?php echo esc_html__('Email Icon', AMWL_DOMAIN); ?></label>
                            </td>
                            <td class="amwl-wishlist-td">
                                <div class="icon-preview amwl-email-icon-preview">
                                    <?php if (!empty($amwl_email_icon)) { ?><span class="amwl-file"><img src="<?php echo $amwl_email_icon; ?>"></span><?php } ?>
                                </div>
                                <div class="icon-upload amwl-email-icon-upload">
                                    <input type="file" id="amwl_email_icon" name="amwl_email_icon" class="icon">
                                    <input type="button" id="amwl_email_upload_btn" name="amwl_email_upload_btn" value="<?php echo esc_html__('Upload Icon', AMWL_DOMAIN); ?>" class="button">
                                </div>
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">           
                                <label for="amwl_wapp_icon"><?php echo esc_html__('WhatsApp Icon', AMWL_DOMAIN); ?></label>                 
                            </td>
                            <td class="amwl-wishlist-td">
                                <div class="icon-preview amwl-wapp-icon-preview">
                                    <?php if (!empty($amwl_wapp_icon)) { ?><span class="amwl-file"><img src="<?php echo $amwl_wapp_icon; ?>"></span><?php } ?>
                                </div>
                                <div class="icon-upload amwl-wapp-icon-upload">
                                    <input type="file" id="amwl_wapp_icon" name="amwl_wapp_icon" class="icon">
                                    <input type="button" id="amwl_wapp_upload_btn" name="amwl_wapp_upload_btn" value="<?php echo esc_html__('Upload Icon', AMWL_DOMAIN); ?>" class="button">
                                </div>
                            </td>                                   
                        </tr>
                        <tr valign="top" class="amwl-wishlist-tr">
                            <td class="amwl-wishlist-td">           
                                <label for="amwl_cb_icon"><?php echo esc_html__('Copy to clipboard Icon', AMWL_DOMAIN); ?></label>          
                            </td>
                            <td class="amwl-wishlist-td">
                                <div class="icon-preview amwl-cb-icon-preview">
                                    <?php if (!empty($amwl_cb_icon)) { ?><span class="amwl-file"><img src="<?php echo $amwl_cb_icon; ?>"></span><?php } ?>
                                </div>
                                <div class="icon-upload amwl-cb-icon-upload">
                                    <input type="file" id="amwl_cb_icon" name="amwl_cb_icon" class="icon">
                                    <input type="button" id="amwl_cb_upload_btn" name="amwl_cb_upload_btn" value="<?php echo esc_html__('Upload Icon', AMWL_DOMAIN); ?>" class="button">
                                </div>
                            </td>                                   
                        </tr>
                    </tbody>
                </table>
            </div>

            <?php wp_nonce_field('amwl_wishlist_opt_action', 'amwl_wishlist_opt_panel'); ?>
            <input type="submit" class="button-primary" value="<?php echo esc_html__('Save Changes', AMWL_DOMAIN); ?>" />
        </form>
    </div>
    <?php
}

/* * *************************************************************************** */

/**
 * Create wishlist column in product lisitng page
 */
add_filter('manage_edit-product_columns', 'AMWL_wishlist_column');

function AMWL_wishlist_column($columns) {
    $new_columns = (is_array($columns)) ? $columns : array();
    $new_columns['amwl_wishlist_count'] = esc_html__('Wishlist Count', AMWL_DOMAIN);
    return $new_columns;
}

/**
 * Add data in wishlist count column
 */
add_action('manage_product_posts_custom_column', 'AMWL_wishlist_column_content', 2);

function AMWL_wishlist_column_content($column) {
    global $product, $wpdb;
    $amwl_table = $wpdb->prefix . sanitize_text_field("amwl_wishlist_items");

    if ($column == sanitize_text_field('amwl_wishlist_count')) {
        $product_id = $product->get_id();
        $wishlist_count = $wpdb->get_row('SELECT count(ID) AS wishlist_count FROM ' . $amwl_table . ' WHERE prod_id = ' . $product_id);
        echo $wishlist_count->wishlist_count;
    }
}
?>