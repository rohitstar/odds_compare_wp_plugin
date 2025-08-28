<?php
namespace OddsCompare\Helpers;

class CacheLayer {
    public static function get($key) {
        $cached = wp_cache_get($key, 'odds_compare');
        if ($cached !== false) return $cached;
        return \get_transient($key);
    }
    public static function set($key, $value, $ttl = 300) {
        \wp_cache_set($key, $value, 'odds_compare', $ttl);
        set_transient($key, $value, $ttl);
    }
    public static function delete($key) {
        wp_cache_delete($key, 'odds_compare');
        delete_transient($key);
    }
}
