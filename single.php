<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php
  $title = (get_field( 'title_override' ) ? get_field( 'title_override' ) : get_the_title());
  $image =  wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); 
?>
<div id="main" <?php post_class('post'); ?>>
<?php if( get_field( 'use_hero_image_layout' ) ): ?>
  <div class="landing-page-hero-full">
  <div class="hero-img gradient-bg" style="background-image:url(<?php echo $image[0]; ?>)">
    <h1><?php echo $title; ?><?php ufl_athena_post_status_message(get_the_id()); ?></h1>
  </div>
  <?php if( get_field( 'hero_description_text' ) ): ?>
  <div class="hero-text">
    <div class="container">
      <div class="col-sm-8 col-sm-offset-2">
        <p><?php the_field( 'hero_description_text' ); ?></p>
      </div>
    </div>
  </div>
  <?php endif // hero_description_text ?>
</div>
<?php endif // use_hero_image_layout ?>
  <article class="container post-content-box">
      <!-- Begin Main Content -->
        <?php if( !get_field( 'use_hero_image_layout' ) ): ?>
        <div class="col-sm-12">
          <h1><?php echo $title; ?><?php ufl_athena_post_status_message(get_the_id()); ?></h1>
        </div>
        <div class="col-md-9">
          <?php if( has_post_thumbnail() && !get_field( 'hide_featured_image' ) ): ?>
          <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' ); ?>
            <img src="<?php echo $image[0]; ?>" class="img-full m-bottom">
          <?php endif // has_post_thumbnail ?>
        <?php endif // use_hero_image_layout ?>
        <?php the_content(); ?>
        <!-- Begin Single Meta -->
          <div class="single-meta">
            <?php the_tags('<p class="tag">Tagged as: ', ', ','</p>'); ?>
            <p class="published"><span><?php echo ( in_category( array('speeches','speech') ) ? 'Date:' : 'Published:' )?> </span><?php the_time('F jS, Y') ?></p>
            <p class="category"><span>Category:</span> <?php the_category(', ') ?></p>
          </div>
          <!-- End Single Meta -->
          <!-- Begin Comments -->
          <div id="comment-container">
            <?php comments_template(); ?>
          </div>  
          <!-- End Comments -->
        </div>
      <!-- End Main Content -->
      <?php if( !get_field( 'use_hero_image_layout' ) ): ?>
      <!-- Begin Sidenav -->
      <div class="col-md-3">
        <?php get_sidebar( 'post_sidebar' ); ?>
      </div>
      <!-- End Sidenav -->
      <?php endif //use_hero_image_layout ?>
    </article><!-- ./post-content-box -->
    <div class="container post-content-box">
      <div class="col-md-12 post-meta">
          <div class="col-sm-6 nav-previous"><?php previous_post_link('%link') ?></div>
          <div class="col-sm-6 nav-next"><?php next_post_link('%link') ?></div>
      </div><!-- ./post-meta -->
    </div>
  </div>
</div>
<?php endwhile // the_post ?>
<?php get_footer(); ?>
