<?php get_header(); ?>
<article id="main-content" class="container post-content-box" role="main">
        <div class="col-sm-12">
        <?php if (have_posts()) : ?>      
          <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
          <?php $cat = get_category( get_query_var( 'cat' ) );?>         

          <?php /* If this is a category archive */ if (is_category()) { ?>
            <h1 class="page-title"><?php single_cat_title(); ?></strong>  <a title="Subscribe to <?php single_cat_title(); ?> RSS Feed" href="<?php echo get_home_url() . '/category/' . esc_html( $cat->slug ) . '/feed';?>"><img class="rss-icon" src="<?php echo UFL_ATHENA_IMG_DIR; ?>/rss-icon.png" alt="Subscribe to RSS Feed" /></a></h1>

          <?php /* If this is a tag archive */
          } elseif (is_tag()) { ?>
            <h1 class="page-title ">Articles Tagged <span class="light-blue">&ldquo;</span><?php single_tag_title(); ?></strong><span class="light-blue">&rdquo;</span> <a title="Subscribe to <?php single_tag_title(); ?> RSS Feed" href="feed/"><img class="rss-icon" src="<?php echo UFL_ATHENA_IMG_DIR; ?>/rss-icon.png" alt="Subscribe to RSS Feed" /></a></h1>

          <?php /* If this is a daily archive */
          } elseif (is_day()) { ?>
            <h1 class="page-title ">Archive for <span class="light-blue">&ldquo;</span><?php wp_title('', true, 'right'); ?></strong><span class="light-blue">&rdquo;</span> <a title="Subscribe to <?php wp_title('', true, 'right'); ?> RSS Feed" href="feed/"><img class="rss-icon" src="<?php echo UFL_ATHENA_IMG_DIR; ?>/rss-icon.png" alt="Subscribe to RSS Feed" /></a></h1>

          <?php /* If this is a monthly archive */
          } elseif (is_month()) { ?>
            <h1 class="page-title ">Archive for <span class="light-blue">&ldquo;</span><?php wp_title('', true, 'right'); ?></strong><span class="light-blue">&rdquo;</span> <a title="Subscribe to <?php wp_title('', true, 'right'); ?> RSS Feed" href="feed/"><img class="rss-icon" src="<?php echo UFL_ATHENA_IMG_DIR; ?>/rss-icon.png" alt="Subscribe to RSS Feed" /></a></h1>

          <?php /* If this is a yearly archive */
          } elseif (is_year()) { ?>
            <h1 class="page-title ">Archive for <span class="light-blue">&ldquo;</span><?php wp_title('', true, 'right'); ?></strong><span class="light-blue">&rdquo;</span> <a title="Subscribe to <?php wp_title('', true, 'right'); ?> RSS Feed" href="feed/"><img class="rss-icon" src="<?php echo UFL_ATHENA_IMG_DIR; ?>/rss-icon.png" alt="Subscribe to RSS Feed" /></a></h1>

          <?php /* If this is an author archive */
          } elseif (is_author()) { ?>
            <h1 class="page-title ">All Posts by <span class="light-blue">&ldquo;</span><?php echo $curauth->display_name; ?></strong><span class="light-blue">&rdquo;</span> <a title="Subscribe to <?php echo $curauth->display_name; ?> RSS Feed" href="feed/"><img class="rss-icon" src="<?php echo UFL_ATHENA_IMG_DIR; ?>/rss-icon.png" alt="Subscribe to RSS Feed" /></a></h1>

          <?php /* If this is a paged archive */
          } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
            <h1 class="page-title ">Blog Archives <a title="Subscribe to RSS Feed" href="feed/"><img class="rss-icon" src="<?php bloginfo('template_directory'); ?>/images/feed.png" alt="Subscribe to RSS Feed" /></a></h1>

          <?php } ?>
        </div>
        <div class="col-sm-9">
          <?php while (have_posts()) : the_post(); ?>

    <?php
    $currenttemplate = get_post_meta($post->ID, '_wp_page_template', true);
    ?>

            <div class="entry">
                <div class="archive-content">
                  <!--<p class="published"><span class="category-tag">Published: <?php// the_time('M jS, Y') ?></p>-->
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
