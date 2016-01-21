<?php namespace Inggo\WordPress\Themes;

class Sela
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueueStyles'));
        add_action('the_content_more_link', array($this, 'appendExtended'), 10, 2);
    }

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
    
    public function appendExtended($link, $linkText)
    {
        $link = $this->replaceLinkText($link, $linkText);
        $post = get_post();
        $extended = get_extended($post->post_content);
        $extended = "<div class=\"entry-extended\">{$extended['extended']}</div>";
        return $link . $extended;
    }

    public function replaceLinkText($link, $linkText)
    {
        return str_replace($linkText, 'Read More <span class="dashicons dashicons-arrow-down"></span>', $link);
    }
}

