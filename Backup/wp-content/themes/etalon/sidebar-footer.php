<?php
/**
 * Footer widget area template
 * @package etalon
 * by KeyDesign
 */
?>

<?php
    $redux_ThemeTek = get_option( 'redux_ThemeTek' );
    $footer_active_widgets = is_active_sidebar( 'footer-first-widget-area' ) + is_active_sidebar( 'footer-second-widget-area' ) + is_active_sidebar( 'footer-third-widget-area' ) + is_active_sidebar( 'footer-fourth-widget-area' );
    $sidebar_cols_class = "col-xs-12 col-sm-12 col-md-3 col-lg-3";

    if ($footer_active_widgets == "1") {
        $sidebar_cols_class = "col-xs-12 col-sm-12 col-md-12 col-lg-12";
    } elseif ($footer_active_widgets == "2") {
        $sidebar_cols_class = "col-xs-12 col-sm-6 col-md-6 col-lg-6";
    } elseif ($footer_active_widgets == "3") {
        $sidebar_cols_class = "col-xs-12 col-sm-12 col-md-4 col-lg-4";
    } elseif ($footer_active_widgets == "4") {
        $sidebar_cols_class = "col-xs-12 col-sm-12 col-md-3 col-lg-3";
    }
?>

<?php if ($footer_active_widgets) : ?>
    <div class="upper-footer">
        <div class="container">
          <?php if (isset($redux_ThemeTek['tek-footer-business-info'])){
              if ($redux_ThemeTek['tek-footer-business-info'] && ($redux_ThemeTek['tek-footer-bussiness-template'] == '1')) : ?>
                  <div class="footer-business-info">
                      <div class="container footer-business-wrapper">
                          <?php if (isset($redux_ThemeTek['tek-business-address']) && $redux_ThemeTek['tek-business-address'] != '' ) : ?>
                              <span class="footer-business-address">
                                    <span class="iconsmind-Map-Marker2"></span>
                                    <span class="footer-business-title"><?php echo esc_html__("Address", "etalon"); ?></span>
                                    <span class="footer-business-content"><?php echo esc_attr($redux_ThemeTek['tek-business-address']); ?></span>
                               </span>
                          <?php endif; ?>
                          <?php if (isset($redux_ThemeTek['tek-business-phone']) && $redux_ThemeTek['tek-business-phone'] != '' ) : ?>
                              <span class="footer-business-phone">
                                    <span class="iconsmind-Telephone"></span>
                                    <span class="footer-business-title"><?php echo esc_html__("Phone", "etalon"); ?></span>
                                    <span class="footer-business-content"><a href="tel:<?php echo esc_attr($redux_ThemeTek['tek-business-phone']); ?>"><?php echo esc_attr($redux_ThemeTek['tek-business-phone']); ?></a></span>
                                </span>
                          <?php endif; ?>
                          <?php if (isset($redux_ThemeTek['tek-business-email']) && $redux_ThemeTek['tek-business-email'] != '' ) : ?>
                              <span class="footer-business-email">
                                    <span class="iconsmind-Mail"></span>
                                    <span class="footer-business-title"><?php echo esc_html__("Email", "etalon"); ?></span>
                                    <span class="footer-business-content"><a href="mailto:<?php echo esc_attr($redux_ThemeTek['tek-business-email']); ?>"><?php echo esc_attr($redux_ThemeTek['tek-business-email']); ?></a></span>
                               </span>
                          <?php endif; ?>
                      </div>
                  </div>
                <?php elseif ($redux_ThemeTek['tek-footer-business-info'] && ($redux_ThemeTek['tek-footer-bussiness-template'] == '2')) : ?>
                  <div class="footer-business-info footer-socials">
                      <div class="container footer-business-wrapper">
                        <div class="footer-social-text"><?php echo esc_html__("Find us on:", "etalon"); ?></div>
                        <div class="footer-social-icons">
                            <?php if ($redux_ThemeTek['tek-social-icons'][1] == 1): ?><a href="<?php echo esc_url($redux_ThemeTek['tek-facebook-url']) ?>" target="_blank"><span class="fa fa-facebook"></span></a><?php endif;  ?>
                            <?php if ($redux_ThemeTek['tek-social-icons'][2] == 1): ?><a href="<?php echo esc_url($redux_ThemeTek['tek-twitter-url']) ?>" target="_blank"><span class="fa fa-twitter"></span></a><?php endif;  ?>
                            <?php if ($redux_ThemeTek['tek-social-icons'][3] == 1): ?><a href="<?php echo esc_url($redux_ThemeTek['tek-google-url']) ?>" target="_blank"><span class="fa fa-google-plus"></span></a><?php endif;  ?>
                            <?php if ($redux_ThemeTek['tek-social-icons'][4] == 1): ?><a href="<?php echo esc_url($redux_ThemeTek['tek-pinterest-url']) ?>" target="_blank"><span class="fa fa-pinterest"></span></a><?php endif;  ?>
                            <?php if ($redux_ThemeTek['tek-social-icons'][5] == 1): ?><a href="<?php echo esc_url($redux_ThemeTek['tek-youtube-url']) ?>" target="_blank"><span class="fa fa-youtube"></span></a><?php endif;  ?>
                            <?php if ($redux_ThemeTek['tek-social-icons'][6] == 1): ?><a href="<?php echo esc_url($redux_ThemeTek['tek-linkedin-url']) ?>" target="_blank"><span class="fa fa-linkedin"></span></a><?php endif;  ?>
                            <?php if ($redux_ThemeTek['tek-social-icons'][7] == 1): ?><a href="<?php echo esc_url($redux_ThemeTek['tek-instagram-url']) ?>" target="_blank"><span class="fa fa-instagram"></span></a><?php endif;  ?>
                        </div>
                        <div class="footer-newsletter-form">
                          <?php if (isset($redux_ThemeTek['tek-footer-panel-formid']) && $redux_ThemeTek['tek-footer-panel-formid'] != '' ) : ?>
                              <?php echo do_shortcode('[contact-form-7 id="'. esc_attr($redux_ThemeTek['tek-footer-panel-formid']).'"]'); ?>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                <?php endif; ?>
            <?php } ?>

            <div class="container">
                <div class="row">
                <?php if (is_active_sidebar( 'footer-first-widget-area' )) : ?>
                    <div class="<?php echo esc_html($sidebar_cols_class); ?> first-widget-area">
                        <?php dynamic_sidebar( 'footer-first-widget-area' ); ?>
                    </div>
                <?php endif;?>

                <?php if (is_active_sidebar( 'footer-second-widget-area' )) :?>
                    <div class="<?php echo esc_html($sidebar_cols_class); ?> second-widget-area">
                        <?php dynamic_sidebar( 'footer-second-widget-area' ); ?>
                    </div>
                <?php endif;?>

                <?php if (is_active_sidebar( 'footer-third-widget-area' )) : ?>
                <div class="<?php echo esc_html($sidebar_cols_class); ?> third-widget-area">
                    <?php dynamic_sidebar( 'footer-third-widget-area' ); ?>
                </div>
                <?php endif;?>

                <?php if (is_active_sidebar( 'footer-fourth-widget-area' )) : ?>
                <div class="<?php echo esc_html($sidebar_cols_class); ?> forth-widget-area">
                    <?php dynamic_sidebar( 'footer-fourth-widget-area' ); ?>
                </div>
                <?php endif;?>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
