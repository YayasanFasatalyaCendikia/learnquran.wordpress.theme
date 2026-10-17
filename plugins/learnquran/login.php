<?php
/**
 * Custom Login Handler And Interface Customization For LearnQuran Plugin
 * Protects Standard WordPress Login Route And Provides Branded Login Screen
 * Includes Admin Panel Settings Page With Visual Customization Controls
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

/**
 * Retrieve Stored Login Settings With Defaults
 *
 * @return array<string, string>
 */
function learnquran_get_login_settings(): array {
    $fallbackLogoRelativePath = '/wp-content/uploads/2026/10/logo-nuraniah-learning-center.png';
    $defaultLogoUrl           = file_exists( ABSPATH . ltrim( $fallbackLogoRelativePath, '/' ) )
        ? home_url( $fallbackLogoRelativePath )
        : '';

    $customLogoAttachmentId = (int) get_theme_mod( 'custom_logo' );
    if ( $customLogoAttachmentId ) {
        $attachmentImageSource = wp_get_attachment_image_src( $customLogoAttachmentId, 'full' );
        if ( ! empty( $attachmentImageSource[0] ) ) {
            $defaultLogoUrl = $attachmentImageSource[0];
        }
    }

    $configuredSlugFromConstant = defined( 'LEARNQURAN_LOGIN_SLUG' )
        ? sanitize_title( LEARNQURAN_LOGIN_SLUG )
        : ( defined( 'MY_LOGIN_SLUG' ) ? sanitize_title( MY_LOGIN_SLUG ) : 'masuk' );

    $defaultSettings = [
        'login_slug'                => $configuredSlugFromConstant,
        'logo_url'                  => $defaultLogoUrl,
        'logo_width'                => '260px',
        'logo_height'               => '80px',
        'background_gradient_start' => '#f0f4fa',
        'background_gradient_mid'   => '#ffffff',
        'background_gradient_end'   => '#ffffff',
        'background_image_url'      => '',
        'card_background_color'     => '#ffffff',
        'card_border_radius'        => '24px',
        'primary_button_start'      => '#1f4c8f',
        'primary_button_end'        => '#183c72',
        'custom_css'                => '',
    ];

    $savedSettings = get_option( 'learnquran_login_settings', [] );
    if ( ! is_array( $savedSettings ) ) {
        return $defaultSettings;
    }

    $mergedSettings = wp_parse_args( $savedSettings, $defaultSettings );

    /* If Defined In Wp Config, Always Prioritize The Configuration Constant */
    if ( defined( 'LEARNQURAN_LOGIN_SLUG' ) ) {
        $mergedSettings['login_slug'] = sanitize_title( LEARNQURAN_LOGIN_SLUG );
    } elseif ( defined( 'MY_LOGIN_SLUG' ) ) {
        $mergedSettings['login_slug'] = sanitize_title( MY_LOGIN_SLUG );
    }

    return $mergedSettings;
}

/* Define Custom Login Route Constant */
if ( defined( 'MY_LOGIN_SLUG' ) && ! defined( 'LEARNQURAN_LOGIN_SLUG' ) ) {
    define( 'LEARNQURAN_LOGIN_SLUG', sanitize_title( MY_LOGIN_SLUG ) );
}

if ( ! defined( 'LEARNQURAN_LOGIN_SLUG' ) ) {
    $loginConfigurationSettings = learnquran_get_login_settings();
    $configuredLoginSlug        = ! empty( $loginConfigurationSettings['login_slug'] )
        ? sanitize_title( $loginConfigurationSettings['login_slug'] )
        : 'masuk';
    define( 'LEARNQURAN_LOGIN_SLUG', $configuredLoginSlug );
}

/*
 * 1. Modify Default Login Uniform Resource Locator
 * Directs All Login Links Across WordPress To Custom Slug
 */
add_filter( 'login_url', function ( string $defaultLoginUrl, string $redirectDestinationUrl ): string {
    /* If Unauthenticated Request Originates From Protected Admin Dashboard, Force Four Zero Four */
    if ( is_admin() && ! is_user_logged_in() ) {
        return home_url( '/404' );
    }

    $customLoginUrl = home_url( '/' . LEARNQURAN_LOGIN_SLUG );

    if ( ! empty( $redirectDestinationUrl ) ) {
        $customLoginUrl = add_query_arg( 'redirect_to', urlencode( $redirectDestinationUrl ), $customLoginUrl );
    }

    return $customLoginUrl;
}, 10, 2 );

/*
 * 2. Modify Logout Uniform Resource Locator
 * Keeps Logout Redirect Flowing Through Custom Slug Route
 */
add_filter( 'logout_url', function ( string $defaultLogoutUrl, string $redirectDestinationUrl ): string {
    return str_replace( 'wp-login.php', LEARNQURAN_LOGIN_SLUG, $defaultLogoutUrl );
}, 10, 2 );

/*
 * 3. Modify Lost Password Uniform Resource Locator
 * Replaces Default Script Target With Custom Slug
 */
