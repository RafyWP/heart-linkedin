<?php

defined('ABSPATH') || exit;

add_action('admin_menu', function () {
    add_options_page(
        'Heart LinkedIn Settings',
        'Heart LinkedIn',
        'manage_options',
        'heart-linkedin-settings',
        'rafy_heart_linkedin_render_settings_page'
    );
});

function rafy_heart_linkedin_render_settings_page() {
    if (isset($_POST['heart_linkedin_token'])) {
        check_admin_referer('rafy_heart_linkedin_settings');
        update_option('heart_linkedin_token', sanitize_text_field($_POST['heart_linkedin_token']));
        echo '<div class="updated"><p>Token salvo com sucesso.</p></div>';
    }

    $token = get_option('heart_linkedin_token', '');
    ?>
    <div class="wrap">
        <h1>Heart LinkedIn – Configurações</h1>
        <form method="post">
            <?php wp_nonce_field('rafy_heart_linkedin_settings'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="heart_linkedin_token">Token de autenticação</label></th>
                    <td><input type="text" id="heart_linkedin_token" name="heart_linkedin_token" value="<?php echo esc_attr($token); ?>" class="regular-text" /></td>
                </tr>
            </table>
            <?php submit_button('Salvar'); ?>
        </form>
    </div>
    <?php
}
