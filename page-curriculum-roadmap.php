<?php
/*
Template Name: Landing Page 
 */
?>
<?php
  get_header(); 
?>
<?php while ( have_posts() ) : the_post(); ?>
  <?php 
    $page = get_field( 'roadmap' );
  ?>


<?php endwhile // the_post ?>
<?php
  get_footer();
?>

