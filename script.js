// script.js for Auto-Pilot WordPress Plugin with OpenAI Integration

// Ensure jQuery is loaded in WordPress
(function($) {
    // Document ready function to ensure DOM is fully loaded
    $(document).ready(function() {
        // Function to handle API key configuration submission
        $('#api-key-form').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            var apiKey = $('#api-key').val(); // Get the API key from the input field

            // Perform an AJAX request to save the API key
            $.ajax({
                url: ajaxurl, // Use the global ajaxurl variable defined by WordPress
                type: 'POST',
                data: {
                    action: 'save_api_key', // Action hook for handling the request in WordPress
                    api_key: apiKey, // Pass the API key to the server
                    security: $('#api_key_nonce').val() // Nonce field for security
                },
                success: function(response) {
                    // Handle the response from the server
                    if (response.success) {
                        alert('API Key saved successfully!');
                    } else {
                        alert('Failed to save API Key. Please try again.');
                    }
                },
                error: function() {
                    // Handle any AJAX errors
                    alert('An error occurred while saving the API Key.');
                }
            });
        });

        // Function to handle settings form submission
        $('#settings-form').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Serialize the form data for submission
            var settingsData = $(this).serialize();

            // Perform an AJAX request to save the settings
            $.ajax({
                url: ajaxurl, // Use the global ajaxurl variable defined by WordPress
                type: 'POST',
                data: {
                    action: 'save_settings', // Action hook for handling the request in WordPress
                    settings: settingsData, // Serialized settings data
                    security: $('#settings_nonce').val() // Nonce field for security
                },
                success: function(response) {
                    // Handle the response from the server
                    if (response.success) {
                        alert('Settings saved successfully!');
                    } else {
                        alert('Failed to save settings. Please check your inputs and try again.');
                    }
                },
                error: function() {
                    // Handle any AJAX errors
                    alert('An error occurred while saving the settings.');
                }
            });
        });

        // Additional JavaScript functionality can be added here as needed
        // to support the Auto-Pilot WordPress Plugin's operations.
    });
})(jQuery);
