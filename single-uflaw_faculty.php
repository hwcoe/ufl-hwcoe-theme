<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div id="main" <?php post_class('page'); ?>>
  <div class="container post-content-box faculty-single">
    <?php if( has_post_thumbnail() ): ?>
      <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' ); ?>
      <img src="<?php echo $image[0]; ?>" class="faculty-portrait m-bottom">
    <?php endif // has_post_thumbnail ?>
      <h1><?php the_title();  ?><?php ufl_athena_post_status_message(get_the_id()); ?></h1>
    <?php if( have_rows( 'titles' ) ): ?>
      <div id="title-container">
        <?php while ( have_rows( 'titles' ) ) : the_row(); ?>
         <h5 class="title"><?php  the_sub_field( 'title' ); ?></h5>
        <?php endwhile // the_row ?>
      </div>
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2" id="info-container">
          <div class="col-sm-6 info-left">
            <?php echo (get_field( 'vita' ) ? "<p class='vita'><a target='_blank' href='" . get_field( 'vita' ) . "'>Vita</a></p>" : ''); ?>
            <?php echo (get_field( 'ssrn' ) ? "<p class='ssrn'><a target='_blank' href='" . get_field( 'ssrn' ) . "'>SSRN</a></p>" : ''); ?>
            <?php echo (get_field( 'selected_works' ) ? "<p class='selected_works'><a target='_blank' href='" . get_field( 'selected_works' ) . "'>bepress (SelectedWorks)</a></p>" : ''); ?>
            <?php echo (get_field( 'personal_website' ) ? "<p class='selected_works'><a target='_blank'  href='" . get_field( 'personal_website' ) . "'>Personal Website</a></p>" : ''); ?>
            <?php echo (get_field( 'blog' ) ? "<p class='selected_works'><a target='_blank'  href='" . get_field( 'blog' ) . "'>Blog</a></p>" : ''); ?>


          </div>
          <div class="col-sm-6 info-right">
            <?php echo (get_field( 'address' ) ? "<p class='address'><strong>Mailing Address:</strong><br>" . get_field( 'address' ) . "</p>" : ''); ?>
            <?php echo (get_field( 'email' ) ? "<p class='email'><strong>Email:</strong><br><a href='mailto:" . get_field( 'email' ) . "'>" . get_field( 'email' ) . "</a></p>" : ''); ?>
            <?php echo (get_field( 'phone' ) ? "<p class='phone'><strong>Phone:</strong><br>" . get_field( 'phone' ) . "</p>" : ''); ?>
            <?php /*commenting out the fax, but leaving in case someone wants it back  echo (get_field( 'fax' ) ? "<p class='fax'><strong>Fax:</strong><br>" . get_field( 'fax' ) . "</p>" : '');*/ ?>
          </div>
        </div>
      </div>
      <?php
          $expertises = wp_get_post_terms( $post->ID, 'uflaw_faculty_tags' );
            $expertise_output = '';
            foreach ($expertises as $expertise) {
              if( 'exclude' != $expertise->slug ){
              $expertise_output .= '<a href="/experts-guide/' . $expertise->slug.'">' . $expertise->name.' </a> <span class="separator">&nbsp;&bull;&nbsp;</span>';
              }
            }
          ?>
          <?php if( $expertise_output ): ?>
          <div class="expertise">
            <h2>Expertise</h2>
            <p><?php echo $expertise_output; ?></p>
          </div>
          <?php endif //expertise_output ?>
      <div class="about"> 
        <h2>About</h2>
        <?php the_content(); ?>
      </div>
      <?php if( have_rows( 'courses' ) ): ?>
        <div class="courses"> 
          <h2>Courses</h2>
          <?php foreach( get_field( 'courses' ) as $course ): ?>
          <?php
            $name = "<a href='" .  get_permalink( $course ) . "'>" . get_the_title( $course ) . " - " . get_field( 'course_number', $course ) . "</a>";
            $description = strip_tags( get_field( 'shortened', $course ) ); 
          ?>
            <h5><?php echo $name; ?></h5>
            <ul>
              <li><?php echo $description; ?></li>
            </ul>
          <?php endforeach // courses ?>
        </div>
      <?php endif // courses ?>
      <?php if( get_field( 'publications' ) ): ?>
        <div class="publications">
          <h2>Publications</h2>
          <?php the_field( 'publications' ); ?>
        </div>
      <?php endif // publications ?>
    <?php endif // have_rows ?>
  </div><!-- ./container -->
</div><!-- ./main -->

<?php endwhile // the_post ?>
<?php get_footer(); ?>
