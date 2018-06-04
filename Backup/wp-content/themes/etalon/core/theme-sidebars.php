<?php
// ------------------------------------------------------------------------
// Register widgetized areas
// ------------------------------------------------------------------------
    function keydesign_sidebars_register() {
		register_sidebar( array(
            'name' => esc_html__( 'Blog Sidebar', 'etalon' ),
            'id' => 'blog-sidebar',
            'description' => esc_html__( 'Add widgets for the blog sidebar area. If none added, default sidebar widgets will be used.', 'etalon' ),
            'before_widget' => '<div class="blog_widget">',
            'after_widget' => '</div>',
            'before_title' => '<h5 class="widget-title"><span>',
            'after_title' => '</span></h5>',
        ) );
        register_sidebar( array(
            'name' => esc_html__( 'Shop Sidebar', 'etalon' ),
            'id' => 'shop-sidebar',
            'description' => esc_html__( 'Add widgets for the shop sidebar area.', 'etalon' ),
            'before_widget' => '<div class="blog_widget">',
            'after_widget' => '</div>',
            'before_title' => '<h5 class="widget-title"><span>',
            'after_title' => '</span></h5>',
        ) );

        register_sidebar( array(
            'name' => esc_html__( 'Footer first widget area', 'etalon' ),
            'id' => 'footer-first-widget-area',
            'description' => esc_html__( 'Add one widget for the first footer widget area.', 'etalon' ),
            'before_widget' => '<div class="footer_widget">',
            'after_widget' => '</div>',
            'before_title' => '<h5 class="widget-title"><span>',
            'after_title' => '</span></h5>',
        ) );

        register_sidebar( array(
            'name' => esc_html__( 'Footer second widget area', 'etalon' ),
            'id' => 'footer-second-widget-area',
            'description' => esc_html__( 'Add one widget for the second footer widget area.', 'etalon' ),
            'before_widget' => '<div class="footer_widget">',
            'after_widget' => '</div>',
            'before_title' => '<h5 class="widget-title"><span>',
            'after_title' => '</span></h5>',
        ) );

        register_sidebar( array(
            'name' => esc_html__( 'Footer third widget area', 'etalon' ),
            'id' => 'footer-third-widget-area',
            'description' => esc_html__( 'Add one widget for the third footer widget area.', 'etalon' ),
            'before_widget' => '<div class="footer_widget">',
            'after_widget' => '</div>',
            'before_title' => '<h5 class="widget-title"><span>',
            'after_title' => '</span></h5>',
        ) );

        register_sidebar( array(
            'name' => esc_html__( 'Footer fourth widget area', 'etalon' ),
            'id' => 'footer-fourth-widget-area',
            'description' => esc_html__( 'Add one widget for the fourth footer widget area.', 'etalon' ),
            'before_widget' => '<div class="footer_widget">',
            'after_widget' => '</div>',
            'before_title' => '<h5 class="widget-title"><span>',
            'after_title' => '</span></h5>',
        ) );
    }

    add_action( 'widgets_init', 'keydesign_sidebars_register' );
?>
