# OddsCompare Plugin Architecture

## Overview
The OddsCompare plugin is a modular WordPress plugin for comparing betting odds. It uses PSR-4 autoloading, a Gutenberg block, REST API endpoints, and a caching layer to deliver real-time odds comparison.

## Class Diagram
- **Bootstrap**: Singleton to initialize hooks and services.
- **OddsManager**: Coordinates scrapers, caching, and normalization.
- **ScraperFactory**: Instantiates bookmaker-specific scrapers.
- **ScraperInterface / AbstractScraper**: Defines scraper contract and common logic.
- **CacheLayer**: Wraps transients and object cache.
- **OddsConverter**: Handles odds format conversions.
- **AdminSettings**: Manages admin UI and settings.
- **RestRoutes**: Registers REST API endpoints.
- **BlockRegistrar**: Registers Gutenberg block.

## Data Flow
1. Gutenberg block or front-end requests odds via REST API.
2. `OddsManager` checks cache (`CacheLayer`).
3. If cache miss, `ScraperFactory` provides scrapers to fetch odds.
4. Odds are normalized, converted (via `OddsConverter`), cached, and returned.
5. Background WP-Cron refreshes cache.

## Caching
- Transients with 30–120s TTL per event-market-bookmaker.
- Fallback to WordPress object cache.
- Background refresh via WP-Cron.