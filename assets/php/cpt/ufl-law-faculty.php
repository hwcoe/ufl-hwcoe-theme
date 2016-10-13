<?php
/*
 * UF LAW Faculty Post Type
 */

function uflaw_create_post_type() {
    $args = array(
    'labels'          => uflaw_post_type_labels( 'Faculty Post' ),
    'public'          => true,
    'rewrite'         => array('slug' => 'faculty'), 
    'capability_type' => 'post',
    'has_archive'     => true,
    'hierarchical'    => true,
    'menu_position'   => 5, 
    'menu_icon'       => 'dashicons-id-alt',
    'supports'  => array(
        'title',
        'editor',
        'author',
        'thumbnail',
        'excerpt',
    )
);
  register_post_type( 'uflaw_faculty', $args );
}
add_action( 'init', 'uflaw_create_post_type' );
 
function uflaw_post_type_labels( $singular, $plural = '' ){
  
  if( $plural == ''){
    $plural = $singular .'s';
  }
  $uflaw_labels = array(
   'name' => _x( $plural, 'post type general name' ),
   'singular_name' => _x( $singular, 'post type singular name' ),
   'add_new' => __( 'Add New' ),
   'add_new_item' => __( 'Add New '. $singular ),
   'edit_item' => __( 'Edit '. $singular ),
   'new_item' => __( 'New '. $singular ),
   'view_item' => __( 'View '. $singular ),
   'search_items' => __( 'Search '. $plural ),
   'not_found' =>  __( 'No '. $plural .' found' ),
   'not_found_in_trash' => __( 'No '. $plural .' found in Trash' ),
   'parent_item_colon' => ''
  );

  return $uflaw_labels;
}
 
function uflaw_faculty_types() {  
  register_taxonomy(  
    'uflaw_faculty_types',  
    'uflaw_faculty',  
     array(  
      'hierarchical' => true,  
      'label' => 'Faculty Types',  
      'query_var' => true,   
    )  
  );  
}  
add_action( 'init', 'uflaw_faculty_types' ); 

function uflaw_faculty_tags() {  
   register_taxonomy(  
    'uflaw_faculty_tags',  
    'uflaw_faculty',  
    array(  
      'hierarchical' => true,  
      'label' => 'Areas of Expertise',  
      'query_var' => true,  
      'rewrite' => array('slug' => 'experts-guide')  
    )  
);  
}  
add_action( 'init', 'uflaw_faculty_tags' );
