# OddsCompare WordPress Plugin

A modular plugin for comparing betting odds across bookmakers, featuring a Gutenberg block, REST API, and caching.

## Installation
1. Upload to `wp-content/plugins/odds-compare`.
2. Run `composer install`.
3. Activate via WordPress admin.
4. Configure settings at **Odds Compare > Settings**.

## Usage
- Add the **Odds Compare** block to a post/page.
- Select bookmakers, market, and odds format in the block editor.
- View live odds on the front-end.

## Legal Notes
- Scraping may violate bookmaker terms. Use APIs or affiliate feeds for production.
- Check `docs/admin-guide.md` for compliance details.

## Development
- PSR-4 autoloading via Composer.
- Extend by adding new scrapers (see `docs/extending.md`).
- Run tests in `tests/` with PHPUnit.