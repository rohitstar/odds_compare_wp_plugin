<?php
namespace OddsCompare;

use OddsCompare\Api\RestRoutes;
use OddsCompare\Admin\AdminSettings;
use OddsCompare\Blocks\BlockRegistrar;
use OddsCompare\OddsManager;

class Bootstrap {
    private static $instance;
    private $oddsManager;
    private $adminSettings;
    private $restRoutes;
    private $blockRegistrar;

    private function __construct() {
        $this->oddsManager = new OddsManager();
        $this->adminSettings = new AdminSettings();
        $this->restRoutes = new RestRoutes($this->oddsManager);
        $this->blockRegistrar = new BlockRegistrar();
    }

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function init() {
        add_action('init', [$this, 'register_rest_routes']);
        add_action('admin_menu', [$this, 'register_admin']);
        add_action('init', [$this, 'register_blocks']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('wp_cron', [$this, 'refresh_cache']);
    }

    public function register_rest_routes() {
        $this->restRoutes->register_routes();
    }

    public function register_admin() {
        $this->adminSettings->register_menu();
    }

    public function register_blocks() {
        $this->blockRegistrar->register();
    }

    public function enqueue_frontend_assets() {
        wp_enqueue_style('odds-compare-frontend', plugins_url('assets/css/frontend.css', __DIR__), [], '1.0.0');
        wp_enqueue_script('odds-compare-frontend', plugins_url('assets/js/block-frontend.js', __DIR__), ['wp-api'], '1.0.0', true);
    }

    public function enqueue_admin_assets() {
        wp_enqueue_style('odds-compare-admin', plugins_url('assets/css/admin.css', __DIR__), [], '1.0.0');
    }

    public function refresh_cache() {
        $settings = get_option('odds_compare_settings', []);
        $bookmakers = $settings['bookmakers'] ?? [];
        $markets = $settings['markets'] ?? ['match-winner'];
        $this->oddsManager->refresh_odds($bookmakers, $markets);
    }
}