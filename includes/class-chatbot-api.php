<?php
defined( 'ABSPATH' ) || exit;

class WP_Chatbot_API {

    public static function register_routes() {
        register_rest_route( 'wp-chatbot-ai/v1', '/message', [
            'methods'             => 'POST',
            'callback'            => [ __CLASS__, 'handle_message' ],
            'permission_callback' => '__return_true',
        ] );
    }

    public static function handle_message( WP_REST_Request $request ) {
        $message = sanitize_text_field( $request->get_param( 'message' ) );

        if ( empty( $message ) ) {
            return new WP_REST_Response( [ 'error' => __( 'Mensaje vacío', 'wp-chatbot-ai' ) ], 400 );
        }

        $response = self::get_ai_response( $message );

        return rest_ensure_response( [ 'response' => $response ] );
    }

    private static function get_ai_response( $message ) {
        // Llamada a IA gratuita: ejemplo usando HuggingFace modelo "gpt2"
        $args = [
            'body'    => json_encode( [ 'inputs' => $message ] ),
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'timeout' => 15,
        ];

        $request = wp_remote_post( 'https://api-inference.huggingface.co/models/gpt2', $args );

        if ( is_wp_error( $request ) ) {
            return __( 'Error al conectar con IA.', 'wp-chatbot-ai' );
        }

        $body = json_decode( wp_remote_retrieve_body( $request ), true );

        if ( isset( $body[0]['generated_text'] ) ) {
            return sanitize_text_field( $body[0]['generated_text'] );
        }

        return __( 'Sin respuesta de IA.', 'wp-chatbot-ai' );
    }
}
