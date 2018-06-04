<?php
/*
 Template Name: Portfolio
 *
 * @package etalon
 * by KeyDesign
*/
?>

<?php
if (!is_front_page()) {
   get_header();
}
?>

<?php
   $redux_ThemeTek = get_option( 'redux_ThemeTek' );
   $themetek_page_bgcolor = get_post_meta( get_the_ID(), '_themetek_page_bgcolor', true );
   $themetek_page_background_color = ' background-color:'.$themetek_page_bgcolor.';';
   $themetek_page_layout = get_post_meta( get_the_ID(), '_themetek_page_layout', true );
   $themetek_page_showhide_title = get_post_meta( get_the_ID(), '_themetek_page_showhide_title', true );
   $themetek_page_subtitle = get_post_meta( get_the_ID(), '_themetek_page_subtitle', true );
   $themetek_page_top_padding = get_post_meta( get_the_ID(), '_themetek_page_top_padding', true );
   $themetek_page_bottom_padding = get_post_meta( get_the_ID(), '_themetek_page_bottom_padding', true );
?>

<section id="<?php echo esc_attr($post->post_name);?>" class="section" style="
   <?php echo (!empty($themetek_page_bgcolor) ? esc_attr($themetek_page_background_color) : '' ); ?>
   <?php echo (!empty($themetek_page_top_padding) ? ' padding-top:'. esc_attr($themetek_page_top_padding) .';' : '' );?>
   <?php echo (!empty($themetek_page_bottom_padding) ? ' padding-bottom:'. esc_attr($themetek_page_bottom_padding) .';' : '' );?> ">
   <div class="container <?php echo ( !empty($themetek_page_layout) ? 'fullwidth' : '' );?>" >
      <div class="row" >
         <?php echo ( empty($themetek_page_showhide_title) ? '<h2 class="section-heading">' . get_the_title() . '</h2>': '' );?>
         <?php echo ( !empty($themetek_page_subtitle) ? '<p class="section-subheading">' . esc_html($themetek_page_subtitle) . '</p>' : '' );?>
      </div>
      <div class="row" id="portfolio-items">
         <?php
         			$args = array(
                     'post_type' => 'portfolio',
                     'orderby' => 'date',
                     'order' => 'ASC',
                     'posts_per_page'   => 99
                     );
         			$loop = new WP_Query( $args );

         			while ( $loop->have_posts() ) : $loop->the_post();
			        $src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), array( 1200, 1200 ), false, '' );
         ?>
			<div class="portfolio-item">
		       <img alt="<?php the_title(); ?>" src="<?php echo esc_url($src[0]); ?>" />
           <div class="portfolio-content" data-id="<?php get_the_ID(); ?>">
              <div class="portfolio-inner-content">
                  <h3><?php the_title(); ?></h3>
                  <a class="tt_button" href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo esc_html__("Read more", "etalon"); ?></a>
              </div>
           </div>
			</div>
      <?php endwhile; ?>
      <?php wp_reset_query(); ?>
    </div>
    <div class="portfolio-content"><?php the_content(); ?></div>
   </div>
</section>

<?php
	if (!is_front_page()) {
		get_footer();
	}
?>
