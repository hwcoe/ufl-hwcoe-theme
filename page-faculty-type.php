<?php
/* 
Template Name: Faculty Type
 */
?>
<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div id="main" <?php post_class('page'); ?>>
  <div class="container post-content-box">
    <div class="row">
      <?php ufl_athena_breadcrumbs(); ?>
      <div class="col-sm-12">
        <?php the_title( '<h1>', '</h1>' );  ?>
      </div>
    </div>
    <div class="row primary">
      <!-- Begin Side Navigation -->
      <div class="col-sm-3 sidenav-container">
        <div class="ul sidenav">
        <?php $sidebar = ufl_athena_sidebar_navigation($post); ?>
        <?php echo $sidebar; ?>
        </div>
      </div>
      <!-- End Side Navigation -->
      <!-- Begin Main Content -->
      <div class="col-sm-8">
        <?php if( has_post_thumbnail() && !get_field( 'hide_featured_image' ) ): ?>
          <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' ); ?>
          <img src="<?php echo $image[0]; ?>" class="img-full m-bottom">
        <?php endif // has_post_thumbnail ?>
        <?php the_content(); ?>
        <?php
          /*
           * Faculty type query 
           */        
        
        $types = get_field( 'faculty_type' ); 
        $term_args = array(
          array(
            'taxonomy'  => 'uflaw_faculty_types',
            'terms'     => $types,
            'operator'  =>'IN',
          ),
        );
        
        $args = array(
          'post_type' => 'uflaw_faculty',
          'meta_key' => 'last-name',
          'orderby' => 'meta_value',
          'order' => 'ASC',
          'posts_per_page' =>-1,
           'tax_query' => $term_args
        );
        $query = new WP_Query( $args );
        ?>
         
        <?php if( $query->have_posts() ): ?>
          <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class='directory-entry container'>
              <?php $img_arr = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' ); ?>
              <div class='col-sm-3'><img class='directory-img img-full' src='<?php echo $img_arr[0] ?>'></div>
              <div class='col-sm-9'><a href='<?php the_permalink(); ?>'><h4><?php the_title(); ?></h4></a>
                <?php if( get_field( 'ssrn' ) ): ?>
                  <a href='<?php the_field( 'ssrn' ); ?>'>SSRN</a>
                <?php endif // get_field ssrn ?>
                <?php while ( have_rows( 'titles' ) ) : the_row(); ?>
                  <p><?php the_sub_field( 'title' ); ?></p>
                <?php endwhile // the_row titles ?>
                <a href='<?php the_permalink(); ?>'>Link to Faculty Page</a>
              </div>
            </div>
<!-- ./directory-entry -->

          <?php endwhile // the_post faculty_type ?>
        <?php endif // have_posts faculty_type ?>
 
            </div>
      <!-- End Main Content -->
  </div><!-- ./container -->
</div><!-- ./main -->

<?php endwhile // the_post ?>
<?php get_footer(); ?>
