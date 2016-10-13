<?php

/*
 * Advanced Custom Post Types PRO inclusion
 * Ensure most recent version of plugin files are included in the
 * assets/php/acf directory
 */

//include_once( 'assets/php/acf/acf-includes.php' );

/*
 * ACF functionality within the uflaw theme
 * All additional functionality should be defined here
 */

if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title' => 'Settings',
    'menu_title'=> 'Theme Settings',
    'menu_slug' => 'theme-general-settings',
    'capability'=> 'edit_posts',
    'redirect'  => false
  ));
}

/*
 * Breadcrumbs
 */

include_once( 'assets/php/breadcrumbs.php' );

/*
 * Widgets
 */

include_once( 'assets/php/widgets/include-widgets.php' );

/*
 * Custom Post Types
 */

include_once( 'assets/php/cpt/ufl-law-courses.php' );
include_once( 'assets/php/cpt/ufl-law-faculty.php' );

/*
 * Shortcodes
 */

include_once( 'assets/php/shortcodes.php' );

/*
 * Theme variable definitions
 */

define( "UFL_ATHENA_IMG_DIR", get_template_directory_uri() . "/assets/img" );
define( "UFL_ATHENA_INC_DIR", get_template_directory() . "/assets/php/modules" );

/*
 * Get theme version
 */

function get_theme_version(){
  $theme_info = wp_get_theme();
  $version = $theme_info->get( 'Version' );
  return $version;
}

/*
 * Allow for SVG images to be uploaded
 * throuhg media uploader
 */ 

