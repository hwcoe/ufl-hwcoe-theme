<?php
/*
Template Name: ChatWidget-Landing Page 
 */
?>
<?php
  get_header(); 
?>
<?php while ( have_posts() ) : the_post(); ?>
<?php
  $landing_page_style = get_field( 'landing_page_style' ); 
?>
<?php if( 'double-image' == $landing_page_style ): ?>
  <?php
    /*
     * Landing Page with Double Graphics  
     */
  ?>
  <?php include( UFL_ATHENA_INC_DIR . '/ufl-landing-page-double.php' ); ?>
<?php elseif( 'hero-image' === $landing_page_style ): ?>
  <?php
    /*
     * Landing Page with Single Hero Graphic 
     */
  ?>
  <?php include( UFL_ATHENA_INC_DIR . '/ufl-landing-page-single.php' ); ?>
<?php endif // landing_page_style ?>

<?php if( have_rows('landing_page_modules') ): ?>
  <?php while ( have_rows('landing_page_modules') ) : the_row(); ?>
    <?php
      /*
       * Secondary Module
       * Modular- can be used multiple times
       */
      ?>
    <?php if( get_row_layout() == 'secondary_module' ): ?>
        <?php include( UFL_ATHENA_INC_DIR . '/ufl-secondary.php' ); ?>
    <?php endif // secondary_module ?>
    <?php
      /*
       * Secondary with Image Module
       * Modular- can be used multiple times
       */
      ?>
    <?php if( get_row_layout() == 'secondary_with_image' ): ?>
        <?php include( UFL_ATHENA_INC_DIR . '/ufl-secondary-image.php' ); ?>
    <?php endif // secondary_module ?>
    <?php
      /*
       * Statistics Wide Module
       * Up to 6 statistics, depending on row count 
       */
      ?>
    <?php if( get_row_layout() == 'staistics_wide' ): ?>
        <?php include( UFL_ATHENA_INC_DIR . '/ufl-statistics-wide.php' ); ?>
    <?php endif // secondary_module ?>
    <?php
      /*
       * Category Content Module 
       * Get recent post, or add content 
       */
      ?>
    <?php if( get_row_layout() == 'category_content' ): ?>
        <?php include( UFL_ATHENA_INC_DIR . '/ufl-category-content.php' ); ?>
    <?php endif // secondary_module ?>
    <?php
      /*
       * Image Callout
       * Three image callout
       */
      ?>
    <?php if( get_row_layout() == 'triple_image_callout' ): ?>
        <?php include( UFL_ATHENA_INC_DIR . '/ufl-image-callout.php' ); ?>
    <?php endif // secondary_module ?>
    <?php
      /*
       * Content Block with Quote 
       */
      ?>
    <?php if( get_row_layout() == 'secondary_content_with_quote_block' ): ?>
        <?php include( UFL_ATHENA_INC_DIR . '/ufl-secondary-quote.php' ); ?>
    <?php endif // secondary_module ?>
    <?php
      /*
       * General Content- No Formatting 
       */
      ?>
    <?php if( get_row_layout() == 'general_content' ): ?>
        <?php include( UFL_ATHENA_INC_DIR . '/ufl-content.php' ); ?>
    <?php endif // secondary_module ?>
    <?php
      /*
       * General Content- Image
       * Left or Right justified image
       */
      ?>
    <?php if( get_row_layout() == 'general_content_with_image' ): ?>
        <?php include( UFL_ATHENA_INC_DIR . '/ufl-content-image.php' ); ?>
    <?php endif // secondary_module ?>
    <?php
      /*
       * List Sub-Pages
       */
      ?>
    <?php if( get_row_layout() == 'list_sub_pages' ): ?>
        <?php include( UFL_ATHENA_INC_DIR . '/ufl-sub-page-list.php' ); ?>
    <?php endif // secondary_module ?>
    <?php
      /*
       * List Posts from category
       */
      ?>
    <?php if( get_row_layout() == 'archive_content' ): ?>
        <?php include( UFL_ATHENA_INC_DIR . '/ufl-landing-page-archive.php' ); ?>
    <?php endif // secondary_module ?>
     <?php
      /*
       * List Faculty Archive
       */
      ?>
    <?php if( get_row_layout() == 'faculty_archive_content' ): ?>
        <?php include( UFL_ATHENA_INC_DIR . '/ufl-landing-page-archive-faculty.php' ); ?>
    <?php endif // secondary_module ?>
  
     <?php
      /*
       * Profiles 
       */
      ?>
    <?php if( get_row_layout() == 'profile_module' ): ?>
        <?php include( UFL_ATHENA_INC_DIR . '/ufl-profile-page.php' ); ?>
    <?php endif // secondary_module ?>
 
  

 







  <?php endwhile // the_row ?>
<?php endif // have_rows ?>
<?php endwhile // the_post ?>
<?php
    get_footer();    
    include('footer_purechat.php');
?>

