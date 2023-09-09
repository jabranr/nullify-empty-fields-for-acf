<?php

/**
 * Plugin Name: Nullify empty fields for ACF
 * Plugin URI: https://github.com/jabranr/nullify-empty-fields-for-acf
 * Description: Set Advanced Custom Fields (ACF) empty field value as <code>null</code> instead of <code>false</code> to avoid GraphQL error in GatsbyJS.
 * Author: Jabran Rafique <hello@jabran.me>
 * Version: 1.2.4
 * Author URI: https://jabran.me?utm_source=nullify-empty-fields-for-acf
 * License: MIT License
 *
 * Copyright 2020 Jabran Rafique
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 */

require_once(plugin_dir_path(__FILE__) . '/settings.php');

/**
 * Add settings link
 */
function nullify_empty_fields_for_acf_settings_link($links)
{
    $links[] = sprintf('<a href="%s">%s</a>', admin_url('plugins.php?page=nullify-empty-fields-for-acf'), __('Settings'));
    return $links;
}

/**
 * Return `null` if an empty value is returned from ACF.
 *
 * @param mixed $value
 * @param mixed $post_id
 * @param array $field
 *
 * @link https://www.gatsbyjs.org/packages/gatsby-source-wordpress/#graphql-error---unknown-field-on-acf
 * @return mixed
 */
function nullify_empty_fields_for_acf_empty($value, $post_id, $field)
{
    if (empty($value)) {
        return null;
    }

    return $value;
}

/**
 * Uninstall hook callback function
 */
function nullify_empty_fields_for_acf_uninstall()
{
    $nullifyTypes = get_option('nullify_empty_fields_for_acf_types');

    if (empty($nullifyTypes)) {
        remove_filter('acf/format_value', 'nullify_empty_fields_for_acf_empty', 100, 3);
    } else {
        $nullifyTypes = explode(',', $nullifyTypes);

        foreach ($nullifyTypes as $nullifyType) {
            if ($remove) {
                remove_filter('acf/format_value/type=' . $nullifyType, 'nullify_empty_fields_for_acf_empty', 100, 3);
            }
        }
    }

    delete_option('nullify_empty_fields_for_acf_types');
}

/**
 * Activate/Deactivate hooks callback common function
 *
 * @param $remove boolean
 */
function nullify_empty_fields_for_acf_toggle($remove = false)
{
    $nullifyTypes = get_option('nullify_empty_fields_for_acf_types');

    if (empty($nullifyTypes)) {
        if ($remove) {
            remove_filter('acf/format_value', 'nullify_empty_fields_for_acf_empty', 100, 3);
        } else {
            add_filter('acf/format_value', 'nullify_empty_fields_for_acf_empty', 100, 3);
        }
    } else {
        $nullifyTypes = explode(',', $nullifyTypes);

        foreach ($nullifyTypes as $nullifyType) {
            if ($remove) {
                remove_filter('acf/format_value/type=' . trim($nullifyType), 'nullify_empty_fields_for_acf_empty', 100, 3);
            } else {
                add_filter('acf/format_value/type=' . trim($nullifyType), 'nullify_empty_fields_for_acf_empty', 100, 3);
            }
        }
    }

    add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'nullify_empty_fields_for_acf_settings_link', 100, 3);
}

/**
 * Deactivate hook callback function
 */
function nullify_empty_fields_for_acf_deactivate()
{
    nullify_empty_fields_for_acf_toggle(true);
}

/**
 * Activate hook callback function
 */
function nullify_empty_fields_for_acf_activate()
{
    if (!nullify_empty_fields_for_acf_is_acf_active()) {
        wp_die(sprintf('This plugin only works with <a href="%s" target="_blank" rel="noopener">Advanced Custom Fields (ACF)</a>. Please install and activate ACF before using this plugin.', 'https://wordpress.org/plugins/advanced-custom-fields/?utm_source=nullify-empty-fields-for-acf'));
    }

    nullify_empty_fields_for_acf_toggle();
}

// default setup
nullify_empty_fields_for_acf_toggle();

// hooks
register_activation_hook(__FILE__, 'nullify_empty_fields_for_acf_activate');
register_deactivation_hook(__FILE__, 'nullify_empty_fields_for_acf_deactivate');
register_uninstall_hook(__FILE__, 'nullify_empty_fields_for_acf_uninstall');
