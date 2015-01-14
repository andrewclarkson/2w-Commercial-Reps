<?php
/**
 * @package commercial-reps
 * @version 0.1
 */

/*
Plugin Name: 2nd Wind Commercial Reps
Plugin URI: github.io/2nd-wind-exercise/commercial-reps
Description: A simple site-specific plugin to manage 2nd Wind Exercise's Commercial Representatives 
Author: Andrew Clarkson
Version: 0.1
Author URI: andrew.clarkson.mn
 */


class commercial_reps {

    public static function display_info_meta_box($post) {
        $custom = get_post_custom($post->ID);
        ?>
        <label for="representative-name">Name:</label>
        <input type="text" name="representative-name" value="<?php echo $custom['representative-name'][0] ?>"/>
        <?php
    }

    /**
     * Registers the meta boxes (custom fields) for the Commercial Representative post type
     */ 
    public static function register_meta_boxes($post) {
        // Add the Commercial Representative Info meta box
        add_meta_box( 
            'representative-info', // The form field's id
            __( 'Representative Info', 'commercial_reps' ), // The form field's label
            array('commercial_reps', 'display_info_meta_box'), // the callback to generate html
            'commercial_reps' // The post type
        );
    }



    /**
     * Registers the Commercial Representative Post Type
     *
     */
    public static function register_commercial_reps() {

        $labels = array(
            'name'                => _x( 'Commercial Representatives', 'Post Type General Name', 'commercial_reps' ),
            'singular_name'       => _x( 'Commercial Representative', 'Post Type Singular Name', 'commercial_reps' ),
            'menu_name'           => __( 'Representatives', 'commercial_reps' ),
            'parent_item_colon'   => __( 'Parent Item:', 'commercial_reps' ),
            'all_items'           => __( 'All Representatives', 'commercial_reps' ),
            'view_item'           => __( 'View Item', 'commercial_reps' ),
            'add_new_item'        => __( 'Add New Representative', 'commercial_reps' ),
            'add_new'             => __( 'Add New', 'commercial_reps' ),
            'edit_item'           => __( 'Edit Representative', 'commercial_reps' ),
            'update_item'         => __( 'Update Representative', 'commercial_reps' ),
            'search_items'        => __( 'Search Representatives', 'commercial_reps' ),
            'not_found'           => __( 'Not found', 'commercial_reps' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'commercial_reps' ),
        );
        $rewrite = array(
            'slug'                => 'representatives',
            'with_front'          => true,
            'pages'               => true,
            'feeds'               => true,
        );
        $args = array(
            'label'               => __( 'commercial_reps', 'commercial_reps' ),
            'description'         => __( 'A Commercial Sales Representative', 'commercial_reps' ),
            'labels'              => $labels,
            'supports'            => array( 'thumbnail', ),
            'hierarchical'        => false,
            'register_meta_box_cb'=> array( 'commercial_reps', 'register_meta_boxes' ),
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-businessman',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => $rewrite,
            'capability_type'     => 'post',
        );
        register_post_type( 'commercial_reps', $args );
    
    }


}

// Hook into the 'init' action
add_action( 'init', array('commercial_reps', 'register_commercial_reps') );

