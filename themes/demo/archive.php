<?php get_header();
if (have_posts()) {
?>
    <div class="wrapper">
        <?php
        while (have_posts()) {
            the_post();
            $id = get_the_ID();
            $title = get_the_title($id);
            $img = (get_the_post_thumbnail_url($id) ? get_the_post_thumbnail_url($id) : get_template_directory_uri() . '/images/placeholder-image.png');
        ?>
            <img src="<?php echo $img; ?>" />
            <h3><?php echo get_the_title(); ?> </h3>
        <?php
        }
        ?>
    </div>
<?php
    wp_reset_query();
    wp_reset_postdata();
}
?>

<?php get_footer(); ?>