<?php
/*
Plugin Name: Meu Plugin
Description: Plugin com update manual via GitHub
Version: 1.1.1
Author: Seu Nome
*/

if (!defined('ABSPATH')) exit;

// ===============================
// Constantes
// ===============================
define('MEU_PLUGIN_VERSION', '1.1.1');
define('MEU_PLUGIN_SLUG', 'meu-plugin');
define('MEU_PLUGIN_FILE', __FILE__);
define('MEU_PLUGIN_REPO', 'MauricioGomarim/meu-plugin');


// ===============================
// Admin
// ===============================
if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . 'admin/admin-menu.php';
}


add_action('admin_enqueue_scripts', 'an7_addons_admin_assets');
function an7_addons_admin_assets($hook) {

    // slug da sua página
    if ($hook !== 'toplevel_page_an7-addons') {
        return;
    }

    wp_enqueue_style(
        'an7-addons-admin',
        plugin_dir_url(__FILE__) . 'admin/admin.css',
        [],
        '1.0.0'
    );
}


function an7_is_addon_active($addon) {
    $addons = get_option('an7_addons', []);
    return !empty($addons[$addon]);
}




add_action('plugins_loaded', function () {

    if (!did_action('elementor/loaded')) {
        return;
    }

    require_once plugin_dir_path(__FILE__) . 'elementor/widgets-loader.php';
});



// ===============================
// Verifica atualizações via TAG
// ===============================
add_filter('pre_set_site_transient_update_plugins', function ($transient) {

    if (empty($transient->checked)) {
        return $transient;
    }

    $response = wp_remote_get(
        'https://api.github.com/repos/' . MEU_PLUGIN_REPO . '/tags',
        [
            'headers' => [
                'Accept'     => 'application/vnd.github+json',
                'User-Agent' => 'WordPress'
            ],
            'timeout' => 15
        ]
    );

    if (is_wp_error($response)) {
        return $transient;
    }

    $tags = json_decode(wp_remote_retrieve_body($response));

    if (empty($tags) || empty($tags[0]->name)) {
        return $transient;
    }

    $latest_version = ltrim($tags[0]->name, 'v');

    if (version_compare(MEU_PLUGIN_VERSION, $latest_version, '<')) {

        $plugin = new stdClass();
        $plugin->slug        = MEU_PLUGIN_SLUG;
        $plugin->plugin      = MEU_PLUGIN_SLUG . '/' . MEU_PLUGIN_SLUG . '.php';
        $plugin->new_version = $latest_version;
        $plugin->url         = 'https://github.com/' . MEU_PLUGIN_REPO;
        $plugin->package     = 'https://github.com/' . MEU_PLUGIN_REPO . '/archive/refs/tags/' . $tags[0]->name . '.zip';

        $transient->response[$plugin->plugin] = $plugin;
    }

    return $transient;
});

add_filter('upgrader_post_install', function ($response, $hook_extra, $result) {

    if (
        empty($hook_extra['plugin']) ||
        $hook_extra['plugin'] !== MEU_PLUGIN_SLUG . '/' . MEU_PLUGIN_SLUG . '.php'
    ) {
        return $response;
    }

    $plugins_dir = WP_PLUGIN_DIR;
    $correct_dir = $plugins_dir . '/' . MEU_PLUGIN_SLUG;

    if (is_dir($correct_dir)) {
        return $response;
    }

    // Pasta extraída pelo GitHub (ex: meu-plugin-1.0.7)
    $source = $result['destination'];

    // Move para o nome correto
    rename($source, $correct_dir);

    // Atualiza referência interna do WP
    $result['destination'] = $correct_dir;

    return $response;
}, 10, 3);






add_action('elementor/elements/categories_registered', function ($elements_manager) {

    $elements_manager->add_category(
        'an7-addons',
        [
            'title' => 'An7 Addons',
            'icon'  => 'fa fa-plug',
        ]
    );
});
