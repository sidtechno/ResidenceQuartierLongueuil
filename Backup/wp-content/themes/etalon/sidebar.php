<?php
/**
 * Default Sidebar for Blog
 * @package etalon
 * by KeyDesign
 */
?>

<?php if( is_active_sidebar('blog-sidebar') ) : ?>
            <?php dynamic_sidebar('blog-sidebar'); ?>
<?php endif; ?>
