<?php get_header(); ?>

<?php echo "<h2>Search Results for: " . get_query_var('s') . "</h2>";?>

<?php
$found = $wp_query->found_posts;
echo '<h3>We found ' . $found . ' result for your search.</h3>';

if (have_posts())
{
    while (have_posts())
    {
        the_post(); ?>
        
        <?php the_title(); ?>

        <?php
        if ( has_post_thumbnail() )
        {
            ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail(); ?>
            </a><?php 
        } ?>

        <?php the_content(); ?>

        <?php
    }
    wp_reset_query();
    wp_reset_postdata();
}
else
{
    get_search_form();
} ?>

<?php get_footer(); ?>