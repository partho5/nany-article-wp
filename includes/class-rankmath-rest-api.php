<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Rank_Math_Meta_Exposer {
    
    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_rank_math_meta_fields' ) );
    }
    
    /**
     * Register Rank Math meta fields in the REST API under /wp/v2/posts.
     */
    public function register_rank_math_meta_fields() {
        // Register for posts
        register_rest_field( 'post', 'rank_math_meta', array(
            'get_callback'    => array( $this, 'get_rank_math_meta' ),
            'update_callback' => array( $this, 'update_rank_math_meta' ),
            'schema'          => null,
        ) );
        
        // Also register for pages
        register_rest_field( 'page', 'rank_math_meta', array(
            'get_callback'    => array( $this, 'get_rank_math_meta' ),
            'update_callback' => array( $this, 'update_rank_math_meta' ),
            'schema'          => null,
        ) );
        
        // Register for custom post types
        $post_types = get_post_types( array( 'public' => true, '_builtin' => false ) );
        foreach ( $post_types as $post_type ) {
            register_rest_field( $post_type, 'rank_math_meta', array(
                'get_callback'    => array( $this, 'get_rank_math_meta' ),
                'update_callback' => array( $this, 'update_rank_math_meta' ),
                'schema'          => null,
            ) );
        }
    }
    
    /**
     * Retrieve Rank Math meta fields for a post.
     */
    public function get_rank_math_meta( $post, $field_name, $request ) {
        $meta_keys = array(
            'rank_math_focus_keyword',
            'rank_math_description',
            'rank_math_title',
        );
        
        $meta = array();
        foreach ( $meta_keys as $key ) {
            $meta[$key] = get_post_meta( $post['id'], $key, true ) ?: '';
        }
        
        return $meta;
    }
    
    /**
     * Update Rank Math meta fields via REST API.
     */
    public function update_rank_math_meta( $value, $post, $field_name ) {
        if ( ! is_array( $value ) ) {
            return false;
        }
        
        $allowed_keys = array(
            'rank_math_focus_keyword',
            'rank_math_description',
            'rank_math_title',
        );
        
        foreach ( $allowed_keys as $key ) {
            if ( isset( $value[$key] ) ) {
                update_post_meta( $post->ID, $key, sanitize_text_field( $value[$key] ) );
            }
        }
        
        return true;
    }
}

// Initialize the class
new Rank_Math_Meta_Exposer();