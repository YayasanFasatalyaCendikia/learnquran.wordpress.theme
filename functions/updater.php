<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

/* GitHub Repository Configuration For Learn Quran Theme */
define( 'LEARNQURAN_GITHUB_REPOSITORY_OWNER', 'YayasanFasatalyaCendikia' );
define( 'LEARNQURAN_GITHUB_REPOSITORY_NAME', 'learnquran.wordpress.theme' );
define( 'LEARNQURAN_GITHUB_THEME_SLUG', 'learnquran' );
define( 'LEARNQURAN_GITHUB_TRANSIENT_KEY', 'learnquran_github_release_cache' );

/* Fetch Latest Release Data From GitHub Application Programming Interface */
function learnquran_get_latest_github_release_data( $force_refresh = false ) {
    $cached_release_data = get_site_transient( LEARNQURAN_GITHUB_TRANSIENT_KEY );

    if ( ! $force_refresh && false !== $cached_release_data ) {
        return $cached_release_data;
    }

    $github_api_endpoint = sprintf(
        'https://api.github.com/repos/%s/%s/releases/latest',
        LEARNQURAN_GITHUB_REPOSITORY_OWNER,
        LEARNQURAN_GITHUB_REPOSITORY_NAME
    );

    $http_request_arguments = array(
        'timeout'    => 10,
        'user-agent' => 'WordPress/' . get_bloginfo( 'version' ) . '; ' . home_url( '/' ),
        'headers'    => array(
            'Accept' => 'application/vnd.github.v3+json',
        ),
    );

    $http_response = wp_remote_get( $github_api_endpoint, $http_request_arguments );

    if ( is_wp_error( $http_response ) || 200 !== wp_remote_retrieve_response_code( $http_response ) ) {
        /* Cache Empty Response Briefly To Prevent Immediate Re-querying On Error */
        set_site_transient( LEARNQURAN_GITHUB_TRANSIENT_KEY, array(), 10 * MINUTE_IN_SECONDS );
        return null;
    }

    $response_body = wp_remote_retrieve_body( $http_response );
    $decoded_data  = json_decode( $response_body, true );

    if ( ! is_array( $decoded_data ) || empty( $decoded_data['tag_name'] ) ) {
        set_site_transient( LEARNQURAN_GITHUB_TRANSIENT_KEY, array(), 10 * MINUTE_IN_SECONDS );
        return null;
    }

    /* Cache Valid Release Data For 6 Hours */
    set_site_transient( LEARNQURAN_GITHUB_TRANSIENT_KEY, $decoded_data, 6 * HOUR_IN_SECONDS );

    return $decoded_data;
}

/* Check Theme Updates Against Latest GitHub Release */
function learnquran_check_github_theme_updates( $transient_object ) {
    if ( empty( $transient_object->checked ) ) {
        return $transient_object;
    }

    $current_theme_stylesheet = LEARNQURAN_GITHUB_THEME_SLUG;
    $installed_theme_object   = wp_get_theme( $current_theme_stylesheet );

    if ( ! $installed_theme_object->exists() ) {
        return $transient_object;
    }

    $installed_theme_version = $installed_theme_object->get( 'Version' );
    $is_forced_check         = isset( $_GET['force-check'] ) || ( isset( $_GET['action'] ) && 'check-again' === $_GET['action'] );
    $latest_release_data     = learnquran_get_latest_github_release_data( $is_forced_check );

    if ( empty( $latest_release_data ) || empty( $latest_release_data['tag_name'] ) ) {
        return $transient_object;
    }

    $latest_version_tag = ltrim( (string) $latest_release_data['tag_name'], 'vV' );

    if ( version_compare( $latest_version_tag, $installed_theme_version, '>' ) ) {
        /* Determine Best Download Package URL / Priority To Standalone Zip Asset If Present */
        $package_download_url = '';

        if ( ! empty( $latest_release_data['assets'] ) && is_array( $latest_release_data['assets'] ) ) {
            foreach ( $latest_release_data['assets'] as $release_asset ) {
                if ( ! empty( $release_asset['browser_download_url'] ) && str_ends_with( strtolower( (string) $release_asset['name'] ), '.zip' ) ) {
                    $package_download_url = $release_asset['browser_download_url'];
                    break;
                }
            }
        }

        /* Fallback To GitHub Generated Source Zipball */
        if ( empty( $package_download_url ) && ! empty( $latest_release_data['zipball_url'] ) ) {
            $package_download_url = $latest_release_data['zipball_url'];
        }

        $transient_object->response[ $current_theme_stylesheet ] = array(
            'theme'        => $current_theme_stylesheet,
            'new_version'  => $latest_version_tag,
            'url'          => ! empty( $latest_release_data['html_url'] ) ? $latest_release_data['html_url'] : 'https://github.com/' . LEARNQURAN_GITHUB_REPOSITORY_OWNER . '/' . LEARNQURAN_GITHUB_REPOSITORY_NAME . '/releases',
            'package'      => $package_download_url,
            'requires'     => $installed_theme_object->get( 'RequiresWP' ) ?: '6.7',
            'requires_php' => $installed_theme_object->get( 'RequiresPHP' ) ?: '8.1',
        );
    }

    return $transient_object;
}
add_filter( 'pre_set_site_transient_update_themes', 'learnquran_check_github_theme_updates', 20 );

