<?php
namespace OddsCompare\Api;

use OddsCompare\OddsManager;
use OddsCompare\Helpers\OddsConverter;

class RestRoutes {
    private $oddsManager;

    public function __construct(OddsManager $oddsManager) {
        $this->oddsManager = $oddsManager;
    }

    public function register_routes() {
        register_rest_route('odds-compare/v1', '/odds', [
            'methods' => 'GET',
            'callback' => [$this, 'get_odds'],
            'permission_callback' => '__return_true',
        ]);
        register_rest_route('odds-compare/v1', '/convert', [
            'methods' => 'GET',
            'callback' => [$this, 'convert_odds'],
            'permission_callback' => '__return_true',
        ]);
        register_rest_route('odds-compare/v1', '/refresh', [
            'methods' => 'POST',
            'callback' => [$this, 'refresh_cache'],
            'permission_callback' => [$this, 'admin_permission_check'],
        ]);
    }

    public function get_odds(\WP_REST_Request $request) {
        $event = sanitize_text_field($request->get_param('event'));
        $market = sanitize_text_field($request->get_param('market'));
        $format = sanitize_text_field($request->get_param('format') ?? 'decimal');
        $bookmakers = explode(',', sanitize_text_field($request->get_param('bookmakers') ?? 'oddschecker'));
        $odds = $this->oddsManager->getComparison($event, $market, $bookmakers, $format);
        return new \WP_REST_Response($odds, 200, ['Cache-Control' => 'max-age=120']);
    }

    public function convert_odds(\WP_REST_Request $request) {
        $from = sanitize_text_field($request->get_param('from'));
        $to = sanitize_text_field($request->get_param('to'));
        $value = floatval($request->get_param('value'));
        if ($from === 'decimal' && $to === 'fractional') {
            $result = OddsConverter::decimalToFractional($value);
        } elseif ($from === 'fractional' && $to === 'decimal') {
            $result = OddsConverter::fractionalToDecimal($value);
        } elseif ($from === 'decimal' && $to === 'american') {
            $result = OddsConverter::decimalToAmerican($value);
        } elseif ($from === 'american' && $to === 'decimal') {
            $result = OddsConverter::americanToDecimal($value);
        } else {
            return new \WP_REST_Response(['error' => 'Invalid conversion'], 400);
        }
        return new \WP_REST_Response(['result' => $result], 200);
    }

    public function refresh_cache(\WP_REST_Request $request) {
        if (!wp_verify_nonce($request->get_header('X-WP-Nonce'), 'wp_rest')) {
            return new \WP_REST_Response(['error' => 'Invalid nonce'], 403);
        }
        $settings = get_option('odds_compare_settings', []);
        $this->oddsManager->refresh_odds($settings['bookmakers'] ?? [], $settings['markets'] ?? []);
        return new \WP_REST_Response(['status' => 'Cache refreshed'], 200);
    }

    public function admin_permission_check() {
        return current_user_can('manage_options');
    }
}