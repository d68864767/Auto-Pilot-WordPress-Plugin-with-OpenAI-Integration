<?php

/**
 * The Auto_Pilot_Content_Generator class is responsible for generating content using OpenAI's API.
 */
class Auto_Pilot_Content_Generator {

    /**
     * Generates content based on the plugin settings and OpenAI's API.
     */
    public function generate_content() {
        // Retrieve plugin options
        $options = get_option('auto_pilot_plugin_options');
        $api_key = isset($options['openai_api_key']) ? $options['openai_api_key'] : '';

        // Check if the OpenAI API key is set
        if (empty($api_key)) {
            error_log('Auto-Pilot Plugin Error: OpenAI API key is not set.');
            return;
        }

        // Define content generation parameters based on plugin settings
        $content_params = array(
            'prompt' => $this->get_content_prompt($options),
            'max_tokens' => 1024, // Example value, adjust as needed
            'temperature' => 0.7, // Example value, adjust as needed
            // Add other parameters as needed
        );

        // Generate content using OpenAI's API
        $generated_content = $this->call_openai_api($api_key, $content_params);

        // Check if content was successfully generated
        if ($generated_content) {
            // Insert the content into a new WordPress post
            $this->insert_generated_content_as_post($generated_content, $options);
        }
    }

    /**
     * Constructs the content prompt based on plugin settings.
     *
     * @param array $options Plugin options.
     * @return string Content prompt for OpenAI.
     */
    private function get_content_prompt($options) {
        // Example prompt construction, adjust based on actual plugin settings
        $prompt = "Write a comprehensive article about ";
        $prompt .= isset($options['content_topic']) ? $options['content_topic'] : 'the latest technology trends';

        return $prompt;
    }

    /**
     * Calls the OpenAI API to generate content.
     *
     * @param string $api_key OpenAI API key.
     * @param array $params Parameters for content generation.
     * @return string|false Generated content or false on failure.
     */
    private function call_openai_api($api_key, $params) {
        // OpenAI API endpoint
        $api_endpoint = 'https://api.openai.com/v1/engines/davinci-codex/completions';

        // Set up the API headers
        $headers = array(
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json',
        );

        // Make the API request
        $response = wp_remote_post($api_endpoint, array(
            'headers' => $headers,
            'body' => json_encode($params),
            'method' => 'POST',
            'data_format' => 'body',
        ));

        // Check for WP_Error or non-200 response code
        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            error_log('Auto-Pilot Plugin Error: Failed to generate content from OpenAI.');
            return false;
        }

        // Decode the response and return the generated content
        $body = json_decode(wp_remote_retrieve_body($response), true);
        return isset($body['choices'][0]['text']) ? $body['choices'][0]['text'] : false;
    }

    /**
     * Inserts the generated content into a new WordPress post.
     *
     * @param string $content The generated content.
     * @param array $options Plugin options.
     */
    private function insert_generated_content_as_post($content, $options) {
        // Define the post data
        $post_data = array(
            'post_title'   => $this->generate_post_title($options),
            'post_content' => $content,
            'post_status'  => 'draft', // Set to 'publish' or another status as needed
            'post_author'  => 1, // Set to a specific author ID as needed
            'post_category'=> array(1), // Set to specific category IDs as needed
            // Add other post data as needed
        );

        // Insert the post into the database
        $post_id = wp_insert_post($post_data);

        // Check for errors
        if (is_wp_error($post_id)) {
            error_log('Auto-Pilot Plugin Error: Failed to insert generated content as post.');
        }
    }

    /**
     * Generates a title for the new post based on plugin settings or content.
     *
     * @param array $options Plugin options.
     * @return string Generated post title.
     */
    private function generate_post_title($options) {
        // Example title generation, adjust based on actual plugin settings
        $title = "Latest Article on ";
        $title .= isset($options['content_topic']) ? $options['content_topic'] : 'Technology Trends';

        return $title;
    }
}

?>
