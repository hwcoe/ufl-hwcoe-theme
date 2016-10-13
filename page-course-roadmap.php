<?php
/*
Template Name: Course Roadmap
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

        <div class="container">
          <?php if( get_field( 'core_courses' ) ): ?>
            <div class="col-sm-3">
              <h4>Core Courses</h4>
              <?php foreach( get_field( 'core_courses' ) as $course ): ?>
                <?php 
                  $name = get_the_title( $course );
                  $link = get_permalink( $course );
                  $number = get_field( 'course_number', $course );
                  $credits = get_field( 'credits', $course );
                ?>
                <div class="roadmap-course">
                  <p><a href="<?php echo $link; ?>"><?php echo $name; ?></a></p>
                    <?php echo $number; ?> | 
                    <?php echo $credits; ?>
                    Credits
                  </p>
                </div>
              <?php endforeach // core_course ?>
            </div>
          <?php endif // core_courses ?>
          <?php if( get_field( 'elective_courses' ) ): ?>
            <div class="col-sm-3">
              <h4>Elective Courses</h4>
              <?php foreach( get_field( 'elective_courses' ) as $course ): ?>
                <?php 
                  $name = get_the_title( $course );
                  $link = get_permalink( $course );
                  $number = get_field( 'course_number', $course );
                  $credits = get_field( 'credits', $course );
                ?>
                <div class="roadmap-course">
                  <p><a href="<?php echo $link; ?>"><?php echo $name; ?></a></p>
                    <?php echo $number; ?> | 
                    <?php echo $credits; ?>
                    Credits
                  </p>
                </div>
              <?php endforeach // core_course ?>
            </div>
          <?php endif // elective_courses ?>
          <?php if( get_field( 'highly_supportive' ) ): ?>
            <div class="col-sm-3">
              <h4>Highly Supportive</h4>
              <?php foreach( get_field( 'highly_supportive' ) as $course ): ?>
                <?php 
                  $name = get_the_title( $course );
                  $link = get_permalink( $course );
                  $number = get_field( 'course_number', $course );
                  $credits = get_field( 'credits', $course );
                ?>
                <div class="roadmap-course">
                  <p><a href="<?php echo $link; ?>"><?php echo $name; ?></a></p>
                    <?php echo $number; ?> | 
                    <?php echo $credits; ?>
                    Credits
                  </p>
                </div>
              <?php endforeach // core_course ?>
            </div>
          <?php endif // highly_supportive ?>
          <?php if( get_field( 'skills_courses' ) ): ?>
            <div class="col-sm-3">
              <h4>Skills Courses</h4>
              <?php foreach( get_field( 'skills_courses' ) as $course ): ?>
                <?php 
                  $name = get_the_title( $course );
                  $link = get_permalink( $course );
                  $number = get_field( 'course_number', $course );
                  $credits = get_field( 'credits', $course );
                ?>
                <div class="roadmap-course">
                  <p><a href="<?php echo $link; ?>"><?php echo $name; ?></a></p>
                  <p class="pull-right">
                    <?php echo $number; ?> | 
                    <?php echo $credits; ?>
                    Credits
                  </p>
                </div>
              <?php endforeach // core_course ?>
            </div>
          <?php endif // skills_courses ?>
          </div><!-- ./container -->
            
        <?php the_content(); ?>
        
      </div>
    </div><!-- End Main Content -->
  </div><!-- ./container -->
</div><!-- ./main -->

<?php endwhile // the_post ?>
<?php get_footer(); ?>
