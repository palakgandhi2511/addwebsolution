<?php
/*
Plugin Name: Resources CPT
Description: create your own resources cpt
Author: Anonymous
*/
if (!defined('WPINC')) die;
class RegisterResourcesCPT
{
    public function InitCall()
    {
        add_action('init', [$this, 'resources_post_type']);
        add_filter('template_include', [$this, 'resource_cpt_template']);
        add_action('wp_ajax_nopriv_get_resources_data', [$this, 'get_resources_data']);
        add_action('wp_ajax_get_resources_data',  [$this, 'get_resources_data']);
        add_filter('posts_where', [$this, 'get_resourcesby_title'], 10, 2);
        add_action('pre_get_posts', [$this, 'resources_limit_query']);
        add_action('wp_enqueue_scripts', [$this, 'add_css']);
    }

    public function add_css()
    {
        wp_enqueue_style('build', WP_PLUGIN_URL . '/resource-cpt/css/build.css', array(), time());
        wp_enqueue_script('build', WP_PLUGIN_URL . '/resource-cpt/js/build.js', array(), time(), true);
        wp_localize_script('build', 'ajaxObj', array('ajax_url' => admin_url('admin-ajax.php')));
    }

    public function resources_post_type()
    {
        register_post_type(
            'resources',
            array(
                'labels' => array(
                    'name' => __('Resources'),
                    'singular_name' => __('Resource')
                ),
                'public' => true,
                'show_in_rest' => true,
                'supports' => array('title', 'editor', 'thumbnail'),
                'has_archive' => true,
                'rewrite'   => array('slug' => 'resources'),
                'menu_position' => 5,
                'menu_icon' => 'dashicons-products',
            )
        );
        register_taxonomy('resource-type', 'resources', array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x('Resource Types', 'taxonomy general name'),
                'singular_name' => _x('', 'taxonomy singular name'),
                'menu_name' => __('Resource Types'),
                'all_items' => __('All Resource Types'),
                'edit_item' => __('Edit Resource Type'),
                'update_item' => __('Update Resource Type'),
                'add_new_item' => __('Add Resource Type'),
                'new_item_name' => __('New Resource Type'),
            ),
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
        ));
        register_taxonomy('resource-topic', 'resources', array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x('Resource Topics', 'taxonomy general name'),
                'singular_name' => _x('Resource Topic', 'taxonomy singular name'),
                'menu_name' => __('Resource Topics'),
                'all_items' => __('All Resource Topics'),
                'edit_item' => __('Edit Resource Topic'),
                'update_item' => __('Update Resource Topic'),
                'add_new_item' => __('Add Resource Topic'),
                'new_item_name' => __('New Resource Topic'),
            ),
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
        ));
    }

    public function resource_cpt_template($template)
    {
        if (is_archive('resources')) {
            $template = WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__)) . '/archive-resources.php';
        }
        return $template;
    }

    public function get_resourcesby_title($where, &$wp_query)
    {
        global $wpdb;
        if ($restitle = $wp_query->get('res_title')) {
            $where .= ' AND wp_posts.post_title LIKE \'%' . esc_sql($wpdb->esc_like($restitle)) . '%\'';
        }
        return $where;
    }
    public function get_resources_data()
    {
        $input = $_POST['input'];
        $type = $_POST['type'];
        $topic = $_POST['topic'];
        $search_query = array(
            'post_type' => 'resources',
            'posts_per_page' => 9,
            'post_status'      => 'publish',
            'orderby'          => 'title',
            'order'            => 'ASC',
        );
        if ((isset($type) && $type !== '-1') && (isset($topic) && $topic !== '-1')) {
            $search_query['tax_query']['relation'] = "AND";
        }
        if (isset($input) && !empty($input)) {
            $search_query['res_title'] = $input;
        }
        if (isset($topic) && $topic !== '-1' && $topic !== '' ) {
            $search_query['tax_query'][] = array(
                'taxonomy' => 'resource-topic',
                'terms' => $topic,
                'field' => 'id',
                'operator' => 'IN'
            );
        }
        if (isset($type) && $type !== '-1' && $type !== '') {
            $search_query['tax_query'][] = array(
                'taxonomy' => 'resource-type',
                'terms' => $type,
                'field' => 'id',
                'operator' => 'IN'
            );
        }
        $wp_query = new WP_Query($search_query);
        if ($wp_query->have_posts()) {
            while ($wp_query->have_posts()) {
                $wp_query->the_post();
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
                        <h3><?php echo $title; ?> </h3>
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
            wp_reset_query();
            wp_reset_postdata();
        } else {
            echo '<h3>NO Resources Found!!!</h3>';
        }
        die();
    }
    public function resources_limit_query($query)
    {
        if (!is_admin() && $query->is_post_type_archive('resources') && $query->is_main_query()) {
            $query->set('posts_per_page', 9);
        }
    }
}
$Plugin = new RegisterResourcesCPT();
$Plugin->InitCall();
