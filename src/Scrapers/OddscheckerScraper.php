<?php
namespace OddsCompare\Scrapers;

class OddscheckerScraper extends AbstractScraper {
    public function getName(): string {
        return 'oddschecker';
    }

    public function getAvailableMarkets(): array {
        return ['match-winner', 'over-under'];
    }

    public function getOdds(string $eventId, string $market): array {
        $url = "https://example.com/odds/{$eventId}/{$market}";
        try {
            $html = $this->fetchHtml($url);
            return [
                'bookmaker' => $this->getName(),
                'event_id' => $eventId,
                'market' => $market,
                'selection' => 'Team A',
                'odds_decimal' => $this->sanitizeOddsFormat(1.75)
            ];
        } catch (\Exception $e) {
            return [];
        }
    }
}