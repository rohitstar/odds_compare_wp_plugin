# Extending OddsCompare

## Adding a New Bookmaker
1. Create `src/Scrapers/NewBookieScraper.php`:
```php
namespace OddsCompare\Scrapers;

class NewBookieScraper extends AbstractScraper {
    public function getName(): string {
        return 'newbookie';
    }

    public function getAvailableMarkets(): array {
        return ['match-winner'];
    }

    public function getOdds(string $eventId, string $market): array {
        $url = "https://newbookie.com/odds/{$eventId}/{$market}";
        $html = $this->fetchHtml($url);
        // Parse and return normalized array
        return [
            'bookmaker' => $this->getName(),
            'event_id' => $eventId,
            'market' => $market,
            'selection' => 'Team A',
            'odds_decimal' => 1.85
        ];
    }
}