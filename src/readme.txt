=== Nullify empty fields for ACF ===
Contributors: jabranr
Donate link: https://paypal.me/jabranr
Tags: gatsby, graphql, acf, advanced-custom-fields, wordpress
Requires at least: 5.0
Tested up to: 6.3
Stable tag: 1.2.4
Requires PHP: 7.1
License: MIT License
License URI: https://opensource.org/licenses/MIT

Set Advanced Custom Fields (ACF) empty field value as `null` instead of `false` to avoid GraphQL error in GatsbyJS.

== Description ==

Set Advanced Custom Fields (ACF) empty field value as `null` instead of `false` to avoid GraphQL error in GatsbyJS.

== Prerequisites ==

- Advanced Custom Fields (ACF) plugin

== Installation ==

- Install the plugin from WordPress admin panel
- Activate the plugin
- Use settings to choose specific types to nullify

== Changelog ==

= 1.2.4 =
* Support for WordPress 6.3 as previous attempt to support major version only did not work

= 1.2.3 =
* Support for WordPress 6.x

= 1.2.2 =
* Support for WordPress 5.8

= 1.2.1 =
* Add icons

= 1.2.0 =
* Compatibility for WordPress 5.5
* Bugfix where default value was not being applied to all ACF field types

= 1.1.0 =
* Support for Advanced Custom Fields (PRO)

= 1.0.0 =
* First version release
