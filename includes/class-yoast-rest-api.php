<?php
/**
 * SEO Metadata REST API Integration
 * 
 * Handles both Yoast SEO and Rank Math metadata in the WordPress REST API
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'plugins_loaded', 'SEO_Meta_REST_API_init' );

class SEO_Meta_REST_API {
    protected $yoast_keys = array(
        'yoast_wpseo_focuskw',
        'yoast_wpseo_metadesc'
    );
    
    protected $rank_math_keys = array(
        'rank_math_focus_keyword',
        'rank_math_description'
    );
    
    function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_seo_meta_fields' ) );
    }
    
    function register_seo_meta_fields() {
        // Get all post types to register fields for
        $post_types = array_merge(
            array('post', 'page'),
            get_post_types(array('public' => true, '_builtin' => false))
        );
        
        foreach ($post_types as $post_type) {
            // Register Yoast SEO fields
            if (class_exists('WPSEO_Frontend')) {
                register_rest_field( $post_type,
                    'yoast_meta',
                    array(
                        'get_callback'    => array( $this, 'get_yoast_meta' ),
                        'update_callback' => array( $this, 'update_yoast_meta' ),
                        'schema'          => null,
                    )
                );
            }
            
            // Register Rank Math fields
            if (class_exists('RankMath')) {
                register_rest_field( $post_type,
                    'rank_math_meta',
                    array(
                        'get_callback'    => array( $this, 'get_rank_math_meta' ),
                        'update_callback' => array( $this, 'update_rank_math_meta' ),
                        'schema'          => null,
                    )
                );
            }
        }
    }
    
    /**
     * Get Yoast SEO metadata for a post
     */
    function get_yoast_meta( $post, $field_name, $request ) {
        $yoast_meta = array();
        
        foreach ($this->yoast_keys as $key) {
            $yoast_meta[$key] = get_post_meta( $post['id'], '_' . $key, true );
        }
        
        return (array) $yoast_meta;
    }
    
    /**
     * Update Yoast SEO metadata via REST API
     */
    function update_yoast_meta( $value, $post, $field_name ) {
        if (!is_array($value)) {
            return false;
        }
        
        foreach ($value as $key => $val) {
            if (in_array($key, $this->yoast_keys) && !empty($key)) {
                update_post_meta($post->ID, '_' . $key, sanitize_text_field($val));
            }
        }
        
        return true;
    }
    
    /**
     * Get Rank Math metadata for a post
     */
    function get_rank_math_meta( $post, $field_name, $request ) {
        $rank_math_meta = array();
        
        foreach ($this->rank_math_keys as $key) {
            $rank_math_meta[$key] = get_post_meta( $post['id'], $key, true );
        }
        
        return (array) $rank_math_meta;
    }
    
    /**
     * Update Rank Math metadata via REST API
     */
    function update_rank_math_meta( $value, $post, $field_name ) {
        if (!is_array($value)) {
            return false;
        }
        
        foreach ($value as $key => $val) {
            if (in_array($key, $this->rank_math_keys)) {
                update_post_meta($post->ID, $key, sanitize_text_field($val));
            }
        }
        
        return true;
    }
}

/**
 * Initialize the SEO Meta REST API class if any supported SEO plugin is active
 */
function SEO_Meta_REST_API_init() {
    if (class_exists('WPSEO_Frontend') || class_exists('RankMath')) {
        new SEO_Meta_REST_API();
    } else {
        add_action('admin_notices', 'seo_plugin_not_loaded');
    }
}

/**
 * Display admin notice if no supported SEO plugin is active
 */
function seo_plugin_not_loaded() {
    printf(
        '<div class="error"><p>%s</p></div>',
        __('SEO Meta REST API integration requires either <b>Yoast SEO</b> or <b>Rank Math SEO</b> plugin to be active.')
    );
}