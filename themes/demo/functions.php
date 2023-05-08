<?php
if (!function_exists('demotheme_setup'))
{
    function demotheme_setup()
    {
        add_theme_support('title-tag');
        add_theme_support( 'block-templates' );
        add_theme_support(
                'post-formats',
                array(
                    'link',
                    'aside',
                    'gallery',
                    'image',
                    'quote',
                    'status',
                    'video',
                    'audio',
                    'chat',
                )
        );

        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1568, 9999);
        add_theme_support('menus');
        register_nav_menus(
                array(
                    'primary' => esc_html__('Primary menu', 'demotheme'),
                    'footer' => __('Footer menu', 'demotheme'),
                )
        );

        add_theme_support(
                'html5',
                array(
                    'search-form',
                    'comment-form',
                    'comment-list',
                    'gallery',
                    'caption',
                    'style',
                    'script',
                    'navigation-widgets',
                )
        );
  
    }

}
add_action('after_setup_theme', 'demotheme_setup');
//include functions file
require get_stylesheet_directory() . '/includes/custom-functions.php';
//include theme options file
require get_stylesheet_directory() . '/includes/custom-options.php';
//enqueue public scripts
function iflairtheme_public_scripts()
{
    wp_enqueue_style('public-style', get_template_directory_uri() . '/css/my-custom.css', array(), time());
    wp_enqueue_style('style', get_stylesheet_uri());

    //scripts
    wp_enqueue_script('public-script', get_template_directory_uri() . '/js/my-script.js', array('jquery'), time());

    wp_localize_script('public-script', 'ajaxObj', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'iflairtheme_public_scripts');

//enqueue admin scripts
function iflairtheme_admin_scripts()
{
    //styles
    wp_enqueue_media();
    wp_enqueue_style('admin', get_template_directory_uri() . '/css/admin-style.css', array(), time());

    //scripts
    wp_enqueue_script('admin-script', get_template_directory_uri() . '/js/ckeditor.js', array(), time());
    wp_enqueue_script('admin', get_template_directory_uri() . '/js/admin-script.js', array('jquery'), true, time());
     wp_localize_script('admin-script', 'admin_ajaxObj', array('ajax_url' => admin_url('admin-ajax.php'), 'curr_user' => get_current_user_id(),));
         
}
add_action('admin_enqueue_scripts', 'iflairtheme_admin_scripts');