add_filter( 'lostpassword_url', function ( string $defaultLostPasswordUrl, string $redirectDestinationUrl ): string {
    return str_replace( 'wp-login.php', LEARNQURAN_LOGIN_SLUG, $defaultLostPasswordUrl );
}, 10, 2 );

/*
 * 4. Modify Core Login Post Form Target Uniform Resource Locator
 * Directs Native Form Submission Target To Custom Slug
 */
add_filter( 'site_url', function ( string $calculatedSiteUrl, string $requestPath, ?string $requestScheme ): string {
    if ( 'wp-login.php' === $requestPath && 'login_post' === $requestScheme ) {
        return home_url( '/' . LEARNQURAN_LOGIN_SLUG );
    }
    return $calculatedSiteUrl;
}, 10, 3 );

/*
 * 5. Intercept Custom Route And Guard Default Login Script
 * Catches Custom Slug Access And Prevents Unauthorized Direct Visits To Default Script
 */
add_action( 'init', function () {
    $requestUriPath = parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH );
    if ( empty( $requestUriPath ) ) {
        return;
    }

    $homeUriPath     = parse_url( home_url(), PHP_URL_PATH ) ?: '';
    $relativeUriPath = ( ! empty( $homeUriPath ) && strpos( $requestUriPath, $homeUriPath ) === 0 )
        ? substr( $requestUriPath, strlen( $homeUriPath ) )
        : $requestUriPath;

    $currentRouteSlug = trim( $relativeUriPath, '/' );
    $currentRouteSlug = preg_replace( '#^index\.php/?#', '', $currentRouteSlug );

    /* Handle Custom Login Slug Request */
    if ( $currentRouteSlug === LEARNQURAN_LOGIN_SLUG ) {
        $requestedActionName = isset( $_REQUEST['action'] ) ? sanitize_key( $_REQUEST['action'] ) : 'login';

        /* If Already Authenticated And Accessing Default Login Form, Forward To Admin Dashboard */
        if ( is_user_logged_in() && ! in_array( $requestedActionName, [ 'logout', 'confirm_admin_email' ], true ) ) {
            wp_safe_redirect( admin_url() );
            exit;
        }

        /* Prevent Undefined Variable Warnings In Core Script By Initializing Global Scope */
        global $user_login, $error, $interim_login, $action;
        $user_login    = '';
        $error         = '';
        $interim_login = false;
        $action        = $requestedActionName;

        /* Execute Native Login Flow Without Modifying Physical Core Files */
        @include_once ABSPATH . 'wp-login.php';
        exit;
    }

    /* Block Unauthenticated Direct Access To Administration Dashboard / Hide Login Screen */
    $isAccessingAdministrationArea = ( strpos( $requestUriPath, '/wp-admin' ) !== false );
    $isAsynchronousAjaxRequest     = ( strpos( $requestUriPath, 'admin-ajax.php' ) !== false || ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() ) );
    $isScheduledCronRequest        = ( strpos( $requestUriPath, 'wp-cron.php' ) !== false || ( function_exists( 'wp_doing_cron' ) && wp_doing_cron() ) );

    if ( $isAccessingAdministrationArea && ! is_user_logged_in() && ! $isAsynchronousAjaxRequest && ! $isScheduledCronRequest ) {
        wp_safe_redirect( home_url( '/404' ) );
        exit;
    }

    /* Intercept Direct Access To Native Login File */
    global $pagenow;
    if ( 'wp-login.php' === $pagenow && $currentRouteSlug !== LEARNQURAN_LOGIN_SLUG && empty( $_POST ) ) {
        /* Preserve Valid Logout Requests By Redirecting To Custom Route */
        if ( isset( $_GET['action'] ) && 'logout' === $_GET['action'] ) {
            $queryString = $_SERVER['QUERY_STRING'] ?? '';
            wp_safe_redirect( home_url( '/' . LEARNQURAN_LOGIN_SLUG . ( $queryString ? '?' . $queryString : '' ) ) );
            exit;
        }

        /* Redirect Unmatched Direct Visits Away From Core Login Script */
        wp_safe_redirect( home_url( '/404' ) );
        exit;
    }
} );


/*
 * 6. Customize Login Logo Destination Header Link
 * Changes Default WordPress Site Link To Active Site Home
 */
add_filter( 'login_headerurl', function (): string {
    return home_url( '/' );
} );

/*
 * 7. Customize Login Logo Tooltip Text
 * Replaces Powered By WordPress Label With Site Name
 */
add_filter( 'login_headertext', function (): string {
    return get_bloginfo( 'name' );
} );

/*
 * 8. Render Animated Wave Background Markup In Login Header
 * Injects Ambient Floating Orbs And Continuous Wave Curves Matching The LearnQuran Theme
 */
