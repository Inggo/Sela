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
            array('jquery'),
            INGGO_SELA_VERSION,
            true
        );
        
        wp_enqueue_style(
            'sela-parent-style',
            get_template_directory_uri() . '/style.css',
            array(),
            INGGO_SELA_VERSION
        );

        wp_enqueue_style(
            'photoswipe',
            get_stylesheet_directory_uri() . '/vendor/photoswipe/photoswipe.css',
            array(),
            '4.1.2'
        );

        wp_enqueue_style(
            'photoswipe-default-skin',
            get_stylesheet_directory_uri() . '/vendor/photoswipe/default-skin/default-skin.css',
            array(),
            '4.1.2'
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

    public function gallery($attr)
    {
        $post = get_post();

        static $instance = 0;
        $instance++;

        if (!empty($attr['ids'])) {
            if (empty($attr['orderby'])) {
                $attr['orderby'] = 'post__in';
            }
            $attr['include'] = $attr['ids'];
        }

        $atts  = shortcode_atts(array(
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'id'         => $post ? $post->ID : 0,
            'itemtag'    => $html5 ? 'figure' : 'dl',
            'icontag'    => $html5 ? 'div' : 'dt',
            'captiontag' => $html5 ? 'figcaption' : 'dd',
            'columns'    => 3,
            'size'       => 'thumbnail',
            'include'    => '',
            'exclude'    => '',
            'link'       => '',
        ), $attr, 'gallery');

        $id = intval($atts['id']);

        if (!empty($atts['include'])) {
            $_attachments = get_posts(array(
                'include'        => $atts['include'],
                'post_status'    => 'inherit',
                'post_type'      => 'attachment',
                'post_mime_type' => 'image',
                'order'          => $atts['order'],
                'orderby'        => $atts['orderby'],
            ));

            $attachments = array();
            foreach ($_attachments as $key => $val) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        } elseif (!empty($atts['exclude'])) {
            $attachments = get_children(array(
                'post_parent'    => $id,
                'exclude'        => $atts['exclude'],
                'post_status'    => 'inherit',
                'post_type'      => 'attachment',
                'post_mime_type' => 'image',
                'order'          => $atts['order'],
                'orderby'        => $atts['orderby'],
            ));
        } else {
            $attachments = get_children(array(
                'post_parent'    => $id,
                'post_status'    => 'inherit',
                'post_type'      => 'attachment',
                'post_mime_type' => 'image',
                'order'          => $atts['order'],
                'orderby'        => $atts['orderby'],
            ));
        }

        if (empty($attachments)) {
            return '';
        }

        if (is_feed()) {
            $output = "\n";
            foreach ($attachments as $att_id => $attachment) {
                $output .= wp_get_attachment_link($att_id, $atts['size'], true) . "\n";
            }
            return $output;
        }

        ob_start();
        include("gallery.php");
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
