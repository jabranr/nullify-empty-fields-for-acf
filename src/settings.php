<?php

/**
 * Settings hooks
 *
 * @author Jabran Rafique
 */

/**
 * Util method to check if ACF plugin (free/pro) is enabled
 */
function nullify_empty_fields_for_acf_is_acf_active() {
    $activePlugins = (array) get_option('active_plugins', array());
    return strpos(join(',', $activePlugins), 'advanced-custom-fields') !== false;
}

/**
 * Add UI for WP admin
 */
function nullify_empty_fields_for_acf_add_ui() {
    require_once(plugin_dir_path(__FILE__) . '/ui.php');
}

/**
 * Settings for WP admin UI
 */
function nullify_empty_fields_for_acf_add_settings() {
    add_plugins_page(
        'Settings for Nullify empty fields for ACF',
        'Nullify empty fields for ACF',
        'manage_options',
        'nullify-empty-fields-for-acf',
        'nullify_empty_fields_for_acf_add_ui'
    );
}

add_action('admin_menu', 'nullify_empty_fields_for_acf_add_settings');
