<?php
namespace OddsCompare\Scrapers;

interface ScraperInterface {
    public function getName(): string;
    public function getAvailableMarkets(): array;
    public function getOdds(string $eventId, string $market): array;
}