<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

vue_theme_api_get('/site', function () {
    return vue_theme_get_site_info();
});

vue_theme_api_get('/menus/{location}', function (WP_REST_Request $request) {
    if (!array_key_exists($request['location'], get_registered_nav_menus())) {
        return new WP_Error('vue_theme_unknown_menu', 'Unknown menu location.', ['status' => 404]);
    }

    return vue_theme_get_menu($request['location']);
});

vue_theme_api_get('/programs', function () {
    return learnquran_get_programs_api();
});

vue_theme_api_get('/programs/{slug}', function (WP_REST_Request $request) {
    return learnquran_get_program_by_slug_api($request['slug']);
});

vue_theme_api_get('/testimonials', function () {
    return learnquran_get_testimonials_api();
});

vue_theme_api_get('/faqs', function () {
    return learnquran_get_faqs_api();
});

/* Deprecated Since 2.0.0 / Use vue-theme/v1/site */
add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/site-title', [
        'methods'  => 'GET',
        'callback' => 'vue_theme_rest_get_site_title',
        'permission_callback' => '__return_true',
    ]);

    register_rest_route('wp/v2', '/logo', [
        'methods'  => 'GET',
        'callback' => 'vue_theme_rest_get_custom_logo',
        'permission_callback' => '__return_true',
    ]);
});

function vue_theme_get_site_info() {
    $logo_id = (int) get_theme_mod('custom_logo');
    $image   = $logo_id ? wp_get_attachment_image_src($logo_id, 'full') : false;

    return [
        'title'       => wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES),
        'description' => wp_specialchars_decode(get_bloginfo('description'), ENT_QUOTES),
        'url'         => home_url('/'),
        'language'    => get_bloginfo('language'),
        'logo'        => $image ? [
            'url'    => $image[0],
            'width'  => (int) $image[1],
            'height' => (int) $image[2],
            'alt'    => (string) get_post_meta($logo_id, '_wp_attachment_image_alt', true),
        ] : null,
        'options'     => function_exists( 'learnquran_get_theme_options' ) ? learnquran_get_theme_options() : [],
    ];
}

/* Menu Items Of A Location Nested Under Children */
function vue_theme_get_menu($location) {
    $locations = get_nav_menu_locations();

    if (empty($locations[$location])) {
        return [];
    }

    $items = wp_get_nav_menu_items($locations[$location]);

    if (!$items) {
        return [];
    }

    $nodes = [];
    foreach ($items as $item) {
        $nodes[$item->ID] = [
            'id'       => (int) $item->ID,
            'parent'   => (int) $item->menu_item_parent,
            'title'    => html_entity_decode(wp_strip_all_tags($item->title), ENT_QUOTES, 'UTF-8'),
            'url'      => $item->url,
            'target'   => $item->target,
            'classes'  => array_values(array_filter((array) $item->classes)),
            'children' => [],
        ];
    }

    $tree = [];
    foreach ($nodes as &$node) {
        if ($node['parent'] && isset($nodes[$node['parent']])) {
            $nodes[$node['parent']]['children'][] = &$node;
        } else {
            $tree[] = &$node;
        }
    }
    unset($node);

    return $tree;
}

/* Callback Function To Return The Site Title */
function vue_theme_rest_get_site_title() {
    return new WP_REST_Response([
        'site_title' => get_bloginfo('name')
    ], 200);
}

/* Callback Function To Return The Logo URL */
function vue_theme_rest_get_custom_logo(WP_REST_Request $request) {
    $site = vue_theme_get_site_info();

    if (!$site['logo']) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'No custom logo set.',
        ], 404);
    }

    return new WP_REST_Response([
        'success' => true,
        'logo_url' => $site['logo']['url'],
    ], 200);
}

/* Add Custom API Routes Here */

/* Sample Route /wp-json/vue-theme/v1/hello */
vue_theme_api_get('/hello', function (WP_REST_Request $request) {
    $name = sanitize_text_field($request['name'] ?? '') ?: 'World';

    return [
        'message' => sprintf('Hello %s, this comes from functions/api.php', $name),
    ];
});

