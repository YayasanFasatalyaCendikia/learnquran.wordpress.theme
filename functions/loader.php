<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

require_once __DIR__ . '/settings.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/api.php';

/* Vue App Loader / Vite Dev Server Or Production Build */
require_once __DIR__ . '/vite.php';

/* Navigation Menus */
require_once __DIR__ . '/menu/_loader.php';

/* Custom Post Types */
require_once __DIR__ . '/posttype/_loader.php';

/* WordPress Customizer Options */
require_once __DIR__ . '/customizer.php';

/* Bundled Companion Plugin Auto Installer */
require_once __DIR__ . '/installer.php';

/* Dynamic OpenGraph And Social Share Meta Tags */
require_once __DIR__ . '/opengraph.php';


