<?php

/*
 * uflaw courses shortcode
 * Empty, no attributes are needed at present
 */

function uflaw_courses_shortcode( $atts ){

  $args = array(
    'posts_per_page'     => -1,
    'orderby'          => 'title',
    'order'            => 'ASC',
    'post_type'        => 'courses',
    'post_status'      => 'publish',
  );
  $courses = new WP_Query( $args );
  
  if ( $courses->have_posts() ) {
    while ( $courses->have_posts() ) { $courses->the_post();
      $link           = get_permalink();
      $title          = get_the_title(); 
      $credits        = get_field( 'credits' );
      $description    = (get_field( 'shortened' ) ? get_field( 'shortened' ) : ufl_athena_trim_content( get_field( 'description' ), 240, '...') ); 
      $course_number  = get_field( 'course_number' );

?>
    <div class="entry">
        <h2><a href="<?php echo $link; ?>" rel="bookmark"><?php echo $title; ?></a></h2>
          <p>
            <strong>Course Number: </strong><span class="course-number"><?php echo $course_number; ?></span>
            <strong>Credits: </strong><span class="course-credits"><?php echo $credits; ?></span>
          </p>
          <div>
            <?php if( have_rows( 'prerequisites' ) ): ?>
              <p><strong>Prerequisites</strong>:
              <?php while ( have_rows( 'prerequisites' ) ) : the_row(); ?>
                <?php
                  $preq   = get_sub_field( 'prerequisite' );
                  $title  = $preq->post_title;
                  $num    = get_field( 'course_number', $preq->ID );
                  $preq_out = $title . "(" . $num . ") ";
                  echo $preq_out;
                ?>
              <?php endwhile // the_row ?> 
              </p>
            <?php endif // preqs ?>
            <?php echo $description; ?> 
          </div>
          </p>
      </div><!-- end .entry -->
  <?php } // have_posts 
    } // have_posts
}
add_shortcode( 'uflaw-courses', 'uflaw_courses_shortcode' );

/*
 * Expert Guide
 */

function uflaw_expert_guide_shortcode(){
    $taxonomy = 'uflaw_faculty_tags';
    $tax_terms = get_terms( $taxonomy );
    $expert_search = false;
    ?>
    <ul class="sidenav">
    <?php 
    foreach( $tax_terms as $term ) {
      if( 'exclude' != $term->name ){
echo '<li>' . '<a href="' . esc_attr(get_term_link($term, $taxonomy)) . '" title="' . sprintf( __( "View all posts in %s" ), $term->name ) . '" ' . '>' . $term->name.'</a></li>';
      } }?>
    </ul>
<?php
}
add_shortcode( 'uflaw-experts', 'uflaw_expert_guide_shortcode' );

/*
 * Faculty directory 
 */