/* Return Programs List And Categories For Frontend Consumption */
function learnquran_get_programs_api() {
    $raw_cats = get_terms([
        'taxonomy'   => 'learnquran_program_category',
        'hide_empty' => false,
    ]);

    $categories = [
        [ 'id' => 'all', 'label' => 'Semua Program' ]
    ];
    $seen_keys = [ 'all' => true ];

    if ( ! empty( $raw_cats ) && ! is_wp_error( $raw_cats ) ) {
        foreach ( $raw_cats as $c ) {
            $label = trim( html_entity_decode( wp_specialchars_decode( $c->name, ENT_QUOTES ), ENT_QUOTES, 'UTF-8' ) );
            $normalized_key = strtolower( preg_replace( '/[^a-zA-Z0-9]/', '', $label ) );
            $clean_slug = sanitize_title( $c->slug );

            if ( isset( $seen_keys[ $normalized_key ] ) || isset( $seen_keys[ $clean_slug ] ) ) {
                continue;
            }

            $seen_keys[ $normalized_key ] = true;
            $seen_keys[ $clean_slug ] = true;

            $categories[] = [
                'id'    => $c->slug,
                'label' => $label,
            ];
        }
    } else {
        $categories[] = [ 'id' => 'kids', 'label' => 'Balita & Anak-anak' ];
        $categories[] = [ 'id' => 'teen-adult', 'label' => 'Remaja & Dewasa' ];
        $categories[] = [ 'id' => 'intensive', 'label' => 'Privat Khusus' ];
    }

    $posts = get_posts([
        'post_type'      => 'learnquran_program',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    ]);

    $items = [];
    foreach ( $posts as $p ) {
        $cats = wp_get_post_terms( $p->ID, 'learnquran_program_category' );
        $cat_slug = ! empty( $cats ) && ! is_wp_error( $cats ) ? $cats[0]->slug : 'kids';

        $thumb = get_the_post_thumbnail_url( $p->ID, 'large' );
        if ( ! $thumb ) {
            $thumb = get_post_meta( $p->ID, '_learnquran_program_img_fallback', true );
        }
        if ( ! $thumb ) {
            $thumb = 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=700&q=80';
        }

        $features_raw = get_post_meta( $p->ID, '_learnquran_program_features', true );
        $features = [];
        if ( ! empty( $features_raw ) ) {
            $lines = explode( "\n", str_replace( "\r", "", $features_raw ) );
            foreach ( $lines as $line ) {
                $trimmed = trim( $line );
                if ( ! empty( $trimmed ) ) {
                    $features[] = $trimmed;
                }
            }
        }

        $items[] = [
            'id'         => $p->ID,
            'title'      => html_entity_decode( wp_strip_all_tags( get_the_title( $p ) ), ENT_QUOTES, 'UTF-8' ),
            'slug'       => $p->post_name,
            'link'       => get_permalink( $p ),
            'category'   => $cat_slug,
            'age'        => html_entity_decode( get_post_meta( $p->ID, '_learnquran_program_age', true ) ?: 'Semua Usia', ENT_QUOTES, 'UTF-8' ),
            'badgeColor' => get_post_meta( $p->ID, '_learnquran_program_badge_color', true ) ?: 'bg-teal-100 text-teal-800',
            'desc'       => html_entity_decode( wp_strip_all_tags( $p->post_content ), ENT_QUOTES, 'UTF-8' ),
            'features'   => array_map( function( $f ) {
                return html_entity_decode( $f, ENT_QUOTES, 'UTF-8' );
            }, $features ),
            'img'        => $thumb,
        ];
    }

    return [
        'categories' => $categories,
        'items'      => $items,
    ];
}

