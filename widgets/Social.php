<?php namespace Inggo\WordPress\Widgets;

use WP_Widget;

class Social extends WP_Widget
{
    public $socialMedia = [
        'instagram' => 'Instagram',
        'facebook' => 'Facebook',
        'shop' => 'Shop',
        'mail' => 'Mail',
    ];

    public function __construct()
    {
        $widget_ops = array( 
            'classname' => 'inggo-sela-social',
            'description' => 'Display links to social media. Use the Theme Customizer to define social links.',
        );
        parent::__construct('inggo-sela-social', 'Social Links', $widget_ops);
    }

    public function registerCustomizer($customizer)
    {
        $this->customizer = $customizer;
    }

    public function widget($args, $instance)
    {
        include (get_stylesheet_directory() . "/views/widgets/social.php");
    }

    public function form($instance)
    {
        $title = ! empty($instance['title']) ? $instance['title'] : esc_html__('Social', 'text_domain');
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php 
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ?
            strip_tags($new_instance['title']) : 
            '';

        return $instance;
    }

    private function printSocialButtons($customizer)
    {
        foreach ($this->socialMedia as $medium => $label) {
            if ($customizer->hasSocial($medium)) {
                $this->printButton($customizer->getSocial($medium), $medium, $label);
            }
        }
    }

    private function printButton($link, $medium, $title)
    {
        if ($medium == 'mail') {
            $link = 'mailto:' . $link;
        }
        include (get_stylesheet_directory() . "/views/partials/social-button.php");
    }
}
