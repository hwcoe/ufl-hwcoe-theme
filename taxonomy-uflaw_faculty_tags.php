<?php get_header(); ?>
<?php 
  $terms = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
  $taxonomy = $terms->taxonomy;
  $slug = $terms->slug;
  $name = $terms->name;
  $args = array(
    'post_type' => 'uflaw_faculty',
    $taxonomy => $slug,
    'meta_key' => 'last-name',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'posts_per_page' =>-1,
     'tax_query'      => array(
       array(
         'taxonomy'  => 'uflaw_faculty_tags',
         'field'     => 'slug',
         'terms'      => 'exclude',
         'operator'  =>'NOT IN',
        ),
     )
  );
  $query = new WP_Query( $args );
?>
<article id="main-content" class="container post-content-box" role="main">
  <h1 class="page-title ">Faculty Expertise: <span class="light-blue"><?php echo $name; ?></span></h1>
  <div class="col-sm-9">
  <?php if( $query->have_posts() ): ?>
    <?php while ($query->have_posts()) : $query->the_post(); ?>
      <div class="entry">
        <div class="archive-content">
          <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>  
          <?php if( has_post_thumbnail() ){ the_post_thumbnail('thumbnail');} ?>
          <?php echo (get_field( 'ssrn' ) ? "<p class='ssrn'><a href='" . get_field( 'ssrn' ) . "'>SSRN</a></p>" : ''); ?>
          <?php echo (get_field( 'selected_works' ) ? "<p class='selected-works'><a href='" . get_field( 'selected_works' ) . "'>Selected Works</a></p>" : ''); ?>
          <?php while ( have_rows( 'titles' ) ) : the_row(); ?>
            <p class="title"><?php  the_sub_field( 'title' ); ?></p>
            <?php break // only show the first title ?>
          <?php endwhile // the_row ?>
          <p>
          <?php echo (get_field( 'email' ) ? "Email: <a href='" . get_field( 'email' ) . "'>" . get_field( 'email' ) . "</a>" : ''); ?>
          <?php echo (get_field( 'phone' ) ? "Phone: <a href='tel:" . get_field( 'phone' ) . "'>" . get_field( 'phone' ) . "</a>" : ''); ?>
          </p>
          <?php 
            $expertises = wp_get_post_terms( $post->ID, 'uflaw_faculty_tags' );
            $expertise_output = '';
            foreach ($expertises as $expertise) {
              $expertise_output .= '<a href="/experts-guide/' . $expertise->slug.'">' . $expertise->name.' </a><span class="separator">&nbsp;&bull;&nbsp;</span>';
            }
          ?>
          <p>Expertise: <?php echo $expertise_output; ?></p>
        </div>
      </div><!-- end .entry -->
      <hr />

     
    <?php endwhile // the_post ?>
  <?php endif // have_posts ?>
  </div>
  <div class="col-sm-3">
  <?php
    $taxonomy = 'uflaw_faculty_tags';
    $tax_terms = get_terms( $taxonomy );
  ?>
    <h4>Browse Expertises</h4>
    <select class="styled slug-search" data-initial-option="Faculty Expertise">
      <?php foreach( $tax_terms as $term ) {
        echo '<option value="' . $term->slug . '">' . $term->name . '</option>'; 
      } ?>
    </select>
  </div>
</article><!-- end #main-content --> 
<?php
  wp_enqueue_script( 'uflaw-experts', get_template_directory_uri() . '/assets/js/uflaw-experts.js', array('jquery'), get_theme_version(), true );
?>
<?php get_footer(); ?>
