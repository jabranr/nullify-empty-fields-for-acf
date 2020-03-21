<?php

/**
 * Admin UI Page
 *
 * @author Jabran Rafique
 */

$isSuccess = false;
$isAcfEnabled = is_plugin_active('advanced-custom-fields/acf.php');

if (
    isset($_POST['acf_empty_fields_nullify_form_wp_nonce']) &&
    wp_verify_nonce($_POST['acf_empty_fields_nullify_form_wp_nonce'], 'update-plugin-options')
) {

    if (isset($_POST['nullify-types'])) {
        $nullifyTypes = sanitize_text_field($_POST['nullify-types']);

        if (empty($nullifyTypes)) {
            delete_option('acf_empty_fields_nullify_types');
        } else {
            update_option('acf_empty_fields_nullify_types', $nullifyTypes);
        }

        $isSuccess = true;
    }
}

?>

<style>
    .acf_empty_fields_nullify_form {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
    .acf_empty_fields_nullify_form .form-group {
        display: block;
        font-weight: normal;
    }
    .acf_empty_fields_nullify_form .form-label {
        display: block;
        font-size: 14px;
        color: #333;
        margin-top: 1rem;
        margin-bottom: 4px;
        font-weight: bold;
    }
    .acf_empty_fields_nullify_form .helper-text {
        display: block;
        color: #666;
        font-size: 12px;
        margin-top: 4px;
    }
    .acf_empty_fields_nullify_copyright {
        font-weight: normal;
        font-size: 12px;
        color: #888;
    }
</style>

<h2>ACF empty fields nullify</h2>

<?php
    if ($isSuccess) {
        printf('<div class="notice notice-success is-dismissible"><p>%s</p></div>', __( 'Successfully updated', 'acf_empty_fields_nullify' ));
    }

    if (!$isAcfEnabled) {
        printf('<div class="notice notice-error is-dismissible">');
        printf(
            '<p>%s</p>',
            __(
                '<strong>ACF empty fields nullify</strong> depends on the last version of <strong>Advanced Custom Fields (ACF)</strong> to work!',
                'acf_empty_fields_nullify'
            )
        );

        printf(
            '<p><a href="%s" class="button button-primary">Activate in plugins &raquo;</a></p>',
            admin_url('plugins.php')
        );

        printf('</div>');
    }
?>

<form method="post" class="acf_empty_fields_nullify_form" action="<?php echo admin_url(htmlentities(basename($_SERVER['PHP_SELF']) . '?' .$_SERVER['QUERY_STRING'])); ?>">
    <div class="form-group">
        <label for="nullify-types" class="form-label">Field types to nullify</label>
        <p class="helper-text">Add types separated by commas e.g. "repeater, image, text". Leave it empty to nullify all types.</p>
        <input id="nullify-types" name="nullify-types" class="form-input regular-text<?php if (!$isAcfEnabled) echo ' disabled'; ?>" <?php if (!$isAcfEnabled) echo 'disabled'; ?> type="text" value="<?php echo get_option('acf_empty_fields_nullify_types'); ?>" />
        <?php wp_nonce_field('update-plugin-options', 'acf_empty_fields_nullify_form_wp_nonce', '', true); ?>
        <button type="submit" id="nullify-submit" class="form-input button action<?php if (!$isAcfEnabled) echo ' disabled'; ?>">Update</button>
    </div>
</form>
<hr />
<div class="acf_empty_fields_nullify_copyright">Plugin by <a href="https://jabran.me?utm_source=acf_empty_fields_nullify" target="_blank" rel="noopener">Jabran Rafique</a></div>
