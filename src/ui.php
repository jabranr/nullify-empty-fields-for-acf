<?php

/**
 * UI page
 */

if (isset($_POST['gatsby_wp_acf_nullify_form_wp_nonce']) && wp_verify_nonce($_POST['gatsby_wp_acf_nullify_form_wp_nonce'], 'update-plugin-options')) {

    if (isset($_POST['nullify-types'])) {
        $nullifyTypes = $_POST['nullify-types'];
        $nullifyTypes = explode(',', $nullifyTypes);
        $nullifyTypes = array_map('trim', $nullifyTypes);

        if (empty($nullifyTypes)) {
            delete_option('gatsby_wp_acf_nullify_types', join(',', $nullifyTypes));
        } else {
            update_option('gatsby_wp_acf_nullify_types', join(',', $nullifyTypes));
        }
    }
}

?>

<style>
    .gatsby_wp_acf_nullify_form {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
    .gatsby_wp_acf_nullify_form .form-group {
        display: block;
        font-weight: normal;
    }
    .gatsby_wp_acf_nullify_form .form-label {
        display: block;
        font-size: 14px;
        color: #333;
        margin-bottom: 4px;
        font-weight: bold;
    }
    .gatsby_wp_acf_nullify_form .helper-text {
        display: block;
        color: #666;
        font-size: 12px;
        margin-top: 4px;
    }
    .gatsby_wp_acf_nullify_copyright {
        font-weight: normal;
        font-size: 12px;
        color: #888;
    }
</style>

<h2>Gatsby WP ACF Nullify<h2>

<form method="post" class="gatsby_wp_acf_nullify_form" action="<?php echo admin_url(htmlentities(basename($_SERVER['PHP_SELF']) . '?' .$_SERVER['QUERY_STRING'])); ?>">
    <div class="form-group">
        <label for="nullify-types" class="form-label">Field types to nullify</label>
        <p class="helper-text">Add types separated by commas e.g. "repeater, image, text". Leave it empty to nullify all types.</p>
        <input id="nullify-types" name="nullify-types" class="form-input regular-text" type="text" value="<?php echo get_option('gatsby_wp_acf_nullify_types'); ?>" />
        <?php wp_nonce_field('update-plugin-options', 'gatsby_wp_acf_nullify_form_wp_nonce', '', true); ?>
        <button type="submit" id="nullify-submit" class="form-input button action">Update settings</button>
    </div>
</form>
<hr />
<div class="gatsby_wp_acf_nullify_copyright">Plugin by <a href="https://jabran.me?utm_source=gatsby_wp_acf_nullify" target="_blank" rel="noopener">Jabran Rafique</a></div>