/* Return Testimonials List For Frontend Consumption */
function learnquran_get_testimonials_api() {
    $posts = get_posts([
        'post_type'      => 'learnquran_testimoni',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    ]);

    $items      = [];
    $seen_names = [];
    foreach ( $posts as $p ) {
        $name = html_entity_decode( wp_strip_all_tags( get_the_title( $p ) ), ENT_QUOTES, 'UTF-8' );
        if ( isset( $seen_names[ $name ] ) ) {
            continue;
        }
        $seen_names[ $name ] = true;

        $thumb = get_the_post_thumbnail_url( $p->ID, 'thumbnail' );
        if ( ! $thumb ) {
            $thumb = get_post_meta( $p->ID, '_learnquran_testi_avatar_fallback', true );
        }
        if ( ! $thumb ) {
            $thumb = 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&q=80';
        }

        $items[] = [
            'id'     => $p->ID,
            'name'   => $name,
            'role'   => html_entity_decode( get_post_meta( $p->ID, '_learnquran_testi_role', true ) ?: 'Wali Santri', ENT_QUOTES, 'UTF-8' ),
            'rating' => (int) ( get_post_meta( $p->ID, '_learnquran_testi_rating', true ) ?: 5 ),
            'text'   => html_entity_decode( wp_strip_all_tags( $p->post_content ), ENT_QUOTES, 'UTF-8' ),
            'avatar' => $thumb,
        ];
    }

    return [
        'items' => $items,
    ];
}

/* Return FAQ List For Frontend Consumption */
function learnquran_get_faqs_api() {
    $posts = get_posts([
        'post_type'      => 'learnquran_faq',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    ]);

    $items = [];
    foreach ( $posts as $p ) {
        $items[] = [
            'id' => $p->ID,
            'q'  => html_entity_decode( wp_strip_all_tags( get_the_title( $p ) ), ENT_QUOTES, 'UTF-8' ),
            'a'  => html_entity_decode( wp_strip_all_tags( $p->post_content ), ENT_QUOTES, 'UTF-8' ),
        ];
    }

    return [
        'items' => $items,
    ];
}

