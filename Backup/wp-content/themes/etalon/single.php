<?php
/**
 * The Template for displaying all single posts.
 * @package etalon
 * by KeyDesign
 */

get_header(); ?>

<div id="posts-content" class="container blog-single">
<?php if ($redux_ThemeTek['tek-blog-sidebar']) { ?>
    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
<?php } else { ?>
    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 BlogFullWidth">
<?php } ?>
      <?php
          if ( have_posts() ) : the_post();
      ?>
      <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
         <div class="blog-single-content">
            <h1 class="blog-single-title"><?php the_title(); ?></h1>
            <div class="entry-meta">
               <?php  if ( is_sticky() ) echo '<span class="fa fa-thumb-tack"></span> Sticky <span class="blog-separator">|</span>  '; ?>
               <span class="published"><span class="fa fa-clock-o"></span><?php the_time( get_option('date_format') ); ?></span>
               <span class="author"><span class="fa fa-keyboard-o"></span><?php the_author_posts_link(); ?></span>
               <span class="blog-label"><span class="fa fa-folder-open-o"></span><?php the_category(', '); ?></span>
            </div>
            <?php the_post_thumbnail('large'); ?>
            <div class="blog-content"><?php the_content(); ?><?php wp_link_pages(); ?></div>
            <div class="meta-content">
               <div class="tags"><span class="tags-label">Tags:</span> <?php the_tags(' ',' '); ?></div>
               <div class="navigation pagination">
                  <?php previous_post_link('%link', __('Previous', 'etalon')); ?>
                  <?php next_post_link('%link', __('Next', 'etalon')); ?>
               </div>
            </div>
         </div>
      </div>
      <div class="page-content comments-content">
          <?php
              // If comments are open or we have at least one comment, load up the comment template
              if ( comments_open() || '0' != get_comments_number() ) {
                  comments_template();
              }
          ?>
      </div>
   </div>
   <?php if ($redux_ThemeTek['tek-blog-sidebar']) { ?>
       <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
          <?php get_sidebar(); ?>
       </div>
   <?php } ?>
   <?php else : ?>
       <div id="post-not-found" <?php post_class() ?>>
          <h1 class="entry-title"><?php esc_html_e('Error 404 - Not Found', 'etalon')   ?></h1>
          <div class="entry-content">
             <p><?php esc_html_e("Sorry, but you are looking for something that isn't here.", "etalon"); ?></p>
          </div>
       </div>
   <?php endif; ?>
</div>

<?php get_footer(); ?>
