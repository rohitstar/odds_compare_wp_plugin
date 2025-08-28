<?php
namespace OddsCompare\Helpers;

class HttpClient {
    public function get($url, $args = []) {
        $response = wp_remote_get($url, $args);
        if (is_wp_error($response)) {
            throw new \Exception($response->get_error_message());
        }
        return wp_remote_retrieve_body($response);
    }
}