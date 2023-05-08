<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="format-detection" content="telephone=no">       
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <?php
    if (class_exists('acf')) {
        $logo = get_field('demotheme_site_header_logo', 'options');
        $logo_url = ($logo ? $logo['url'] : '');
        $logo_alt = ($logo ? $logo['alt'] : '');

        $favicon = get_field('demotheme_site_favicon', 'options');
        $favicon_url = ($favicon ? $favicon['url'] : '');
        echo '<link rel = "icon" href = "' . $favicon_url . '" type = "image/x-icon" >
              <link rel = "shortcut icon" href = "' . $favicon_url . '" type = "image/x-icon" >';
    } else {
        $logo_url = get_option('site_header_logo');
        $logo_alt = '';

        $favicon_url = get_option('site_favicon');
        echo '<link rel = "icon" href = "' . $favicon_url . '" type = "image/x-icon" >
              <link rel = "shortcut icon" href = "' . $favicon_url . '" type = "image/x-icon" >';
    }
    ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header>
        <div class="container">
            <div class="header-wrapper">
                <?php
                if (!empty($logo_url))
                {
                    ?><div class="logo">
                        <a href="<?php echo home_url('/'); ?>"><img src="<?php echo $logo_url; ?>" alt="<?php echo $logo_alt; ?>" width="150px"></a>
                    </div><?php
                }?>

                <div class="header-right">
                    <div class="header-menu">
                        <?php wp_nav_menu(array('theme_location' => 'primary')); ?>

                    </div>
                    <a class="mobile-menu-trigger"> 
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
            </div>
        </div>
    </header>