<?php get_header(); ?>

<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();
        ?>

        <div class="section-padding blog-post-section">
            <div class="container">
                <h1 class="text-center post-title single-title-blog"><?php the_title(); ?></h1>
                <div class="post-wrapper-blog single-post-blog">
                    <?php
                    if (has_post_thumbnail()) {
                        ?>
                        <a class="image-wrapper-post" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <?php the_post_thumbnail(); ?>  
                        </a>
                    <?php }
                    ?>
                    <div><?php the_content(); ?></div>
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