/* Normalize Unpacked GitHub Directory Name To Theme Slug */
function learnquran_rename_github_unpacked_theme_folder( $source_directory, $remote_source_directory, $upgrader_instance, $hook_extra = array() ) {
    global $wp_filesystem;

    if ( ! is_array( $hook_extra ) || empty( $hook_extra['theme'] ) || LEARNQURAN_GITHUB_THEME_SLUG !== $hook_extra['theme'] ) {
        return $source_directory;
    }

    $target_directory_name = LEARNQURAN_GITHUB_THEME_SLUG;
    $corrected_source_path = trailingslashit( $remote_source_directory ) . $target_directory_name;

    if ( trailingslashit( $source_directory ) === trailingslashit( $corrected_source_path ) ) {
        return $source_directory;
    }

    $move_successful = $wp_filesystem->move( $source_directory, $corrected_source_path );

    if ( $move_successful ) {
        return trailingslashit( $corrected_source_path );
    }

    return $source_directory;
}
add_filter( 'upgrader_source_selection', 'learnquran_rename_github_unpacked_theme_folder', 10, 4 );

/* Provide Detailed Release Information In WordPress Themes Update Modal */
function learnquran_theme_information_modal( $result_object, $requested_action, $argument_object ) {
    if ( 'theme_information' !== $requested_action || empty( $argument_object->slug ) || LEARNQURAN_GITHUB_THEME_SLUG !== $argument_object->slug ) {
        return $result_object;
    }

    $latest_release_data = learnquran_get_latest_github_release_data( false );

    if ( empty( $latest_release_data ) ) {
        return $result_object;
    }

    $installed_theme_object = wp_get_theme( LEARNQURAN_GITHUB_THEME_SLUG );
    $latest_version_tag     = ltrim( (string) $latest_release_data['tag_name'], 'vV' );
    $release_notes_markdown = ! empty( $latest_release_data['body'] ) ? $latest_release_data['body'] : '';

    $theme_information = new stdClass();
    $theme_information->name          = $installed_theme_object->get( 'Name' );
    $theme_information->slug          = LEARNQURAN_GITHUB_THEME_SLUG;
    $theme_information->version       = $latest_version_tag;
    $theme_information->author        = $installed_theme_object->get( 'Author' );
    $theme_information->preview_url   = home_url( '/' );
    $theme_information->requires      = $installed_theme_object->get( 'RequiresWP' ) ?: '6.7';
    $theme_information->requires_php  = $installed_theme_object->get( 'RequiresPHP' ) ?: '8.1';
    $theme_information->last_updated  = ! empty( $latest_release_data['published_at'] ) ? gmdate( 'Y-m-d', strtotime( $latest_release_data['published_at'] ) ) : gmdate( 'Y-m-d' );
    $theme_information->sections      = array(
        'description' => $installed_theme_object->get( 'Description' ),
        'changelog'   => nl2br( esc_html( $release_notes_markdown ) ),
    );

    return $theme_information;
}
add_filter( 'themes_api', 'learnquran_theme_information_modal', 20, 3 );

/* Append GitHub Release Link To Theme Management Row In Admin */
function learnquran_append_github_release_action_links( $action_links, $theme_stylesheet ) {
    if ( LEARNQURAN_GITHUB_THEME_SLUG !== $theme_stylesheet ) {
        return $action_links;
    }

    $github_releases_url = sprintf(
        'https://github.com/%s/%s/releases',
        LEARNQURAN_GITHUB_REPOSITORY_OWNER,
        LEARNQURAN_GITHUB_REPOSITORY_NAME
    );

    $action_links[] = sprintf(
        '<a href="%s" target="_blank" rel="noopener noreferrer">%s</a>',
        esc_url( $github_releases_url ),
        esc_html__( 'Rilis GitHub', 'learnquran' )
    );

    return $action_links;
}
add_filter( 'theme_row_meta', 'learnquran_append_github_release_action_links', 10, 2 );

/* Clear Release Transient Cache When Switching Themes Or Manually Checking */
function learnquran_clear_github_release_cache() {
    delete_site_transient( LEARNQURAN_GITHUB_TRANSIENT_KEY );
}
add_action( 'switch_theme', 'learnquran_clear_github_release_cache' );
add_action( 'upgrader_process_complete', 'learnquran_clear_github_release_cache' );

