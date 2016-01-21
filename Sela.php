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
    }

    /**
     * Enqueue Theme styles
     *
     * @return  void  [description]
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
}
