<?php

/* 
 * Register Sidebars
 * Note: most of these are holdovers from the original UF Theme
 * Widget use should be re-evaluated: there are better ways to 
 * display custom content on the homepage/post.
 * Notably, widgets aren't versioned like post meta
 */

add_action( 'widgets_init', 'ufl_athena_widgets_init' );

function ufl_athena_widgets_init() {
    register_sidebar (array(
      'name' => 'Post Sidebar',
      'id' => 'post_sidebar',
      'description' => 'Widgets in this area will be shown in the SIDE of a POST.',
      'before_widget' => '<div class="widget sidebar_widget">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
    ));
    register_sidebar (array(
      'name' => 'Courses Sidebar',
      'id' => 'post_sidebar',
      'description' => 'Widgets in this area will be shown in the SIDE of a Course.',
      'before_widget' => '<div class="widget sidebar_widget">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
    ));
}

/*
 * Recent Posts
 */
include 'widget-recent-posts.php';
