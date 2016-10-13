<?php get_header(); ?>
<article id="main-content" class="container post-content-box" role="main">
        <div class="col-sm-12">
        <?php if (have_posts()) : ?>      
          <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
            <?php $cat = get_category( get_query_var( 'cat' ) );?>
          <?php /* If this is a category archive */ if (is_category()) { ?>
            <h1 class="page-title"><?php single_cat_title(); ?></strong>  <a title="Subscribe to <?php single_cat_title(); ?> RSS Feed" href="<?php echo get_home_url() . '/category/' . esc_html( $cat->slug ) . '/feed';?>"><img class="rss-icon" src="<?php echo UFL_ATHENA_IMG_DIR; ?>/rss-icon.png" alt="Subscribe to RSS Feed" /></a></h1>

          
          <?php } ?>
        </div>
        <div class="col-sm-9">
         <?php
              $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
              $events_query = new WP_Query(
                      array(
                          'posts_per_page'      => 10,
                          'ignore_sticky_posts' => true,
                          'category_name'       => 'past-events',
                          'meta_key'            => 'Event_Date',
                          'orderby'             => 'meta_value meta_value_num',
                          'order'               => 'desc',
                          'paged'               => $paged,
                      )  
              );
              
              while ($events_query->have_posts()) : $events_query->the_post();
                  //Get the value for the Meta Field "Event_Date"
                  $event_date= get_post_meta( get_the_ID(), 'Event_Date', true );
                  
                
                  /* Commenting out this for now, because I don't know if I'll need it for this site 
                  // check if the custom field has a value
                  if(! empty( $event_date)) {
                  
                  //extract the month number
                  $month_number=substr($event_date,4,2);
              
                  //convert the month number to a string
                  switch($month_number)
                  {
                      case "01" : $month_short="Jan";
                          break;
                      case "02" : $month_short="Feb";
                          break;
                      case "03" : $month_short="Mar";
                          break;
                      case "04" : $month_short="Apr";
                          break;
                      case "05" : $month_short="May";
                          break;
                      case "06" : $month_short="Jun";
                          break;
                      case "07" : $month_short="Jul";
                          break;
                      case "08" : $month_short="Aug";
                          break;
                      case "09" : $month_short="Sep";
                          break;
                      case "10" : $month_short="Oct";
                          break;
                      case "11" : $month_short="Nov";
                          break;
                      case "12" : $month_short="Dec";
                          break;
                  };
              
                  //extract the day from the value
                  $day_number=substr($event_date,6,2);
                  $year_number=substr($event_date,0,4);
              }
              */
      ?>

    <?php
    $currenttemplate = get_post_meta($post->ID, '_wp_page_template', true);




    ?>

            <div class="entry">
                <div class="archive-content">
                  <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>  
                  <div class="entry-details">
                    <?php if( has_post_thumbnail() ){ the_post_thumbnail('thumbnail');} ?>
                    <?php the_excerpt(); ?>
                  </div>
                </div>
              </div><!-- end .entry -->

  <?php endwhile; ?>
<?php endif; ?>
  
<?php if (is_user_logged_in()) { ?> <p id="edit" class="clear" style="margin-top:20px;"><?php edit_post_link('Edit this article', '&nbsp; &raquo; ', ''); ?> | <a href="<?php echo wp_logout_url(); ?>" title="Log out of this account">Log out &raquo;</a></p> <?php } ?> 

      </div><!-- ./col-sm-9 --> 
      <div class="col-sm-3">
        <?php get_sidebar('post_sidebar'); ?>
      </div>
    </div>
  </article><!-- end #main-content --> 
    <?php if ( $wp_query->max_num_pages > 1 ) : ?>
    <div class="container post-content-box">
      <div class="col-md-12 post-meta">
        <div class="col-sm-6 nav-previous"><?php next_posts_link( ' Older posts' ); ?></div>
        <div class="col-sm-6 nav-next"><?php previous_posts_link( 'Newer posts ' ); ?></div>
      </div>
    </div>
    <?php endif; ?>
    </div>
<?php get_footer(); ?>