add_action( 'login_header', function () {
    $activeSettings     = learnquran_get_login_settings();
    $primaryButtonStart = ! empty( $activeSettings['primary_button_start'] ) ? $activeSettings['primary_button_start'] : '#1f4c8f';
    $primaryButtonEnd   = ! empty( $activeSettings['primary_button_end'] ) ? $activeSettings['primary_button_end'] : '#183c72';
    ?>
    <div class="login-wave-wrapper" aria-hidden="true">
        <!-- Ambient Floating Gradient Orbs / Soft Transparent Primary Accents Matching LearnQuran Theme -->
        <div class="login-orb login-orb-1"></div>
        <div class="login-orb login-orb-2"></div>
        <div class="login-orb login-orb-3"></div>

        <!-- Animated Wave Curves / Cascading From Top Down With Balanced Soft Transparency -->
        <svg 
            class="login-wave-svg" 
            xmlns="http://www.w3.org/2000/svg" 
            viewBox="0 0 150 28" 
            preserveAspectRatio="none" 
            shape-rendering="auto"
        >
            <defs>
                <!-- Deep Primary Wave Gradient -->
                <linearGradient id="learnquran-login-wave-deep" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="<?php echo esc_attr( $primaryButtonStart ); ?>" stop-opacity="0.32" />
                    <stop offset="50%" stop-color="<?php echo esc_attr( $primaryButtonStart ); ?>" stop-opacity="0.18" />
                    <stop offset="100%" stop-color="<?php echo esc_attr( $primaryButtonStart ); ?>" stop-opacity="0.04" />
                </linearGradient>

                <!-- Mid Wave Gradient -->
                <linearGradient id="learnquran-login-wave-mid" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="<?php echo esc_attr( $primaryButtonStart ); ?>" stop-opacity="0.25" />
                    <stop offset="45%" stop-color="#3b74c4" stop-opacity="0.14" />
                    <stop offset="100%" stop-color="<?php echo esc_attr( $primaryButtonStart ); ?>" stop-opacity="0.02" />
                </linearGradient>

                <!-- Soft Crest Gradient -->
                <linearGradient id="learnquran-login-wave-soft" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="<?php echo esc_attr( $primaryButtonEnd ); ?>" stop-opacity="0.20" />
                    <stop offset="55%" stop-color="#60a5fa" stop-opacity="0.12" />
                    <stop offset="100%" stop-color="#dce7f4" stop-opacity="0.02" />
                </linearGradient>

                <!-- Reusable Continuous Top Down Wave Path Matching Theme -->
                <path id="learnquran-login-wave-path" d="M-160 -10 v26 c30 0 58 12 88 12 s 58 -12 88 -12 58 12 88 12 58 -12 88 -12 v-26 z" />
            </defs>

            <g>
                <use href="#learnquran-login-wave-path" x="48" y="0" fill="url(#learnquran-login-wave-deep)" class="login-wave-slow" />
                <use href="#learnquran-login-wave-path" x="48" y="2" fill="url(#learnquran-login-wave-mid)" class="login-wave-medium" />
                <use href="#learnquran-login-wave-path" x="48" y="4" fill="url(#learnquran-login-wave-soft)" class="login-wave-fast" />
            </g>
        </svg>
    </div>
    <?php
} );

/*
 * 9. Inject Custom Styling And Keyframes For Login Interface
 * Applies LearnQuran Theme Gradient Background And Animated Wave Keyframes
 */
