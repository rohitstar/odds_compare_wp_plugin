# Demo Setup

## Requirements
- WordPress 5.8+
- PHP 7.4+
- Composer

## Steps
1. Clone the repo to `wp-content/plugins/odds-compare`.
2. Run `composer install`.
3. Activate the plugin.
4. Add the Odds Compare block to a post/page.
5. Configure bookmakers and markets in the admin settings.
6. Test REST endpoint: `/wp-json/odds-compare/v1/odds?event=test-event&market=match-winner`.

## Demo Credentials
- Admin URL: `/wp-admin`
- Username: demo
- Password: demo123