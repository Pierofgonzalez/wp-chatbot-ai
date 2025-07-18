<?php
/**
 * Plugin Name:       WP Chatbot AI
 * Description:       Chatbot IA para WordPress usando una API gratuita.
 * Version:           1.0.0
 * Author:            WP Plugin Architect
 * Author URI:        https://chatgpt.com/g/g-6cqBCrKTn-wp-plugin-architect
 * Text Domain:       wp-chatbot-ai
 * License:           GPLv2 or later
 */

defined( 'ABSPATH' ) || exit;

define( 'WP_CHATBOT_AI_VERSION', '1.0.0' );
define( 'WP_CHATBOT_AI_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_CHATBOT_AI_URL', plugin_dir_url( __FILE__ ) );

require_once WP_CHATBOT_AI_PATH . 'includes/class-chatbot-init.php';

add_action( 'plugins_loaded', [ 'WP_Chatbot_Init', 'init' ] );
