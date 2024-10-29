<?php
/**
 * get options from database
 */
if ( ! function_exists( 'AMWL_get_option' ) ) {
  function AMWL_get_option($amwl_option) {
    return get_option($amwl_option);
  }
}

/**
 * Display Users Ip
 */
if ( ! function_exists( 'AMWL_get_the_user_ip' ) ) {
    function AMWL_get_the_user_ip() {
    if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            /**
             * Check ip from share internet
             */
            $ip = esc_attr($_SERVER['HTTP_CLIENT_IP']);
        } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            /**
             * To check ip is pass from proxy
             */
            $ip = esc_attr($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            $ip = esc_attr($_SERVER['REMOTE_ADDR']);
        }
        return $ip;
    }
}

#########################################################################################################
/**
 * Add action for add button in archive page
 */
add_action( AMWL_PREFIX . '_btn_in_archive', 'AMWL_add_to_archive' );

if ( ! function_exists( 'AMWL_add_to_archive' ) ) {
    function AMWL_add_to_archive() {
        switch (AMWL_get_option('amwl_btn_archive_position')) {
            case sanitize_text_field('amwl_btn_archive_before'):               
                add_action( 'woocommerce_after_shop_loop_item', 'AMWL_add_to_btn_html', 9);
                break;
            case sanitize_text_field('amwl_btn_archive_after'):
                add_action( 'woocommerce_after_shop_loop_item', 'AMWL_add_to_btn_html', 1000);
                break;
            case sanitize_text_field('amwl_btn_archive_shortcode'):
                add_shortcode( 'amwl_add_to_wishlist', 'AMWL_add_to_btn_html' );
                break;
        }
    }
}

/**
 * Add action for button in details page
 */
add_action( AMWL_PREFIX . '_btn_in_details', 'AMWL_add_to_product' );

if ( ! function_exists( 'AMWL_add_to_product' ) ) {
    function AMWL_add_to_product() {
            switch (AMWL_get_option('amwl_btn_position')) {
                case sanitize_text_field('amwl_btn_before'):
                    add_action( 'woocommerce_before_add_to_cart_button', 'AMWL_add_to_btn_html');
                    break;
                case sanitize_text_field('amwl_btn_after'):
                    add_action( 'woocommerce_after_add_to_cart_button', 'AMWL_add_to_btn_html');
                    break;
                case sanitize_text_field('amwl_btn_shortcode'):
                    add_shortcode( 'amwl_add_to_wishlist', 'AMWL_add_to_btn_html' );
                    break;
            }
    }
}

#########################################################################################################
/**
 * Add to wishlist button html
 */