add_action( 'login_enqueue_scripts', function () {
    $activeSettings = learnquran_get_login_settings();

    $brandLogoUrl          = ! empty( $activeSettings['logo_url'] ) ? $activeSettings['logo_url'] : '';
    $brandLogoWidth        = ! empty( $activeSettings['logo_width'] ) ? $activeSettings['logo_width'] : '260px';
    $brandLogoHeight       = ! empty( $activeSettings['logo_height'] ) ? $activeSettings['logo_height'] : '80px';
    $gradientStartColor    = ! empty( $activeSettings['background_gradient_start'] ) ? $activeSettings['background_gradient_start'] : '#f0f4fa';
    $gradientEndColor      = ! empty( $activeSettings['background_gradient_end'] ) ? $activeSettings['background_gradient_end'] : '#ffffff';
    $primaryButtonStart    = ! empty( $activeSettings['primary_button_start'] ) ? $activeSettings['primary_button_start'] : '#1f4c8f';
    $primaryButtonEnd      = ! empty( $activeSettings['primary_button_end'] ) ? $activeSettings['primary_button_end'] : '#183c72';
    $cardBorderRadius      = ! empty( $activeSettings['card_border_radius'] ) ? $activeSettings['card_border_radius'] : '24px';
    $additionalCustomStyle = ! empty( $activeSettings['custom_css'] ) ? $activeSettings['custom_css'] : '';
    ?>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body.login {
            background: linear-gradient(180deg, <?php echo esc_attr( $gradientStartColor ); ?> 0%, <?php echo esc_attr( $gradientEndColor ); ?> 65%, #ffffff 100%) !important;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 32px 20px;
            box-sizing: border-box;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Wave Wrapper / Absolute Full Viewport Background */
        .login-wave-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            pointer-events: none;
            user-select: none;
            z-index: 1;
        }

        /* Ambient Floating Orbs Matching LearnQuran Hero Background */
        .login-orb {
            position: absolute;
            border-radius: 9999px;
            filter: blur(48px);
            pointer-events: none;
        }

        .login-orb-1 {
            top: -7rem;
            left: 25%;
            width: 36rem;
            height: 18rem;
            background: linear-gradient(to bottom, rgba(31, 76, 143, 0.20), rgba(31, 76, 143, 0.10), transparent);
            animation: heroGradientShift 14s ease-in-out infinite;
        }

        .login-orb-2 {
            top: -6rem;
            right: -5rem;
            width: 24rem;
            height: 24rem;
            background: linear-gradient(to bottom left, rgba(245, 153, 49, 0.14), rgba(31, 76, 143, 0.10), transparent);
            animation: heroGradientShift 14s ease-in-out infinite;
            animation-delay: -5s;
        }

        .login-orb-3 {
            top: -5rem;
            left: -5rem;
            width: 20rem;
            height: 20rem;
            background: linear-gradient(to bottom right, rgba(31, 76, 143, 0.16), transparent);
            animation: heroGradientShift 14s ease-in-out infinite;
            animation-delay: -10s;
        }

        /* Continuous Wave Svg / Responsive Top Header */
        .login-wave-svg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 240px;
            margin-top: -2px;
            opacity: 0.95;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .login-wave-svg {
                width: 180%;
                height: 160px;
            }
        }

        /* Hero Wave Keyframes / Liquid Motion Matching LearnQuran Theme */
        @keyframes heroWaveMove {
            0% {
                transform: translate3d(-90px, 0, 0);
            }
            50% {
                transform: translate3d(85px, 0, 0);
            }
            100% {
                transform: translate3d(-90px, 0, 0);
            }
        }

        @keyframes heroWaveDrift {
            0% {
                transform: translate3d(85px, 0, 0) scaleY(1);
            }
            50% {
                transform: translate3d(-90px, 0, 0) scaleY(1.18);
            }
            100% {
                transform: translate3d(85px, 0, 0) scaleY(1);
            }
        }

        @keyframes heroGradientShift {
            0%, 100% {
                transform: scale(1) translate(0, 0);
                opacity: 0.55;
            }
            50% {
                transform: scale(1.15) translate(25px, -15px);
                opacity: 0.85;
            }
        }

        .login-wave-fast {
            animation: heroWaveMove 12s cubic-bezier(0.55, 0.5, 0.45, 0.5) infinite;
        }

        .login-wave-medium {
            animation: heroWaveDrift 18s cubic-bezier(0.55, 0.5, 0.45, 0.5) infinite;
        }

        .login-wave-slow {
            animation: heroWaveMove 25s cubic-bezier(0.55, 0.5, 0.45, 0.5) infinite;
        }

        #login {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            padding: 0 !important;
            margin: auto;
        }

        #login h1 {
            margin-bottom: 24px;
        }

        #login h1 a {
            <?php if ( ! empty( $brandLogoUrl ) ) : ?>
            background-image: url('<?php echo esc_url( $brandLogoUrl ); ?>') !important;
            background-size: contain !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            width: <?php echo esc_attr( $brandLogoWidth ); ?> !important;
            height: <?php echo esc_attr( $brandLogoHeight ); ?> !important;
            margin: 0 auto !important;
            display: block !important;
            filter: drop-shadow(0 6px 14px rgba(31, 76, 143, 0.12));
            <?php endif; ?>
        }

        .login form {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: <?php echo esc_attr( $cardBorderRadius ); ?> !important;
            box-shadow: 0 20px 45px -10px rgba(31, 76, 143, 0.10), 0 2px 6px rgba(15, 23, 42, 0.04) !important;
            padding: 36px 32px !important;
            margin: 0 !important;
        }

        .login form .input,
        .login input[type="text"],
        .login input[type="password"] {
            background-color: #f8fafc !important;
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 14px !important;
            padding: 12px 16px !important;
            font-size: 15px !important;
            color: #0f172a !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02) !important;
            margin-top: 6px !important;
            margin-bottom: 16px !important;
        }

        .login form .input:focus,
        .login input[type="text"]:focus,
        .login input[type="password"]:focus {
            background-color: #ffffff !important;
            border-color: <?php echo esc_attr( $primaryButtonStart ); ?> !important;
            box-shadow: 0 0 0 4px rgba(31, 76, 143, 0.16) !important;
            outline: none !important;
        }

        .login label {
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #334155 !important;
            letter-spacing: 0.01em !important;
        }

        .login .forgetmenot {
            margin-top: 4px !important;
        }

        .login .forgetmenot label {
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
        }

        .login input[type="checkbox"] {
            border-radius: 6px !important;
            border-color: #cbd5e1 !important;
            width: 18px !important;
            height: 18px !important;
        }

        .login input[type="checkbox"]:checked {
            background-color: <?php echo esc_attr( $primaryButtonStart ); ?> !important;
            border-color: <?php echo esc_attr( $primaryButtonStart ); ?> !important;
        }

        .login .submit {
            margin-top: 14px !important;
        }

        .wp-core-ui .button-primary {
            background: linear-gradient(135deg, <?php echo esc_attr( $primaryButtonStart ); ?> 0%, <?php echo esc_attr( $primaryButtonEnd ); ?> 100%) !important;
            border: none !important;
            border-radius: 14px !important;
            padding: 12px 24px !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            width: 100% !important;
            height: auto !important;
            line-height: 1.5 !important;
            box-shadow: 0 8px 20px -4px rgba(31, 76, 143, 0.45) !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            cursor: pointer !important;
            text-shadow: none !important;
        }

        .wp-core-ui .button-primary:hover,
        .wp-core-ui .button-primary:focus {
            filter: brightness(1.08) !important;
            box-shadow: 0 12px 24px -4px rgba(31, 76, 143, 0.55) !important;
            transform: translateY(-1px) !important;
            color: #ffffff !important;
        }

        .wp-core-ui .button-primary:active {
            transform: translateY(0) !important;
        }

        .login #nav,
        .login #backtoblog {
            text-align: center !important;
            padding: 14px 0 0 0 !important;
            font-size: 13px !important;
            margin: 0 !important;
        }

        .login #nav a,
        .login #backtoblog a {
            color: #64748b !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            transition: color 0.2s ease !important;
        }

        .login #nav a:hover,
        .login #backtoblog a:hover {
            color: <?php echo esc_attr( $primaryButtonStart ); ?> !important;
            text-decoration: underline !important;
        }

        .login .message,
        .login .notice,
        .login #login_error {
            border-radius: 16px !important;
            border-left: 5px solid !important;
            padding: 14px 18px !important;
            font-size: 13.5px !important;
            line-height: 1.5 !important;
            margin-bottom: 20px !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05) !important;
        }

        .login #login_error {
            background-color: #fff1f2 !important;
            border-color: #f43f5e !important;
            color: #9f1239 !important;
        }

        .login .message {
            background-color: #f0fdfa !important;
            border-color: <?php echo esc_attr( $primaryButtonStart ); ?> !important;
            color: #115e59 !important;
        }

        .login .privacy-policy-page-link {
            text-align: center !important;
            margin-top: 18px !important;
        }

        .login .privacy-policy-page-link a {
            color: #94a3b8 !important;
            font-size: 12px !important;
        }

        <?php echo $additionalCustomStyle; ?>
    </style>
    <?php
} );

