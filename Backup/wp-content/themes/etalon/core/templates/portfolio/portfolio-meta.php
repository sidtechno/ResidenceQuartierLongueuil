<?php if (isset($redux_ThemeTek['tek-portfolio-social'])) : ?>
    <?php if ($redux_ThemeTek['tek-portfolio-social']) : ?>
      	<div class="portfolio-meta share-meta">
      		<h4><?php echo esc_html__("Share on", "etalon"); ?></h4>
      		<span class="portfolio-share">
      		  <a href='https://www.facebook.com/sharer.php?u=<?php echo esc_url(get_permalink(get_the_ID())); ?>' target='_blank'><span class='fa fa-facebook'></span></a>
      		  <a href='https://twitter.com/share?url=<?php echo esc_url(get_permalink(get_the_ID())); ?>' target='_blank'><span class='fa fa-twitter'></span></a>
      		  <a href='https://plusone.google.com/_/+1/confirm?hl=en&url=<?php echo esc_url(get_permalink(get_the_ID())); ?>' target='_blank'><span class='fa fa-google-plus'></span></a>
      		  <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url(get_permalink(get_the_ID())); ?>" target='_blank'><span class="fa fa-linkedin"></span></a>
      		</span>
      	</div>
     <?php endif; ?>
<?php endif; ?>
