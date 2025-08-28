<?php
namespace OddsCompare\Scrapers;

use OddsCompare\Helpers\HttpClient;

abstract class AbstractScraper implements ScraperInterface {
    protected $httpClient;

    public function __construct() {
        $this->httpClient = new HttpClient();
    }

    protected function fetchHtml($url) {
        return $this->httpClient->get($url, ['timeout' => 10]);
    }

    protected function sanitizeOddsFormat($odds) {
        return is_numeric($odds) ? floatval($odds) : 0.0;
    }
}