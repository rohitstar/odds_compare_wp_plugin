<?php
namespace OddsCompare\Scrapers;


class ScraperFactory {
    private $scrapers = [];

    public function register($slug, $class) {
        $this->scrapers[$slug] = $class;
    }

    public function get($slug): ?ScraperInterface {
        if (!isset($this->scrapers[$slug])) {
            return null;
        }
        $class = $this->scrapers[$slug];
        return new $class();
    }

    public function getAll(): array {
        return array_map(function ($class) {
            return new $class();
        }, $this->scrapers);
    }
}