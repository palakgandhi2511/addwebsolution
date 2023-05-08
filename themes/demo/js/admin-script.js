jQuery(document).ready(function ($) {

    setTimeout(function () {
                var currentTab = localStorage.getItem('current_tab');
                var currentur = localStorage.getItem('current_usr');
                var chkur = admin_ajaxObj.curr_user;

                if (currentTab && currentur == chkur) {
                    jQuery('.tabs li[data-tab="' + currentTab + '"]').trigger('click');
                }
            }, 5);
                //nav tabs for theme options
           jQuery(document).on("click", 'ul.tabs li', function (e) {
                localStorage.setItem('current_tab', jQuery(e.target).attr('data-tab'));
                //alert(localStorage);
                localStorage.setItem('current_usr', admin_ajaxObj.curr_user);
                var tab_id = jQuery(this).attr('data-tab');

                jQuery('ul.tabs li.tab-link').removeClass('current');
                jQuery('.tab-content').removeClass('current');

                jQuery(this).addClass('current');
                jQuery("#" + tab_id).addClass('current');
            });
   
    
        jQuery(document).ready(function( $ ){
            $( '#add-row' ).on('click', function(e) {
                e.preventDefault();
                var row = $( '.empty-row.custom-repeter-text' ).clone(true);
                row.removeClass( 'empty-row custom-repeter-text' ).css('display','table-row');
                row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
                return false;
            });

            $( '.remove-row' ).on('click', function() {
                $(this).parents('tr').remove();
                return false;
            });
        });
    //users profile remove
    jQuery(document).on('click', ".form-table-profile .remove-image", function () {
        $(this).parents('.form-table-profile').find('input[type=hidden]').val('');
        $(this).parents('.form-table-profile').find('.image-wrap').html('');
    });
    jQuery(document).on('click', ".input .remove-image", function () {
        $(this).parents('.input').find('input.upload_image').val('');
        $(this).parents('.input').find('.image-wrap').html('');
    });
    jQuery(document).find('.is_img:checked').parents('table').find('.upload_image_button').css('display', 'block');
    jQuery(document).find('.is_img:checked').parents('table').find('.image-wrap').css('display', 'block');
    jQuery(document).find('.is_img:checked').val('true');

    jQuery(document).on('change', '.is_img', function () {
        if (jQuery(this).prop("checked") === true) {
            jQuery(this).val('true');
            jQuery(this).parents('table').find('.upload_image_button').css('display', 'block');
        } else {
            jQuery(this).val('false');
            // jQuery(this).parents('table').find('.upload_image_button').css('display', 'none');
        }
        jQuery(this).parents('table').find('.image-wrap').html('');
        jQuery(this).parents('table').find('.upload_image').val('');
    });
    var custom_uploader;

    jQuery(document).on('click', '.upload_image_button', function (e) {
        //If the uploader object has already been created, reopen the dialog
        var $this = jQuery(this);
        if (custom_uploader)
        {
            custom_uploader.open();
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function () {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery($this).parents('.input').find('.upload_image').val(attachment.url);
            jQuery($this).parents('.input').find('.image-wrap').html('<img id="thumb" src="' + attachment.url + '"/><a class="remove-image" style="display: inline;">&#215;</a>');
        });

        //Open the uploader dialog
        custom_uploader.open();
    });
});
if (jQuery('#ckeditor').length > 0) {
    ClassicEditor.create(document.querySelector('#ckeditor'));
}