if ( ! function_exists( 'AMWL_add_to_btn_html' ) ) {
    function AMWL_add_to_btn_html() {
        global $wpdb, $product;
        $amwl_table = $wpdb->prefix . sanitize_text_field("amwl_wishlist_items");

        $pro_added_text = sanitize_text_field(AMWL_get_option('amwl_pro_added_text'));
        $pro_remove_text = esc_html__('Product removed from list', AMWL_DOMAIN);

        $product_id = sanitize_text_field($product->get_id());
        $product_type = sanitize_text_field($product->get_type());
        $product_name = sanitize_text_field($product->get_name());      
        
        $user_id = get_current_user_id();

        if($user_id == 0 || $user_id == NULL){

            $temp_data = AMWL_get_the_user_ip();

            $pro_exists = $wpdb->get_results( 'SELECT prod_id FROM '. $amwl_table .' WHERE prod_id = '. $product_id .' AND temp_user_data = "'. $temp_data .'" AND pro_exists = '. sanitize_text_field('1'));
        }else {
            $pro_exists = $wpdb->get_results( 'SELECT prod_id FROM '. $amwl_table .' WHERE prod_id = '. $product_id .' AND user_id = '. $user_id .' AND pro_exists = '. sanitize_text_field('1')); 
        }  

        if(!empty($pro_exists)){
            $data_exists = sanitize_text_field('1');
        } else {
            $data_exists = sanitize_text_field('0');
        } 

        $after_text = '';
        $after_class = '';
        switch (AMWL_get_option('amwl_after_add_to_wishlist_behaviour_add')) {
                case sanitize_text_field('amwl_already'):
                    $after_text .= esc_html__(AMWL_get_option('amwl_btn_already_in'), AMWL_DOMAIN);
                    $after_class .= sanitize_text_field('amwl-already-in');
                    break;
                case sanitize_text_field('amwl_view'):
                    $after_text .= esc_html__(AMWL_get_option('amwl_btn_view_text'), AMWL_DOMAIN);
                    $after_class .= sanitize_text_field('amwl-view-list');
                    break;
                case sanitize_text_field('amwl_remove'):
                    $after_text .= esc_html__(AMWL_get_option('amwl_btn_remove_text'), AMWL_DOMAIN);
                    $after_class .= sanitize_text_field('amwl-remove-list');
                    break;
            }

        $amwl_link_html = '';
        switch (AMWL_get_option('amwl_btn_icon')) {             
                case sanitize_text_field('amwl_icon_heart'):
                    $amwl_link_html .= '<a class="amwl-heart-icon amwl-add-to-wishlist" data-product-id="'. $product_id .'"   href="javascript:void();" >';
                    $amwl_link_html .= '<span class="amwl-link-text">';
                    $amwl_link_html .= '<i class="fa fa-heart" aria-hidden="true"></i>';
                    $amwl_link_html .= esc_html__(AMWL_get_option('amwl_btn_text'), AMWL_DOMAIN);
                    $amwl_link_html .= '</span>';
                    $amwl_link_html .= '</a>';
                    $amwl_link_html .= '<a class="amwl-link amwl-heart-icon '. $after_class .'" href="javascript:void();">';      
                    $amwl_link_html .= '<span class="amwl-link-text">';
                    $amwl_link_html .= '<i class="fa fa-heart" aria-hidden="true"></i>';
                    $amwl_link_html .= $after_text;
                    $amwl_link_html .= '</span>';
                    $amwl_link_html .= '</a>';             
                    break;
                case sanitize_text_field('amwl_icon_none'):
                    $amwl_link_html .= '<a class="amwl-add-to-wishlist" href="javascript:void();">'; 
                    $amwl_link_html .= '<span class="amwl-link-text">';   
                    $amwl_link_html .= esc_html__(AMWL_get_option('amwl_btn_text'), AMWL_DOMAIN);
                    $amwl_link_html .= '</span>';
                    $amwl_link_html .= '</a>'; 
                    $amwl_link_html .= '<a class="amwl-link '. $after_class .'" href="javascript:void();">'; 
                    $amwl_link_html .= '<span class="amwl-link-text">';   
                    $amwl_link_html .= $after_text;
                    $amwl_link_html .= '</span>';
                    $amwl_link_html .= '</a>'; 
                    break;
                case sanitize_text_field('amwl_icon_custom'):
                    $amwl_link_html .= '<a class="amwl-add-to-wishlist" href="javascript:void();">'; 
                    $amwl_link_html .= '<span class="amwl-link-icon">';
                    $amwl_link_html .= '<img class="amwl-icon" src="'. esc_url_raw(AMWL_get_option('amwl_icon_upload')) .'"></img>';
                    $amwl_link_html .= '</span>';
                    $amwl_link_html .= '<span class="amwl-link-text">';                   
                    $amwl_link_html .= esc_html__(AMWL_get_option('amwl_btn_text'), AMWL_DOMAIN);
                    $amwl_link_html .= '</span>';
                    $amwl_link_html .= '</a>';
                    $amwl_link_html .= '<a class="amwl-link '. $after_class .'" href="javascript:void();">'; 
                    $amwl_link_html .= '<span class="amwl-link-icon">';
                    $amwl_link_html .= '<img class="amwl-icon" src="'. esc_url_raw(AMWL_get_option('amwl_icon_upload')) .'"></img>'; 
                    $amwl_link_html .= '</span>';
                    $amwl_link_html .= '<span class="amwl-link-text">';                   
                    $amwl_link_html .= $after_text;
                    $amwl_link_html .= '</span>';
                    $amwl_link_html .= '</a>'; 
                    break;
        }

        $amwl_btn_html = '';
        $amwl_btn_html .= '<div class="amwl-add-to-wishlist-wrap" data-product-id="'. $product_id .'" 
                                data-product-type="'. $product_type .'" data-title="'. $after_text .'" data-success="'. $pro_added_text .'" 
                                data-remove="'. $pro_remove_text .'" data-exists="'. $data_exists .'">';

        if (AMWL_get_option('amwl_btn_style') == sanitize_text_field('amwl_style_btn')){   
            $amwl_btn_html .= '<input class="amwl-add-to-wishlist amwl-add-to-wishlist-btn" type="button" value="'. AMWL_get_option('amwl_btn_text') .'">';
            $amwl_btn_html .= '<input class="amwl-link '. $after_class .'" type="button" value="'. $after_text .'">';   
        } else {            
            $amwl_btn_html .=  $amwl_link_html;         
        }   

        $amwl_btn_html .= '</div>';


        echo $amwl_btn_html;
    }
}

