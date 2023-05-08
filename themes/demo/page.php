<?php get_header(); ?>

<?php
$user_login_page = get_option('user_login_page');
$user_registration_page = get_option('user_registration_page');
$user_my_account_page = get_option('user_my_account_page');
$user_forgot_pass_page = get_option('user_forgot_pass_page');
$style = "";
if ($user_forgot_pass_page == get_the_ID() || $user_login_page == get_the_ID() || $user_registration_page == get_the_ID() || $user_my_account_page == get_the_ID()) {
    $style = 'style="background:#fff;"';
} else {
    $style = "";
}

if (have_posts()) {
    while (have_posts()) {
        the_post();
        ?>
        <div class="section-padding">
            <div class="container about-section-page">
                <?php
                if ($user_forgot_pass_page == get_the_ID() || $user_login_page == get_the_ID() || $user_registration_page == get_the_ID()) {
                    ?><h1 class="text-center" style="display: none;"><?php the_title(); ?></h1><?php
                } else {
                    ?><h1 class="text-center post-title single-title-blog">
                    <?php the_title(); ?>
                    </h1><?php }
                ?>
                <div class="about-content-wrapper" <?php echo $style; ?>>
                    <?php
                    if (has_post_thumbnail()) {
                        ?><a class="about-img-content" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_post_thumbnail(); ?>
                        </a><?php }
                    ?>
                    <div class="about-content-wrapper" <?php echo $style; ?>>
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    wp_reset_query();
    wp_reset_postdata();
}
?>

<?php get_footer(); ?>