function uflaw_faculty_directory_shortcode(){

  $tax_args = array(
    array(
      'taxonomy'  => 'uflaw_faculty_tags',
      'field'     => 'slug',
      'terms'      => 'exclude',
      'operator'  =>'NOT IN',
    )
  );

  global $wp_query;
  if( isset( $wp_query->query_vars['expertise'] ) ){
  
    $expert_search = true; 
    $term_args = array(
      'relation' => 'AND',
      array(
        'taxonomy'  => 'uflaw_faculty_types',
        'field'     => 'slug',
        'terms'      => 'exclude',
        'operator'  =>'NOT IN',
      ),
      array(
        'taxonomy'  => 'uflaw_faculty_tags',
        'field'     => 'slug',
        'terms'      => $wp_query->query_vars['expertise'],
        'operator'  =>'IN',
      )
    );
  }

  $args = array(
    'post_type' => 'uflaw_faculty',
    'meta_key' => 'last-name',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'posts_per_page' =>-1,
     'tax_query' => array (
	$term_args,
	//adding additional query parameters to exclude retired and emeriti faculty by checking the 'Exclude' Faculty type
	array(
                                    'taxonomy'  => 'uflaw_faculty_types',
                                    'field'     => 'slug',
                                    'terms'      => 'exclude',
                                    'operator'  =>'NOT IN',
                                   ),
	
     ),
  );

  $query = new WP_Query( $args );
  $nav_output = "<div class='row'><div class='col-md-4'><a href='/uflaw-faculty/faculty-and-staff-directory/tenured-and-tenure-track-faculty'>Tenured and Tenure Track Faculty</a></div>
<div class='col-md-4'><a href='/uflaw-faculty/faculty-and-staff-directory/legal-skills-faculty'>Legal Skills Faculty</a></div>
<div class='col-md-4'><a href='/uflaw-faculty/faculty-and-staff-directory/legal-information-center-faculty'>Legal Information Center Faculty</a></div>
</div>
<div class='row'>
<div class='col-md-4'><a href='/uflaw-faculty/faculty-and-staff-directory/emeriti-and-retired-faculty'>Emeriti and Retired Faculty</a></div>
<div class='col-md-4'><a href='/uflaw-faculty/faculty-and-staff-directory/affiliate-professor'>Affiliate Professors</a></div>
<div class='col-md-4'><a href='/uflaw-faculty/faculty-and-staff-directory/adjunct-faculty'>Adjunct Faculty</a></div>
</div>
<div class='row'>
<div class='col-md-4'><a href='/uflaw-faculty/faculty-and-staff-directory/visiting-faculty'>Visiting Faculty</a></div> 
</div>
<div class='row'>&nbsp;</div><div id='faculty-directory-nav'><div class='row'>";
  $output = "<div id='faculty-directory'>";
  $alphabet = array( 'A' => array(), 
                'B' => array(),
                'C' => array(),
                'D' => array(),
                'E' => array(),
                'F' => array(),
                'G' => array(),
                'H' => array(),
                'I' => array(),
                'J' => array(),
                'K' => array(),
                'L' => array(),
                'M' => array(),
                'N' => array(),
                'O' => array(),
                'P' => array(),
                'Q' => array(),
                'R' => array(),
                'S' => array(),
                'T' => array(),
                'U' => array(),
                'V' => array(),
                'W' => array(),
                'X' => array(),
                'Y' => array(),
                'Z' => array() ); 
  /*
   * Gather all taxonomy terms for search
   */

  $uflaw_terms = get_terms( 'uflaw_faculty_tags' );
  $term_output ="<div class='col-sm-6'><select class='styled slug-search' data-initial-option='Expertise' name='expert-slug'>";
  $searched_term = '';
  $searched = '';
  if( $expert_search ){
     $searched = $wp_query->query_vars['expertise']; 
     $searched_term = get_term_by('slug', $searched, 'uflaw_faculty_tags');
     $term_output .= "<option value='" . $searched . "'>" . $searched_term->name  . "</option>";
  } else { 
     $term_output .= "<option value=''>Expertise</option>";
  }
  foreach($uflaw_terms as $term){
    $term_taxonomy=$term->taxonomy;
    $term_slug=$term->slug;
    $term_name =$term->name;
    $link = $term_slug;
    if( $term_slug != 'exclude' ){
      $term_output .="<option value='".$link."'>".$term_name."</option>";
    }
  }  
  $term_output .="</select></div>";

  $nav_output .= $term_output;
  $nav_output .= "<div class='col-sm-6'><p id='expert-search-wrap'><input type='text' id='experts-search' placeholder='Search by name' /><button class='btn-search'><span class='icon-svg'><svg><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='" . UFL_ATHENA_IMG_DIR . "/spritemap.svg#search'></use></svg></span></button></p></div></div><div class='row'><div class='col-sm-12'>";

  if( $expert_search ){
    $nav_output .= "<div class='faculty-directory-results'>" . count($query->posts) . " Experts found for '" . $searched_term->name . "'";
    $nav_output .= "<span class='close'>&times;</span></div>";
  }
  /*
   * Sort faculty information by last name
   */

  if( $query->have_posts() ) {
    while ($query->have_posts()) { $query->the_post();
      $letter = substr( strtoupper( trim( get_field( 'last-name' ) ) ), 0 , 1 );

      $member = array(
        'name'    => get_the_title(),
        'link'    => get_permalink(),
        'ssrn'    => get_field( 'ssrn' ),
        'works'   => get_field( 'selected_works' ),
        'image'   =>  wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()  ), 'medium' ), 
        'terms'   => wp_get_post_terms( get_the_ID(), 'uflaw_faculty_tags' ),
        'titles'  => get_field( 'titles' )
      );
      array_push( $alphabet[$letter], $member );
    }
      wp_enqueue_script( 'uflaw-directory', get_template_directory_uri() . '/assets/js/uflaw-directory.js', array('jquery'), get_theme_version(), true );
  }

  /*
   * Loop through all letters with faculty members
   */
  
  $nav_output .= "<ul id='faculty-alpha-select'>";
  $nav_count = 0;
  foreach( $alphabet as $key=>$value ){
    if( sizeof( $value ) > 0 ){
      $nav_count++;
      $item_nav = "<li class='directory-nav'><a href='#$key' data-target='$key'>$key</a></li>\n"; 
      $nav_output .= $item_nav;
      $item = "<div class='directory-item default' data-id='$key'>\n";

      /*
       * foreach letter, loop through each faculty member
       */

      foreach( $value as $indv ){
        $item .= "<div class='directory-entry col-sm-6'>\n";
        $item .= "<div class='col-sm-3'><img class='directory-img img-full' src='" . $indv['image'][0] . "'></div>\n";
        $item .= "<div class='col-sm-9'><a href='" . $indv['link'] . "'><h4>" . $indv['name'] . "</h4></a>\n";
        if( $indv['ssrn'] ) {
          $item .= "<h5><a target='_blank' href='" . $indv['ssrn'] . "'>SSRN</a></h5>\n";
        }
        if( $indv['works'] ) {
          $item .= "<h5><a target='_blank'href='" . $indv['works'] . "'>bepress (SelectedWorks)</a></h5>\n";
        }
        foreach( $indv['titles'] as $title ){
          if( strlen($title['title']) > 0 ){
            $item .= "<p>" . $title['title'] . "</p>\n";
          }
        }
        if( $indv['terms'] ){
          $item .= "<p>Expertise: ";
          foreach( $indv['terms'] as $term ){
            $item .= '<a href="/experts-guide/' . $term->slug. '">' . $term->name . ' </a><span class="separator">&nbsp;&bull;&nbsp;</span>';
          }
          $item .= "</p>";
        }
        $item .= "<h5><a href='" . $indv['link'] . "'>Faculty profile</a></h5>\n";
        $item .= "</div></div><!-- ./directory-entry -->\n";
      }
      $item .= "</div><!-- ./directory-item -->\n";
      $output .= $item;
    }
  }
  $nav_output .= "</ul></div></div></div>\n";
  $output .= "</div><!-- ./faculty-directory -->\n";

  if( $expert_search ){
    echo "<div id='faculty-directory-shortcode' class='expert-search'>";
  } else {
    echo "<div id='faculty-directory-shortcode'>";
  }
  $nav_item_width = 100 / $nav_count;
  echo "<style>@media screen and (min-width: 992px){#faculty-directory-shortcode #faculty-directory-nav .directory-nav{ width: {$nav_item_width}%; }}</style>";
  echo $nav_output;
  echo $output;
  echo "</div></div><!-- ./faculty-directory-shortcode -->";
}
add_shortcode( 'uflaw-directory', 'uflaw_faculty_directory_shortcode' );




