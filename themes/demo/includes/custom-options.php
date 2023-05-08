<?php
if (class_exists('acf')) 
{
    //acf theme setting
    if (function_exists('acf_add_options_page')) 
    {
        acf_add_options_page(array(
            'page_title' => 'Theme General Settings',
            'menu_title' => 'Theme Settings',
            'menu_slug' => 'theme-general-settings',
            'capability' => 'edit_posts',
            'redirect' => false
        ));
    }
} 
else
{
    //admin theme settings
    add_action('admin_menu', 'admin_theme_settings');
    function admin_theme_settings() 
    {
        $page_title = 'Admin Settings';
        $menu_title = 'Admin Settings';
        $capability = 'manage_options';
        $menu_slug = 'admin_settings';
        $function = 'my_page_display';
        $icon_url = '';

        add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url);
    }

    function my_page_display() 
    {
        if (isset($_POST['site_header_logo'])) 
        {
            $value = $_POST['site_header_logo'];
            update_option('site_header_logo', $value);
        }
        if (isset($_POST['site_footer_logo'])) 
        {
            $value = $_POST['site_footer_logo'];
            update_option('site_footer_logo', $value);
        }
        if (isset($_POST['site_favicon'])) 
        {
            $value = $_POST['site_favicon'];
            update_option('site_favicon', $value);
        }
        if (isset($_POST['copyright'])) 
        {
            $value = $_POST['copyright'];
            update_option('copyright', $value);
        }
        if (isset($_POST['social_media'])) 
        {
            $value = $_POST['social_media'];
            $sm = [];
            foreach ($value as $k => $v) {
                for ($i = 0; $i < count($v); $i++) {
                    if ($v[$i] !== '') {
                        $sm[$i][$k] = $v[$i];
                    }
                }
            }
            update_option('social_media',  $sm);
        }
        $site_header_logo = get_option('site_header_logo');
        $site_footer_logo = get_option('site_footer_logo');
        $site_favicon = get_option('site_favicon');
        $copyright = get_option('copyright');
        $social_media = get_option('social_media');?>
        <div class="wrap">
            <form method="POST" enctype="multipart/form-data">
                <div class="container" style="color:black;">
                    <h1>Theme Settings</h1>
                    <!-- Nav tabs -->
                    <div class="tabing-wrapper admin-tabing">
                        <ul class="tabs">
                            <li class="tab-link current" data-tab="site_logo_favicon"> Header Logo/Favicon & Footer Logo</li>
                            <li  class="tab-link" data-tab="header_section">Header Section</li>
                            <li  class="tab-link" data-tab="social_media">Social Media</li>
                            <li  class="tab-link" data-tab="footer_section">Footer Section</li>
                        </ul>
                        <div class="tab-content current" id="site_logo_favicon">
                            <div class="inner-column-wrapper">
                                <div class="field col-6">
                                    <div class="field-lable">
                                        <h3>Header Logo</h3>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="site_header_logo" class="upload_image" value="<?php echo $site_header_logo; ?>"> 	
                                        <input type="button" class="upload_image_button btn btn-sm" value="Upload" />

                                        <div class="image-wrap header-logo">
                                            <?php 
                                            if (!empty($site_header_logo)) 
                                            {
                                                ?><img id="thumb" src="<?php echo $site_header_logo; ?>" alt="" data-name="image" /><a class="remove-image" style="display: inline;">&#215;</a><?php
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="field col-6">
                                    <div class="field-label">
                                        <h3>Footer Logo</h3>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="site_footer_logo" class="upload_image" value="<?php echo $site_footer_logo; ?>">
                                        <input type="button" class="upload_image_button btn btn-sm" value="Upload" />
                                        <div class="image-wrap footer-logo">
                                            <?php 
                                            if (!empty($site_footer_logo)) 
                                            {
                                                ?><img id="thumb" src="<?php echo $site_footer_logo; ?>" alt="" data-name="image" /><a class="remove-image" style="display: inline;">&#215;</a><?php
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="field col-6">
                                    <div class="field-label">
                                        <h3>Favicon</h3>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="site_favicon" class="upload_image" value="<?php echo $site_favicon; ?>">
                                        <input type="button" class="upload_image_button btn btn-sm" value="Upload" />
                                        <div class="image-wrap favicon">
                                            <?php 
                                            if (!empty($site_favicon)) 
                                            {
                                                ?><img id="thumb" src="<?php echo $site_favicon; ?>" alt="" data-name="image" /><a class="remove-image" style="display: inline;">&#215;</a><?php
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="header_section"></div>
                        <div class="tab-content" id="social_media">
                            <div class="field">
                              <div class="row repeater_field">
                                    <table id="repeatable-fieldset-one" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Add Link</th>
                                                <th>Add Logo</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ( $social_media )
                                            {
                                                foreach ( $social_media as $key => $value)
                                                {
                                                    ?><tr class="input">
                                                         <td><input type="text" name="social_media[link][]" value="<?php echo $value['link']; ?>" /></td>
                                                                                    <!-- <td> -->
                                                            <input class="upload_image" type="hidden" name="social_media[logo][]" value="<?php echo $value['logo']; ?>">                                                       
                                                        <!-- </td> -->
                                                        <td>
                                                            <input type="button"class="upload_image_button btn btn-sm" id="" value="Upload" /><br> 
                                                            <div class="image-wrap favicon">
                                                                <?php 
                                                                if (!empty($value['logo'])) 
                                                                    { ?>
                                                                    <img id="thumb" src="<?php echo $value['logo']; ?>" width="150px"/><a class="remove-image" style="display: inline;">&#215;</a>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                        <td><a class="button remove-row" href="#1">Remove</a></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                                <tr class="input">
                                                    <td><input type="text" name="social_media[link][]" value="" /></td>
                                                    <!-- <td> -->
                                                        <input class="upload_image" type="hidden" name="social_media[logo][]" value="">
                                                    <!-- </td> -->
                                                    <td>
                                                        <input type="button" class="upload_image_button btn btn-sm" id="" value="Upload" /><br>
                                                        <div class="image-wrap favicon">
                                                        </div>
                                                    </td>
                                                    <td><a class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></td>
                                                </tr>
                                                <?php
                                            } ?>
                                            <tr class="input empty-row custom-repeter-text" style="display: none">
                                                <td><input type="text" name="social_media[link][]" value="" /></td>
                                                <!-- <td> -->
                                                    <input class="upload_image" type="hidden" name="social_media[logo][]" value="">
                                                <!-- </td> -->
                                                <td>
                                                    <input type="button" class="upload_image_button btn btn-sm" id="" value="Upload" /><br>
                                                    <div class="image-wrap favicon">
                                                    </div>
                                                </td>
                                                <td><a class="btn btn-primary remove-row" href="#">Remove</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <a id="add-row" class="button" href="#">Add another</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="footer_section">
                            <div class="field">
                                <div class="field-lable">
                                    <label for="">Copyright</label>
                                </div> 

                                <div class="input">
                                    <textarea rows="2" name="copyright" id="ckeditor"><?php echo $copyright; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="submit" value="Save" class="button button-primary button-large">
            </form>
        </div><?php
    }
}