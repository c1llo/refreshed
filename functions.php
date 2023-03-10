<?php

if (!defined('ABSPATH')) exit;
/**
 * Gets modified timestamp of last edited post or page
 * @return int unix timestamp or 0 if no posts found
 */
function refreshed_get_latest_post_modified_time()
{
    $args = array(
        'post_type' => 'any',
        'orderby' => 'modified',
        'order' => 'DESC',
        'posts_per_page' => 1
    );
    $latestEditedPosts = new WP_Query($args);
    if (!$latestEditedPosts->have_posts()) return 0;
    $latestPost = $latestEditedPosts->posts[0];
    $latestTimestamp = strtotime($latestPost->post_modified);
    return $latestTimestamp;
}

/**
 * Handler function for REST route
 *
 * @return WP_REST_Response
 */
function refresh_status_func()
{
    try {
        $data = [
            "data" => [
                "latest" => refreshed_get_latest_post_modified_time(),
            ],
            "status" => 200,
        ];
        $response = new WP_REST_Response($data);
        $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', '0');
        return $response;
    } catch (Exception $e) {
        $data  = [
            "data" => null,
            "error" => "Unable to retrieve status",
            "status" => 500,
        ];
        $response = new WP_REST_Response($data);
        $response->set_status(500);
        return $response;
    }
}


/**
 * WP Action Hook to register new REST API endpoint for status
 */
add_action('rest_api_init', function () {
    if (carbon_get_theme_option('refreshed_enabled')) {
        register_rest_route('refreshed/v1', '/status', array(
            'methods' => 'GET',
            'callback' => 'refresh_status_func',
        ));
    }
});

/**
 * Function to enqueue client script
 */
function refreshed_enqueue_scripts()
{
    if (carbon_get_theme_option('refreshed_enabled')) {
        wp_enqueue_script('refreshed_client', REFRESHED_DIR_URL . 'public/js/refreshed.js');
        wp_localize_script(
            'refreshed_client',
            'refreshed',
            array(
                'interval' => carbon_get_theme_option('refreshed_interval'),
                'url' => get_rest_url() . 'refreshed/v1/status'
            )
        );
    }
}
add_action('wp_enqueue_scripts', 'refreshed_enqueue_scripts');
