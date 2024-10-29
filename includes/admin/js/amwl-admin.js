/**
 * Document ready function 
 */
jQuery(document).ready(function() {

    /**
     * Display upload icon field onpage load
     */
    var amwl_btn_icon = jQuery('#amwl_btn_icon option:selected').val();
    if(amwl_btn_icon == 'amwl_icon_custom') {
        jQuery('.amwl-add-wishlist-tr.amwl-wishlist-icon').show(); 
    } else {
        jQuery('.amwl-add-wishlist-tr.amwl-wishlist-icon').hide();
    }
    /**
     * Display upload icon field onchange value
     */
    jQuery('#amwl_btn_icon').change(function(){
        if(jQuery('#amwl_btn_icon').val() == 'amwl_icon_custom') {
            jQuery('.amwl-add-wishlist-tr.amwl-wishlist-icon').show(); 
        } else {
            jQuery('.amwl-add-wishlist-tr.amwl-wishlist-icon').hide(); 
        } 
    });
    /*****************************************************************************************/

    /**
     * Upload icon onclick of upload btn
     */
    jQuery('body').on('click', '#amwl_icon_upload_btn', function(e) {
        e.preventDefault();
        jQuery('span.amwl-file-error').hide();
        amwl_upload_icon('amwl_icon_upload', 'amwl-icon-preview');        
    });
    /*****************************************************************************************/

    /**
     * Upload fb icon onclick of fb upload btn
     */
    jQuery('body').on('click', '#amwl_fb_upload_btn', function(e) {
        e.preventDefault();
        jQuery('span.amwl-file-error').hide();
        amwl_upload_icon('amwl_fb_icon', 'amwl-fb-icon-preview');        
    }); 
    /**
     * Upload twitter icon onclick of twitter upload btn 
     */
    jQuery('body').on('click', '#amwl_twitter_upload_btn', function(e) {
        e.preventDefault();
        jQuery('span.amwl-file-error').hide();
        amwl_upload_icon('amwl_twitter_icon', 'amwl-twitter-icon-preview');        
    }); 
    /**
     * Upload pint icon onclick of pint upload btn 
     */
    jQuery('body').on('click', '#amwl_pint_upload_btn', function(e) {
        e.preventDefault();
        jQuery('span.amwl-file-error').hide();
        amwl_upload_icon('amwl_pint_icon', 'amwl-pint-icon-preview');        
    }); 
    /**
     * Upload email icon onclick of email upload btn 
     */
    jQuery('body').on('click', '#amwl_email_upload_btn', function(e) {
        e.preventDefault();
        jQuery('span.amwl-file-error').hide();
        amwl_upload_icon('amwl_email_icon', 'amwl-email-icon-preview');        
    }); 
    /**
     * Upload wapp icon onclick of wapp upload btn 
     */
    jQuery('body').on('click', '#amwl_wapp_upload_btn', function(e) {
        e.preventDefault();
        jQuery('span.amwl-file-error').hide();
        amwl_upload_icon('amwl_wapp_icon', 'amwl-wapp-icon-preview');        
    }); 
    /**
     * Upload cb icon onclick of cb upload btn 
     */
    jQuery('body').on('click', '#amwl_cb_upload_btn', function(e) {
        e.preventDefault();
        jQuery('span.amwl-file-error').hide();
        amwl_upload_icon('amwl_cb_icon', 'amwl-cb-icon-preview');        
    });  

});

/**
 * Create function for upload icon
 */
function amwl_upload_icon(amwl_input_id, amwl_preview_class){

        var file_data = new FormData();
        var file = jQuery('#'+ amwl_input_id);
        var single_file = file[0].files[0];

        /**
         * Check file is not empty
         */
        if(single_file == undefined){
          file.next().after('<span class="amwl-file-error">Please select icon first.</span>');
          return false;          
        }
        
        /**
         * Check valid file extestion
         */
        var file_ext = single_file['type'];
        var file_ext_arr = ['image/png', 'image/jpeg', 'image/jpg'];
        if(jQuery.inArray(file_ext, file_ext_arr) == -1){
          file.next().after('<span class="amwl-file-error">File extension not valid. Valid extension are .png,.jpeg,.jpg.</span>');
          return false;          
        }           

        file_data.append("amwl_icon", single_file);
        file_data.append("amwl_option_name", amwl_input_id);
        file_data.append('action', 'amwl_upload_file'); 

        jQuery.ajax({
            type: 'POST',
            url: amwl_upload.ajax_url,
            data: file_data,
            contentType: false,
            processData: false,
            success: function(response){
                
                var response_data = jQuery.parseJSON(response);
                var file_url = response_data['file_url'];

                if(file_url != ''){                  
                  file.next().after('<span class="amwl-file-success">Icon upload successfully.</span>');

                  var amwl_preview = jQuery('.'+ amwl_preview_class);
                  amwl_preview.show();
                  amwl_preview.html('');
                  amwl_preview.append('<span class="amwl-file"><img src="'+file_url+'"></span>');
                } else {
                  file.next().after('<span class="amwl-file-error">Error in upload. Please try again!</span>');
                }             

                setTimeout(function() {
                    jQuery('.amwl-file-success').fadeOut('slow');
                    jQuery('.amwl-file-error').fadeOut('slow');
                }, 5000);
            }
        });
}