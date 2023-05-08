<?php
//add SVG to allowed file uploads
function add_file_types_to_uploads($file_types)
{
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg';
    $file_types = array_merge($file_types, $new_filetypes);

    return $file_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads');

function add_site_favicon()
{
    if (class_exists('acf')) {
        $favicon = get_field('demotheme_site_favicon', 'options');
        $favicon_url = ($favicon ? $favicon['url'] : '');
        echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
    } else {
        $favicon_url = get_option('site_favicon');
        echo '<link rel = "icon" href = "' . $favicon_url . '" type = "image/x-icon" >
                  <link rel = "shortcut icon" href = "' . $favicon_url . '" type = "image/x-icon" >';
    }
}

add_action('login_head', 'add_site_favicon');
add_action('admin_head', 'add_site_favicon');

// Add file update and show profle image if selected
add_action('show_user_profile', 'wk_custom_user_profile_fields');
add_action('edit_user_profile', 'wk_custom_user_profile_fields');

function wk_custom_user_profile_fields($user)
{
    ?>
    <table class="form-table form-table-profile">
        <tr>
            <th><label for="user_profile">Profile Image</label></th>
            <td>
                <?php
                $curr_usr = (isset($_GET['user_id']) ) ? $_GET['user_id'] : get_current_user_id();
                $profPic = get_user_meta($curr_usr, "user_profile");
                ?>
                <div class="input">
                    <input type="hidden" name="user_profile" class="upload_image" value="<?php echo ($profPic[0] ? $profPic[0] : ''); ?>"> 
                    <input type="button" class="upload_image_button button-secondary" value="Upload" />
                </div>
                <br> 
                <div class="image-wrap">
                    <?php
                    if (!empty($profPic)) {
                        echo "<img src='" . $profPic[0] . "' width='150px' id='thumb'>
                            <a class='remove-image' style='display: inline;'>&#215;</a>";
                    }
                    ?>
                </div>
            </td>
        </tr>
    </table>
    <?php
}

// Update User Profile in Admin edit profile
add_action('profile_update', 'wk_save_custom_user_profile_fields');

function wk_save_custom_user_profile_fields()
{
    if (isset($_POST['user_profile']) && $_POST['user_id']) {
        update_user_meta($_POST['user_id'], 'user_profile', $_POST['user_profile']);
    }
}
//Show Profile image in Frontend and Gravatar
add_filter('get_avatar_data', 'ow_change_avatar', 100, 2);

function ow_change_avatar($args, $user_data)
{
    if(is_object($user_data)){
        $user_id = $user_data->user_id;
    } else{
        $user_id = $user_data;  
    }
    if($user_id){
        $author_pic = get_user_meta($user_id, 'user_profile', true);
        if($author_pic){
            $args['url'] = $author_pic;
        } else {
            $args['url'] = 'http://0.gravatar.com/avatar/3017cf980d30e9ee79c2b3cb16b58f54?s=64&d=mm&r=g';
        }
    } else {
        $args['url'] = 'http://0.gravatar.com/avatar/3017cf980d30e9ee79c2b3cb16b58f54?s=64&d=mm&r=g';
    }
    return $args;
}

//Add enctype in admin edit profile form to upload file/image
if (is_admin())
{
    function add_post_enctype()
    {
        echo "<script type=\"text/javascript\">
        jQuery(document).ready(function(){
        jQuery('#your-profile').attr('enctype','multipart/form-data');
        });
        </script>";
    }
    add_action('admin_head', 'add_post_enctype');
}