<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

/* Register LearnQuran Theme Settings Admin Menu In WordPress Sidebar */
function learnquran_theme_settings_admin_menu() {
    add_menu_page(
        __( 'Pengaturan Theme', 'learnquran' ),
        __( 'Pengaturan Theme', 'learnquran' ),
        'edit_theme_options',
        'customize.php?autofocus[panel]=learnquran_theme_panel',
        '',
        'dashicons-admin-customizer',
        59
    );
}

add_action( 'admin_menu', 'learnquran_theme_settings_admin_menu' );

