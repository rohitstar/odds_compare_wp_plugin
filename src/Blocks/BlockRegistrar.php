<?php
namespace OddsCompare\Blocks;

class BlockRegistrar {
    public function register() {
        register_block_type(__DIR__ . '/odds-compare-block', [
            'render_callback' => [$this, 'render_block'],
        ]);
    }

    public function render_block($attributes) {
        $event = esc_attr($attributes['event'] ?? 'test-event');
        $market = esc_attr($attributes['market'] ?? 'match-winner');
        $bookmakers = esc_attr(implode(',', $attributes['bookmakers'] ?? ['oddschecker']));
        $format = esc_attr($attributes['format'] ?? 'decimal');
        ob_start();
        include __DIR__ . '/../../templates/frontend-odds.php';
        return ob_get_clean();
    }
}