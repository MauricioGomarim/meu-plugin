<?php
/*
Plugin Name: Meu Plugin
Description: Plugin com update manual via GitHub
Version: 1.0.4
Author: Seu Nome
*/

if (!defined('ABSPATH')) exit;

// 🔥 CARREGA O ADMIN APENAS NO PAINEL
if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . 'admin.php';
}

define('MEU_PLUGIN_VERSION', '1.0.4');
define('MEU_PLUGIN_SLUG', 'meu-plugin');
define('MEU_PLUGIN_FILE', __FILE__);
define('MEU_PLUGIN_UPDATE_URL', 'https://raw.githubusercontent.com/MauricioGomarim/meu-plugin/main/update.json');

/**
 * Verifica atualizações
 */
add_filter('pre_set_site_transient_update_plugins', function ($transient) {

    if (empty($transient->checked)) {
        return $transient;
    }

    $response = wp_remote_get(MEU_PLUGIN_UPDATE_URL);

    if (is_wp_error($response)) {
        return $transient;
    }

    $data = json_decode(wp_remote_retrieve_body($response));

    if (
        version_compare(MEU_PLUGIN_VERSION, $data->version, '<')
    ) {
        $plugin = new stdClass();
        $plugin->slug        = MEU_PLUGIN_SLUG;
        $plugin->plugin      = MEU_PLUGIN_SLUG . '/' . MEU_PLUGIN_SLUG . '.php';
        $plugin->new_version = $data->version;
        $plugin->url         = $data->homepage;
        $plugin->package     = $data->download_url;

        $transient->response[$plugin->plugin] = $plugin;
    }

    return $transient;
});
<?php
/*
Plugin Name: Meu Plugin
Description: Plugin com update manual via GitHub
Version: 1.0.4
Author: Seu Nome
*/

if (!defined('ABSPATH')) exit;

// 🔥 CARREGA O ADMIN APENAS NO PAINEL
if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . 'admin.php';
}

define('MEU_PLUGIN_VERSION', '1.0.4');
define('MEU_PLUGIN_SLUG', 'meu-plugin');
define('MEU_PLUGIN_FILE', __FILE__);
define('MEU_PLUGIN_UPDATE_URL', 'https://raw.githubusercontent.com/MauricioGomarim/meu-plugin/main/update.json');

/**
 * Verifica atualizações
 */
add_filter('pre_set_site_transient_update_plugins', function ($transient) {

    if (empty($transient->checked)) {
        return $transient;
    }

    $response = wp_remote_get(MEU_PLUGIN_UPDATE_URL);

    if (is_wp_error($response)) {
        return $transient;
    }

    $data = json_decode(wp_remote_retrieve_body($response));

    if (
        version_compare(MEU_PLUGIN_VERSION, $data->version, '<')
    ) {
        $plugin = new stdClass();
        $plugin->slug        = MEU_PLUGIN_SLUG;
        $plugin->plugin      = MEU_PLUGIN_SLUG . '/' . MEU_PLUGIN_SLUG . '.php';
        $plugin->new_version = $data->version;
        $plugin->url         = $data->homepage;
        $plugin->package     = $data->download_url;

        $transient->response[$plugin->plugin] = $plugin;
    }

    return $transient;
});
