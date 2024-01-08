<?php

/**
 * The api-key-config.php file is responsible for handling the API key configuration for the Auto-Pilot WordPress Plugin.
 */

// Include the necessary WordPress components.
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Handles the submission of the API key configuration form.
 */
function auto_pilot_plugin_handle_api_key_submission() {
    if (isset($_POST['auto_pilot_plugin_api_key_nonce']) && wp_verify_nonce($_POST['auto_pilot_plugin_api_key_nonce'], 'auto_pilot_plugin_api_key')) {
        // Check if the user has the required capability to perform this action.
        if (current_user_can('manage_options')) {
            // Instantiate the settings class to access plugin settings methods.
            $settings = new Auto_Pilot_Settings();

            // Sanitize and update the API key.
            $api_key = sanitize_text_field($_POST['auto_pilot_plugin_options']['openai_api_key']);
            $settings->update_setting('openai_api_key', $api_key);

            // Redirect back to the settings page with a success message.
            wp_redirect(add_query_arg('message', 'api_key_saved', menu_page_url('auto_pilot_plugin', false)));
            exit;
        }
    }
}

// Hook the function to WordPress 'admin_post' action for handling form submissions.
add_action('admin_post_auto_pilot_plugin_update_api_key', 'auto_pilot_plugin_handle_api_key_submission');

/**
 * Displays a success message after the API key has been saved.
 */
function auto_pilot_plugin_admin_notices() {
    if (isset($_GET['message']) && $_GET['message'] === 'api_key_saved') {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('OpenAI API key saved successfully.', 'auto-pilot-plugin'); ?></p>
        </div>
        <?php
    }
}

// Hook the admin notices action to display messages in the admin area.
add_action('admin_notices', 'auto_pilot_plugin_admin_notices');

?>