/**
 * Add to wishlist action
 */
if ( ! function_exists( 'amwl_add_to_wishlist_action' ) ) {
    function amwl_add_to_wishlist_action() {
        global $wpdb;
        $amwl_table = $wpdb->prefix . sanitize_text_field("amwl_wishlist_items");

        $user_id = get_current_user_id();
        $product_id = sanitize_text_field($_POST['product_id']);

        $product = wc_get_product($product_id);
        $quantity = $product->is_in_stock();
        $prod_org_price = $product->get_price();

        $prod_org_currency = get_option('woocommerce_currency');
        $current_date = date('Y-m-d H:i:s');        
  
        $pro_exists = sanitize_text_field('1');
        $temp_data = sanitize_text_field('0');

        if($user_id == 0 || $user_id == NULL){
            $wishlist_id = sanitize_text_field('2');
            $temp_data = AMWL_get_the_user_ip();
        } else{
            $wishlist_id = sanitize_text_field('1');
        }

        $table_data = array(
            'wishlist_id' => $wishlist_id,
            'user_id' => $user_id,
            'prod_id' => $product_id,
            'quantity' => $quantity,
            'prod_org_price' => $prod_org_price,
            'prod_org_currency' => $prod_org_currency,
            'prod_dateadded' => $current_date,    
            'pro_exists' => $pro_exists,
            'temp_user_data' => $temp_data,
        );

        $row_id = $wpdb->insert($amwl_table, $table_data);
        $data = array('row_id' => $row_id );
        $response = json_encode($data);
        echo $response;
        die();        
    }
}
add_action('wp_ajax_amwl_add_to_wishlist_action', 'amwl_add_to_wishlist_action');
add_action('wp_ajax_nopriv_amwl_add_to_wishlist_action', 'amwl_add_to_wishlist_action');

#########################################################################################################
/**
 * Remove from wishlist action
 */
if ( ! function_exists( 'amwl_remove_from_wishlist' ) ) {
    function amwl_remove_from_wishlist() {
        global $wpdb;
        $amwl_table = $wpdb->prefix . sanitize_text_field("amwl_wishlist_items");

        $product_id = sanitize_text_field($_POST['product_id']);
        $user_id = get_current_user_id();

        if($user_id == 0 || $user_id == NULL){

            $temp_data = AMWL_get_the_user_ip();

            $remove_row = $wpdb->delete( $amwl_table, array( 'user_id' => $user_id, 'prod_id' => $product_id, 'temp_user_data' => $temp_data ));
        } else {
            $remove_row = $wpdb->delete( $amwl_table, array( 'user_id' => $user_id, 'prod_id' => $product_id));
        }        
        $data = array('remove_row' => $remove_row );
        $response = json_encode($data);
        echo $response;
        die();
    }
}
add_action('wp_ajax_amwl_remove_from_wishlist', 'amwl_remove_from_wishlist');
add_action('wp_ajax_nopriv_amwl_remove_from_wishlist', 'amwl_remove_from_wishlist');

#########################################################################################################
/**
 * View wishlist action
 */
if ( ! function_exists( 'amwl_view_wishlist' ) ) {
    function amwl_view_wishlist() {
        if(sanitize_text_field(AMWL_get_option('amwl_wishlist_page')) != sanitize_text_field('0')){
            $page_id = sanitize_text_field(AMWL_get_option('amwl_wishlist_page'));
            $page_url = get_permalink($page_id);
            $data = array('page_url' => $page_url );
            $response = json_encode($data);
            echo $response;
        }
        die();
    }
}
add_action('wp_ajax_amwl_view_wishlist', 'amwl_view_wishlist');
add_action('wp_ajax_nopriv_amwl_view_wishlistt', 'amwl_view_wishlist');

#########################################################################################################
/**
 * Show wishlist table
 */
