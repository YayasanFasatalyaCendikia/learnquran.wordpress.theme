<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

/* Retrieve Current Clean Request Uniform Resource Identifier Path */
function learnquran_get_request_path() {
    $raw_request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/';
    $parsed_url_path = (string) wp_parse_url( $raw_request_uri, PHP_URL_PATH );
    $home_url_path   = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
    $current_path = trim( $parsed_url_path, '/' );
    $home_path    = trim( $home_url_path, '/' );
    if ( ! empty( $home_path ) && str_starts_with( $current_path, $home_path ) ) {
        $current_path = trim( substr( $current_path, strlen( $home_path ) ), '/' );
    }
    return $current_path;
}

/* Retrieve Default Social Share Image From Theme Settings Or Logo */
function learnquran_get_default_share_image() {
    /* Check Hero Image In Customizer */
    $hero_image_candidate = get_theme_mod( 'learnquran_hero_image_one', get_theme_mod( 'learnquran_hero_image', '' ) );
    if ( ! empty( $hero_image_candidate ) ) {
        return $hero_image_candidate;
    }
    /* Check WordPress Custom Logo */
    $custom_logo_identifier = (int) get_theme_mod( 'custom_logo' );
    if ( $custom_logo_identifier ) {
        $logo_image_source = wp_get_attachment_image_src( $custom_logo_identifier, 'full' );
        if ( ! empty( $logo_image_source[0] ) ) {
            return $logo_image_source[0];
        }
    }
    /* Fallback To Theme Screenshot */
    $theme_screenshot_path = get_template_directory() . '/screenshot.png';
    if ( file_exists( $theme_screenshot_path ) ) {
        return get_template_directory_uri() . '/screenshot.png';
    }
    return '';
}

