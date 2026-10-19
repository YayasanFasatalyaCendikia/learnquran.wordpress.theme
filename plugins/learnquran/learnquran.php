<?php
/**
 * Plugin Name:       Learn Quran Core
 * Plugin URI:        https://syifarahmat.click/
 * Description:       Plugin pendamping resmi untuk tema Learn Quran. Mendukung portabilitas media konten dinamis, kustomisasi halaman login, dan kompatibilitas tema Nuraniah Learning Center.
 * Version:           26.10.1911
 * Author:            Rahmat Sifa'i ~ gmail@syifarahmat.click
 * Author URI:        https://syifarahmat.click/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       learnquran
 * Requires at least: 6.7
 * Requires PHP:      8.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

/* Define Plugin Constants */
define( 'LEARNQURAN_PLUGIN_VERSION', '26.10.1911' );
define( 'LEARNQURAN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'LEARNQURAN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/* Load Dynamic Content Uniform Resource Locator Handler */
require_once LEARNQURAN_PLUGIN_DIR . 'contenturl.php';

/* Load Custom Login Route And Interface Customizer */
require_once LEARNQURAN_PLUGIN_DIR . 'login.php';

/* Hide Development Source Theme Directory From WordPress Themes Admin Screen */
if ( ! function_exists( 'learnquran_hide_development_themes_from_admin' ) ) {
    function learnquran_hide_development_themes_from_admin( $prepared_themes ) {
        if ( is_array( $prepared_themes ) ) {
            unset( $prepared_themes['learnquran.src'] );
            foreach ( $prepared_themes as $stylesheet_slug => $theme_info ) {
                if ( str_ends_with( (string) $stylesheet_slug, '.src' ) ) {
                    unset( $prepared_themes[ $stylesheet_slug ] );
                }
            }
        }
        return $prepared_themes;
    }
    add_filter( 'wp_prepare_themes_for_js', 'learnquran_hide_development_themes_from_admin' );
}

