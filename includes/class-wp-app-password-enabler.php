<?php

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

class WP_App_Password_Enabler {

    public function __construct() {
        error_log('WP_App_Password_Enabler class initialized!'); // Debug log
        
        add_filter('wp_is_application_passwords_available', '__return_true');
        add_filter('wp_is_application_passwords_available_for_user', '__return_true');
        add_filter('application_password_is_api_request', '__return_true');
        
        if (!defined('WP_APPLICATION_PASSWORDS')) {
            define('WP_APPLICATION_PASSWORDS', true);
        }
    }
}

// Initialize the class
new WP_App_Password_Enabler();
