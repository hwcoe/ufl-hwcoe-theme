<?php
function uflaw_create_courses_post() {
  $labels = array(
    'name'               =>  _x( 'Courses', 'post type general name' ),
    'singular_name'      =>  _x( 'Course', 'post type singular name' ),
    'add_new'            =>  _x( 'Add New', 'course'),
    'add_new_item'       =>  __( 'Add New Course' ),
    'edit_item'          =>  __( 'Edit Course' ),
    'new_item'           =>  __( 'New Course' ),
    'all_items'          =>  __( 'All Courses' ),
    'view_item'          =>  __( 'View Course' ),
    'search_items'       =>  __( 'Search Courses' ),
    'not_found'          =>  __( 'No Course Found' ),
    'not_found_in_trash' =>  __( 'No Course found in the Trash' ),
    'parent_item_colon'  =>  '',
    'menu_name'          =>  'Courses'
  );
  
  $args = array(
    'labels'             => $labels,
    'description'        => 'Holds all the courses',
    'public'             => true,
    'menu_position'     => 5,
    'supports'           => array( 'title' ),
    'has_archive'        => true,
    'menu_icon'          => 'dashicons-index-card'
  );

  register_post_type( 'courses' , $args );

}
add_action( 'init', 'uflaw_create_courses_post' );
