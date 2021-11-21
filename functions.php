<?php

define( 'VALID_KEY', 0 );
define( 'INVALID_KEY', -1 );
define( 'EXPIRED_KEY', -2 );

function my_custom_post_cv_key() {
    $labels = array(
        'name'               => _x( 'CV Keys', 'post type general name' ),
        'singular_name'      => _x( 'CV Key', 'post type singular name' ),
        'add_new'            => _x( 'Create a CV Key', 'CV Key' ),
        'add_new_item'       => __( 'Add New CV Key' ),
        'edit_item'          => __( 'Edit CV Key' ),
        'new_item'           => __( 'New CV Key' ),
        'all_items'          => __( 'All CV Keys' ),
        'view_item'          => __( 'View CV Key' ),
        'search_items'       => __( 'Search CV Keys' ),
        'not_found'          => __( 'No CV Keys found' ),
        'not_found_in_trash' => __( 'No CV Keys found in the Trash' ), 
        'menu_name'          => 'CV Keys'
    );
  
    $args = array(
        'labels'        => $labels,
        'description'   => 'Holds my CV Keys for accessing personal information',
        'public'        => false,
        'publicly_queryable' => false,  // you should be able to query it
        'show_ui' => true,  // you should be able to edit it in wp-admin
        'exclude_from_search' => true,  // you should exclude it from search results
        'show_in_nav_menus' => false,  // you shouldn't be able to add it to menus
        'rewrite' => false,  // it shouldn't have rewrite rules
        'menu_position' => 5,
        'supports'      => array( 'title' ),
        'has_archive'   => false,
    );
    
    register_post_type( 'cv_key', $args ); 
}


add_action( 'init', 'my_custom_post_cv_key' );


add_filter( 'manage_cv_key_posts_columns', 'colincooper_filter_posts_columns' );


function colincooper_filter_posts_columns( $columns ) {
    
  $columns['cv_key_owner'] = __( 'Key Owner', 'colincooper' );
  $columns['cv_expiry_date'] = __( 'Expiry Date', 'colincooper' );
  $columns['cv_status'] = __( 'Status', 'colincooper' );
  
  return $columns;
    
}


add_action( 'manage_cv_key_posts_custom_column', 'colincooper_cv_key_column', 10, 2);


function colincooper_cv_key_column( $column, $post_id ) {
    
    if ( 'cv_key_owner' === $column ) {
        $cv_key_owner = get_post_meta( $post_id, 'cv_key_owner', true );
    
        if ( ! $cv_key_owner ) {
            _e( 'n/a' );  
        }
        else {
            echo $cv_key_owner;
        }
    }
    
    if ( 'cv_expiry_date' === $column ) {
        $cv_expiry_date = get_post_meta( $post_id, 'cv_expiry_date', true );
    
        if ( ! $cv_expiry_date ) {
            _e( 'None' );  
        }
        else {
            $date_format = get_option('date_format');
            $expiry_timestamp = new DateTime( $cv_expiry_date );
            echo date( $date_format, $expiry_timestamp->getTimestamp() );
        }
    }
    
    if ( 'cv_status' === $column ) {
        $cv_expiry_date = get_post_meta( $post_id, 'cv_expiry_date', true );
    
        if ( ! $cv_expiry_date ) {
            _e( 'Valid' );  
        }
        else {
            if ( $cv_expiry_date >= date( 'Ymd' )) {
                _e( 'Valid' );
            }
            else {
                _e( 'Expired' );
            }
        }
    }
}

  


add_filter( 'nonce_life', function () { return 1 * HOUR_IN_SECONDS; } );

function check_cv_key_status( $cv_key, $email ) {
    
    $return_value = INVALID_KEY;
    
    $args = array(  
        'name' => $cv_key,
        'post_type' => 'cv_key',
        'post_status' => 'publish',
     	'meta_query'  => array(
            array(
                'key' => 'cv_key_owner',
                'value' => $email,
            )
        ),
        'posts_per_page' => 1, 
    );

    $cv_key_results = new WP_Query( $args ); 
    $cv_key_count = $cv_key_results->found_posts;
    
    if ( $cv_key_count === 1 ) {
        $cv_key_results->the_post();
        $cv_key_expiry_date = get_post_meta( get_the_ID(), 'cv_expiry_date', true );
        $current_date = date('Ymd');
        
        if ( $cv_key_expiry_date >= $current_date || intval( $cv_key_expiry_date ) === 0 ){
            $return_value = VALID_KEY;
        }
        else {
            $return_value = EXPIRED_KEY;
        }
    }

    wp_reset_postdata(); 
    
    return $return_value;
}

function show_post($path) {
    
  $post = get_page_by_path($path);
  $content = apply_filters('the_content', $post->post_content);
  echo $content;
}

