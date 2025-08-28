<?php
/**
 * Plugin Name: OddsCompare
 * Description: Advanced odds comparison plugin for WordPress.
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL-2.0+
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

use OddsCompare\Bootstrap;

Bootstrap::get_instance()->init();