function cc_mime_types($mimes){
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/*
 * Add theme support for featured images on pages
 */

add_theme_support( 'post-thumbnails', array( 'post', 'page', 'uflaw_faculty' ) );

/*
 * Add page excerpts
 */

add_post_type_support( 'page', 'excerpt' );

/*
 * Add thumbnail image variant for main navigation
 */

add_image_size( 'nav-featured-image', 300, 300 );

/*
 * Open up WYSIWYG
 */

function ufl_athena_editor( $args ) {
  $args['wordpress_adv_hidden'] = false;
   return $args; 
} 
add_filter( 'tiny_mce_before_init', 'ufl_athena_editor' );

/*
 * Return Header Logo
 * Defaults if none present
 */

function ufl_athena_home_logo(){
  $logo = get_field( 'home_logo', 'option' );
  if( $logo ){
    echo $logo;
  } else {
    echo get_template_directory_uri() . "/asseassets/img/logo-uf.svg"; 
  }
}

/*
 * Show post status if Draft or Private 
 */

function ufl_athena_post_status_message($id){
  $status = get_post_status($id);
  if( 'draft' == $status ){
    echo " (Draft)";
  }elseif ( 'private' == $status ){
    echo " (Private)";
  }elseif( 'trash'  == $status ){
    echo " (Trash)";
  }
}


/*
 * Site specific search
 */

function ufl_athena_search_domain(){
  if( true === get_field( 'enable_site_search', 'option' ) ){
    $search_domain = trim( get_field( 'search_url', 'option' ) );
    echo "<input type='hidden' name='site' id='site' value='$search_domain'>";
  }
}

/*
 * Trim content
 * Useful for generating exceprt like snippets of content
 */

function ufl_athena_trim_content( $content, $length, $after_content ){

  if( strlen( $content ) > $length ){
    $trimmed_content = substr( strip_tags( $content ), 0,  $length  ) . $after_content;
    return $trimmed_content; 
  } else{
    return $content;
  }
}

/*
 * Register menus
 */

function ufl_athena_register_menus() {
  register_nav_menus(
    array(
      'main_menu' => 'Main Menu Override',
      'top_menu' => 'Top Menu Override',
      'audience_menu' => 'Audience Menu Override',
      'page_post_override' => 'Page / Post Sidebar Menu'
    )
  );
}
add_action('init', 'ufl_athena_register_menus');

/*
 * Include Walker functions
 */

include_once( 'assets/php/walker.php' );

/*
 * Mega menu- removes image and accomodates a large menu structure
 */

function ufl_athena_main_mega_menu(){
  $args = array(
    'theme_location'  => 'main_menu',
    'container'       => 'div',
    'container_class' => 'main-menu-wrap',
    'container_id'    => '',
    'menu_class'      => 'menu',
    'menu_id'         => '',
    'echo'            => true,
    'fallback_cb'     => 'wp_page_menu',
    'before'          => '',
    'after'           => '',
    'link_before'     => '',
    'link_after'      => '', 
    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    'depth'           => 3,
    'walker'          => new ufl_athena_main_mega_walker_nav_menu
  );

  wp_nav_menu( $args ) ;
}

/*
 * Main menu
 */

function ufl_athena_main_menu(){
  $args = array(
    'theme_location'  => 'main_menu',
    'container'       => 'div',
    'container_class' => 'main-menu-wrap',
    'container_id'    => '',
    'menu_class'      => 'menu',
    'menu_id'         => '',
    'echo'            => true,
    'fallback_cb'     => 'wp_page_menu',
    'before'          => '',
    'after'           => '',
    'link_before'     => '',
    'link_after'      => '', 
    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    'depth'           => 2,
    'walker'          => new ufl_athena_main_walker_nav_menu
  );

  wp_nav_menu( $args ) ;
}

/*
 * Page / Post Sidebar navigation
 * Overrides default ufl_athena_sidebar_navigation
 */

function ufl_athena_sidebar_menu(){

  $args = array(
    'theme_location'  => 'page_post_override',
    'menu'            => '',
    'container'       => 'div',
    'container_class' => '',
    'container_id'    => '',
    'menu_class'      => 'menu',
    'menu_id'         => '',
    'echo'            => true,
    'fallback_cb'     => 'wp_page_menu',
    'before'          => '',
    'after'           => '',
    'link_before'     => '',
    'link_after'      => '',
    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    'depth'           => 0,
    'walker'          => ''
  );

  wp_nav_menu( $args );
}

/*
 * Top Menu Override 
 * Overrides default Institutional/Global top navigation 
 */

function ufl_athena_top_menu(){
  
  $wrap = '';

  if( get_field( 'theme_byline', 'option' ) ){
    $wrap = '<ul id="%1$s" class="%2$s"><li><a href=' . home_url() . ' class="theme-byline">' . get_field( 'theme_byline', 'option' ) .  '</a></li>%3$s</ul>';
  }else{
    $wrap = '<ul id="%1$s" class="%2$s">%3$s</ul>';
  }

  $args = array(
    'theme_location'  => 'top_menu',
    'menu'            => '',
    'container'       => false,
    'container_id'    => '',
    'menu_class'      => 'aux-nav',
    'menu_id'         => false,
    'echo'            => true,
    'fallback_cb'     => 'wp_page_menu',
    'before'          => '',
    'after'           => '',
    'link_before'     => '',
    'link_after'      => '',
    'items_wrap'      => $wrap,
    'depth'           => 0,
    'walker'          => ''
  );

  wp_nav_menu( $args );
}

/*
 * Audience Menu Override 
 * Overrides default Drop-down audience menu 
 */

function ufl_athena_audience_menu(){

  $args = array(
    'theme_location'  => 'audience_menu',
    'menu'            => '',
    'container'       => false,
    'container_id'    => '',
    'menu_class'      => false, 
    'menu_id'         => false,
    'echo'            => true,
    'fallback_cb'     => 'wp_page_menu',
    'before'          => '',
    'after'           => '',
    'link_before'     => '',
    'link_after'      => '',
    'depth'           => 0,
    'walker'          => ''
  );

  wp_nav_menu( $args );
}





/*
 * Return ID of top Post Parent
 */

function ufl_athena_get_top_page_parent($post){
  $ancestors = $post->ancestors;
  if ($ancestors) {
    return end($ancestors);
  } else {
    return $post->ID;
  }
}

/*
 * Sidebar Output
 */

function ufl_athena_sidebar_navigation($post) {
  $parent_id = ufl_athena_get_top_page_parent( $post );
  $args = array(
    'child_of'     => $parent_id,
    'date_format'  => get_option('date_format'),
    'depth'        => 5,
    'echo'         => 0,
    'link_after'   => '',
    'link_before'  => '',
    'post_type'    => 'page',
    'post_status'  => 'publish',
    'show_date'    => '',
    'sort_column'  => 'menu_order, post_title',
    'sort_order'   => '',
    'title_li'     => '',
    'walker'       => new Walker_Page
  );

  $sidebar = wp_list_pages( $args );
  return $sidebar;
}

/*
 * Menu Output
 * Takes theme option enable_mega_menu
 */

function ufl_athena_main_menu_output(){
  $mega_menu = get_field( 'enable_mega_menu', 'option' );

  if( true === $mega_menu ){
    ufl_athena_main_mega_menu();
  } else {
    ufl_athena_main_menu();
  }
}

/*
 * Determine menu style
 */

function ufl_athena_menu_style(){
  $mega_menu = get_field( 'enable_mega_menu', 'option' );

  if( true === $mega_menu ){
    echo 'mega-menu';
  }
}

/*
 * Header scripts
 * Provides <title> tag logic
 */

function ufl_athena_header_adder() {
  
  $bloginfo_name = get_bloginfo('name');
  $parent_org = (get_field( 'parent_organization', 'option' ) ? get_field( 'parent_organization', 'option' ) : 'None');

  // Site <title> logic
  echo "<title>";
  if (!is_front_page()) {
    echo wp_title('&raquo;', false, 'right') . " " . $bloginfo_name;
  } else { //if we are on the home page, only show the name of the site
    echo $bloginfo_name;
  }
  if ( ($bloginfo_name != $parent_org) && ($parent_org == 'University of Florida')) {
    echo " &raquo; " . $parent_org;
  } elseif ( ($parent_org != 'None') && ($bloginfo_name != 'University of Florida') ) {
    echo " &raquo; " . $parent_org . " &raquo; University of Florida";
  }
  echo "</title>\n";
}
add_action('wp_head', 'ufl_athena_header_adder');

/*
 * Areas Of Expertise Filtering to the Faculty Directory
 */

function ufl_athena_law_faculty_add_query_var(){
    global $wp;
    $wp->add_query_var( 'expertise' );
}
add_filter( 'init', 'ufl_athena_law_faculty_add_query_var' );


/*
 * Header Styles and Scripts
 */

function ufl_athena_register_header_scripts(){
  // Styles
  wp_enqueue_style( 'styles', get_template_directory_uri() . '/style.css', array(), get_theme_version(), false );
}
add_action( 'wp_enqueue_scripts', 'ufl_athena_register_header_scripts' );


/* 
 * Footer Styles and Scripts
 *
 */
function ufl_athena_register_footer_scripts(){
    // Scripts
    wp_enqueue_script( 'velocity', 'https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.min.js', array('jquery'), get_theme_version(), true );
    wp_enqueue_script( 'velocity-ui', 'https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.ui.min.js', array('jquery', 'velocity'), get_theme_version(), true );
      wp_enqueue_script( 'plugins', get_template_directory_uri() . '/assets/js/plugins.js', array('jquery', 'velocity', 'velocity-ui'), get_theme_version(), true );
    // NOTE this will be replaced with scripts.min.js moving to production
      wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery', 'velocity', 'velocity-ui', 'plugins'), get_theme_version(), true );
}
add_action( 'wp_enqueue_scripts', 'ufl_athena_register_footer_scripts' );


//Remove bad login messages
add_filter('login_errors',create_function('$a', "return null;"));

//Remove Meta generator tag
remove_action('wp_head', 'wp_generator');


/*
 * Flush Rewrite rules
 * Courses / Faculty modify slugs
 */

add_action( 'after_switch_theme', 'flush_rewrite_rules' );
