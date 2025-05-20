<?php

defined('ABSPATH') || exit;

add_action('rest_api_init', function () {
    register_rest_route('heart-linkedin/v1', '/toggle', [
        'methods'             => 'POST',
        'callback'            => 'rafy_toggle_like_callback',
        'permission_callback' => 'rafy_heart_linkedin_check_token_permission',
        'args' => [
            'post_id' => [
                'required' => true,
                'type'     => 'integer',
            ],
        ],
    ]);
});

function rafy_toggle_like_callback( \WP_REST_Request $request ) {
    $user_id = absint( $request->get_param( 'user_id' ) );
    $post_id = absint( $request->get_param( 'post_id' ) );

    if ( ! $user_id || ! $post_id || ! get_post( $post_id ) ) {
        return new \WP_REST_Response( [ 'error' => 'Invalid data' ], 400 );
    }

    $likes = get_field( 'likes', 'user_' . $user_id );

    if ( ! is_array( $likes ) ) {
        $likes = [];
    }

    if ( in_array( $post_id, $likes ) ) {
        $likes = array_diff( $likes, [ $post_id ] );
        $action = 'unliked';
    } else {
        $likes[] = $post_id;
        $likes = array_unique( array_map( 'absint', $likes ) );
        $action = 'liked';
    }

    update_field( 'likes', $likes, 'user_' . $user_id );

    return new \WP_REST_Response( [
        'status' => 'success',
        'action' => $action,
        'likes'  => array_values( $likes ),
    ] );
}

function rafy_heart_linkedin_check_token_permission($request) {
    $provided_token = $request->get_header('heart-token');
    $saved_token = get_option('heart_linkedin_token');

    if (!$saved_token || !$provided_token) {
        return false;
    }

    return hash_equals($saved_token, $provided_token);
}
