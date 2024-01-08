<?php

/**
 * The admin-page.php is responsible for rendering the plugin's admin settings page in the WordPress dashboard.
 */

// Include the necessary WordPress components.
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Renders the admin settings page for the Auto-Pilot WordPress Plugin.
 */
function auto_pilot_plugin_admin_page() {
    ?>
    <div class="wrap">
        <h1>Auto-Pilot Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php
            // Output security fields for the registered setting "auto_pilot_plugin_options_group"
            settings_fields('auto_pilot_plugin_options_group');
            // Output setting sections and their fields
            do_settings_sections('auto_pilot_plugin');
            // Output save settings button
            submit_button('Save Changes');
            ?>
        </form>
    </div>
    <?php
}

/**
 * Initializes the plugin's admin page by adding it to the WordPress dashboard menu.
 */
function auto_pilot_plugin_add_admin_menu() {
    add_menu_page(
        'Auto-Pilot Plugin Settings', // Page title
        'Auto-Pilot', // Menu title
        'manage_options', // Capability
        'auto_pilot_plugin', // Menu slug
        'auto_pilot_plugin_admin_page', // Function to display the page
        'dashicons-admin-generic', // Icon URL
        81 // Position
    );
}

// Hook the admin menu action to add the admin menu page
add_action('admin_menu', 'auto_pilot_plugin_add_admin_menu');

/**
 * Registers the plugin's admin page styles and scripts.
 */
function auto_pilot_plugin_admin_enqueue_scripts($hook) {
    // Load only on ?page=auto_pilot_plugin
    if ($hook != 'toplevel_page_auto_pilot_plugin') {
        return;
    }

    // Enqueue styles and scripts here if necessary
    wp_enqueue_style('auto_pilot_plugin_admin_style', plugins_url('style.css', __FILE__));
    wp_enqueue_script('auto_pilot_plugin_admin_script', plugins_url('script.js', __FILE__));
}

// Hook the admin enqueue scripts action to register admin page styles and scripts
add_action('admin_enqueue_scripts', 'auto_pilot_plugin_admin_enqueue_scripts');
?>
