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
        $this->registerAdvanced();
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
        $this->customizer->add_control(new CustomizeControl(
            $this->customizer,
            $setting,
            array(
                'label' => $label,
                'description' => $description,
                'section' => $section,
                'type' => 'textarea',
            )
        ));
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
