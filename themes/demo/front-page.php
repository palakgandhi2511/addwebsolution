<?php get_header(); ?>

<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();
        ?>
        <div class="section-padding blog-post-section">
            <div class="container">
                <h1 class="text-center post-title">Home Page</h1>
            </div>
        </div>
        <?php
    }
    wp_reset_query();
    wp_reset_postdata();
}
?>
<?php get_footer(); ?>