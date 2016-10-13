<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php
  $title = (get_field( 'title_override' ) ? get_field( 'title_override' ) : get_the_title());
  $image =  wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); 
?>
<div id="main" <?php post_class('post'); ?>>
  <article class="container post-content-box">
      <!-- Begin Main Content -->
      <div class="col-sm-12">
        <a href="/courses/">⇠ Back to Courses Overview</a>
        <h1><?php echo $title; ?><?php ufl_athena_post_status_message(get_the_id()); ?></h1>
      </div>
      <div class="col-md-9">
        <div class="entry">
<?php
      $link           = get_permalink();
      $title          = get_the_title(); 
      $credits        = get_field( 'credits' );
      $description    = get_field( 'description' ); 
      $course_number  = get_field( 'course_number' );
?>
           <p>
            <strong>Course Number: </strong><span class="course-number"><?php echo $course_number; ?></span>
            <strong>Credits: </strong><span class="course-credits"><?php echo $credits; ?></span>
          </p>
          <div>
            <?php if( have_rows( 'prerequisites' ) ): ?>
              <p><strong>Prerequisites</strong>:<ul>
              <?php while ( have_rows( 'prerequisites' ) ) : the_row(); ?>
                <?php
                  $preq   = get_sub_field( 'prerequisite' );
                  $title  = $preq->post_title;
                  $num    = get_field( 'course_number', $preq->ID );
                  $preq_out = "<li>" . $title . "(" . $num . ")</li>";
                  echo $preq_out;
                ?>
              <?php endwhile // the_row ?> 
              </ul></p>
            <?php endif // preqs ?>
            <?php echo $description; ?> 
          </div>
          </p>
      </div><!-- end .entry -->
       
      </div>
      <!-- End Main Content -->
      <!-- Begin Sidenav -->
      <div class="col-md-3">
        <?php get_sidebar( 'course_sidebar' ); ?>
      </div>
      <!-- End Sidenav -->
    </article><!-- ./post-content-box -->
    </div>
  </div>
</div>
<?php endwhile // the_post ?>
<?php get_footer(); ?>