/*
 * uflaw row/columns 
 * Modified from marshall theme to adhere to Bootstrap 3.x grid 
 */

function ufl_row( $atts, $content = null ){
  extract( shortcode_atts(  array(
    'columns' => '',  
    ), $atts ) );

  // Define a global variable to pass to internal.
  $GLOBALS[ 'ufl_columns' ] = $columns;

  $output = '<div class="ufl_columns row">' . do_shortcode( $content ) . '</div>';

  return $output;
}

// Internal 
function ufl_column( $atts, $content = null ) {

  // Bring in global variable from the wrapper.
  $columns  = $GLOBALS[ 'ufl_columns' ];

  // Counter
  static $count = 0;
  $count++;

  // Translate number of columns to proper class and give the first of each row an alpha class.
  if ( $columns == '' || $columns == 1 ) {
    $columns = 'col-sm-12';
  }

  elseif ( $columns == 2 ) {
    $columns = 'col-sm-6';
  }

  elseif ( $columns == 3 ) {
    $columns = 'col-sm-4';
  }

  elseif ( $columns == 'left' ) {
    if ( $count == 1 ){
      $columns = 'col-sm-6';
    }
    else {
      $columns = 'col-sm-8';
    }
  }

  elseif ( $columns == 'right' ) {
    if ( $count == 1 ){
      $columns = 'col-sm-6';
    }
    else {
      $columns = 'col-sm-8';
    }
  }

  $output = '<div class="columns ' . $columns . '">' . do_shortcode( $content ) . '</div>';

  return $output;
}

add_shortcode('ufl_row', 'ufl_row');
add_shortcode('ufl_column', 'ufl_column');

// Remove the defualt WP gallery shortcode.
remove_shortcode( 'gallery' , 'gallery_shortcode' );

// Add the UFL customized shortcode.
add_shortcode('gallery', 'ufl_gallery');

