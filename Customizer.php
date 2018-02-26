<?php namespace Inggo\WordPress;

use WP_Customize_Control as CustomizeControl;

class Customizer
{
    public $customizer;

    public function __construct()
    {
        add_action('customize_register', array($this, 'register'));
        add_action('wp_head', array($this, 'printCustomHead'));
        add_action('wp_footer', array($this, 'printCustomFoot'));
    }

    /**
     * Set the customizer object and register individual settings
     *
     * @param   WP_Customize  $customizer  Reference to the global WP_Customize object
     */
    public function register($customizer)
    {
        $this->customizer = $customizer;
        $this->registerSocial();
        $this->registerAdvanced();
    }

    public function registerSocial()
    {
        $this->customizer->add_section('social', array(
            'title' => 'Social Links',
            'description' => 'Social media links and settings.'
        ));

        $this->customizer->add_setting('social_instagram');

        $this->customizer->add_setting('social_facebook');

        $this->customizer->add_setting('social_shop');
        
        $this->customizer->add_setting('social_mail');

        $this->addTextControl(
            'social_instagram',
            'social',
            'Instagram',
            'Link to Instagram, e.g.: ' .
                '<code>https://www.instagram.com/username/</code>'
        );

        $this->addTextControl(
            'social_facebook',
            'social',
            'Facebook',
            'Link to Facebook, e.g.: ' .
                '<code>https://www.facebook.com/username/</code>'
        );

        $this->addTextControl(
            'social_shop',
            'social',
            'Shop',
            'Link to Shop, e.g.: ' .
                '<code>https://society6.com/shop</code>'
        );

        $this->addControl(
            'email',
            'social_mail',
            'social',
            'Email',
            'Email for mailto:, e.g.: ' .
                '<code>sample@email.com</code>'
        );
    }

    /**
     * Register "Advanced" section and settings to theme mods
     */
    public function registerAdvanced()
    {
        $this->customizer->add_section('advanced', array(
            'title' => 'Advanced',
            'description' => 'Advanced theme customization',
        ));

        $this->customizer->add_setting('custom_head');

        $this->customizer->add_setting('custom_foot');

        $this->addTextareaControl(
            'custom_head',
            'advanced',
            'Custom Header Code',
            'Place custom code that needs to appear in the ' .
                '<code>&lt;head&gt;</code> section of all pages here.'
        );

        $this->addTextareaControl(
            'custom_foot',
            'advanced',
            'Custom Footer Code',
            'Place custom code that needs to appear in the bottom of ' .
            'all pages here.'
        );
    }

    private function addControl($type, $setting, $section, $label, $description)
    {
        $this->customizer->add_control(new CustomizeControl(
            $this->customizer,
            $setting,
            array(
                'label' => $label,
                'description' => $description,
                'section' => $section,
                'type' => $type,
            )
        ));
    }

    private function addTextControl($setting, $section, $label, $description)
    {
        $this->addControl('text', $setting, $section, $label, $description);
    }

    /**
     * Add a text area control
     *
     * @param  string  $setting      Setting to add the control for
     * @param  string  $section      Section to add the control in
     * @param  string  $label        Label of the control
     * @param  string  $description  Description of the control
     */
    private function addTextareaControl($setting, $section, $label, $description)
    {
        $this->addControl('textarea', $setting, $section, $label, $description);
    }

    public function hasSocial($value)
    {
        return !empty(get_theme_mod('social_' . $value));
    }

    public function getSocial($value)
    {
        return get_theme_mod('social_' . $value);
    }

    /**
     * Print out the custom_head theme mod
     */
    public function printCustomHead()
    {
        echo get_theme_mod('custom_head', '');
    }

    /**
     * Print out the custom_foot theme mod
     */
    public function printCustomFoot()
    {
        echo get_theme_mod('custom_foot', '');
    }
}
