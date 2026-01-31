<?php
/*
Plugin Name: Meu Plugin
Description: Plugin com update manual via GitHub
Version: 1.0.5
Author: Seu Nome
*/

if (!defined('ABSPATH')) exit;

// ===============================
// Constantes
// ===============================
define('MEU_PLUGIN_VERSION', '1.0.7');
define('MEU_PLUGIN_SLUG', 'meu-plugin');
define('MEU_PLUGIN_FILE', __FILE__);
define('MEU_PLUGIN_REPO', 'MauricioGomarim/meu-plugin');

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

// ===============================
// Corrige nome da pasta após update
// ===============================
add_filter('upgrader_source_selection', function ($source, $remote_source, $upgrader) {

    if (
        isset($upgrader->skin->plugin) &&
        $upgrader->skin->plugin === MEU_PLUGIN_SLUG . '/' . MEU_PLUGIN_SLUG . '.php'
    ) {
        $correct_path = trailingslashit($remote_source) . MEU_PLUGIN_SLUG;

        if (file_exists($correct_path)) {
            return $correct_path;
        }

        rename($source, $correct_path);

        return $correct_path;
    }

    return $source;
}, 10, 3);
