<?php get_header();
if (have_posts()) {
    $resource_types_tax = get_terms('resource-type');
    $resource_topics_tax = get_terms('resource-topic');
?>
    <div class="wrapper">

        <form class="form-search" method="get" action="#">
            <input type="search" name="search" placeholder="search your book here for..">
            <div class="selectdiv">
                <?php if (!empty($resource_types_tax)) { ?>
                    <select name="resource_type">
                        <option value="-1">Select</option>
                        <?php foreach ($resource_types_tax as $type) { ?>
                            <option value="<?php echo $type->term_id; ?>"><?php echo $type->name; ?></option>
                        <?php } ?>
                    </select>
                <?php } ?>
                <?php if (!empty($resource_topics_tax)) { ?>
                    <select name="resource_topic">
                         <option value="-1">Select</option>
                        <?php foreach ($resource_topics_tax as $topic) { ?>
                            <option value="<?php echo $topic->term_id; ?>"><?php echo $topic->name; ?></option>
                        <?php } ?>
                    </select>
                <?php } ?>
            </div>
        </form>
        <ul class="block-list">
            <?php
            while (have_posts()) {
                the_post();
                $id = get_the_ID();
                $title = get_the_title($id);
                $img = (get_the_post_thumbnail_url($id) ? get_the_post_thumbnail_url($id) : get_template_directory_uri() . '/images/placeholder-image.png');
                $resource_types = get_the_terms($id, 'resource-type');
                $resource_topics = get_the_terms($id, 'resource-topic');
            ?>
                <li class="block-list__item recipe--small">
                    <a href="#" class="recipe__img--small">
                        <img src="<?php echo $img; ?>" />
                    </a>
                    <div class="recipe__title--small">
                        <h3><?php echo get_the_title(); ?> </h3>
                        <?php if (!empty($resource_types)) { ?>
                            <ul class="ingredients-list--small">
                                <li class="ingredients-list__header">Resource Types:</li>
                                <?php foreach ($resource_types as $type) { ?>
                                    <li class="ingredient--small"><a href="<?php echo get_term_link($type->term_id); ?>"><?php echo $type->name; ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                        <?php if (!empty($resource_topics)) { ?>
                            <ul class="ingredients-list--small">
                                <li class="ingredients-list__header">Resource Topics:</li>
                                <?php foreach ($resource_topics as $topic) { ?>
                                    <li class="ingredient--small"><a href="<?php echo get_term_link($topic->term_id); ?>"><?php echo $topic->name; ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </li>
            <?php
            }
            ?>
        </ul>

    </div>

<?php
    wp_reset_query();
    wp_reset_postdata();
}
?>

<?php get_footer(); ?>