function ufl_gallery($attr) {
  
  // Enqueue: lightbox.js
  wp_enqueue_script( 'lightbox' );


  $post = get_post();

  static $instance = 0;
  $instance++;

  if ( ! empty( $attr['ids'] ) ) {
    // 'ids' is explicitly ordered, unless you specify otherwise.
    if ( empty( $attr['orderby'] ) )
      $attr['orderby'] = 'post__in';
    $attr['include'] = $attr['ids'];
  }

  // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
  if ( isset( $attr['orderby'] ) ) {
    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    if ( !$attr['orderby'] )
      unset( $attr['orderby'] );
  }

  extract(shortcode_atts(array(
    'order'      => 'ASC',
    'orderby'    => 'menu_order ID',
    'id'         => $post ? $post->ID : 0,
    'itemtag'    => 'dl',
    'icontag'    => 'dt',
    'captiontag' => 'dd',
    'columns'    => 4,
    'size'       => 'thumbnail',
    'include'    => '',
    'exclude'    => ''
  ), $attr, 'gallery'));

  $id = intval($id);
  if ( 'RAND' == $order )
    $orderby = 'none';

  if ( !empty($include) ) {
    $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

    $attachments = array();
    foreach ( $_attachments as $key => $val ) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  } elseif ( !empty($exclude) ) {
    $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  } else {
    $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  }

  if ( empty($attachments) )
    return '';

  if ( is_feed() ) {
    $output = "\n";
    foreach ( $attachments as $att_id => $attachment )
      $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
    return $output;
  }

  $itemtag = tag_escape($itemtag);
  $captiontag = tag_escape($captiontag);
  $icontag = tag_escape($icontag);
  $valid_tags = wp_kses_allowed_html( 'post' );
  if ( ! isset( $valid_tags[ $itemtag ] ) )
    $itemtag = 'dl';
  if ( ! isset( $valid_tags[ $captiontag ] ) )
    $captiontag = 'dd';
  if ( ! isset( $valid_tags[ $icontag ] ) )
    $icontag = 'dt';

  $columns = intval($columns);
  $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
  $float = is_rtl() ? 'right' : 'left';

  $selector = "gallery-{$instance}";

  $gallery_style = $gallery_div = '';
  if ( apply_filters( 'use_default_gallery_style', true ) )
    $gallery_style = "
    <style type='text/css'>
      #{$selector} {
        margin: auto;
      }
      #{$selector} .gallery-item {
        float: {$float};
        margin-top: 10px;
        text-align: center;
        width: {$itemwidth}%;
      }
      #{$selector} img {
        border: 2px solid #cfcfcf;
      }
      #{$selector} .gallery-caption {
        margin-left: 0;
      }
    </style>";
  $size_class = sanitize_html_class( $size );
  $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
  $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
  
  $i = 0;
  foreach ( $attachments as $id => $attachment ) {

    // Lightbox variables ready to inject into image links.
    $lightbox_caption = 'data-title="' . wptexturize( $attachment->post_title ) . '"';
    $lightbox = '<a data-lightbox="' . $selector . '" ' . $lightbox_caption;

    $image_output = wp_get_attachment_link( $id, $size, false, false );
    
    // Add the lightbox data attribute 
    $image_output = str_replace( '<a' , $lightbox , $image_output );

    $image_meta  = wp_get_attachment_metadata( $id );

    $orientation = '';
    if ( isset( $image_meta['height'], $image_meta['width'] ) )
      $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

    $output .= "<{$itemtag} class='gallery-item'>";
    $output .= "
      <{$icontag} class='gallery-icon {$orientation}'>
        $image_output
      </{$icontag}>";
    $output .= "</{$itemtag}>";
    if ( $columns > 0 && ++$i % $columns == 0 )
      $output .= '<br style="clear: both" />';
  }

  $output .= "
      <br style='clear: both;' />
    </div>\n";

  return $output;
}


function ufl_button($atts, $content = null) {
  extract( shortcode_atts(
    array(
      'text'      => 'button',
      'link'      => '#',
      'size'      => 'small',
      'color'     => 'grey',
      ), $atts )
  );


  $output  = '<a class="btn btn--'. $color . '" href="'. $link .'">' . $text;
  $output .= '<span class="arw-right icon-svg"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="' . UFL_ATHENA_IMG_DIR .'/spritemap.svg#arw-right"></use></svg></span>';
  $output .= '</a>';

  return $output;
}

add_shortcode("ufl_button", "ufl_button");