/* Resolve Dynamic Open Graph And Meta Tag Information For Current Route */
function learnquran_get_share_metadata() {
    $site_name           = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
    $site_description    = wp_specialchars_decode( get_bloginfo( 'description' ), ENT_QUOTES );
    $default_share_image = learnquran_get_default_share_image();
    $current_path        = learnquran_get_request_path();
    $meta_title       = '';
    $meta_description = '';
    $meta_image       = $default_share_image;
    $meta_type        = 'website';
    $meta_url         = home_url( '/' . ( $current_path ? $current_path . '/' : '' ) );
    /* Case: Home / Root Path */
    if ( empty( $current_path ) || $current_path === 'home' ) {
        $hero_badge_text  = get_theme_mod( 'learnquran_hero_badge', "Bimbingan Belajar Al~Qur'an Ramah Anak & Dewasa" );
        $meta_title       = $site_name . ' ~ ' . $hero_badge_text;
        $meta_description = get_theme_mod( 'learnquran_hero_subtitle', "Assalamu’alaikum, Ayah & Bunda. Nuraniah Learning Center menghadirkan guru ngaji privat ke rumah dan online yang ramah, profesional, serta tersertifikasi dengan Metode Nuraniah yang menyenangkan untuk anak~anak hingga dewasa." );
        $meta_url         = home_url( '/' );
        return [
            'title'       => $meta_title,
            'description' => $meta_description,
            'image'       => $meta_image,
            'type'        => $meta_type,
            'url'         => $meta_url,
        ];
    }
    /* Case: All Programs Archive /programs/ */
    if ( $current_path === 'programs' || $current_path === 'program' ) {
        $archive_title_text = get_theme_mod( 'learnquran_programs_archive_title', "Semua Program Belajar Al~Qur'an" );
        $meta_title         = $archive_title_text . ' ~ ' . $site_name;
        $meta_description   = get_theme_mod( 'learnquran_programs_archive_desc', "Pilihan program bimbingan intensif membaca Al~Qur'an dengan metode terstruktur untuk balita, anak-anak, remaja, hingga dewasa bersama guru privat profesional." );
        $meta_url           = home_url( '/programs/' );
        return [
            'title'       => $meta_title,
            'description' => $meta_description,
            'image'       => $meta_image,
            'type'        => $meta_type,
            'url'         => $meta_url,
        ];
    }
    /* Case: Program Detail /program/{slug}/ */
    if ( str_starts_with( $current_path, 'program/' ) || str_starts_with( $current_path, 'learnquran_program/' ) || str_starts_with( $current_path, 'nlc_program/' ) ) {
        $path_segments = explode( '/', $current_path );
        $program_slug  = end( $path_segments );
        $program_query = new WP_Query( [
            'name'           => $program_slug,
            'post_type'      => [ 'learnquran_program', 'nlc_program' ],
            'post_status'    => 'publish',
            'posts_per_page' => 1,
        ] );
        if ( $program_query->have_posts() ) {
            $program_post = $program_query->posts[0];
            $meta_title   = get_the_title( $program_post ) . ' ~ ' . $site_name;
            $program_excerpt = wp_strip_all_tags( get_the_excerpt( $program_post ) );
            if ( empty( $program_excerpt ) ) {
                $custom_program_desc = get_post_meta( $program_post->ID, '_learnquran_program_desc', true );
                $program_excerpt     = ! empty( $custom_program_desc ) ? $custom_program_desc : wp_trim_words( wp_strip_all_tags( $program_post->post_content ), 28 );
            }
            $meta_description = ! empty( $program_excerpt ) ? $program_excerpt : ( 'Program bimbingan belajar Al~Qur\'an ' . get_the_title( $program_post ) . ' di ' . $site_name );
            if ( has_post_thumbnail( $program_post->ID ) ) {
                $thumbnail_url = get_the_post_thumbnail_url( $program_post->ID, 'full' );
                if ( ! empty( $thumbnail_url ) ) {
                    $meta_image = $thumbnail_url;
                }
            }
            $meta_type = 'article';
            $meta_url  = home_url( '/program/' . $program_post->post_name . '/' );
            return [
                'title'       => $meta_title,
                'description' => $meta_description,
                'image'       => $meta_image,
                'type'        => $meta_type,
                'url'         => $meta_url,
            ];
        }
    }
    /* Case: Blog Archive /blog/ */
    if ( $current_path === 'blog' ) {
        $blog_page_title_text = get_theme_mod( 'learnquran_blog_page_title', "Blog Edukasi Al~Qur'an" );
        $meta_title           = $blog_page_title_text . ' ~ ' . $site_name;
        $meta_description     = get_theme_mod( 'learnquran_blog_page_desc', "Tips mendidik anak mencintai Al~Qur'an, tajwid praktis, dan kabar seputar Nuraniah Learning Center." );
        $meta_url             = home_url( '/blog/' );
        /* Retrieve Featured Image From Latest Blog Post If Available */
        $recent_posts = get_posts( [
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'numberposts'    => 1,
        ] );
        if ( ! empty( $recent_posts ) && has_post_thumbnail( $recent_posts[0]->ID ) ) {
            $latest_post_thumbnail = get_the_post_thumbnail_url( $recent_posts[0]->ID, 'full' );
            if ( ! empty( $latest_post_thumbnail ) ) {
                $meta_image = $latest_post_thumbnail;
            }
        }
        return [
            'title'       => $meta_title,
            'description' => $meta_description,
            'image'       => $meta_image,
            'type'        => $meta_type,
            'url'         => $meta_url,
        ];
    }
    /* Case: Single Post / Article /{slug}/ */
    $extracted_post_slug = $current_path;
    if ( str_contains( $extracted_post_slug, '/' ) ) {
        $path_elements       = explode( '/', $extracted_post_slug );
        $extracted_post_slug = end( $path_elements );
    }
    $article_query = new WP_Query( [
        'name'           => $extracted_post_slug,
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
    ] );
    if ( $article_query->have_posts() ) {
        $article_post = $article_query->posts[0];
        $meta_title   = get_the_title( $article_post ) . ' ~ ' . $site_name;
        $article_excerpt = wp_strip_all_tags( get_the_excerpt( $article_post ) );
        if ( empty( $article_excerpt ) ) {
            $article_excerpt = wp_trim_words( wp_strip_all_tags( $article_post->post_content ), 28 );
        }
        $meta_description = ! empty( $article_excerpt ) ? $article_excerpt : $site_description;
        if ( has_post_thumbnail( $article_post->ID ) ) {
            $thumbnail_url = get_the_post_thumbnail_url( $article_post->ID, 'full' );
            if ( ! empty( $thumbnail_url ) ) {
                $meta_image = $thumbnail_url;
            }
        }
        $meta_type = 'article';
        $meta_url  = get_permalink( $article_post ) ?: home_url( '/' . $article_post->post_name . '/' );
        return [
            'title'       => $meta_title,
            'description' => $meta_description,
            'image'       => $meta_image,
            'type'        => $meta_type,
            'url'         => $meta_url,
        ];
    }
    /* Case: Static Page /{slug}/ */
    $static_page_query = new WP_Query( [
        'name'           => $extracted_post_slug,
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
    ] );
    if ( $static_page_query->have_posts() ) {
        $static_page = $static_page_query->posts[0];
        $meta_title  = get_the_title( $static_page ) . ' ~ ' . $site_name;
        $page_excerpt = wp_strip_all_tags( get_the_excerpt( $static_page ) );
        if ( empty( $page_excerpt ) ) {
            $page_excerpt = wp_trim_words( wp_strip_all_tags( $static_page->post_content ), 28 );
        }
        $meta_description = ! empty( $page_excerpt ) ? $page_excerpt : ( 'Informasi resmi ' . get_the_title( $static_page ) . ' di ' . $site_name );
        if ( has_post_thumbnail( $static_page->ID ) ) {
            $thumbnail_url = get_the_post_thumbnail_url( $static_page->ID, 'full' );
            if ( ! empty( $thumbnail_url ) ) {
                $meta_image = $thumbnail_url;
            }
        }
        $meta_type = 'article';
        $meta_url  = get_permalink( $static_page ) ?: home_url( '/' . $static_page->post_name . '/' );
        return [
            'title'       => $meta_title,
            'description' => $meta_description,
            'image'       => $meta_image,
            'type'        => $meta_type,
            'url'         => $meta_url,
        ];
    }
    /* Special Case: Privacy Policy And Terms Routes */
    if ( in_array( $extracted_post_slug, [ 'privacy', 'policy', 'kebijakan', 'privasi' ], true ) ) {
        $meta_title       = 'Kebijakan Privasi ~ ' . $site_name;
        $meta_description = 'Kebijakan privasi dan ketentuan perlindungan data santri serta keluarga di ' . $site_name . '.';
        $meta_url         = home_url( '/' . $extracted_post_slug . '/' );
        return [
            'title'       => $meta_title,
            'description' => $meta_description,
            'image'       => $meta_image,
            'type'        => $meta_type,
            'url'         => $meta_url,
        ];
    }
    if ( in_array( $extracted_post_slug, [ 'terms', 'conditions', 'syarat', 'ketentuan' ], true ) ) {
        $meta_title       = 'Syarat & Ketentuan ~ ' . $site_name;
        $meta_description = 'Syarat dan ketentuan layanan bimbingan belajar Al~Qur\'an di ' . $site_name . '.';
        $meta_url         = home_url( '/' . $extracted_post_slug . '/' );
        return [
            'title'       => $meta_title,
            'description' => $meta_description,
            'image'       => $meta_image,
            'type'        => $meta_type,
            'url'         => $meta_url,
        ];
    }
    /* Default Fallback */
    $meta_title       = ( ! empty( $site_description ) ? $site_name . ' ~ ' . $site_description : $site_name );
    $meta_description = get_theme_mod( 'learnquran_hero_subtitle', $site_description );
    return [
        'title'       => $meta_title,
        'description' => $meta_description,
        'image'       => $meta_image,
        'type'        => $meta_type,
        'url'         => $meta_url,
    ];
}

