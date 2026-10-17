<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

/* Auto-Install And Activate Bundled LearnQuran Companion Plugin */
function learnquran_auto_install_bundled_plugin() {
    $is_theme_switch_request = ( did_action( 'after_switch_theme' ) > 0 );

    /* Only Execute In WordPress Admin Context Or During Theme Switch And WP-CLI */
    if ( ! is_admin() && ! $is_theme_switch_request && ! ( defined( 'WP_CLI' ) && WP_CLI ) ) {
        return;
    }

    if ( ! $is_theme_switch_request && ! current_user_can( 'activate_plugins' ) ) {
        return;
    }

    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';

    $plugin_slug = 'learnquran';
    $plugin_main_file = 'learnquran/learnquran.php';
    $target_plugin_directory = WP_PLUGIN_DIR . '/' . $plugin_slug;
    $target_plugin_main_file = WP_PLUGIN_DIR . '/' . $plugin_main_file;
    $source_plugin_directory = get_template_directory() . '/plugins/' . $plugin_slug;
    $source_plugin_main_file = $source_plugin_directory . '/learnquran.php';

    /* If Bundled Plugin Source Directory Is Not Present In Active Theme / Skip */
    if ( ! is_dir( $source_plugin_directory ) || ! file_exists( $source_plugin_main_file ) ) {
        return;
    }

    $is_fresh_installation = false;
    $is_version_upgrade = false;

    /* Check If Plugin Exists In Target Plugins Directory */
    if ( ! file_exists( $target_plugin_main_file ) ) {
        $copied = learnquran_copy_directory_recursive( $source_plugin_directory, $target_plugin_directory );
        if ( $copied ) {
            $is_fresh_installation = true;
        }
    } else {
        /* Check For Plugin Version Differences Between Theme Bundle And Installed Plugin */
        $installed_data = get_file_data( $target_plugin_main_file, [ 'Version' => 'Version' ] );
        $bundled_data   = get_file_data( $source_plugin_main_file, [ 'Version' => 'Version' ] );

        $installed_version = ! empty( $installed_data['Version'] ) ? $installed_data['Version'] : '0.0.0';
        $bundled_version   = ! empty( $bundled_data['Version'] ) ? $bundled_data['Version'] : '0.0.0';

        if ( version_compare( $bundled_version, $installed_version, '>' ) ) {
            learnquran_copy_directory_recursive( $source_plugin_directory, $target_plugin_directory );
            $is_version_upgrade = true;
        }
    }

    /* Auto-Activate Plugin If Currently Inactive */
    if ( file_exists( $target_plugin_main_file ) && ! is_plugin_active( $plugin_main_file ) ) {
        $was_manually_deactivated = (bool) get_option( 'learnquran_plugin_manual_deactivated', false );

        /* Always Activate On Theme Activation Or When Freshly Installed / Respect Intentional Manual Deactivation Otherwise */
        $is_theme_switch_request = ( did_action( 'after_switch_theme' ) > 0 );
        if ( $is_theme_switch_request || $is_fresh_installation || ! $was_manually_deactivated ) {
            $activation_result = activate_plugin( $plugin_main_file );
            if ( ! is_wp_error( $activation_result ) ) {
                delete_option( 'learnquran_plugin_manual_deactivated' );
                set_transient( 'learnquran_bundled_plugin_activated_notice', true, 60 );
            }
        }
    }
}

/* Recursively Copy Files And Directories / Robust Filesystem Fallback */
function learnquran_copy_directory_recursive( $source_path, $destination_path ) {
    if ( ! is_dir( $source_path ) ) {
        return false;
    }

    if ( ! is_dir( $destination_path ) ) {
        wp_mkdir_p( $destination_path );
    }

    $directory_handle = opendir( $source_path );
    if ( ! $directory_handle ) {
        return false;
    }

    while ( false !== ( $file_item = readdir( $directory_handle ) ) ) {
        if ( $file_item === '.' || $file_item === '..' ) {
            continue;
        }

        $source_item_path      = $source_path . '/' . $file_item;
        $destination_item_path = $destination_path . '/' . $file_item;

        if ( is_dir( $source_item_path ) ) {
            learnquran_copy_directory_recursive( $source_item_path, $destination_item_path );
        } else {
            copy( $source_item_path, $destination_item_path );
        }
    }

    closedir( $directory_handle );
    return true;
}

/* Track When User Manually Deactivates Or Activates The Plugin */
function learnquran_handle_plugin_deactivation( $deactivated_plugin ) {
    if ( $deactivated_plugin === 'learnquran/learnquran.php' ) {
        update_option( 'learnquran_plugin_manual_deactivated', true );
    }
}
add_action( 'deactivated_plugin', 'learnquran_handle_plugin_deactivation' );

function learnquran_handle_plugin_activation( $activated_plugin ) {
    if ( $activated_plugin === 'learnquran/learnquran.php' ) {
        delete_option( 'learnquran_plugin_manual_deactivated' );
    }
}
add_action( 'activated_plugin', 'learnquran_handle_plugin_activation' );

/* Reset Manual Deactivation Flag On Theme Switch So New Activations Auto-Install Smoothly */
function learnquran_reset_plugin_deactivation_flag() {
    delete_option( 'learnquran_plugin_manual_deactivated' );
    learnquran_auto_install_bundled_plugin();
}
add_action( 'after_switch_theme', 'learnquran_reset_plugin_deactivation_flag', 5 );

/* Ensure Bundled Plugin Runs In Administration Lifecycle */
add_action( 'admin_init', 'learnquran_auto_install_bundled_plugin', 10 );

/* Admin Notice After Successful Auto-Activation */
function learnquran_show_bundled_plugin_notice() {
    if ( get_transient( 'learnquran_bundled_plugin_activated_notice' ) ) {
        delete_transient( 'learnquran_bundled_plugin_activated_notice' );
        ?>
        <div class="notice notice-success is-dismissible">
            <p>
                <strong>LearnQuran Theme:</strong> Plugin pendamping <em>LearnQuran Core & Dynamic Content URL</em> berhasil diinstall dan diaktifkan secara otomatis.
            </p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'learnquran_show_bundled_plugin_notice' );

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


