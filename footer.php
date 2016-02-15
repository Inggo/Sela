<?php
/**
 * The template for displaying the footer.
 *
 * @package Inggo-Sela
 */
?>

    </div><!-- #content -->

    <?php get_sidebar( 'footer' ); ?>

    <footer id="colophon" class="site-footer">
        <?php if ( has_nav_menu ( 'social' ) ) : ?>
            <?php wp_nav_menu( array( 'theme_location' => 'social', 'depth' => 1, 'link_before' => '<span class="screen-reader-text">', 'link_after' => '</span>', 'container_class' => 'social-links', ) ); ?>
        <?php endif; ?>

        <div class="site-info"  role="contentinfo">
            <?php printf( __( '%1$s by %2$s.', 'sela' ), 'sela', '<a href="http://wordpress.com/themes/sela/">WordPress.com</a>' ); ?>
            <span class="sep"> | </span>
            <?php printf( __( 'With modifications by %1$s.', 'inggo-sela' ), '<a href="https://github.com/Inggo/Sela">Inggo</a>'); ?>
        </div><!-- .site-info -->
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
