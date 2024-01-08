<?php

/**
 * The Auto_Pilot_Settings class is responsible for managing the plugin settings.
 */
class Auto_Pilot_Settings {

    /**
     * The options name to be used for this plugin's settings.
     *
     * @var string
     */
    private $options_name = 'auto_pilot_plugin_options';

    /**
     * Constructor for the Auto_Pilot_Settings class.
     */
    public function __construct() {
        // Add actions to handle the settings initialization and saving.
        add_action('admin_init', array($this, 'initialize_settings'));
    }

    /**
     * Initializes the plugin settings by registering the settings and their sections and fields.
     */
    public function initialize_settings() {
        // Register a new setting for the Auto-Pilot plugin page.
        register_setting('auto_pilot_plugin_options_group', $this->options_name);

        // Add a new section to the plugin page for the API key configuration.
        add_settings_section(
            'auto_pilot_plugin_api_key_section',
            'API Key Configuration',
            array($this, 'api_key_section_callback'),
            'auto_pilot_plugin'
        );

        // Add a new field to the API key section for the OpenAI API key.
        add_settings_field(
            'openai_api_key',
            'OpenAI API Key',
            array($this, 'api_key_field_callback'),
            'auto_pilot_plugin',
            'auto_pilot_plugin_api_key_section'
        );

        // Add more sections and fields as needed for content, interaction, SEO, and analytics settings.
    }

    /**
     * Callback for the API key section.
     */
    public function api_key_section_callback() {
        echo '<p>Enter your OpenAI API key to enable content generation and interaction handling.</p>';
    }

    /**
     * Callback for the OpenAI API key field.
     */
    public function api_key_field_callback() {
        // Get the value of the setting we've registered with register_setting()
        $options = get_option($this->options_name);
        $api_key = isset($options['openai_api_key']) ? esc_attr($options['openai_api_key']) : '';
        // Output the field
        echo '<input type="text" id="openai_api_key" name="' . $this->options_name . '[openai_api_key]" value="' . $api_key . '" />';
    }

    // Add more callbacks for additional settings fields as needed.

    /**
     * Retrieves the plugin settings.
     *
     * @return array The array of settings.
     */
    public function get_settings() {
        return get_option($this->options_name, array());
    }

    /**
     * Updates a specific plugin setting.
     *
     * @param string $key The setting key.
     * @param mixed $value The new value for the setting.
     */
    public function update_setting($key, $value) {
        $options = $this->get_settings();
        $options[$key] = $value;
        update_option($this->options_name, $options);
    }
}

?>