if ( ! function_exists( 'AMWL_show_wishlist_html' ) ) {
    function AMWL_show_wishlist_html() {    
        global $wpdb, $product;
        $amwl_table = $wpdb->prefix . sanitize_text_field("amwl_wishlist_items");

        if(isset($_GET['amwl_my_wishlist'])){
            $user_id = base64_decode(esc_url_raw($_GET['amwl_my_wishlist']));
        } else {
            $user_id = get_current_user_id();
        }          

        if($user_id == 0 || $user_id == NULL){

            $temp_data = AMWL_get_the_user_ip();

            $wishlist_data = $wpdb->get_results( 'SELECT * FROM '. $amwl_table .' WHERE user_id = '. $user_id .' AND temp_user_data = "'. $temp_data .'" ORDER BY prod_dateadded DESC');  
        }else {
           $wishlist_data = $wpdb->get_results( 'SELECT * FROM '. $amwl_table .' WHERE user_id = '. $user_id .' ORDER BY prod_dateadded DESC'); 
        }
        ?>
        <div class="amwl-wishlist-wrap">
            <?php if(!empty(AMWL_get_option('amwl_wishlist_name'))){ ?>
                <h3><?php echo esc_html__(AMWL_get_option('amwl_wishlist_name')); ?></h3>
            <?php } ?>
            <?php if(!empty($wishlist_data)){ ?>
                <div class="amwl-wishlist-page-msg"></div>
                <table class="amwl-wishlist-table">
                    <thead>
                        <tr>
                            <?php if(sanitize_text_field(AMWL_get_option('amwl_show_remove_icon')) == sanitize_text_field('true')){ ?>
                                <th class="prod-remove"><?php echo esc_html__('Remove', AMWL_DOMAIN); ?></th>
                            <?php } ?>                                                 
                            <?php if(sanitize_text_field(AMWL_get_option('amwl_show_prod_image')) == sanitize_text_field('true')){ ?>
                                <th class="prod-img"><?php echo esc_html__('Product Image', AMWL_DOMAIN); ?></th>
                            <?php } ?>
                            <?php if(sanitize_text_field(AMWL_get_option('amwl_show_prod_title')) == sanitize_text_field('true')){ ?>
                                <th class="prod-name"><?php echo esc_html__('Product Title', AMWL_DOMAIN); ?></th>
                            <?php } ?>
                            <?php if(sanitize_text_field(AMWL_get_option('amwl_show_prod_price')) == sanitize_text_field('true')){ ?>
                                <th class="prod-price"><?php echo esc_html__('Product Price', AMWL_DOMAIN); ?></th>
                            <?php } ?>
                            <?php if(sanitize_text_field(AMWL_get_option('amwl_show_prod_stock')) == sanitize_text_field('true')){ ?>
                                <th class="prod-stock-status"><?php echo esc_html__('Product Stock Status', AMWL_DOMAIN); ?></th>
                            <?php } ?>
                            <?php if(sanitize_text_field(AMWL_get_option('amwl_show_date_added')) == sanitize_text_field('true')){ ?>
                                <th class="prod-date-add"><?php echo esc_html__('Date of added', AMWL_DOMAIN); ?></th>
                            <?php } ?>
                            <?php if(sanitize_text_field(AMWL_get_option('amwl_cart_style')) != sanitize_text_field('false')){ ?>
                                <th class="prod-add-cart"><?php echo esc_html__('Add To Cart', AMWL_DOMAIN); ?></th>
                            <?php } ?> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($wishlist_data as $product_data ) { 
                            $prod_id = sanitize_text_field($product_data->prod_id);                           

                            $title = get_the_title($prod_id);
                            $url = get_permalink($prod_id);
                            $image = get_the_post_thumbnail_url($prod_id, 'post-thumbnail');
                            $stock = get_post_meta( $prod_id, '_stock_status', true );

                            $product = wc_get_product( $prod_id );
                            $price = $product->get_price_html();
                            $currency = $product_data->prod_org_currency;
                            $date_added = date_create($product_data->prod_dateadded);
                            $date = date_format($date_added, 'M d, Y');

                            if($stock == sanitize_text_field('instock')){
                                $stock = '<span class="amwl-in-stock">' . esc_html__('In Stock', AMWL_DOMAIN) . '</span>';
                            } else {
                                $stock = '<span class="amwl-out-of-stock">' . esc_html__('Out of stock', AMWL_DOMAIN) . '</span>';
                            }

                            if(!empty($image)){
                                $image = '<img src="'.esc_url_raw($image).'">';
                            } else {
                                $image = esc_html__('N/A', AMWL_DOMAIN);  
                            }

                            $amwl_cart_html = '';
                            $amwl_cart_url = wc_get_cart_url();
                            $amwl_cart_text = sanitize_text_field(AMWL_get_option('amwl_cart_text'));
                            $amwl_success_notice = sanitize_text_field(AMWL_get_option('amwl_success_notice'));
                            switch (sanitize_text_field(AMWL_get_option('amwl_cart_style'))) {
                                    case sanitize_text_field('amwl_cart_style_link'):
                                        $amwl_cart_html .= '<a class="amwl-add-to-cart add_to_cart_button" href="javascript:void();" data-product-id="'. $prod_id .'" data-success="'. $amwl_success_notice .'" data-redirect="'. $amwl_cart_url .'">'; 
                                        $amwl_cart_html .= '<span class="amwl-link-text">';   
                                        $amwl_cart_html .= esc_html__($amwl_cart_text);
                                        $amwl_cart_html .= '</span>';
                                        $amwl_cart_html .= '</a>';   
                                        break;
                                    case sanitize_text_field('amwl_cart_style_btn'):
                                        $amwl_cart_html .= '<input class="amwl-add-to-cart" type="button" value="'. $amwl_cart_text .'" data-product-id="'. $prod_id .'" data-success="'. $amwl_success_notice .'" data-redirect="'. $amwl_cart_url .'">';
                                        break;
                            }
                        ?>
                        <tr>                                                     
                            <?php if(sanitize_text_field(AMWL_get_option('amwl_show_remove_icon')) == sanitize_text_field('true')){ ?>                                
                                    <td class="prod-remove"><a class="amwl-remove_prod" href="javascript:void();" data-product-id="<?php echo $prod_id; ?>"><i class="fa fa-trash-alt"></i></a></td>                               
                            <?php } ?>                                                      
                            <?php if(sanitize_text_field(AMWL_get_option('amwl_show_prod_image')) == sanitize_text_field('true')){ ?>
                                <td class="prod-img"><a href="<?php echo esc_url_raw($url); ?>"><?php echo $image; ?></a></td>
                            <?php } ?>
                            <?php if(sanitize_text_field(AMWL_get_option('amwl_show_prod_title')) == sanitize_text_field('true')){ ?>
                                <td class="prod-name"><a href="<?php echo esc_url_raw($url); ?>"><?php echo sanitize_text_field($title); ?></a></td>
                            <?php } ?>
                            <?php if(sanitize_text_field(AMWL_get_option('amwl_show_prod_price')) == sanitize_text_field('true')){ ?>
                                <td class="prod-price"><?php echo $price; ?></td>
                            <?php } ?>
                            <?php if(sanitize_text_field(AMWL_get_option('amwl_show_prod_stock')) == sanitize_text_field('true')){ ?>
                                <td class="prod-stock-status"><?php echo $stock; ?></td>
                            <?php } ?>
                            <?php if(sanitize_text_field(AMWL_get_option('amwl_show_date_added')) == sanitize_text_field('true')){ ?>
                                <td class="prod-date-add"><?php echo sanitize_text_field($date); ?></td>
                            <?php } ?>
                            <?php if(sanitize_text_field(AMWL_get_option('amwl_cart_style')) != sanitize_text_field('false')){ ?>                             
                                <td class="prod-add-cart"><?php echo $amwl_cart_html; ?></td>
                            <?php } ?>  
                        </tr>      
                        <?php } ?>
                    </tbody>
                </table>

                <?php if ( is_user_logged_in() ) { AMWL_show_social_sharing(); } ?>

            <?php } else { ?>
                <div class="amwl-wishlist-notice"><?php echo esc_html__('There are no products added to wishlist.', AMWL_DOMAIN); ?></div>
            <?php } ?>
        </div>
        <?php
    }
}

