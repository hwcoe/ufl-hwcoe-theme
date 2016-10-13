<div class="footer-wrap">

  <div class="footer-top">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <ul class="footer-audience-nav">
            <?php if( have_rows( 'footer_buttons', 'option' ) ): ?>
              <?php while ( have_rows( 'footer_buttons', 'option' ) ) : the_row(); ?>
              <?php $button_link = ( 'internal' == get_sub_field( 'internal_or_external_link' ) ? get_sub_field( 'internal_link' ) : get_sub_field( 'external_url' ) ); ?>
                <li><a href="<?php echo $button_link; ?>"><?php the_sub_field( 'button_text' ); ?></a></li>
              
              <?php endwhile // the_row ?>
            <?php endif // have_rows ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="container">
      <div class="row">

        <div class="col-md-4 col-md-push-8 footer-contact-wrap">
        <a href="http://ufl.edu/" class="footer-logo icon-svg"><svg><use xlink:href="<?php echo UFL_ATHENA_IMG_DIR; ?>/spritemap.svg#florida-logo-full"></use></svg><span class="visuallyhidden">University of Florida</span></a>
          <ul class="social-nav">
            <li><a href="<?php the_field( 'facebook', 'option' ); ?>" class="btn-circle icon-svg icon-facebook"><svg><use xlink:href="<?php echo UFL_ATHENA_IMG_DIR; ?>/spritemap.svg#facebook"></use></svg><span class="visuallyhidden">Facebook</span></a></li>
            <li><a href="<?php the_field( 'twitter', 'option' ); ?>" class="btn-circle icon-svg icon-twitter"><svg><use xlink:href="<?php echo UFL_ATHENA_IMG_DIR; ?>/spritemap.svg#twitter"></use></svg><span class="visuallyhidden">Twitter</span></a></li>
            <li><a href="<?php the_field( 'instagram', 'option' ); ?>" class="btn-circle icon-svg icon-instagram"><svg><use xlink:href="<?php echo UFL_ATHENA_IMG_DIR; ?>/spritemap.svg#instagram"></use></svg><span class="visuallyhidden">Instagram</span></a></li>
            <li><a href="<?php the_field( 'youtube', 'option' ); ?>" class="btn-circle icon-svg icon-youtube"><svg><use xlink:href="<?php echo UFL_ATHENA_IMG_DIR; ?>/spritemap.svg#youtube"></use></svg><span class="visuallyhidden">YouTube</span></a></li>
            <li><a href="<?php the_field( 'linkedin', 'option' ); ?>" class="btn-circle icon-svg icon-linkedin" title="LinkedIn"><svg viewBox="0 0 512 512"><path d="M186.4 142.4c0 19-15.3 34.5-34.2 34.5 -18.9 0-34.2-15.4-34.2-34.5 0-19 15.3-34.5 34.2-34.5C171.1 107.9 186.4 123.4 186.4 142.4zM181.4 201.3h-57.8V388.1h57.8V201.3zM273.8 201.3h-55.4V388.1h55.4c0 0 0-69.3 0-98 0-26.3 12.1-41.9 35.2-41.9 21.3 0 31.5 15 31.5 41.9 0 26.9 0 98 0 98h57.5c0 0 0-68.2 0-118.3 0-50-28.3-74.2-68-74.2 -39.6 0-56.3 30.9-56.3 30.9v-25.2H273.8z"/></svg><!--[if lt IE 9]><em>LinkedIn</em><![endif]--></a></li>

          </ul>
          <p class="address"><?php the_field( 'address', 'option' ); ?></p>
        </div>

        <div class="col-md-8 col-md-pull-4">
          <div class="row">
            <?php if( get_field( 'override_footer_coloumns', 'option' ) ): ?>
              <?php while ( have_rows( 'footer_columns', 'option' ) ) : the_row(); ?>
                <div class="col-md-<?php the_sub_field( 'columns' ); ?> col-sm-<?php the_sub_field( 'columns' ); ?> footer-menu">
                  <h2><?php the_sub_field( 'heading' ); ?> <span class="icon-svg icon-caret"><svg><use xlink:href="<?php echo UFL_ATHENA_IMG_DIR; ?>/spritemap.svg#caret"></use></svg></span></h2>
                  <?php the_sub_field( 'list_items' ); ?>
                </div>
              <?php endwhile // footer_columns ?>
            <?php else: ?>
            <div class="col-md-4 col-sm-4 footer-menu">
            <h2>Resources <span class="icon-svg icon-caret"><svg><use xlink:href="<?php echo UFL_ATHENA_IMG_DIR; ?>/spritemap.svg#caret"></use></svg></span></h2>
              <ul>
                <li><a href="#">ISIS</a></li>
                <li><a href="#">Webmail</a></li>
                <li><a href="#">myUFL</a></li>
                <li><a href="#">eLearning</a></li>
                <li><a href="#">Directory</a></li>
              </ul>
            </div>
            <div class="col-md-4 col-sm-4 footer-menu">
            <h2>Campus <span class="icon-svg icon-caret"><svg><use xlink:href="<?php echo UFL_ATHENA_IMG_DIR; ?>/spritemap.svg#caret"></use></svg></span></h2>
              <ul>
                <li><a href="#">Weather</a></li>
                <li><a href="#">Campus Map</a></li>
                <li><a href="#">Student Tours</a></li>
                <li><a href="#">Academic Calendar</a></li>
                <li><a href="#">Events</a></li>
              </ul>
            </div>
            <div class="col-md-4 col-sm-4 footer-menu">
            <h2>Website <span class="icon-svg icon-caret"><svg><use xlink:href="<?php echo UFL_ATHENA_IMG_DIR; ?>/spritemap.svg#caret"></use></svg></span></h2>
              <ul>
                <li><a href="#">About This Site</a></li>
                <li><a href="#">Website Listing</a></li>
                <li><a href="#">Accessibility</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Regulations</a></li>
              </ul>
            </div>
          </div>
        </div>
        <?php endif //override_footer_coloumns ?>
      </div>
    </div>
  </div>
</div>
<a href="#0" class="cd-top"></a>
<?php wp_footer(); ?>
<?php
if( get_field( 'include_pure_chat' ) ){
    include_once( 'assets/php/modules/ufl-purechat.php' );
}
?>
<script>
<?php 
  // Make the image directory available to JS
?>
  var uflAthenaImgDir = '<?php echo UFL_ATHENA_IMG_DIR; ?>';
</script>
</body>
</html>
