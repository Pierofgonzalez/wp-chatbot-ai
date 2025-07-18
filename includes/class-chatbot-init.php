<?php
defined( 'ABSPATH' ) || exit;

class WP_Chatbot_Init {

    public static function init() {
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_assets' ] );
        add_action( 'wp_footer', [ __CLASS__, 'render_chat_window' ] );
        add_action( 'rest_api_init', [ __CLASS__, 'register_rest_routes' ] );
    }

    public static function enqueue_assets() {
        wp_enqueue_style(
            'wp-chatbot-ai',
            WP_CHATBOT_AI_URL . 'css/chatbot.css',
            [],
            WP_CHATBOT_AI_VERSION
        );

        wp_enqueue_script(
            'wp-chatbot-ai',
            WP_CHATBOT_AI_URL . 'assets/js/chatbot.js',
            [],
            WP_CHATBOT_AI_VERSION,
            true
        );

        wp_localize_script( 'wp-chatbot-ai', 'ChatbotAI', [
            'nonce' => wp_create_nonce( 'wp_rest' ),
            'endpoint' => esc_url_raw( rest_url( 'wp-chatbot-ai/v1/message' ) ),
        ] );
    }

    public static function render_chat_window() {
        include WP_CHATBOT_AI_PATH . 'templates/chatbot-window.php';
    }

    public static function register_rest_routes() {
        require_once WP_CHATBOT_AI_PATH . 'includes/class-chatbot-api.php';
        WP_Chatbot_API::register_routes();
    }
}
