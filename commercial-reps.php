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
        $photo = $customer['representative-photo'][0];
        ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <td>
                        <img src="<?php echo $photo ? $photo : 'http://1.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=128' ?>">
                    </td>
                    <td>
                        <input type="hidden" name="representative-photo" aria-required="true" size="30" value="<?php echo $custom['representative-photo'][0] ?>"/>
                        <?php if ($photo) { ?>
                            <p>
                                <a href="<?php echo $photo ?>"><?php echo substr($photo, 0, 32); ?>...</a>
                            </p>
                        <?php } else { ?>
                            <p>None</p>
                        <?php } ?>
                        <a class="button" id="upload-representative-photo" href="http://localhost/wordpress/wp-admin/media-upload.php?post_id=1&amp;type=image&amp;TB_iframe=1&amp;width=717&amp;height=575">Set Image</a>
                    </td>
                    <td>
                        <p class="howto"></p>
                    </td>
                </tr>
                <tr>
                    <td>Name:</td>
                    <td>
                        <label class="screen-reader-text" for="representative-phone">Name</label>
                        <input type="text" name="representative-phone" aria-required="true" size="30" value="<?php echo $custom['representative-name'][0] ?>"/>
                    </td>
                    <td>
                        <p class="howto">The representative's full name (first and last).</p>
                    </td>
                </tr>
                <tr>
                    <td>Phone Number:</td>
                    <td>
                        <label class="screen-reader-text" for="representative-phone">Phone Number</label>
                        <input type="text" name="representative-phone" aria-required="true" size="30" value="<?php echo $custom['representative-phone'][0] ?>"/>
                    </td>
                    <td>
                        <p class="howto">The representative's phone number.</p>
                    </td>
                </tr>
                <tr>
                    <td>Formstack Url:</td>
                    <td>
                        <label class="screen-reader-text" for="representative-form">Formstack Form Url</label>
                        <input class="code" type="text" name="representative-form" aria-required="true" size="30" value="<?php echo $custom['representative-form'][0] ?>"/>
                    </td>
                    <td>
                        <p class="howto">Each representative should have a Formstack form with a unique url.</p>
                    </td>
                </tr>
                               
 
            </tbody>
        </table>
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
            'commercial_reps', // The post type
            'normal',
            'high'
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
            'feeds'               => false,
        ); 
        $args = array(
            'label'               => __( 'commercial_reps', 'commercial_reps' ),
            'description'         => __( 'A Commercial Sales Representative', 'commercial_reps' ),
            'labels'              => $labels,
            'supports'            => false,
            'hierarchical'        => false,
            'taxonomies'          => array( 'commercial_verticals', 'commercial_territories' ),
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
            'publicly_queryable'  => true,
            'rewrite'             => $rewrite,
            'capability_type'     => 'post',
        );
        register_post_type( 'commercial_reps', $args );
        flush_rewrite_rules();
    }

    public static function register_commercial_verticals() {

        $labels = array(
            'name'                       => _x( 'Verticals', 'Taxonomy General Name', 'commercial_reps' ),
            'singular_name'              => _x( 'Vertical', 'Taxonomy Singular Name', 'commercial_reps' ),
            'menu_name'                  => __( 'Verticals', 'commercial_reps' ),
            'all_items'                  => __( 'All Verticals', 'commercial_reps' ),
            'parent_item'                => __( 'Parent Vertical', 'commercial_reps' ),
            'parent_item_colon'          => __( 'Parent Vertical:', 'commercial_reps' ),
            'new_item_name'              => __( 'New Vertical', 'commercial_reps' ),
            'add_new_item'               => __( 'Add New Vertical', 'commercial_reps' ),
            'edit_item'                  => __( 'Edit Vertical', 'commercial_reps' ),
            'update_item'                => __( 'Update Vertical', 'commercial_reps' ),
            'separate_items_with_commas' => __( 'Separate verticals with commas', 'commercial_reps' ),
            'search_items'               => __( 'Search Verticals', 'commercial_reps' ),
            'add_or_remove_items'        => __( 'Add or remove verticals', 'commercial_reps' ),
            'choose_from_most_used'      => __( 'Choose from the most used verticals', 'commercial_reps' ),
            'not_found'                  => __( 'Not Found', 'commercial_reps' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy( 'commercial_verticals', array( 'commercial_reps' ), $args );

    }

    public static function display_map( $atts ) {
        $defaults = array( 'verticals' => 'all' );
        $attributes = shortcode_atts($defaults, $atts);
        $query = array( 'post_type' => 'commercial_reps' );
        
        if($attributes['verticals'] != 'all') {
            $query['tax_query'] = array(
                array(
                    'taxonomy'  => 'commercial_verticals',
                    'name'     => 'slug',
                    'terms'     => $attributes['verticals'],
                ),
            );
        }
        $query['tax_query'] = array(
            array(
                'taxonomy'  => 'commercial_verticals',
                'field'     => 'slug',
                'terms'     => 'multi-housing',
            ),
        );

        $posts = get_posts( $query );

        foreach ( $posts as $post ) {
            print_r( wp_get_post_terms( $post->ID, 'commercial_territories' ) );
        }
    }

    public static function manage_columns( $columns ) {
        unset($columns['title']);
        return $columns;
    }

}

// Hook into the 'init' action
add_action( 'init', array('commercial_reps', 'register_commercial_verticals') );
add_action( 'init', array('commercial_reps', 'register_commercial_reps') );

add_filter( 'manage_commercial_reps_posts_columns', array( 'commercial_reps', 'manage_columns' ) );


// Add a shortcode for displaying the map
add_shortcode( 'commercial_map', array( 'commercial_reps', 'display_map' ) );