/* Return Single Program Detail By Slug For Frontend Consumption */
function learnquran_get_program_by_slug_api( $slug ) {
    $posts = get_posts([
        'post_type'      => 'learnquran_program',
        'name'           => sanitize_title( $slug ),
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ]);

    if ( empty( $posts ) ) {
        return new WP_Error( 'not_found', 'Program tidak ditemukan', [ 'status' => 404 ] );
    }

    $p = $posts[0];

    /* Image Attachment */
    $thumb = get_the_post_thumbnail_url( $p->ID, 'large' );
    if ( ! $thumb ) {
        $thumb = get_post_meta( $p->ID, '_learnquran_program_img_fallback', true );
    }
    if ( ! $thumb ) {
        $thumb = 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=1200&q=80';
    }

    /* Program Category Terms */
    $terms = wp_get_post_terms( $p->ID, 'learnquran_program_category' );
    $cat_slug = ! empty( $terms ) && ! is_wp_error( $terms ) ? $terms[0]->slug : 'kids';
    $cat_name = ! empty( $terms ) && ! is_wp_error( $terms ) ? html_entity_decode( wp_specialchars_decode( $terms[0]->name, ENT_QUOTES ), ENT_QUOTES, 'UTF-8' ) : 'Semua Program';

    /* Meta Field Values */
    $headline = get_post_meta( $p->ID, '_learnquran_program_headline', true );
    if ( ! $headline ) {
        $headline = 'Stimulasi Tumbuh Kembang & Pondasi Islami Si Kecil Sejak Dini';
    }

    $price = get_post_meta( $p->ID, '_learnquran_program_price', true ) ?: 'Rp 275.000';
    $age = get_post_meta( $p->ID, '_learnquran_program_age', true ) ?: 'Usia 3 ~ 5 Tahun';
    $badge_color = get_post_meta( $p->ID, '_learnquran_program_badge_color', true ) ?: 'bg-emerald-100 text-emerald-800';

    /* Raw Features */
    $raw_features = get_post_meta( $p->ID, '_learnquran_program_features', true );
    $features = ! empty( $raw_features ) 
        ? array_values( array_filter( array_map( 'trim', explode( "\n", $raw_features ) ) ) )
        : ['Metode ramah anak & bermain sensorik', 'Jadwal fleksibel (rumah / online)', 'Pengajar tersertifikasi & sabar'];

    /* Learning Points */
    $raw_points = get_post_meta( $p->ID, '_learnquran_program_learning_points', true );
    if ( ! empty( $raw_points ) ) {
        $learning_points = array_values( array_filter( array_map( 'trim', explode( "\n", $raw_points ) ) ) );
    } else {
        $learning_points = [
            'Bermain & Gerak Aktif',
            'Mengenal Huruf Hijaiyah',
            'Kartu Sensorik Interaktif',
            'Dongeng Karakter Nabi & Akhlak',
            'Hafalan Surat Pendek Pilihan',
            'Adab Harian Anak Muslim',
            'Stimulasi Motorik Halus & Kasar',
        ];
    }

    /* Specifications List / Dynamic And Unlimited */
    $specs_list = get_post_meta( $p->ID, '_learnquran_program_specs_list', true );
    if ( empty( $specs_list ) || ! is_array( $specs_list ) ) {
        $target_group = get_post_meta( $p->ID, '_learnquran_program_target_group', true ) ?: $age . ' (Balita & Pra-TK)';
        $format       = get_post_meta( $p->ID, '_learnquran_program_format', true ) ?: 'Privat 1 Guru 1 Murid (Ke Rumah / Online Tatap Muka)';
        $duration     = get_post_meta( $p->ID, '_learnquran_program_duration', true ) ?: '45 - 60 Menit per Pertemuan (Jadwal Fleksibel)';
        $output       = get_post_meta( $p->ID, '_learnquran_program_output', true ) ?: 'Menumbuhkan kecintaan pada Al-Qur\'an sejak dini, mengenali hijaiyah, dan terbiasa berakhlak mulia.';

        $specs_list = [
            [ 'label' => '1. Kelompok Sasaran', 'value' => $target_group ],
            [ 'label' => '2. Format Pembelajaran', 'value' => $format ],
            [ 'label' => '3. Durasi & Frekuensi', 'value' => $duration ],
            [ 'label' => '4. Output yang Diharapkan', 'value' => $output ],
        ];
    } else {
        $target_group = $specs_list[0]['value'] ?? '';
        $format       = $specs_list[1]['value'] ?? '';
        $duration     = $specs_list[2]['value'] ?? '';
        $output       = $specs_list[3]['value'] ?? '';
    }

    $formatted_specs_list = [];
    foreach ( $specs_list as $item ) {
        if ( ! empty( $item['label'] ) || ! empty( $item['value'] ) ) {
            $formatted_specs_list[] = [
                'label' => html_entity_decode( $item['label'] ?? '', ENT_QUOTES, 'UTF-8' ),
                'value' => html_entity_decode( $item['value'] ?? '', ENT_QUOTES, 'UTF-8' ),
            ];
        }
    }

    /* Mentors List / Dynamic From learnquran_mentor CPT With Selection Filter */
    $selected_mentor_ids = get_post_meta( $p->ID, '_learnquran_program_mentor_ids', true );
    $mentor_args = [
        'post_type'      => 'learnquran_mentor',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    ];

    if ( ! empty( $selected_mentor_ids ) && is_array( $selected_mentor_ids ) ) {
        $mentor_args['post__in'] = array_map( 'absint', $selected_mentor_ids );
        $mentor_args['orderby']  = 'post__in';
    } else {
        $mentor_args['posts_per_page'] = 3;
    }

    $mentor_posts = get_posts( $mentor_args );

    $mentors = [];
    if ( ! empty( $mentor_posts ) ) {
        foreach ( $mentor_posts as $m ) {
            $m_thumb = get_the_post_thumbnail_url( $m->ID, 'medium' );
            if ( ! $m_thumb ) {
                $m_thumb = get_post_meta( $m->ID, '_learnquran_mentor_avatar_fallback', true );
            }
            if ( ! $m_thumb ) {
                $m_thumb = 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&q=80';
            }

            $mentors[] = [
                'id'     => $m->ID,
                'name'   => html_entity_decode( wp_strip_all_tags( get_the_title( $m ) ), ENT_QUOTES, 'UTF-8' ),
                'role'   => html_entity_decode( get_post_meta( $m->ID, '_learnquran_mentor_role', true ) ?: 'Quran Mentor', ENT_QUOTES, 'UTF-8' ),
                'badge'  => html_entity_decode( get_post_meta( $m->ID, '_learnquran_mentor_badge', true ) ?: 'Tersertifikasi Sanad', ENT_QUOTES, 'UTF-8' ),
                'cert'   => html_entity_decode( get_post_meta( $m->ID, '_learnquran_mentor_cert', true ) ?: 'Pengajar Terverifikasi Nuraniah Learning Center', ENT_QUOTES, 'UTF-8' ),
                'desc'   => html_entity_decode( wp_strip_all_tags( $m->post_content ), ENT_QUOTES, 'UTF-8' ),
                'avatar' => $m_thumb,
            ];
        }
    }

    /* Reviews / Fetch Real Testimonials First Or Fallback To Default */
    $testi_posts = get_posts([
        'post_type'      => 'learnquran_testimoni',
        'posts_per_page' => 2,
        'post_status'    => 'publish',
        'orderby'        => 'rand',
    ]);
    $reviews = [];
    if ( ! empty( $testi_posts ) ) {
        foreach ( $testi_posts as $t ) {
            $t_thumb = get_the_post_thumbnail_url( $t->ID, 'thumbnail' );
            if ( ! $t_thumb ) {
                $t_thumb = get_post_meta( $t->ID, '_learnquran_testi_avatar_fallback', true ) ?: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&q=80';
            }
            $reviews[] = [
                'name'   => html_entity_decode( wp_strip_all_tags( get_the_title( $t ) ), ENT_QUOTES, 'UTF-8' ),
                'role'   => html_entity_decode( get_post_meta( $t->ID, '_learnquran_testi_role', true ) ?: 'Wali Santri', ENT_QUOTES, 'UTF-8' ),
                'rating' => (int) ( get_post_meta( $t->ID, '_learnquran_testi_rating', true ) ?: 5 ),
                'text'   => html_entity_decode( wp_strip_all_tags( $t->post_content ), ENT_QUOTES, 'UTF-8' ),
                'avatar' => $t_thumb,
            ];
        }
    }
    if ( empty( $reviews ) ) {
        $reviews = [
            [
                'name'   => 'Bunda Sarah Ramadhani',
                'role'   => 'Wali Santri (Ananda Kenzi, 5 thn)',
                'rating' => 5,
                'text'   => 'Awalnya Kenzi gampang bosan kalau belajar mengaji. Sejak ikut privat Nuraniah Learning Center dengan metode bermain sensorial, dia sekarang selalu antusias nunggu ustadzah datang. Masya Allah!',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&q=80',
            ],
            [
                'name'   => 'Ayah Dimas Prasetyo',
                'role'   => 'Wali Santri (Ananda Aisyah, 4 thn)',
                'rating' => 5,
                'text'   => 'Laporan perkembangan rutinnya sangat detail dan membantu kami memantau progres motorik serta hafalan doa harian Aisyah. Pengajarnya sopan, tepat waktu, dan sangat sabar.',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80',
            ],
        ];
    }

    /* Fetch Related Programs */
    $other_posts = get_posts([
        'post_type'      => 'learnquran_program',
        'posts_per_page' => 2,
        'post_status'    => 'publish',
        'exclude'        => [ $p->ID ],
        'orderby'        => 'rand',
    ]);
    $related = [];
    foreach ( $other_posts as $op ) {
        $op_thumb = get_the_post_thumbnail_url( $op->ID, 'medium' );
        if ( ! $op_thumb ) {
            $op_thumb = get_post_meta( $op->ID, '_learnquran_program_img_fallback', true ) ?: 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=500&q=80';
        }
        $related[] = [
            'id'         => $op->ID,
            'title'      => html_entity_decode( wp_strip_all_tags( get_the_title( $op ) ), ENT_QUOTES, 'UTF-8' ),
            'slug'       => $op->post_name,
            'age'        => html_entity_decode( get_post_meta( $op->ID, '_learnquran_program_age', true ) ?: 'Semua Usia', ENT_QUOTES, 'UTF-8' ),
            'badgeColor' => get_post_meta( $op->ID, '_learnquran_program_badge_color', true ) ?: 'bg-teal-100 text-teal-800',
            'price'      => get_post_meta( $op->ID, '_learnquran_program_price', true ) ?: 'Rp 275.000',
            'desc'       => html_entity_decode( wp_strip_all_tags( $op->post_content ), ENT_QUOTES, 'UTF-8' ),
            'img'        => $op_thumb,
        ];
    }

    $theme_options = function_exists( 'learnquran_get_theme_options' ) ? learnquran_get_theme_options() : [];

    /* Resolve Mentor Quality Checklist Points */
    $raw_mentor_points = get_post_meta( $p->ID, '_learnquran_program_mentor_points', true );
    if ( ! empty( $raw_mentor_points ) ) {
        $mentor_quality_points = array_values( array_filter( array_map( 'trim', explode( "\n", $raw_mentor_points ) ) ) );
    } else {
        $mentor_quality_points = $theme_options['program_detail']['mentor_points'] ?? [
            'Hafalan terjaga dan menguasai kaidah tajwid',
            'Terlatih menangani berbagai mood anak',
            "Latar belakang pendidikan Islam & Ma'had terpercaya",
            'Tepat waktu, sopan, dan menjaga privasi keluarga',
        ];
    }

    /* Resolve Program Gallery Images */
    $gallery_img1 = get_post_meta( $p->ID, '_learnquran_program_gallery_img1', true );
    if ( ! $gallery_img1 ) {
        $gallery_img1 = 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=600&q=80';
    }
    $gallery_img2 = get_post_meta( $p->ID, '_learnquran_program_gallery_img2', true );
    if ( ! $gallery_img2 ) {
        $gallery_img2 = 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=600&q=80';
    }

    /* Resolve Consultation Widget Settings */
    $consult_icon   = get_post_meta( $p->ID, '_learnquran_program_consult_icon', true ) ?: ( $theme_options['program_detail']['consult_icon'] ?? 'MessageCircle' );
    $consult_title  = get_post_meta( $p->ID, '_learnquran_program_consult_title', true ) ?: ( $theme_options['program_detail']['consult_title'] ?? 'Butuh Rekomendasi Program?' );
    $consult_desc   = get_post_meta( $p->ID, '_learnquran_program_consult_desc', true ) ?: ( $theme_options['program_detail']['consult_desc'] ?? 'Konsultasikan usia dan kemampuan membaca Al-Qur\'an ananda bersama tim akademik kami.' );
    $consult_btn    = get_post_meta( $p->ID, '_learnquran_program_consult_btn', true ) ?: ( $theme_options['program_detail']['consult_btn'] ?? 'Chat Konsultan Akademik →' );
    $consult_wa_msg = get_post_meta( $p->ID, '_learnquran_program_consult_wa_msg', true ) ?: ( $theme_options['program_detail']['consult_wa_msg'] ?? 'Halo Admin LearnQuran, saya ingin konsultasi memilih program yang cocok' );

    /* Resolve Mentor Section Header Text */
    $mentor_sec_badge = get_post_meta( $p->ID, '_learnquran_program_mentor_badge', true ) ?: ( $theme_options['program_detail']['mentor_badge'] ?? 'Tenaga Pengajar' );
    $mentor_sec_title = get_post_meta( $p->ID, '_learnquran_program_mentor_title', true ) ?: ( $theme_options['program_detail']['mentor_title'] ?? 'Profile Guru / Quran Mentor' );
    $mentor_sec_tag   = get_post_meta( $p->ID, '_learnquran_program_mentor_tag', true ) ?: ( $theme_options['program_detail']['mentor_tag'] ?? 'Tersertifikasi' );
    $mentor_sec_desc  = get_post_meta( $p->ID, '_learnquran_program_mentor_desc', true ) ?: ( $theme_options['program_detail']['mentor_desc'] ?? 'Didampingi oleh asatidz dan asatidzah berkarakter lembut, bersanad, dan berpengalaman pedagogi anak:' );

    /* Resolve Pricing Subtitle And Checklist Points */
    $pricing_desc = get_post_meta( $p->ID, '_learnquran_program_pricing_desc', true ) ?: ( $theme_options['program_detail']['pricing_desc'] ?? 'Paket privat personal sesuai jadwal keluarga.' );
    $raw_pricing_points = get_post_meta( $p->ID, '_learnquran_program_pricing_points', true );
    if ( ! empty( $raw_pricing_points ) ) {
        $pricing_points = array_values( array_filter( array_map( 'trim', explode( "\n", $raw_pricing_points ) ) ) );
    } else {
        $pricing_points = $theme_options['program_detail']['pricing_points'] ?? [
            'Sesi Evaluasi & Placement Test kemampuan awal ananda',
            'Jadwal Fleksibel bebas pilih guru datang ke rumah / online',
            "Termasuk Modul Eksklusif & kartu mutaba'ah harian",
            'Laporan Evaluasi Bulanan capaian tajwid dan hafalan',
        ];
    }

    /* Resolve Section Visibility Flags / Per-Program Override Or Customizer Default */
    $raw_show_pol          = get_post_meta( $p->ID, '_learnquran_program_show_pol', true );
    $raw_show_about        = get_post_meta( $p->ID, '_learnquran_program_show_about', true );
    $raw_show_mentors      = get_post_meta( $p->ID, '_learnquran_program_show_mentors', true );
    $raw_show_specs        = get_post_meta( $p->ID, '_learnquran_program_show_specs', true );
    $raw_show_kit          = get_post_meta( $p->ID, '_learnquran_program_show_kit', true );
    $raw_show_banner       = get_post_meta( $p->ID, '_learnquran_program_show_banner', true );
    $raw_show_testimonials = get_post_meta( $p->ID, '_learnquran_program_show_testimonials', true );
    $raw_show_related      = get_post_meta( $p->ID, '_learnquran_program_show_related', true );
    $raw_show_pricing      = get_post_meta( $p->ID, '_learnquran_program_show_pricing', true );
    $raw_show_consult      = get_post_meta( $p->ID, '_learnquran_program_show_consult', true );

    $show_pol          = ( $raw_show_pol === '' ) ? (bool) ( $theme_options['program_detail']['show_pol'] ?? true ) : ( $raw_show_pol === '1' );
    $show_about        = ( $raw_show_about === '' ) ? (bool) ( $theme_options['program_detail']['show_about'] ?? true ) : ( $raw_show_about === '1' );
    $show_mentors      = ( $raw_show_mentors === '' ) ? (bool) ( $theme_options['program_detail']['show_mentors'] ?? true ) : ( $raw_show_mentors === '1' );
    $show_specs        = ( $raw_show_specs === '' ) ? (bool) ( $theme_options['program_detail']['show_specs'] ?? true ) : ( $raw_show_specs === '1' );
    $show_kit          = ( $raw_show_kit === '' ) ? (bool) ( $theme_options['program_detail']['show_kit'] ?? true ) : ( $raw_show_kit === '1' );
    $show_banner       = ( $raw_show_banner === '' ) ? (bool) ( $theme_options['program_detail']['show_banner'] ?? true ) : ( $raw_show_banner === '1' );
    $show_testimonials = ( $raw_show_testimonials === '' ) ? (bool) ( $theme_options['program_detail']['show_testimonials'] ?? true ) : ( $raw_show_testimonials === '1' );
    $show_related      = ( $raw_show_related === '' ) ? (bool) ( $theme_options['program_detail']['show_related'] ?? true ) : ( $raw_show_related === '1' );
    $show_pricing      = ( $raw_show_pricing === '' ) ? (bool) ( $theme_options['program_detail']['show_pricing'] ?? true ) : ( $raw_show_pricing === '1' );
    $show_consult      = ( $raw_show_consult === '' ) ? (bool) ( $theme_options['program_detail']['show_consult'] ?? true ) : ( $raw_show_consult === '1' );

    return [
        'id'              => $p->ID,
        'title'           => html_entity_decode( wp_strip_all_tags( get_the_title( $p ) ), ENT_QUOTES, 'UTF-8' ),
        'slug'            => $p->post_name,
        'headline'        => html_entity_decode( $headline, ENT_QUOTES, 'UTF-8' ),
        'desc'            => html_entity_decode( wp_strip_all_tags( $p->post_content ), ENT_QUOTES, 'UTF-8' ),
        'content_html'    => apply_filters( 'the_content', $p->post_content ),
        'category'        => [
            'slug' => $cat_slug,
            'name' => $cat_name,
        ],
        'age'             => html_entity_decode( $age, ENT_QUOTES, 'UTF-8' ),
        'badge_color'     => $badge_color,
        'price'           => $price,
        'img'             => $thumb,
        'gallery'         => [ $gallery_img1, $gallery_img2 ],
        'features'        => array_map( function( $f ) { return html_entity_decode( $f, ENT_QUOTES, 'UTF-8' ); }, $features ),
        'learning_points' => array_map( function( $lp ) { return html_entity_decode( $lp, ENT_QUOTES, 'UTF-8' ); }, $learning_points ),
        'mentor_quality_points' => array_map( function( $pt ) { return html_entity_decode( $pt, ENT_QUOTES, 'UTF-8' ); }, $mentor_quality_points ),
        'specifications_list'   => $formatted_specs_list,
        'specifications'  => [
            'target_group' => html_entity_decode( $target_group, ENT_QUOTES, 'UTF-8' ),
            'format'       => html_entity_decode( $format, ENT_QUOTES, 'UTF-8' ),
            'duration'     => html_entity_decode( $duration, ENT_QUOTES, 'UTF-8' ),
            'output'       => html_entity_decode( $output, ENT_QUOTES, 'UTF-8' ),
        ],
        'consult_box'     => [
            'icon'   => html_entity_decode( $consult_icon, ENT_QUOTES, 'UTF-8' ),
            'title'  => html_entity_decode( $consult_title, ENT_QUOTES, 'UTF-8' ),
            'desc'   => html_entity_decode( $consult_desc, ENT_QUOTES, 'UTF-8' ),
            'btn'    => html_entity_decode( $consult_btn, ENT_QUOTES, 'UTF-8' ),
            'wa_msg' => html_entity_decode( $consult_wa_msg, ENT_QUOTES, 'UTF-8' ),
        ],
        'mentor_section'  => [
            'badge' => html_entity_decode( $mentor_sec_badge, ENT_QUOTES, 'UTF-8' ),
            'title' => html_entity_decode( $mentor_sec_title, ENT_QUOTES, 'UTF-8' ),
            'tag'   => html_entity_decode( $mentor_sec_tag, ENT_QUOTES, 'UTF-8' ),
            'desc'  => html_entity_decode( $mentor_sec_desc, ENT_QUOTES, 'UTF-8' ),
        ],
        'pricing_desc'    => html_entity_decode( $pricing_desc, ENT_QUOTES, 'UTF-8' ),
        'pricing_points'  => array_map( function( $pt ) { return html_entity_decode( $pt, ENT_QUOTES, 'UTF-8' ); }, $pricing_points ),
        'show_pol'          => $show_pol,
        'show_about'        => $show_about,
        'show_mentors'      => $show_mentors,
        'show_specs'        => $show_specs,
        'show_kit'          => $show_kit,
        'show_banner'       => $show_banner,
        'show_testimonials' => $show_testimonials,
        'show_related'      => $show_related,
        'show_pricing'      => $show_pricing,
        'show_consult'      => $show_consult,
        'visibility'        => [
            'pol'          => $show_pol,
            'about'        => $show_about,
            'mentors'      => $show_mentors,
            'specs'        => $show_specs,
            'kit'          => $show_kit,
            'banner'       => $show_banner,
            'testimonials' => $show_testimonials,
            'related'      => $show_related,
            'pricing'      => $show_pricing,
            'consult'      => $show_consult,
        ],
        'mentors'         => $mentors,
        'reviews'         => $reviews,
        'related_programs'=> $related,
    ];
}
