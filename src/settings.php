<?php

/**
 * Settings hooks
 *
 * @author Jabran Rafique
 */

function nullify_empty_fields_for_acf_add_ui() {
    include_once(plugin_dir_path(__FILE__) . '/ui.php');
}

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