/* Render Open Graph And Twitter Card Meta Tags In HTML Head */
function learnquran_render_social_meta_tags() {
    /* If Third Party SEO Plugin Is Active, Avoid Outputting Duplicate Tags */
    if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || function_exists( 'aioseo' ) ) {
        return;
    }
    $share_metadata = learnquran_get_share_metadata();
    $site_name_safe        = esc_attr( get_bloginfo( 'name' ) );
    $meta_title_safe       = esc_attr( $share_metadata['title'] );
    $meta_description_safe = esc_attr( wp_strip_all_tags( $share_metadata['description'] ) );
    $meta_image_safe       = esc_url( $share_metadata['image'] );
    $meta_type_safe        = esc_attr( $share_metadata['type'] );
    $meta_url_safe         = esc_url( $share_metadata['url'] );
    $locale_safe           = esc_attr( get_locale() );
    echo "\n<!-- Open Graph Meta Tags / WhatsApp, Facebook, LinkedIn -->\n";
    echo '<meta name="description" content="' . $meta_description_safe . '" />' . "\n";
    echo '<meta property="og:site_name" content="' . $site_name_safe . '" />' . "\n";
    echo '<meta property="og:type" content="' . $meta_type_safe . '" />' . "\n";
    echo '<meta property="og:title" content="' . $meta_title_safe . '" />' . "\n";
    echo '<meta property="og:description" content="' . $meta_description_safe . '" />' . "\n";
    echo '<meta property="og:url" content="' . $meta_url_safe . '" />' . "\n";
    if ( ! empty( $meta_image_safe ) ) {
        echo '<meta property="og:image" content="' . $meta_image_safe . '" />' . "\n";
        echo '<meta property="og:image:secure_url" content="' . $meta_image_safe . '" />' . "\n";
        echo '<meta property="og:image:alt" content="' . $meta_title_safe . '" />' . "\n";
    }
    echo '<meta property="og:locale" content="' . $locale_safe . '" />' . "\n";
    echo "\n<!-- Twitter / X Card Meta Tags -->\n";
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="' . $meta_title_safe . '" />' . "\n";
    echo '<meta name="twitter:description" content="' . $meta_description_safe . '" />' . "\n";
    if ( ! empty( $meta_image_safe ) ) {
        echo '<meta name="twitter:image" content="' . $meta_image_safe . '" />' . "\n";
    }
}
add_action( 'wp_head', 'learnquran_render_social_meta_tags', 1 );
/* Filter Document Title Tag To Reflect Resolved Route Title */
function learnquran_route_document_title( $default_title ) {
    $share_metadata = learnquran_get_share_metadata();
    if ( ! empty( $share_metadata['title'] ) ) {
        return $share_metadata['title'];
    }
    return $default_title;
}
add_filter( 'pre_get_document_title', 'learnquran_route_document_title', 20 );

/* Filter Default Document Title Separator Character */
function learnquran_document_title_separator( $separator ) {
    return '~';
}
add_filter( 'document_title_separator', 'learnquran_document_title_separator', 20 );

