<?php
if (!defined('ABSPATH')) exit;

add_action('elementor/widgets/register', function ($widgets_manager) {

    if (!function_exists('an7_is_addon_active')) {
        return;
    }

    $widgets = [
        'widget_exemplo' => 'exemplo-widget.php',
        'widget_filtro_home' => 'filtro-home.php',
        // 'outro_widget' => 'outro-widget.php',
    ];

    foreach ($widgets as $key => $file) {

        if (!an7_is_addon_active($key)) {
            continue;
        }

        $path = plugin_dir_path(__FILE__) . 'widgets/' . $file;

        if (file_exists($path)) {
            require_once $path;
        }
    }
});
