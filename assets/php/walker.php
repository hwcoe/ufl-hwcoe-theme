<?php

class ufl_athena_main_walker_nav_menu extends Walker_Nav_Menu {
  
// add classes to ul sub-menus
function start_lvl( &$output, $depth = 0, $args = array() ) {
    // depth dependent classes
    $indent        = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' );
    $display_depth = ( $depth + 1); // because it counts the first submenu as 0
    $classes       = array(
        'menu-depth-' . $display_depth
        );
    if( $depth == 0 ){
      array_push( $classes, 'dropdown' );
    } 
    $class_names = implode( ' ', $classes );
    // build html
    $output .= "\n" . $indent . '<div class="' . $class_names . '">' . $this->nav_image_output . "<ul>\n";
}

function end_lvl(&$output, $depth=0, $args=array()) {
    $output .= "</ul></div>\n";
}

public $count = 0;
public $nav_image = '';
public $nav_image_output = '';
// add main/sub classes to li's and links
function start_el(  &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    global $wp_query;
    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); 
  
    // depth dependent classes
    $depth_classes = array(
        ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
        ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
        ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
        'menu-item-depth-' . $depth
    );
    $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
  
    // passed classes
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

    // Add featured image 
    if ( has_post_thumbnail( $item->object_id ) && $depth == 0 ) {
      $nav_image = wp_get_attachment_url( get_post_thumbnail_id( $item->object_id, 'nav-featured-image' ) );
      $alt = get_post_meta( get_post_thumbnail_id( $item->object_id, 'nav-featured-image' ), '_wp_attachment_image_alt', true );
      $alt = "Nav Image";
      $this->nav_image_output = "<div class='col-md-4 featured-nav-image'><img src='$nav_image' alt='$alt' class='img-full'></div>";
    }else {
      $this->nav_image_output = '';
    }

    // build html
    $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
      
    // link attributes
    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
    $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

    
    $link_after = "</span><span class='icon-svg icon-caret'><svg><use xlink:href='" . UFL_ATHENA_IMG_DIR . "/spritemap.svg#caret'></use></svg></span>";
    if( $depth == 0 ){
      $args->link_before = "<span>";
      $args->link_after = $link_after;
    } else {
      $args->link_before = '';
      $args->link_after = '';
    }

    //// Add containing ul to nested menu items
    //if( $this->count == 0 && $depth == 1){
    //  $args->before = '<ul class="col-md-4>';
    //}

    //// Increment count to specified maximum per nested ul  
    //if( $depth == 1 ){
    //  $this->count++;
    //}

    //// Close nested ul given specified value
    //if( $this->count %4 == 0 && $depth == 1 ){
    //  $args->after = '</ul>';
    //  $this->count = 0;
    //}

    $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        apply_filters( 'the_title', $item->title, $item->ID ),
        $args->link_after,
        $args->after
    );
      
    // build html
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

}
}


class ufl_athena_main_mega_walker_nav_menu extends Walker_Nav_Menu {
  
// add classes to ul sub-menus
function start_lvl( &$output, $depth = 0, $args = array() ) {
    // depth dependent classes
    $indent        = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' );
    $display_depth = ( $depth + 1); // because it counts the first submenu as 0
    $classes       = array(
        'menu-depth-' . $display_depth
        );
    if( $depth == 0 ){
      array_push( $classes, 'dropdown' );
    } 
    $class_names = implode( ' ', $classes );
  
    // build html
    $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
}

  
// add main/sub classes to li's and links
 function start_el(  &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    global $wp_query;
    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); 
  
    // depth dependent classes
    $depth_classes = array(
        ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
        ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
        ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
        'menu-item-depth-' . $depth
    );
    $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
  
    // passed classes
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
  
    // build html
    $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
  
    // link attributes
    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
    $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

    
    $link_after = "</span><span class='icon-svg icon-caret'><svg><use xlink:href='" . UFL_ATHENA_IMG_DIR . "/spritemap.svg#caret'></use></svg></span>";
    if( $depth == 0 ){
      $args->link_before = "<span>";
      $args->link_after = $link_after;
    } else {
      $args->link_before = '';
      $args->link_after = '';
    }
  
    $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        apply_filters( 'the_title', $item->title, $item->ID ),
        $args->link_after,
        $args->after
    );
  
    // build html
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
}
}