#########################################################################################################
/**
 * Add to cart from wishlist action
 */
if ( ! function_exists( 'amwl_add_to_cart_action' ) ) {
    function amwl_add_to_cart_action() {
        global $wpdb, $woocommerce;
        $amwl_table = $wpdb->prefix . sanitize_text_field("amwl_wishlist_items");

        $user_id = get_current_user_id();
        $product_id = sanitize_text_field($_POST['product_id']);
        $quantity = sanitize_text_field('1');
        $product_status = get_post_status($product_id);

        $remove_flag = sanitize_text_field(AMWL_get_option('amwl_remove_from_wishlist'));
        $redirect_flag = sanitize_text_field(AMWL_get_option('amwl_redirect_to_cart'));

        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
                
        if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity) && 'publish' === $product_status) {

        /****************************************************************************************************************/
            /**
             * Remove product and redirect to cart page
             */
            if($remove_flag == sanitize_text_field('true') && $redirect_flag == sanitize_text_field('true')){

                if($user_id == 0 || $user_id == NULL){

                $temp_data = AMWL_get_the_user_ip();

                    $remove_row = $wpdb->delete( $amwl_table, array( 'user_id' => $user_id, 'prod_id' => $product_id, 'temp_user_data' => $temp_data ));
                } else {
                    $remove_row = $wpdb->delete( $amwl_table, array( 'user_id' => $user_id, 'prod_id' => $product_id));
                }

                if($remove_row != '0'){
                    add_filter('woocommerce_add_to_cart_fragments', function ( $fragments ) {
                        global $woocommerce;
                        ob_start();  
                        
                        echo sanitize_text_field('remove_redirect');
                        $fragments['amwl-after-cart-flag'] = ob_get_clean();
                        return $fragments;
                    });
                }

                do_action('woocommerce_ajax_added_to_cart', $product_id);

                WC_AJAX :: get_refreshed_fragments();

            } else if($remove_flag == sanitize_text_field('true')){

                /**
                 * Remove product from wishlist table
                 */
                if($user_id == 0 || $user_id == NULL){

                $temp_data = AMWL_get_the_user_ip();

                    $remove_row = $wpdb->delete( $amwl_table, array( 'user_id' => $user_id, 'prod_id' => $product_id, 'temp_user_data' => $temp_data ));
                } else {
                    $remove_row = $wpdb->delete( $amwl_table, array( 'user_id' => $user_id, 'prod_id' => $product_id));
                }

                if($remove_row != '0'){
                    add_filter('woocommerce_add_to_cart_fragments', function ( $fragments ) {
                        global $woocommerce;
                        ob_start();  
                        
                        echo sanitize_text_field('remove');
                        $fragments['amwl-after-cart-flag'] = ob_get_clean();
                        return $fragments;
                    });
                }

                do_action('woocommerce_ajax_added_to_cart', $product_id);

                WC_AJAX :: get_refreshed_fragments();

            } else if($redirect_flag == sanitize_text_field('true')){

                /**
                 * Redirect to cart page after product add to cart
                 */
                add_filter('woocommerce_add_to_cart_fragments', function ( $fragments ) {
                        global $woocommerce;
                        ob_start();  
                        
                        echo sanitize_text_field('redirect');
                        $fragments['amwl-after-cart-flag'] = ob_get_clean();
                        return $fragments;
                });

                do_action('woocommerce_ajax_added_to_cart', $product_id);

                WC_AJAX :: get_refreshed_fragments();
            } else {

                do_action('woocommerce_ajax_added_to_cart', $product_id);

                WC_AJAX :: get_refreshed_fragments();
            }
        /****************************************************************************************************************/

        } else {
            $data = array(
               'error' => true,
               'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
            );          
        }
    
        $response = json_encode($data);
        echo $response;
        die();
    }
}
add_action('wp_ajax_amwl_add_to_cart_action', 'amwl_add_to_cart_action');
add_action('wp_ajax_nopriv_amwl_add_to_cart_action', 'amwl_add_to_cart_action');
#########################################################################################################
/**
 * Show social shaing list after wishlist table
 */
