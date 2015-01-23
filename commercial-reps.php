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

$states = array (
    "Alabama",
    "Alaska",
    "Arizona",
    "Arkansas",
    "California",
    "Colorado",
    "Connecticut",
    "Delaware",
    "Florida",
    "Georgia",
    "Hawaii",
    "Idaho",
    "Illinois",
    "Indiana",
    "Iowa",
    "Kansas",
    "Kentucky",
    "Louisiana",
    "Maine",
    "Maryland",
    "Massachusetts",
    "Michigan",
    "Minnesota",
    "Mississippi",
    "Missouri",
    "Montana",
    "Nebraska",
    "Nevada",
    "New Hampshire",
    "New Jersey",
    "New Mexico",
    "New York",
    "North Carolina",
    "North Dakota",
    "Ohio",
    "Oklahoma",
    "Oregon",
    "Pennsylvania",
    "Rhode Island",
    "South Carolina",
    "South Dakota",
    "Tennessee",
    "Texas",
    "Utah",
    "Vermont",
    "Virginia",
    "Washington",
    "West Virginia",
    "Wisconsin",
    "Wyoming",
);

class commercial_reps {

    public static function display_info_meta_box($post) {
        $custom = get_post_custom($post->ID);
        $photo = $custom['representative-photo'][0];
        wp_nonce_field( basename( __FILE__ ), 'representative-nonce' ); 
        ?>
        <table id="representative" class="form-table">
            <tbody>
                <tr>
                    <td>
                        <img id="representative-thumbnail" height="100" width="100" src="<?php echo $photo ? $photo : 'http://1.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=128' ?>">
                    </td>
                    <td>
                        <input type="hidden" id="representative-photo" name="representative-photo" aria-required="true" size="30" value="<?php echo $custom['representative-photo'][0] ?>"/>
                        <a class="button" id="upload-representative-photo" href="http://localhost/wordpress/wp-admin/media-upload.php?post_id=1&type=image">Set Image</a>
                    </td>
                    <td>
                        <p class="howto"></p>
                    </td>
                </tr>
                <tr>
                    <td>Name:</td>
                    <td>
                        <label class="screen-reader-text" for="representative-name">Name</label>
                        <input type="text" name="representative-name" aria-required="true" size="30" value="<?php echo $custom['representative-name'][0] ?>"/>
                    </td>
                    <td>
                        <p class="howto">The representative's full name (first and last).</p>
                    </td>
                </tr>
                <tr>
                    <td>States:</td>
                    <td>
                        <label class="screen-reader-text" for="representative-states[]">States</label>
                        <select name="representative-states[]" size="5" multiple="multiple" tabindex="1">
                            <?php
                            global $states;
                            $selected = unserialize($custom['representative-states'][0]);
                            foreach($states as $state) {
                                $active = in_array($state, $selected)? ' selected' : ''; 
                                echo '<option' . $active . '>' . $state . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <p class="howto">Select multiple using control-click</p>
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
                    <td>Description:</td>
                    <td>
                        <label class="screen-reader-text" for="representative-description">Description</label>
                        <textarea type="text" name="representative-description" size="30"><?php echo $custom['representative-description'][0] ?></textarea>
                    </td>
                    <td>
                        <p class="howto">The representative's territories and verticals</p>
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
                    'field'     => 'slug',
                    'terms'     => $attributes['verticals'],
                ),
            );
        }

        $posts = get_posts( $query );

        if(count($posts) == 0) {
            echo '<p>No Representatives Found</p>';
        } 

        $states = array();
        foreach ($posts as $post) {
            $custom = get_post_meta($post->ID);
            $rep_states = unserialize($custom['representative-states'][0]);
            if($rep_states) {
                foreach ($rep_states as $state) {
                    if(!isset($states[$state])) {
                        $states[$state] = array();
                    }
                    array_push($states[$state], $custom);
                }
            }
        }

        echo '<ul>';
        ksort($states);
        foreach ($states as $state => $representatives) {
            echo '<li id="' . $state . '"><h2>' . $state . '</h2>';
            echo '<ul>';
            foreach ($representatives as $representative) {
                $name = $representative['representative-name'][0];
                $name = isset($name) && $name != '' ? $name : '(no name)';
                echo '<li>' . $name . '</li>';
            }
            echo '</ul></li>';
        }
        echo '</ul>';
   }

    public static function manage_columns( $columns ) {
        unset($columns['title']);
        $new = array(
            'representative-name' => __( 'Name', 'commercial_reps' ),
            'representative-states' => __( 'States', 'commercial_reps' ),
        );
        return array_merge(array_slice($columns, 0, 1), $new, array_slice($columns, 1));
    }

    public static function save_data($post_id) {
        // verify if this is an auto save routine. 
        // If it is our form has not been submitted, so we dont want to do anything
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
            return;

        

        if( !isset($_POST['representative-nonce']) || !wp_verify_nonce( $_POST['representative-nonce'], basename( __FILE__ ) )) {
            return;
        }


        if ( isset($_POST['representative-name']) ) {
            update_post_meta($post_id, 'representative-name', $_POST['representative-name']);
        }
            
        if ( isset($_POST['representative-phone']) ) {
            update_post_meta($post_id, 'representative-phone', $_POST['representative-phone']);
        }
        
        if ( isset($_POST['representative-states']) ) {
            update_post_meta($post_id, 'representative-states', $_POST['representative-states']);
        }
        
        if ( isset($_POST['representative-photo']) ) {
            update_post_meta($post_id, 'representative-photo', $_POST['representative-photo']);
        }

    }

    public static function custom_columns($column) {
        $custom = get_post_custom();
        switch($column) {
            case 'representative-name':
                $text = isset( $custom['representative-name'] ) && $custom['representative-name'][0] != '' ? $custom['representative-name'][0] : '(no name)';
                
                edit_post_link( $text );
                    
                break;
            case 'representative-states':
                if ( isset($custom['representative-states'][0]) ) {
                    $states = unserialize($custom['representative-states'][0]);
                    echo '<ul>';
                    foreach ( $states as $state ) {
                        echo '<li>' . $state . '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '&mdash;';
                }
                break;
        }
    }

    public static function enqueue_admin_scripts($hook) {
        wp_enqueue_media();
        wp_enqueue_script('commercial_reps', plugin_dir_url( __FILE__ ) . 'commercial-reps.js');
    }

}
// Hook into the 'init' action
add_action( 'init', array('commercial_reps', 'register_commercial_verticals') );
add_action( 'init', array('commercial_reps', 'register_commercial_reps') );

add_action( 'save_post_commercial_reps', array( 'commercial_reps', 'save_data' ) ); 

add_action( 'manage_commercial_reps_posts_custom_column', array( 'commercial_reps', 'custom_columns') );

add_action( 'admin_enqueue_scripts', array( 'commercial_reps', 'enqueue_admin_scripts') );

add_filter( 'manage_commercial_reps_posts_columns', array( 'commercial_reps', 'manage_columns' ) );


// Add a shortcode for displaying the map
add_shortcode( 'commercial_map', array( 'commercial_reps', 'display_map' ) );
