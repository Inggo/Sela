<?php namespace Inggo\WordPress\Themes;

class Sela
{
    /**
     * Create a new Theme\Sela instance -- apply hooks and filters
     */
    public function __construct()
    {
        add_filter('xmlrpc_enabled', '__return_false');
        add_action('wp_enqueue_scripts', array($this, 'enqueueStyles'));
        add_action('the_content_more_link', array($this, 'appendExtended'), 10, 2);
        add_action('the_post', array($this, 'photoswipe'));
        add_action('init', array($this, 'overrideGallery'));
    }

    /**
     * Enqueue Theme styles
     */
    public function enqueueStyles()
    {
        wp_register_script(
            'inggo-sela-script',
            get_stylesheet_directory_uri() . '/js/inggo-sela.js',
            array('jquery')
        );
        
        wp_enqueue_style(
            'sela-parent-style',
            get_template_directory_uri() . '/style.css'
        );

        wp_enqueue_style(
            'photoswipe',
            get_template_directory_uri() . '/vendor/photoswipe/photoswipe.css'
        );

        wp_enqueue_style(
            'photoswipe-default-skin',
            get_template_directory_uri() . '/vendor/photoswipe/default-skin/default-skin.css'
        );

        wp_register_script(
            'photoswipe',
            get_stylesheet_directory_uri() . '/vendor/photoswipe/photoswipe.min.js',
            array(),
            '4.1.2',
            true
        );

        wp_register_script(
            'photoswipe-ui',
            get_stylesheet_directory_uri() . '/vendor/photoswipe/photoswipe-ui-default.min.js',
            array(),
            '4.1.2',
            true
        );

        wp_enqueue_script('inggo-sela-script');
    }
    
    /**
     * Append the extended contents to the "read more" link
     *
     * @param   string  $link      The current "read more" link
     * @param   string  $linkText  The text for the "read more" link
     *
     * @return  string             "Read more" link with the extended entry contents
     */
    public function appendExtended($link, $linkText)
    {
        $link = $this->replaceLinkText($link, $linkText);
        $post = get_post();
        $extended = get_extended($post->post_content);
        $extended = "<div class=\"entry-extended\">{$extended['extended']}</div>";
        return $link . $extended;
    }

    /**
     * Replace the default "read more" link text
     *
     * @param   string  $link      The original "read more" link
     * @param   string  $linkText  The text for the "read more" link
     *
     * @return  string             "Read more" link text with overridden text
     */
    public function replaceLinkText($link, $linkText)
    {
        return str_replace($linkText, 'Read More <span class="dashicons dashicons-arrow-down"></span>', $link);
    }

    public function photoswipe($post)
    {
        if (has_shortcode($post->post_content, 'gallery')) {
            wp_enqueue_script('photoswipe');
            wp_enqueue_script('photoswipe-ui');
            add_action('wp_footer', array($this, 'photoswipeMarkup'));
        }

        return $post;
    }

    public function photoswipeMarkup()
    {
        include_once('photoswipe.php');
    }

    public function overrideGallery()
    {
        remove_shortcode('gallery');
        add_shortcode('gallery', array($this, 'gallery'));
    }

    public function gallery($atts, $content)
    {
        extract(shortcode_atts(array(
                'ids' => '',
                'orderby' => 'post__in',
                'columns' => '3',
                'link' => 'file'
        ), $atts));

        var_dump($atts);
    }
}
