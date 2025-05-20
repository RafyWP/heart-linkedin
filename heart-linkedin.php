<?php
/**
 * Heart LinkedIn Block
 * 
 * LinkedIn like and comment button.
 * 
 * @link              https://rafy.com.br/project/heart-linkedin
 * @since             1.0.0
 * @package           RafyCo\HeartLinkedIn
 * @author            Rafy Co.
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Heart LinkedIn Block
 * Plugin URI:        https://rafy.com.br/project/heart-linkedin
 * Description:       LinkedIn like and comment button.
 * Version:           0.1.2
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Rafy Co.
 * Author URI:        https://rafy.com.br
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       heart-linkedin
 * Domain Path:       /languages
 * Update URI:        https://github.com/RafyWP/heart-linkedin/tree/master
 * Network:           true
 */

defined('ABSPATH') || exit;

define('HLB_DIR', plugin_dir_path(__FILE__));
define('HLB_URL', plugin_dir_url(__FILE__));

// Register REST API
require_once HLB_DIR . 'includes/rest-api.php';

// Register admin settings
require_once HLB_DIR . 'includes/admin-settings.php';

// Enqueue assets
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('heart-linkedin-css', HLB_URL . 'assets/css/heart-linkedin.css', [], '0.1.2');
    wp_enqueue_script('heart-linkedin-js', HLB_URL . 'assets/js/heart-linkedin.js', ['jquery'], '0.1.2', true);
    
    wp_localize_script( 'heart-linkedin-js', 'HeartLinkedinVars', [
        'ajaxUrl'    => esc_url_raw( rest_url( 'heart-linkedin/v1/toggle' ) ),
        'pluginUrl'  => plugin_dir_url( __FILE__ ),
        'token'      => get_option( 'heart_linkedin_token' ),
        'nonce'      => wp_create_nonce( 'wp_rest' ),
        'userId'     => get_current_user_id(),
    ] );

});

// Register block via dynamic render
add_action('init', function () {
    register_block_type('heart-linkedin/block', [
        'render_callback' => 'rafy_render_heart_linkedin_block',
    ]);
});

add_shortcode( 'heart_linkedin', 'rafy_render_heart_linkedin_block' );

function rafy_render_heart_linkedin_block($attributes, $content) {
    $user_id = get_current_user_id();
    $post_id = get_the_ID();
    $likes = get_field('likes', 'user_' . $user_id, false) ?: [];

    $liked = in_array($post_id, $likes);
    $img_src = $liked
        ? HLB_URL . 'assets/img/heart-red.png'
        : HLB_URL . 'assets/img/heart-empty.png';

    $linkedin_url = get_field('in_post', $post_id) ?: 'https://www.linkedin.com/shareArticle?mini=true&url=' . get_permalink($post_id);

    $output = '';
    $output .= '<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->';
    $output .= '<div class="wp-block-group rafy-heart-group" data-post-id="' . esc_attr($post_id) . '" data-liked="' . esc_attr($liked ? '1' : '0') . '">';
    $output .= '<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->';
    $output .= '<div class="wp-block-group rafy-heart-wrapper">';
    $output .= '<!-- wp:image -->';
    $output .= '<figure class="wp-block-image size-full"><img src="' . esc_url($img_src) . '" alt="" class="rafy-heart-image" /></figure>';
    $output .= '<!-- /wp:image -->';
    $output .= '<!-- wp:paragraph {"fontSize":"small"} -->';
    $output .= '<p class="has-small-font-size rafy-heart-text">Curtir</p>';
    $output .= '<!-- /wp:paragraph -->';
    $output .= '</div>';
    $output .= '<!-- /wp:group -->';
    $output .= '<!-- wp:buttons -->';
    $output .= '<div class="wp-block-buttons">';
    $output .= '<!-- wp:button -->';
    $output .= '<div class="wp-block-button"><a href="' . esc_url($linkedin_url) . '" target="_blank" rel="noopener" class="wp-block-button__link has-pure-white-color has-ocean-blaze-background-color has-text-color has-background has-link-color has-small-font-size has-custom-font-size wp-element-button rafy-linkedin-button">Comentar no <strong>LinkedIn</strong> <strong>↗</strong></a></div>';
    $output .= '<!-- /wp:button -->';
    $output .= '</div>';
    $output .= '<!-- /wp:buttons -->';
    $output .= '</div>';
    $output .= '<!-- /wp:group -->';

    return $output;
}
