<?php
/**
 * @package Gatsby_Wordpress_Acf_Nullify
 * @version 1.0.0
 * Plugin Name: Gatsby ACF Nullify for WordPress
 * Plugin URI: https://github.com/jabranr/gatsby-wordpress-acf-nullify
 * Description: Set Advanced Custom Fields (ACF) empty field value as <code>null</code> instead of <code>false</code> to avoid GraphQL error in GatsbyJS.
 * Author: Jabran Rafique <hello@jabran.me>
 * Version: 1.0.0
 * Author URI: https://jabran.me?utm_source=gatsby_wp_acf_nullify
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
function gatsby_wp_acf_nullify_settings_link( $links ) {
    $links[] = '<a href="' .
    admin_url( 'plugins.php?page=wp-acf-nullify' ) .
    '">' . __('Settings') . '</a>';
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
function gatsby_wp_acf_nullify_empty($value, $post_id, $field) {
    if (empty($value)) {
        return null;
    }

    return $value;
}

/**
 * Uninstall hook callback function
 */
function gatsby_wp_acf_nullify_uninstall() {
    $nullifyTypes = get_option('gatsby_wp_acf_nullify_types');

    if (empty($nullifyTypes)) {
        remove_filter('acf/format_value', 'gatsby_wp_acf_nullify_empty', 100, 3);
    } else {
        $nullifyTypes = explode(',', $nullifyTypes);

        foreach($nullifyTypes as $nullifyType) {
            if ($remove) {
                remove_filter('acf/format_value/type=' . $nullifyType, 'gatsby_wp_acf_nullify_empty', 100, 3);
            }
        }
    }

    delete_option('gatsby_wp_acf_nullify_types');
}

/**
 * Activate/Deactivate hooks callback common function
 *
 * @param $remove boolean
 */
function gatsby_wp_acf_nullify_toggle($remove = false) {
    $nullifyTypes = get_option('gatsby_wp_acf_nullify_types');

    if (empty($nullifyTypes)) {
        if ($remove) {
            remove_filter('acf/format_value', 'gatsby_wp_acf_nullify_empty', 100, 3);
        } else {
            add_filter('acf/format_value', 'gatsby_wp_acf_nullify_empty', 100, 3);
        }
    } else {
        $nullifyTypes = explode(',', $nullifyTypes);

        foreach($nullifyTypes as $nullifyType) {
            if ($remove) {
                remove_filter('acf/format_value/type=' . $nullifyType, 'gatsby_wp_acf_nullify_empty', 100, 3);
            } else {
                add_filter('acf/format_value/type=' . $nullifyType, 'gatsby_wp_acf_nullify_empty', 100, 3);
            }
        }
    }

    add_filter('plugin_action_links_'. plugin_basename(__FILE__), 'gatsby_wp_acf_nullify_settings_link', 100, 3);
}

/**
 * Deactivate hook callback function
 */
function gatsby_wp_acf_nullify_deactivate() {
    gatsby_wp_acf_nullify_toggle(true);
}

/**
 * Activate hook callback function
 */
function gatsby_wp_acf_nullify_activate() {
    if (!is_plugin_active('advanced-custom-fields/acf.php')) {
        wp_die(sprintf('This plugin only works with <a href="%s" target="_blank" rel="noopener">Advanced Custom Fields (ACF)</a>. Please install and activate ACF before using this plugin.', 'https://wordpress.org/plugins/advanced-custom-fields/?utm_source=gatsby-wordpress-acf-nullify'));
    }

    gatsby_wp_acf_nullify_toggle();
}

// default setup
gatsby_wp_acf_nullify_toggle();

// hooks
register_activation_hook( __FILE__, 'gatsby_wp_acf_nullify_activate' );
register_deactivation_hook( __FILE__, 'gatsby_wp_acf_nullify_deactivate' );
register_uninstall_hook( __FILE__, 'gatsby_wp_acf_nullify_uninstall' );
