<?php get_header(); ?>
<article id="main-content" class="container post-content-box" role="main">
  <div class="col-sm-12">
    <h1 class="page-title ">Courses</h1>
    <p id="course-search-wrap"><input type="text" id="courses-search">
      <button class="btn-search">
        <span class="icon-svg">
          <svg>
          <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?php echo UFL_ATHENA_IMG_DIR; ?>/spritemap.svg#search"></use>
          </svg>
        </span>
      </button>
    </p>
    <?php do_shortcode( '[uflaw-courses]' ); ?> 
  </div>
</article><!-- end #main-content --> 
<?php get_footer(); ?>
