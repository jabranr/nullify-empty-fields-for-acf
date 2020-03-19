<?php

function add_ui() {
    include_once(plugin_dir_path(__FILE__) . '/ui.php');
}

function add_settings() {
    add_plugins_page('Settings for ACF empty fields nullify', 'WP ACF nullify', 'manage_options', 'wp-acf-nullify', 'add_ui');
}

add_action('admin_menu', 'add_settings');
