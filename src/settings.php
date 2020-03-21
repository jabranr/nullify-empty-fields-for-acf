<?php

/**
 * Settings hooks
 *
 * @author Jabran Rafique
 */

function acf_empty_fields_nullify_add_ui() {
    include_once(plugin_dir_path(__FILE__) . '/ui.php');
}

function acf_empty_fields_nullify_add_settings() {
    add_plugins_page(
        'Settings for ACF empty fields nullify',
        'ACF empty fields nullify',
        'manage_options',
        'acf-empty-fields-nullify',
        'acf_empty_fields_nullify_add_ui'
    );
}

add_action('admin_menu', 'acf_empty_fields_nullify_add_settings');
