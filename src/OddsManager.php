<?php
namespace OddsCompare;

use OddsCompare\Scrapers\ScraperFactory;
use OddsCompare\Helpers\CacheLayer;
use OddsCompare\Helpers\OddsConverter;

class OddsManager {
    private $scraperFactory;
    private $cacheLayer;

    public function __construct() {
        $this->scraperFactory = new ScraperFactory();
        $this->scraperFactory->register('oddschecker', \OddsCompare\Scrapers\OddscheckerScraper::class);
        $this->cacheLayer = new CacheLayer();
    }

    public function getComparison($eventId, $market, $bookmakers, $format = 'decimal') {
        $cacheKey = "odds_{$eventId}_{$market}_" . implode('_', $bookmakers);
        $cached = $this->cacheLayer->get($cacheKey);
        if ($cached) {
            return $this->formatOdds($cached, $format);
        }

        $results = [];
        foreach ($bookmakers as $bookmaker) {
            $scraper = $this->scraperFactory->get($bookmaker);
            if ($scraper) {
                $odds = $scraper->getOdds($eventId, $market);
                if ($odds) {
                    $results[] = $odds;
                }
            }
        }

        $this->cacheLayer->set($cacheKey, $results);
        return $this->formatOdds($results, $format);
    }

    private function formatOdds($odds, $format) {
        if ($format === 'decimal') {
            return $odds;
        }
        return array_map(function ($item) use ($format) {
            if ($format === 'fractional') {
                $item['odds'] = OddsConverter::decimalToFractional($item['odds_decimal']);
            } elseif ($format === 'american') {
                $item['odds'] = OddsConverter::decimalToAmerican($item['odds_decimal']);
            }
            return $item;
        }, $odds);
    }

    public function refresh_odds($bookmakers, $markets) {
        foreach ($bookmakers as $bookmaker) {
            $scraper = $this->scraperFactory->get($bookmaker);
            if ($scraper) {
                foreach ($markets as $market) {
                    $this->getComparison('test-event', $market, [$bookmaker]);
                }
            }
        }
    }
}