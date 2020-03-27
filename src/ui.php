<?php

/**
 * Admin UI Page
 *
 * @author Jabran Rafique
 */

$isSuccess = false;

if (
    isset($_POST['nullify_empty_fields_for_acf_form_wp_nonce']) &&
    wp_verify_nonce($_POST['nullify_empty_fields_for_acf_form_wp_nonce'], 'update-plugin-options')
) {

    if (isset($_POST['nullify-types'])) {
        $nullifyTypes = sanitize_text_field($_POST['nullify-types']);

        if (empty($nullifyTypes)) {
            delete_option('nullify_empty_fields_for_acf_types');
        } else {
            update_option('nullify_empty_fields_for_acf_types', $nullifyTypes);
        }

        $isSuccess = true;
    }
}

?>

<style>
    .nullify_empty_fields_for_acf_form {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
    .nullify_empty_fields_for_acf_form .form-group {
        display: block;
        font-weight: normal;
    }
    .nullify_empty_fields_for_acf_form .form-label {
        display: block;
        font-size: 14px;
        color: #333;
        margin-top: 1rem;
        margin-bottom: 4px;
        font-weight: bold;
    }
    .nullify_empty_fields_for_acf_form .helper-text {
        display: block;
        color: #666;
        font-size: 12px;
        margin-top: 4px;
    }
    .nullify_empty_fields_for_acf_copyright {
        font-weight: normal;
        font-size: 12px;
        color: #888;
    }
</style>

<h2>Nullify empty fields for ACF</h2>

<?php
    if ($isSuccess) {
        printf('<div class="notice notice-success is-dismissible"><p>%s</p></div>', __( 'Successfully updated', 'nullify_empty_fields_for_acf' ));
    }

    if (!nullify_empty_fields_for_acf_is_acf_active()) {
        printf('<div class="notice notice-error is-dismissible">');
        printf(
            '<p>%s</p>',
            __(
                '<strong>Nullify empty fields for ACF</strong> depends on the last version of <strong>Advanced Custom Fields (ACF)</strong> to work!',
                'nullify_empty_fields_for_acf'
            )
        );

        printf(
            '<p><a href="%s" class="button button-primary">Activate in plugins &raquo;</a></p>',
            admin_url('plugins.php')
        );

        printf('</div>');
    }
?>

<form method="post" class="nullify_empty_fields_for_acf_form" action="<?php echo admin_url(htmlentities(basename($_SERVER['PHP_SELF']) . '?' .$_SERVER['QUERY_STRING'])); ?>">
    <div class="form-group">
        <label for="nullify-types" class="form-label">Field types to nullify</label>
        <p class="helper-text">Add types separated by commas e.g. "repeater, image, text". Leave it empty to nullify all types.</p>
        <input
            id="nullify-types"
            name="nullify-types"
            class="form-input regular-text<?php if (!nullify_empty_fields_for_acf_is_acf_active()) echo ' disabled" disabled'; ?>"
            <?php if (!nullify_empty_fields_for_acf_is_acf_active()) echo 'disabled'; ?>
            type="text"
            value="<?php echo get_option('nullify_empty_fields_for_acf_types'); ?>"
        />
        <?php wp_nonce_field('update-plugin-options', 'nullify_empty_fields_for_acf_form_wp_nonce', '', true); ?>
        <button
            type="submit"
            id="nullify-submit"
            class="form-input button action<?php if (!nullify_empty_fields_for_acf_is_acf_active()) echo ' disabled'; ?>">Update</button>
    </div>
</form>
<hr />
<div class="nullify_empty_fields_for_acf_copyright">Plugin by <a href="https://jabran.me?utm_source=nullify_empty_fields_for_acf" target="_blank" rel="noopener">Jabran Rafique</a></div>
