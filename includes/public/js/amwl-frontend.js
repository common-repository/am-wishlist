/**
 * Document ready function 
 */
jQuery(document).ready(function($) {
	jQuery('.amwl-already-in').hide();
	jQuery('.amwl-view-list').hide();
	jQuery('.amwl-remove-list').hide();
	jQuery('.amwl-wishlist-page-msg').hide();

	/**
 	 * Check product already in wishlist on pageload
 	 */
	var selects = jQuery('.amwl-add-to-wishlist-wrap[data-exists]');
	selects.each(function() {
        if(jQuery(this).attr('data-exists') == '1'){        	
        	jQuery(this).children('.amwl-add-to-wishlist').hide();
        	jQuery(this).children('.amwl-link').show();
		} else {
			jQuery(this).children('.amwl-add-to-wishlist').show();
        	jQuery(this).children('.amwl-link').hide();
		}
    });

	/******************************************************************************/
	/**
 	 * Add to wishlist
 	 */
	jQuery('.amwl-add-to-wishlist').click(function(e){
		e.preventDefault();

		var current = jQuery(this);
		var parent = current.parent( '.amwl-add-to-wishlist-wrap' );
		product_id = parent.attr( 'data-product-id' );
		success_msg = parent.attr( 'data-success' );
		link_title = parent.attr( 'data-title' );

		jQuery.ajax({
            type: 'POST',
            url: amwl_addto_wishlist.ajax_url,
            data: { 
		        'action' : 'amwl_add_to_wishlist_action',
		        'product_id': product_id, 
		    },
            success: function(response){   

            	var added_data = jQuery.parseJSON(response);
            	var row_id = added_data['row_id'];

            	if(row_id == 1){
	            	/**
				 	 * Display admin setting message after add to wishlist
				 	 */
	            	current.hide();
	            	current.next('.amwl-link').show();
	            	/**
				 	 * Display success message after add to wishlist
				 	 */		       
			        parent.after('<div id="amwl_added_message" class="amwl_added_message">'+success_msg+'</div>');
		    	}else{
		    		parent.after('<div id="amwl_remove_msg" class="amwl-remove-msg">Error in adding</div>');
		    	}

		        setTimeout(function() {
				    jQuery('#amwl_added_message').fadeOut('fast');
				}, 2000);
            }
        });        
	});
	
	/******************************************************************************/
	/**
	 * Already in wishlist
	 */	
	jQuery('.amwl-already-in').click(function(e){
		e.preventDefault();

		var current = jQuery(this);
		var parent = current.parent( ".amwl-add-to-wishlist-wrap" );
		parent.after('<div id="amwl_exists" class="amwl-exists">Already added in wishlist</div>');

		setTimeout(function() {
			jQuery('#amwl_exists').fadeOut('fast');
		}, 2000);
	});

	/******************************************************************************/
	/**
	 * Remove from wishlist
	 */
	jQuery('.amwl-remove-list').click(function(e){
		e.preventDefault();

		var current = jQuery(this);
		var parent = current.parent( ".amwl-add-to-wishlist-wrap" );
		var product_id = parent.attr( 'data-product-id' );
		var success_msg = parent.attr( 'data-success' );
		var remove_msg = parent.attr( 'data-remove' );
		var link_title = parent.attr( 'data-title' );

		jQuery.ajax({
            type: 'POST',
            url: amwl_remove_from_wishlist.ajax_url,
            data: { 
		        'action' : 'amwl_remove_from_wishlist',
		        'product_id': product_id, 
		    },
            success: function(response){

            	var remove_data = jQuery.parseJSON(response);
            	var remove_row = remove_data['remove_row'];

            	if(remove_row == 1){
	            	/**
	 				 * Display admin setting message after remove from wishlist
	 				 */
	            	current.hide();           	
	            	current.prev('.amwl-add-to-wishlist').show();
	            	/**
	 				 * Display success message after remove from wishlist
	 				 */
			        parent.after('<div id="amwl_remove_msg" class="amwl-remove-msg">'+remove_msg+'</div>');		       
		    	}else{
		    		parent.after('<div id="amwl_remove_msg" class="amwl-remove-msg">Error in remove</div>');
		    	}

		    	setTimeout(function() {
				    jQuery('#amwl_remove_msg').fadeOut('fast');
				}, 2000);
            }
        });        
	});

	/******************************************************************************/
	/**
	 * View wishlist
	 */
	jQuery('.amwl-view-list').click(function(e){
		e.preventDefault();

		jQuery.ajax({
            type: 'POST',
            url: amwl_view_wishlist.ajax_url,
            data: { 
		        'action' : 'amwl_view_wishlist',
		    },
            success: function(response){           	

            	var wishlist_page = jQuery.parseJSON(response);
            	var page_url = wishlist_page['page_url'];

            	if(page_url != ''){
	            	window.location = page_url;	       
		    	}
            }
        }); 
	});

	/******************************************************************************/
	
	/**
	 * Remove product from wishlist table
	 */
	jQuery('.amwl-remove_prod').click(function(e){
		e.preventDefault();

		var current = jQuery(this);
		var product_id = current.attr( 'data-product-id' );

		jQuery.ajax({
            type: 'POST',
            url: amwl_remove_from_wishlist.ajax_url,
            data: { 
		        'action' : 'amwl_remove_from_wishlist',
		        'product_id': product_id, 
		    },
            success: function(response){           	

            	var remove_data = jQuery.parseJSON(response);
            	var remove_row = remove_data['remove_row'];

            	if(remove_row == 1){
	            	/**
	 				 * Display message after remove from wishlist table
	 				 */ 
	            	jQuery('.amwl-wishlist-page-msg').html('');
	            	jQuery('.amwl-wishlist-page-msg').show();
	            	jQuery('.amwl-wishlist-page-msg').html('Product removed from wishlist!');
	            	current.parent().parent().remove();
		    	}else{
		    		jQuery('.amwl-wishlist-page-msg').html('');
		    		jQuery('.amwl-wishlist-page-msg').show();
		    		jQuery('.amwl-wishlist-page-msg').html('Error in remove. Please try again!');
		    	}

		    	setTimeout(function() {
				    jQuery('.amwl-wishlist-page-msg').fadeOut('fast');
				}, 5000);
            }
        });        
	});

	/******************************************************************************/
	/**
	 * Add to cart from wishlist table
	 */
	jQuery('.amwl-add-to-cart').click(function(e){
		e.preventDefault();

		var current = jQuery(this);
		product_id = current.attr( 'data-product-id' );
		success_msg = current.attr( 'data-success' );
		checkout_url = current.attr( 'data-redirect' );

		jQuery.ajax({
            type: 'POST',
            url: wc_add_to_cart_params.ajax_url,
            data: { 
		        'action' : 'amwl_add_to_cart_action',
		        'product_id': product_id, 
		    },
            success: function(response){

            	if (response.error & response.product_url) {
            		jQuery('.amwl-wishlist-page-msg').html('');
		    		jQuery('.amwl-wishlist-page-msg').show();
		    		jQuery('.amwl-wishlist-page-msg').html('Error in add to cart. Please try again!');
            	} else {
            		var after_cart_flag = response.fragments['amwl-after-cart-flag'];
            		
            		jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash]);
            		/**
	 				 * Display message after add to cart from wishlist table 
	 		 		 */
		            jQuery('.amwl-wishlist-page-msg').html('');       	
		            jQuery('.amwl-wishlist-page-msg').show();
		            jQuery('.amwl-wishlist-page-msg').html(success_msg);

            		if(after_cart_flag == 'remove_redirect'){
            			current.parent().parent().remove();
            			window.location = checkout_url;
            		} else if(after_cart_flag == 'remove'){
            			current.parent().parent().remove();
            		} else if(after_cart_flag == 'redirect'){
            			window.location = checkout_url;
            		}

            		setTimeout(function() {
				    	jQuery('.amwl-wishlist-page-msg').fadeOut('fast');
					}, 3000);
            	}
            }
        });        
	});


	/******************************************************************************/
	/**
	 * Copy to clipboard
	 */
	jQuery('#amwl_copy_url').click(function(e){
		e.preventDefault();

		var copy_url = jQuery(this).attr('data-attribute');
		var $temp = jQuery("<input>");
		jQuery("body").append($temp);
		$temp.val(copy_url).select();
		document.execCommand("copy");
		$temp.remove();
		jQuery(this).next(".copied").text("Copied!").show().fadeOut(3000);
	});
});