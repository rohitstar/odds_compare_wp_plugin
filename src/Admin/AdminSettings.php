<?php
namespace OddsCompare\Admin;

class AdminSettings {
    public function register_menu() {
        add_menu_page(
            'Odds Compare Settings',
            'Odds Compare',
            'manage_options',
            'odds-compare',
            [$this, 'render_settings_page'],
            'dashicons-chart-line'
        );
    }

    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        ?>
        <div class="wrap">
            <h1>Odds Compare Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('odds_compare_settings');
                do_settings_sections('odds_compare_settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function register_settings() {
        register_setting('odds_compare_settings', 'odds_compare_settings', [$this, 'sanitize_settings']);
        add_settings_section('odds_compare_main', 'Main Settings', null, 'odds_compare_settings');
        add_settings_field('bookmakers', 'Bookmakers', [$this, 'bookmakers_field'], 'odds_compare_settings', 'odds_compare_main');
        add_settings_field('markets', 'Markets', [$this, 'markets_field'], 'odds_compare_settings', 'odds_compare_main');
    }

    public function bookmakers_field() {
        $settings = get_option('odds_compare_settings', []);
        $bookmakers = $settings['bookmakers'] ?? [];
        ?>
        <input type="checkbox" name="odds_compare_settings[bookmakers][]" value="oddschecker" <?php checked(in_array('oddschecker', $bookmakers)); ?>> Oddschecker
        <?php
    }

    public function markets_field() {
        $settings = get_option('odds_compare_settings', []);
        $markets = $settings['markets'] ?? [];
        ?>
        <input type="checkbox" name="odds_compare_settings[markets][]" value="match-winner" <?php checked(in_array('match-winner', $markets)); ?>> Match Winner
        <input type="checkbox" name="odds_compare_settings[markets][]" value="over-under" <?php checked(in_array('over-under', $markets)); ?>> Over/Under
        <?php
    }

    public function sanitize_settings($input) {
        $sanitized = [];
        $sanitized['bookmakers'] = array_map('sanitize_text_field', $input['bookmakers'] ?? []);
        $sanitized['markets'] = array_map('sanitize_text_field', $input['markets'] ?? []);
        return $sanitized;
    }
}