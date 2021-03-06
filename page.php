<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div id="main" <?php post_class('page'); ?>>
  <div class="container post-content-box">
    <div class="row">
      <?php ufl_athena_breadcrumbs(); ?>
      <div class="col-sm-12">
        <h1><?php the_title();  ?><?php ufl_athena_post_status_message(get_the_id()); ?></h1>
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
      </div>
      <!-- End Main Content -->
  </div><!-- ./container -->
</div><!-- ./main -->

<?php endwhile // the_post ?>
<?php get_footer(); ?>
