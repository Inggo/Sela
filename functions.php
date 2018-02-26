<?php

define('INGGO_SELA_VERSION', '0.5.0');

require_once("Sela.php");
require_once("Customizer.php");
require_once("widgets/Social.php");

global $INGGO_SELA;

$INGGO_SELA = [
    'theme' => new Inggo\WordPress\Themes\Sela,
    'customizer' => new Inggo\WordPress\Customizer,
    'widgets' => [
        'social' => new Inggo\Wordpress\Widgets\Social()
    ],
];

foreach ($INGGO_SELA['widgets'] as $widget)
{
    add_action('widgets_init', function() use ($widget) {
        register_widget(get_class($widget));
    });
}