/*
 * 10. Register Admin Settings Menu And Page For Login Screen Customization
 * Adds Dedicated Interface Under Settings Menu In WordPress Dashboard
 */
add_action( 'admin_menu', function () {
    add_options_page(
        __( 'Kustomisasi Login', 'learnquran' ),
        __( 'Kustomisasi Login', 'learnquran' ),
        'manage_options',
        'learnquran-login-settings',
        'learnquran_render_login_settings_page'
    );
} );

/*
 * 11. Enqueue Admin Assets For Media Uploader And Color Pickers
 * Loads Native WordPress Controls Exclusively On Settings Screen
 */
add_action( 'admin_enqueue_scripts', function ( string $hookSuffixName ) {
    if ( 'settings_page_learnquran-login-settings' !== $hookSuffixName ) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );
} );

/**
 * Render Admin Settings Screen For Login Interface Customization
 *
 * @return void
 */
function learnquran_render_login_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Anda tidak memiliki hak akses yang cukup.', 'learnquran' ) );
    }

    $statusMessage = '';

    /* Handle Form Submission And Save Settings */
    if ( isset( $_POST['learnquran_login_settings_nonce'] ) && wp_verify_nonce( $_POST['learnquran_login_settings_nonce'], 'learnquran_save_login_settings' ) ) {
        $submittedLoginSlug = defined( 'LEARNQURAN_LOGIN_SLUG' )
            ? sanitize_title( LEARNQURAN_LOGIN_SLUG )
            : ( defined( 'MY_LOGIN_SLUG' ) ? sanitize_title( MY_LOGIN_SLUG ) : sanitize_title( $_POST['login_slug'] ?? 'masuk' ) );

        $updatedSettings = [
            'login_slug'                => $submittedLoginSlug,
            'logo_url'                  => esc_url_raw( $_POST['logo_url'] ?? '' ),
            'logo_width'                => sanitize_text_field( $_POST['logo_width'] ?? '260px' ),
            'logo_height'               => sanitize_text_field( $_POST['logo_height'] ?? '80px' ),
            'background_gradient_start' => sanitize_hex_color( $_POST['background_gradient_start'] ?? '#042f2e' ) ?: '#042f2e',
            'background_gradient_mid'   => sanitize_hex_color( $_POST['background_gradient_mid'] ?? '#064e3b' ) ?: '#064e3b',
            'background_gradient_end'   => sanitize_hex_color( $_POST['background_gradient_end'] ?? '#0f172a' ) ?: '#0f172a',
            'background_image_url'      => esc_url_raw( $_POST['background_image_url'] ?? '' ),
            'card_background_color'     => sanitize_text_field( $_POST['card_background_color'] ?? 'rgba(255, 255, 255, 0.96)' ),
            'card_border_radius'        => sanitize_text_field( $_POST['card_border_radius'] ?? '24px' ),
            'primary_button_start'      => sanitize_hex_color( $_POST['primary_button_start'] ?? '#0d9488' ) ?: '#0d9488',
            'primary_button_end'        => sanitize_hex_color( $_POST['primary_button_end'] ?? '#059669' ) ?: '#059669',
            'custom_css'                => wp_strip_all_tags( $_POST['custom_css'] ?? '' ),
        ];

        update_option( 'learnquran_login_settings', $updatedSettings );
        $statusMessage = __( 'Pengaturan halaman login berhasil disimpan.', 'learnquran' );
    }

    $currentSettings            = learnquran_get_login_settings();
    $isSlugConfiguredInWpConfig = defined( 'LEARNQURAN_LOGIN_SLUG' ) || defined( 'MY_LOGIN_SLUG' );
    $activeLoginUrl             = home_url( '/' . $currentSettings['login_slug'] );
    ?>
    <div class="wrap" style="max-width: 1040px;">
        <h1 style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
            <span class="dashicons dashicons-shield-alt" style="font-size: 32px; width: 32px; height: 32px; color: #0d9488;"></span>
            <span><?php esc_html_e( 'Editor Kustomisasi Halaman Login', 'learnquran' ); ?></span>
        </h1>

        <?php if ( ! empty( $statusMessage ) ) : ?>
            <div class="notice notice-success is-dismissible" style="border-left-color: #0d9488;">
                <p><strong><?php echo esc_html( $statusMessage ); ?></strong></p>
            </div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1fr 340px; gap: 24px; margin-top: 20px;">
            <div>
                <form method="post" action="">
                    <?php wp_nonce_field( 'learnquran_save_login_settings', 'learnquran_login_settings_nonce' ); ?>

                    <!-- Section: Route Configuration -->
                    <div class="postbox" style="padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                        <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; color: #0f172a; font-size: 16px;">
                            <?php esc_html_e( '1. Slug URL Login', 'learnquran' ); ?>
                        </h2>
                        <table class="form-table" role="presentation">
                            <tr>
                                <th scope="row"><label for="login_slug"><?php esc_html_e( 'Slug Login Kustom', 'learnquran' ); ?></label></th>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <code><?php echo esc_html( home_url( '/' ) ); ?></code>
                                        <?php if ( $isSlugConfiguredInWpConfig ) : ?>
                                            <input type="text" name="login_slug" id="login_slug" value="<?php echo esc_attr( $currentSettings['login_slug'] ); ?>" class="regular-text" style="font-weight: 700; color: #0d9488; background-color: #f1f5f9; cursor: not-allowed;" readonly />
                                            <span class="dashicons dashicons-lock" style="color: #64748b; margin-top: 4px;" title="<?php esc_attr_e( 'Didefinisikan di wp-config.php', 'learnquran' ); ?>"></span>
                                        <?php else : ?>
                                            <input type="text" name="login_slug" id="login_slug" value="<?php echo esc_attr( $currentSettings['login_slug'] ); ?>" class="regular-text" style="font-weight: 700; color: #0d9488;" required />
                                        <?php endif; ?>
                                    </div>
                                    <?php if ( $isSlugConfiguredInWpConfig ) : ?>
                                        <p class="description" style="color: #0d9488; font-weight: 600;">
                                            <?php esc_html_e( 'Dikonfigurasi melalui konstanta LEARNQURAN_LOGIN_SLUG di wp-config.php.', 'learnquran' ); ?>
                                        </p>
                                    <?php else : ?>
                                        <p class="description"><?php esc_html_e( 'Contoh: masuk, portal-login, area-guru. Akses langsung ke wp-login.php akan otomatis diblokir ke 404.', 'learnquran' ); ?></p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Section: Logo Branding -->
                    <div class="postbox" style="padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                        <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; color: #0f172a; font-size: 16px;">
                            <?php esc_html_e( '2. Logo Brand', 'learnquran' ); ?>
                        </h2>
                        <table class="form-table" role="presentation">
                            <tr>
                                <th scope="row"><label for="logo_url"><?php esc_html_e( 'URL Logo', 'learnquran' ); ?></label></th>
                                <td>
                                    <input type="text" name="logo_url" id="logo_url" value="<?php echo esc_attr( $currentSettings['logo_url'] ); ?>" class="large-text" />
                                    <div style="margin-top: 8px;">
                                        <button type="button" class="button" id="upload_logo_button">
                                            <span class="dashicons dashicons-upload" style="margin-top: 4px;"></span>
                                            <?php esc_html_e( 'Pilih / Unggah Logo Media', 'learnquran' ); ?>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="logo_width"><?php esc_html_e( 'Dimensi Logo', 'learnquran' ); ?></label></th>
                                <td>
                                    <div style="display: flex; gap: 16px; align-items: center;">
                                        <div>
                                            <label for="logo_width" style="font-size: 12px; color: #64748b;"><?php esc_html_e( 'Lebar', 'learnquran' ); ?></label><br />
                                            <input type="text" name="logo_width" id="logo_width" value="<?php echo esc_attr( $currentSettings['logo_width'] ); ?>" style="width: 110px;" />
                                        </div>
                                        <div>
                                            <label for="logo_height" style="font-size: 12px; color: #64748b;"><?php esc_html_e( 'Tinggi', 'learnquran' ); ?></label><br />
                                            <input type="text" name="logo_height" id="logo_height" value="<?php echo esc_attr( $currentSettings['logo_height'] ); ?>" style="width: 110px;" />
                                        </div>
                                    </div>
                                    <p class="description"><?php esc_html_e( 'Gunakan satuan piksel / contoh: 260px dan 80px.', 'learnquran' ); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Section: Colors And Background -->
                    <div class="postbox" style="padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                        <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; color: #0f172a; font-size: 16px;">
                            <?php esc_html_e( '3. Warna Latar & Gradien', 'learnquran' ); ?>
                        </h2>
                        <table class="form-table" role="presentation">
                            <tr>
                                <th scope="row"><?php esc_html_e( 'Warna Gradien Latar', 'learnquran' ); ?></th>
                                <td>
                                    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                                        <div>
                                            <label for="background_gradient_start" style="font-size: 12px; color: #64748b; display: block; margin-bottom: 4px;"><?php esc_html_e( 'Awal', 'learnquran' ); ?></label>
                                            <input type="text" name="background_gradient_start" id="background_gradient_start" value="<?php echo esc_attr( $currentSettings['background_gradient_start'] ); ?>" class="learnquran-color-picker" />
                                        </div>
                                        <div>
                                            <label for="background_gradient_mid" style="font-size: 12px; color: #64748b; display: block; margin-bottom: 4px;"><?php esc_html_e( 'Tengah', 'learnquran' ); ?></label>
                                            <input type="text" name="background_gradient_mid" id="background_gradient_mid" value="<?php echo esc_attr( $currentSettings['background_gradient_mid'] ); ?>" class="learnquran-color-picker" />
                                        </div>
                                        <div>
                                            <label for="background_gradient_end" style="font-size: 12px; color: #64748b; display: block; margin-bottom: 4px;"><?php esc_html_e( 'Akhir', 'learnquran' ); ?></label>
                                            <input type="text" name="background_gradient_end" id="background_gradient_end" value="<?php echo esc_attr( $currentSettings['background_gradient_end'] ); ?>" class="learnquran-color-picker" />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="background_image_url"><?php esc_html_e( 'Gambar Latar Opsional', 'learnquran' ); ?></label></th>
                                <td>
                                    <input type="text" name="background_image_url" id="background_image_url" value="<?php echo esc_attr( $currentSettings['background_image_url'] ); ?>" class="large-text" />
                                    <div style="margin-top: 8px;">
                                        <button type="button" class="button" id="upload_bg_button">
                                            <span class="dashicons dashicons-format-image" style="margin-top: 4px;"></span>
                                            <?php esc_html_e( 'Pilih Gambar Latar', 'learnquran' ); ?>
                                        </button>
                                    </div>
                                    <p class="description"><?php esc_html_e( 'Kosongkan jika ingin menggunakan gradien warna saja.', 'learnquran' ); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Section: Card & Buttons -->
                    <div class="postbox" style="padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                        <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; color: #0f172a; font-size: 16px;">
                            <?php esc_html_e( '4. Kotak Form & Tombol', 'learnquran' ); ?>
                        </h2>
                        <table class="form-table" role="presentation">
                            <tr>
                                <th scope="row"><label for="card_border_radius"><?php esc_html_e( 'Kelengkungan Kartu', 'learnquran' ); ?></label></th>
                                <td>
                                    <input type="text" name="card_border_radius" id="card_border_radius" value="<?php echo esc_attr( $currentSettings['card_border_radius'] ); ?>" style="width: 120px;" />
                                    <span class="description"><?php esc_html_e( 'Contoh: 24px atau 16px.', 'learnquran' ); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e( 'Gradien Tombol Masuk', 'learnquran' ); ?></th>
                                <td>
                                    <div style="display: flex; gap: 20px;">
                                        <div>
                                            <label for="primary_button_start" style="font-size: 12px; color: #64748b; display: block; margin-bottom: 4px;"><?php esc_html_e( 'Awal Tombol', 'learnquran' ); ?></label>
                                            <input type="text" name="primary_button_start" id="primary_button_start" value="<?php echo esc_attr( $currentSettings['primary_button_start'] ); ?>" class="learnquran-color-picker" />
                                        </div>
                                        <div>
                                            <label for="primary_button_end" style="font-size: 12px; color: #64748b; display: block; margin-bottom: 4px;"><?php esc_html_e( 'Akhir Tombol', 'learnquran' ); ?></label>
                                            <input type="text" name="primary_button_end" id="primary_button_end" value="<?php echo esc_attr( $currentSettings['primary_button_end'] ); ?>" class="learnquran-color-picker" />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Section: Custom CSS Editor -->
                    <div class="postbox" style="padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                        <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; color: #0f172a; font-size: 16px;">
                            <?php esc_html_e( '5. Custom CSS Tambahan', 'learnquran' ); ?>
                        </h2>
                        <textarea name="custom_css" id="custom_css" rows="6" class="large-text code" style="font-family: monospace; font-size: 13px;"><?php echo esc_textarea( $currentSettings['custom_css'] ); ?></textarea>
                        <p class="description"><?php esc_html_e( 'Tambahkan aturan CSS ekstra untuk kustomisasi tingkat lanjut jika diperlukan.', 'learnquran' ); ?></p>
                    </div>

                    <p class="submit">
                        <button type="submit" class="button button-primary button-large" style="background: #0d9488; border-color: #0f766e; font-weight: 700; padding: 6px 24px; height: auto;">
                            <?php esc_html_e( 'Simpan Perubahan', 'learnquran' ); ?>
                        </button>
                    </p>
                </form>
            </div>

            <!-- Sidebar Info & Preview Card -->
            <div>
                <div class="postbox" style="padding: 20px; border-radius: 12px; position: sticky; top: 40px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <h3 style="margin-top: 0; font-size: 15px; color: #0f172a;"><?php esc_html_e( 'Tautan Langsung', 'learnquran' ); ?></h3>
                    <p style="font-size: 13px; color: #64748b;"><?php esc_html_e( 'Halaman login aktif Anda dapat diakses di:', 'learnquran' ); ?></p>
                    <div style="background: #f1f5f9; padding: 10px; border-radius: 8px; word-break: break-all; margin-bottom: 14px;">
                        <a href="<?php echo esc_url( $activeLoginUrl ); ?>" target="_blank" style="font-weight: 700; color: #0d9488; text-decoration: none;">
                            <?php echo esc_html( $activeLoginUrl ); ?> &#8599;
                        </a>
                    </div>
                    <a href="<?php echo esc_url( $activeLoginUrl ); ?>" target="_blank" class="button button-secondary" style="width: 100%; text-align: center; margin-bottom: 16px;">
                        <span class="dashicons dashicons-external" style="margin-top: 4px;"></span>
                        <?php esc_html_e( 'Buka Halaman Login', 'learnquran' ); ?>
                    </a>

                    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 16px 0;" />

                    <h4 style="margin: 0 0 10px 0; font-size: 14px;"><?php esc_html_e( 'Status Proteksi:', 'learnquran' ); ?></h4>
                    <ul style="font-size: 13px; color: #334155; margin: 0; padding-left: 18px; line-height: 1.6;">
                        <li><strong>wp-login.php</strong>: <?php esc_html_e( 'Diblokir / 404', 'learnquran' ); ?></li>
                        <li><strong>POST Login</strong>: <?php esc_html_e( 'Aktif & Aman', 'learnquran' ); ?></li>
                        <li><strong>Logout</strong>: <?php esc_html_e( 'Otomatis ke /' . esc_html( $currentSettings['login_slug'] ), 'learnquran' ); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            /* Initialize WordPress Color Pickers */
            $('.learnquran-color-picker').wpColorPicker();

            /* Media Uploader For Brand Logo */
            $('#upload_logo_button').on('click', function(event) {
                event.preventDefault();
                var logoFrameInstance = wp.media({
                    title: '<?php echo esc_js( __( 'Pilih Logo Halaman Login', 'learnquran' ) ); ?>',
                    button: { text: '<?php echo esc_js( __( 'Gunakan Logo Ini', 'learnquran' ) ); ?>' },
                    multiple: false
                });

                logoFrameInstance.on('select', function() {
                    var selectedAttachment = logoFrameInstance.state().get('selection').first().toJSON();
                    $('#logo_url').val(selectedAttachment.url);
                });

                logoFrameInstance.open();
            });

            /* Media Uploader For Background Image */
            $('#upload_bg_button').on('click', function(event) {
                event.preventDefault();
                var bgFrameInstance = wp.media({
                    title: '<?php echo esc_js( __( 'Pilih Gambar Latar Belakang', 'learnquran' ) ); ?>',
                    button: { text: '<?php echo esc_js( __( 'Gunakan Gambar Ini', 'learnquran' ) ); ?>' },
                    multiple: false
                });

                bgFrameInstance.on('select', function() {
                    var selectedAttachment = bgFrameInstance.state().get('selection').first().toJSON();
                    $('#background_image_url').val(selectedAttachment.url);
                });

                bgFrameInstance.open();
            });
        });
    </script>
    <?php
}