if ( ! function_exists( 'AMWL_show_social_sharing' ) ) {
    function AMWL_show_social_sharing() {

        $user_id = base64_encode(get_current_user_id());
        $amwl_curr_url = get_permalink();

        $amwl_share_url = add_query_arg( 'amwl_my_wishlist', $user_id, $amwl_curr_url );
        $amwl_share_title = sanitize_text_field(AMWL_get_option('amwl_share_title'));

        $amwl_fb_share = 'https://www.facebook.com/sharer/sharer.php?href='. urlencode($amwl_share_url);

        $amwl_twitter_share = 'https://twitter.com/share?url='. urlencode($amwl_share_url) .'&text='.$amwl_share_title;

        $amwl_pint_share = 'http://pinterest.com/pin/create/button/?url='. urlencode($amwl_share_url) ;

        $amwl_email_share = 'mailto:?subject='.$amwl_share_title.'&body='. urlencode($amwl_share_url);

        $amwl_wapp_share = 'https://api.whatsapp.com/send?text=' . $amwl_share_title . ' – ' . urlencode($amwl_share_url);

        $amwl_cb_share = $amwl_share_url;
        ?>

        <div class="amwl_social_share">

        <?php
        if(!empty(AMWL_get_option('amwl_share_text'))){ ?>
            <p><?php echo sanitize_text_field(AMWL_get_option('amwl_share_text')); ?></p>
        <?php } ?>

        <ul class="amwl_social_icon">

        <?php if(!empty(AMWL_get_option('amwl_fb_icon')) && sanitize_text_field(AMWL_get_option('amwl_share_fb')) == sanitize_text_field('true') ){ ?>            
            <li><a href="<?php echo esc_url_raw($amwl_fb_share); ?>" target="_blank" title="<?php echo esc_html__('Facebook', AMWL_DOMAIN); ?>"><img src="<?php echo esc_url_raw(AMWL_get_option('amwl_fb_icon')); ?>"></a></li>
        <?php }
        
        if(!empty(AMWL_get_option('amwl_twitter_icon')) && sanitize_text_field(AMWL_get_option('amwl_share_twitter')) == sanitize_text_field('true') ){ ?>
            <li><a href="<?php echo esc_url_raw($amwl_twitter_share); ?>" target="_blank" title="<?php echo esc_html__('Twitter', AMWL_DOMAIN); ?>"><img src="<?php echo esc_url_raw(AMWL_get_option('amwl_twitter_icon')); ?>"></a></li>
        <?php }
        
        if(!empty(AMWL_get_option('amwl_pint_icon')) && sanitize_text_field(AMWL_get_option('amwl_share_pinterest')) == sanitize_text_field('true') ){ ?>
            <li><a href="<?php echo esc_url_raw($amwl_pint_share); ?>" target="_blank" title="<?php echo esc_html__('Pinterest', AMWL_DOMAIN); ?>"><img src="<?php echo esc_url_raw(AMWL_get_option('amwl_pint_icon')); ?>"></a></li>
        <?php }
        
        if(!empty(AMWL_get_option('amwl_email_icon')) && sanitize_text_field(AMWL_get_option('amwl_share_email')) == sanitize_text_field('true') ){ ?>
            <li><a href="<?php echo esc_url_raw($amwl_email_share); ?>" target="_blank" title="<?php echo esc_html__('Email', AMWL_DOMAIN); ?>"><img src="<?php echo esc_url_raw(AMWL_get_option('amwl_email_icon')); ?>"></a></li>
        <?php }

        if(!empty(AMWL_get_option('amwl_wapp_icon')) && sanitize_text_field(AMWL_get_option('amwl_share_whatsapp')) == sanitize_text_field('true') ){ ?>
            <li><a href="<?php echo esc_url_raw($amwl_wapp_share); ?>" target="_blank" title="<?php echo esc_html__('WhatsApp', AMWL_DOMAIN); ?>">
                <img src="<?php echo esc_url_raw(AMWL_get_option('amwl_wapp_icon')); ?>"></a></li>
        <?php }

        if(!empty(AMWL_get_option('amwl_cb_icon')) && sanitize_text_field(AMWL_get_option('amwl_share_clipboard')) == sanitize_text_field('true') ){ ?>
            <li><a href="javascript:void();" data-attribute="<?php echo esc_url_raw($amwl_cb_share); ?>" title="<?php echo esc_html__('Copy To Clipboard', AMWL_DOMAIN); ?>" id="amwl_copy_url"><img src="<?php echo esc_url_raw(AMWL_get_option('amwl_cb_icon')); ?>"></a>
                <span class="copied"></span></li>
        <?php } ?>

        </ul>
        </div>
    <?php
    }
}

##########################################################################################################
/**
 * Add custom css
 */
if ( ! function_exists( 'AMWL_add_custom_css' ) ) {
    function AMWL_add_custom_css(){
        if(sanitize_text_field(AMWL_get_option('amwl_btn_custom_css')) != sanitize_text_field('')){ ?>
            <style type="text/css"><?php echo AMWL_get_option('amwl_btn_custom_css'); ?></style>
            <?php
        }
    }
}
?>