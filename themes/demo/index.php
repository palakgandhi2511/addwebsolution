<?php get_header(); ?>
<div class="section-padding">
    <div class="container"><?php
        if (is_post_type_archive()) {
            post_type_archive_title();
        }
        ?>
        <div class="post-listing-wrapper">
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    ?><div class="post-grid">
                    <?php
                    the_post();
                    if (has_post_thumbnail()) {
                        ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <div class="post-image-wrapper" style="background-image: url('<?php the_post_thumbnail_url(); ?>');">
                                </div></a>
                        <?php }
                        ?>
                        <div class="post-grid-content">
                            <h6><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h6>
                            <?php the_content(); ?>
                        </div>
                        </a>
                    </div>
                    <?php
                }
                wp_reset_query();
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>