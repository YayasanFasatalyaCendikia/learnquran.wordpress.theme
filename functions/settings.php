<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

function vue_theme_load_theme_settings() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'script', 'style' ) );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'editor.css' );

    /* Assign Navigation Menus In Appearance > Menus */
    register_nav_menus( array(
        'primary' => __( 'Primary Menu / Menu Atas', 'learnquran' ),
        'footer'  => __( 'Footer Menu / Menu Bawah', 'learnquran' ),
    ) );
}

add_action( 'after_setup_theme', 'vue_theme_load_theme_settings' );

/**
 * Automatically creates and assigns default 'Main Menu' to 'primary' location
 * if no menu is assigned yet. This allows it to appear immediately in WP Customizer > Menu!
 */
function learnquran_setup_default_primary_menu() {
    $menu_name = 'Main Menu';
    $locations = get_theme_mod( 'nav_menu_locations' );

    if ( ! empty( $locations['primary'] ) ) {
        return;
    }

    $menu_obj = wp_get_nav_menu_object( $menu_name );

    if ( ! $menu_obj ) {
        $menu_id = wp_create_nav_menu( $menu_name );

        if ( ! is_wp_error( $menu_id ) ) {
            $default_items = [
                [ 'title' => 'Home', 'url' => '/' ],
                [ 'title' => 'Program Belajar', 'url' => '/#/programs' ],
                [ 'title' => 'Keunggulan', 'url' => '/#/features' ],
                [ 'title' => 'Testimoni', 'url' => '/#/testimonials' ],
                [ 'title' => 'FAQ', 'url' => '/#/faq' ],
                [ 'title' => 'Artikel', 'url' => '/blog' ],
            ];

            foreach ( $default_items as $order => $item ) {
                wp_update_nav_menu_item( $menu_id, 0, [
                    'menu-item-title'   => $item['title'],
                    'menu-item-url'     => home_url( $item['url'] ),
                    'menu-item-status'  => 'publish',
                    'menu-item-type'    => 'custom',
                    'menu-item-position'=> $order + 1,
                ] );
            }
        }
    } else {
        $menu_id = $menu_obj->term_id;
    }

    if ( ! empty( $menu_id ) && ! is_wp_error( $menu_id ) ) {
        if ( ! is_array( $locations ) ) {
            $locations = [];
        }
        $locations['primary'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
}
add_action( 'after_setup_theme', 'learnquran_setup_default_primary_menu' );

/**
 * Automatically creates and assigns default 'Footer Menu' to 'footer' location
 * with 3 main menu columns and their respective sub-menus if no menu is assigned yet.
 */
function learnquran_setup_default_footer_menu() {
    $menu_name = 'Footer Menu';
    $locations = get_theme_mod( 'nav_menu_locations' );

    if ( ! empty( $locations['footer'] ) ) {
        return;
    }

    $menu_obj = wp_get_nav_menu_object( $menu_name );

    if ( ! $menu_obj ) {
        $menu_id = wp_create_nav_menu( $menu_name );

        if ( ! is_wp_error( $menu_id ) ) {
            $structure = [
                [
                    'title'    => 'Program Belajar',
                    'url'      => '/#/programs',
                    'children' => [
                        [ 'title' => 'Tahsin Balita & Toddler', 'url' => '/#/programs' ],
                        [ 'title' => "Bimbingan Membaca Al-Qur'an", 'url' => '/#/programs' ],
                        [ 'title' => "Tahfidz & Muraja'ah Anak", 'url' => '/#/programs' ],
                        [ 'title' => 'Kelas Privat Dewasa / Intensif', 'url' => '/#/programs' ],
                        [ 'title' => 'Ngaji Online Interaktif', 'url' => '/#/programs' ],
                    ],
                ],
                [
                    'title'    => 'Informasi',
                    'url'      => '/#/features',
                    'children' => [
                        [ 'title' => 'Tentang Kami', 'url' => '/#/features' ],
                        [ 'title' => 'Metode Nuraniah', 'url' => '/#/features' ],
                        [ 'title' => 'Testimoni Wali Santri', 'url' => '/#/testimonials' ],
                        [ 'title' => 'Tanya Jawab / FAQ', 'url' => '/#/faq' ],
                        [ 'title' => 'Artikel & Edukasi', 'url' => '/blog' ],
                    ],
                ],
                [
                    'title'    => 'Hubungi Kami',
                    'url'      => '#',
                    'children' => [
                        [ 'title' => 'Kantor & Lokasi Belajar', 'url' => 'https://maps.google.com' ],
                        [ 'title' => 'Konsultasi WhatsApp', 'url' => 'https://wa.me/6282266331136' ],
                        [ 'title' => 'Email Resmi', 'url' => 'mailto:info@nuraniahlearningcenter.com' ],
                    ],
                ],
            ];

            $order = 1;
            foreach ( $structure as $col ) {
                $parent_id = wp_update_nav_menu_item( $menu_id, 0, [
                    'menu-item-title'    => $col['title'],
                    'menu-item-url'      => ( strpos( $col['url'], 'http' ) === 0 || strpos( $col['url'], 'mailto:' ) === 0 || $col['url'] === '#' ) ? $col['url'] : home_url( $col['url'] ),
                    'menu-item-status'   => 'publish',
                    'menu-item-type'     => 'custom',
                    'menu-item-position' => $order++,
                ] );

                if ( ! is_wp_error( $parent_id ) && ! empty( $col['children'] ) ) {
                    foreach ( $col['children'] as $sub ) {
                        wp_update_nav_menu_item( $menu_id, 0, [
                            'menu-item-title'     => $sub['title'],
                            'menu-item-url'       => ( strpos( $sub['url'], 'http' ) === 0 || strpos( $sub['url'], 'mailto:' ) === 0 || $sub['url'] === '#' ) ? $sub['url'] : home_url( $sub['url'] ),
                            'menu-item-status'    => 'publish',
                            'menu-item-type'      => 'custom',
                            'menu-item-parent-id' => $parent_id,
                            'menu-item-position'  => $order++,
                        ] );
                    }
                }
            }
        }
    } else {
        $menu_id = $menu_obj->term_id;
    }

    if ( ! empty( $menu_id ) && ! is_wp_error( $menu_id ) ) {
        if ( ! is_array( $locations ) ) {
            $locations = [];
        }
        $locations['footer'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }
}
add_action( 'after_setup_theme', 'learnquran_setup_default_footer_menu' );

/**
 * Automatically Creates Three Comprehensive Demo Blog Articles
 * Includes Rich Gutenberg Content, Categories, And Featured Images
 */
function learnquran_setup_default_demo_posts() {
    if ( get_option( 'learnquran_demo_posts_thumbnails_v3' ) === 'yes' ) {
        return;
    }

    $existingPublishedPosts = get_posts( [
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 4,
        'fields'         => 'ids',
    ] );

    if ( count( $existingPublishedPosts ) >= 4 ) {
        update_option( 'learnquran_demo_posts_seeded_v1', 'yes' );
        return;
    }

    $demoArticles = [
        [
            'title'     => "Keutamaan Mengenalkan Al-Qur'an Sejak Dini Pada Periode Emas Anak",
            'slug'      => 'keutamaan-mengenalkan-alquran-sejak-dini',
            'excerpt'   => 'Masa golden age adalah momen terbaik menanamkan kecintaan pada kalamullah melalui stimulasi visual dan auditori yang menyenangkan.',
            'category'  => "Parenting Qur'ani",
            'imageUrl'  => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=1200&q=80',
            'content'   => '<!-- wp:paragraph -->
<p>Masa kanak-kanak, terutama pada periode usia 3 hingga 7 tahun, dikenal sebagai <em>golden age</em> atau periode emas perkembangan otak dan daya serap anak. Pada masa inilah anak memiliki kemampuan luar biasa dalam meniru bunyi, menghafal kosakata, serta menyerap nilai-nilai spiritual yang dikenalkan oleh lingkungannya.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>1. Membentuk Kedekatan Emosional dengan Al-Qur\'an</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Mengenalkan Al-Qur\'an sejak dini bukan sekadar melatih anak membaca huruf, melainkan membangun kedekatan emosional dan rasa cinta (<em>mahabbah</em>). Di <strong>Nuraniah Learning Center</strong>, kami menggunakan pendekatan interaktif, sensory play, dan kartu huruf bergambar agar anak merasa belajar membaca Al-Qur\'an adalah aktivitas yang seru dan dinanti-nanti setiap hari.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>2. Melatih Ketajaman Artikulasi dan Memori</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Melafalkan huruf-huruf hijaiyah sesuai makharijul huruf yang fasih sejak dini melatih otot bicara anak agar lebih presisi. Selain itu, irama tartil Al-Qur\'an secara alami merangsang daya ingat anak sehingga memudahkan mereka dalam menghafal surat-surat pendek Juz \'Amma secara mutqin.</p>
<!-- /wp:paragraph -->

<!-- wp:quote -->
<blockquote class="wp-block-quote"><p>“Sebaik-baik kalian adalah orang yang belajar Al-Qur\'an dan mengajarkannya.” (HR. Bukhari)</p></blockquote>
<!-- /wp:quote -->

<!-- wp:paragraph -->
<p>Dengan bimbingan yang penuh kelembutan dan kesabaran dari para asatidz, ananda akan tumbuh menjadi generasi yang tidak hanya mahir membaca Al-Qur\'an, tetapi juga memiliki akhlak mulia dalam kehidupan sehari-hari.</p>
<!-- /wp:paragraph -->',
        ],
        [
            'title'     => 'Mengapa Metode Nuraniah Sangat Efektif Membentuk Makharijul Huruf Fasih?',
            'slug'      => 'mengapa-metode-nuraniah-sangat-efektif',
            'excerpt'   => 'Metode Nuraniah membiasakan anak mengeja dan melafalkan harakat secara akurat tanpa membuat anak jenuh.',
            'category'  => 'Metode Nuraniah',
            'imageUrl'  => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=1200&q=80',
            'content'   => '<!-- wp:paragraph -->
<p>Metode Nuraniah (<em>Al-Qa\'idah An-Nuraniyyah</em>) telah diakui secara luas di berbagai belahan dunia Islam sebagai salah satu metode terbaik dan paling terstruktur dalam mengajarkan kaidah membaca Al-Qur\'an yang fasih dan bertajwid.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>Kunci Keunggulan Metode Nuraniah</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Berbeda dengan metode belajar membaca konvensional, Metode Nuraniah memiliki keunggulan mendasar:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<li><strong>Fokus pada Makhraj dan Sifat Huruf:</strong> Setiap huruf dilatih bunyinya secara murni sebelum disambung menjadi kata.</li>
<li><strong>Irama dan Ketukan yang Teratur:</strong> Membantu anak merasakan panjang pendek (mad) dan dengung (ghunnah) secara alami tanpa harus menghafal rumus tajwid yang rumit.</li>
<li><strong>Sistematis dan Terukur:</strong> Disusun bertahap dari pengenalan huruf tunggal, huruf bersambung, harakat, tanwin, sukun, tasydid, hingga ayat panjang.</li>
</ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Di <strong>Nuraniah Learning Center</strong>, metode ini dikemas dengan media modern dan bimbingan privat satu-lawan-satu sehingga anak balita maupun dewasa dapat menguasai bacaan Al-Qur\'an standar Madinah dalam waktu yang relatif lebih singkat dan menyenangkan.</p>
<!-- /wp:paragraph -->',
        ],
        [
            'title'     => "5 Tips Menjaga Semangat Muraja'ah Hafalan Al-Qur'an Ananda di Rumah",
            'slug'      => 'tips-menjaga-semangat-hafalan-anak-di-rumah',
            'excerpt'   => 'Membangun rutinitas yang konsisten tanpa paksaan melalui apresiasi positif dan mutaba\'ah teratur bersama orang tua.',
            'category'  => 'Tips Belajar',
            'imageUrl'  => 'https://images.unsplash.com/photo-1609599006353-e629aaabfeae?auto=format&fit=crop&w=1200&q=80',
            'content'   => '<!-- wp:paragraph -->
<p>Menghafal Al-Qur\'an adalah karunia agung, namun menjaga hafalan (<em>muraja\'ah</em>) membutuhkan komitmen dan suasana yang kondusif, terutama bagi anak~anak usia sekolah. Berikut adalah 5 tips praktis bagi Ayah dan Bunda untuk mendampingi ananda di rumah:</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>1. Tetapkan Jam Emas Muraja\'ah yang Konsisten</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Pilihlah waktu ketika anak dalam keadaan segar dan fokus, misalnya ba\'da Subuh atau ba\'da Maghrib. Cukup 15–20 menit setiap sesi asalkan dilakukan secara istiqamah setiap hari.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>2. Jadikan Orang Tua Sebagai Pendengar yang Antusias</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Dengarkan setoran hafalan ananda dengan penuh perhatian, tanpa terdistraksi gawai. Tunjukkan rasa bangga dan bahagia saat anak berhasil melafalkan ayat dengan lancar.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>3. Gunakan Buku Mutaba\'ah dan Stiker Apresiasi</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Visualisasikan pencapaian anak dengan tabel mutaba\'ah harian atau stiker bintang. Hal sederhana ini sangat ampuh membangkitkan rasa pencapaian pada anak.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>4. Putar Murottal Favorit Sebagai Latar di Rumah</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Memperdengarkan bacaan Syaikh favorit saat bermain santai atau menjelang tidur membantu hafalan melekat kuat di alam bawah sadar ananda.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>5. Hubungkan Hafalan dengan Kisah Al-Qur\'an</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Ceritakan kisah menarik di balik surat yang sedang dihafal, seperti kisah gajah pada Surat Al-Fil atau kisah fajar pada Surat Al-Fajr, agar ananda memahami makna yang dibacanya.</p>
<!-- /wp:paragraph -->',
        ],
    ];

    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $administratorUsers = get_users( [ 'role' => 'administrator', 'number' => 1 ] );
    $authorIdentifier   = ! empty( $administratorUsers ) ? $administratorUsers[0]->ID : 1;

    foreach ( $demoArticles as $article ) {
        $existingPost = get_page_by_path( $article['slug'], OBJECT, 'post' );
        if ( $existingPost ) {
            continue;
        }

        /* Ensure Category Exists In WordPress Taxonomy */
        $categoryIdentifier = 0;
        if ( ! empty( $article['category'] ) ) {
            $existingTerm = term_exists( $article['category'], 'category' );
            if ( ! $existingTerm ) {
                $createdTerm = wp_insert_term( $article['category'], 'category' );
                if ( ! is_wp_error( $createdTerm ) ) {
                    $categoryIdentifier = (int) $createdTerm['term_id'];
                }
            } else {
                $categoryIdentifier = is_array( $existingTerm ) ? (int) $existingTerm['term_id'] : (int) $existingTerm;
            }
        }

        $createdPostIdentifier = wp_insert_post( [
            'post_title'    => $article['title'],
            'post_name'     => $article['slug'],
            'post_content'  => $article['content'],
            'post_excerpt'  => $article['excerpt'],
            'post_status'   => 'publish',
            'post_type'     => 'post',
            'post_author'   => $authorIdentifier,
            'post_category' => $categoryIdentifier ? [ $categoryIdentifier ] : [],
        ] );

        if ( ! is_wp_error( $createdPostIdentifier ) && ! empty( $article['imageUrl'] ) ) {
            $mediaAttachmentIdentifier = @media_sideload_image( $article['imageUrl'], $createdPostIdentifier, $article['title'], 'id' );
            if ( ! is_wp_error( $mediaAttachmentIdentifier ) && is_numeric( $mediaAttachmentIdentifier ) ) {
                set_post_thumbnail( $createdPostIdentifier, (int) $mediaAttachmentIdentifier );
            }
        }
    }

    /* Ensure Each Demo Article Has A Valid Featured Image Thumbnail */
    $availableImageAttachments = get_posts( [
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_status'    => 'inherit',
        'posts_per_page' => 10,
        'fields'         => 'ids',
    ] );

    if ( ! empty( $availableImageAttachments ) ) {
        $demoArticleSlugs = [
            'keutamaan-mengenalkan-alquran-sejak-dini',
            'mengapa-metode-nuraniah-sangat-efektif',
            'tips-menjaga-semangat-hafalan-anak-di-rumah',
        ];

        foreach ( $demoArticleSlugs as $articleIndex => $articleSlug ) {
            $matchedPosts = get_posts( [
                'name'        => $articleSlug,
                'post_type'   => 'post',
                'post_status' => 'any',
                'numberposts' => 1,
            ] );
            if ( ! empty( $matchedPosts ) ) {
                $targetPost = $matchedPosts[0];
                if ( ! has_post_thumbnail( $targetPost->ID ) ) {
                    $selectedMediaIdentifier = $availableImageAttachments[ $articleIndex % count( $availableImageAttachments ) ];
                    set_post_thumbnail( $targetPost->ID, $selectedMediaIdentifier );
                }
            }
        }
    }

    update_option( 'learnquran_demo_posts_thumbnails_v3', 'yes' );
}
add_action( 'init', 'learnquran_setup_default_demo_posts' );


function vue_theme_load_custom_scripts() {
    wp_enqueue_style('wp-block-library');
    /* Enqueue Additional Custom Styles And Scripts */
}
add_action('wp_enqueue_scripts', 'vue_theme_load_custom_scripts');


/* Prevent WordPress From Guessing Redirect / Handled By Vue Router */
add_filter( 'do_redirect_guess_404_permalink', '__return_false' );

/* Prevent 404 Status In Document Title For Vue Handled Client Routes */
function vue_theme_document_title_parts( $parts ) {
    if ( is_404() ) {
        $parts = array( 'title' => get_bloginfo( 'name', 'display' ) );
    }

    return $parts;
}
add_filter( 'document_title_parts', 'vue_theme_document_title_parts' );

/* Flush Rewrite Rules Once For Custom Post Type URLs / Avoid 404 */
function learnquran_maybe_flush_rewrites() {
    if ( get_option( 'learnquran_flushed_rewrites_v1' ) !== 'yes' ) {
        flush_rewrite_rules( false );
        update_option( 'learnquran_flushed_rewrites_v1', 'yes' );
    }
}
add_action( 'init', 'learnquran_maybe_flush_rewrites', 99 );

/* Enqueue Global Admin Styles / Remove Input Number Spinners And Select Carets */
function learnquran_global_admin_custom_css() {
    ?>
    <style type="text/css">
        /* Hide Native Number Input Spinners / Steppers In Admin */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
            appearance: textfield;
        }
        /* Hide Native Select Dropdown Arrow In Admin */
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: none !important;
        }
        select::-ms-expand {
            display: none;
        }

        /* Sleek Auto Hiding Scrollbar In Admin / Appear On Hover */
        ::-webkit-scrollbar,
        *::-webkit-scrollbar {
            width: 6px !important;
            height: 6px !important;
        }

        ::-webkit-scrollbar-button,
        *::-webkit-scrollbar-button {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
            background: transparent !important;
        }

        ::-webkit-scrollbar-track,
        *::-webkit-scrollbar-track {
            background: transparent !important;
        }

        html,
        body,
        * {
            --sb-thumb: transparent;
        }

        html:hover,
        body:hover,
        *:hover {
            --sb-thumb: rgba(31, 76, 143, 0.45);
        }

        ::-webkit-scrollbar-thumb,
        *::-webkit-scrollbar-thumb {
            background-color: var(--sb-thumb, transparent) !important;
            border-radius: 9999px !important;
            transition: background-color 0.2s ease-in-out;
        }

        ::-webkit-scrollbar-thumb:hover,
        *::-webkit-scrollbar-thumb:hover {
            background-color: #1f4c8f !important;
        }

        ::-webkit-scrollbar-thumb:active,
        *::-webkit-scrollbar-thumb:active {
            background-color: #f59931 !important;
        }

        ::-webkit-scrollbar-corner,
        *::-webkit-scrollbar-corner {
            background: transparent !important;
        }

        /* Firefox Support In Admin */
        @supports (-moz-appearance: none) {
            * {
                scrollbar-width: thin;
                scrollbar-color: transparent transparent;
            }
            *:hover {
                scrollbar-color: rgba(31, 76, 143, 0.45) transparent;
            }
        }
    </style>
    <?php
}
add_action( 'admin_head', 'learnquran_global_admin_custom_css' );
add_action( 'customize_controls_print_styles', 'learnquran_global_admin_custom_css' );

/* Enqueue Editor Stylesheet For Gutenberg Block Editor */
function learnquran_enqueue_block_editor_styles() {
    wp_enqueue_style( 'learnquran-editor-style', get_template_directory_uri() . '/editor.css', [], VUE_THEME_VERSION );
}
add_action( 'enqueue_block_editor_assets', 'learnquran_enqueue_block_editor_styles' );

/* Ensure Sleek Scrollbar Is Injected Into Gutenberg Iframe Canvas */
function learnquran_admin_editor_iframe_scrollbar_script() {
    ?>
    <script type="text/javascript">
    (function(){
        /* Inject Custom Auto Hiding Scrollbar Into Iframe Document */
        function injectScrollbarStyle(doc) {
            if (!doc || doc.getElementById('learnquran-injected-scrollbar')) return;
            var style = doc.createElement('style');
            style.id = 'learnquran-injected-scrollbar';
            style.textContent = `
                ::-webkit-scrollbar, *::-webkit-scrollbar { width: 6px !important; height: 6px !important; }
                ::-webkit-scrollbar-button, *::-webkit-scrollbar-button { display: none !important; width: 0 !important; height: 0 !important; }
                ::-webkit-scrollbar-track, *::-webkit-scrollbar-track { background: transparent !important; }
                html, body, * { --sb-thumb: transparent; }
                html:hover, body:hover, *:hover { --sb-thumb: rgba(31, 76, 143, 0.45); }
                ::-webkit-scrollbar-thumb, *::-webkit-scrollbar-thumb {
                    background-color: var(--sb-thumb, transparent) !important;
                    border-radius: 9999px !important;
                    transition: background-color 0.2s ease-in-out;
                }
                ::-webkit-scrollbar-thumb:hover, *::-webkit-scrollbar-thumb:hover { background-color: #1f4c8f !important; }
                ::-webkit-scrollbar-thumb:active, *::-webkit-scrollbar-thumb:active { background-color: #f59931 !important; }
                ::-webkit-scrollbar-corner, *::-webkit-scrollbar-corner { background: transparent !important; }
                @supports (-moz-appearance: none) {
                    * { scrollbar-width: thin; scrollbar-color: transparent transparent; }
                    *:hover { scrollbar-color: rgba(31, 76, 143, 0.45) transparent; }
                }
            `;
            if (doc.head) {
                doc.head.appendChild(style);
            }
        }

        /* Check If Gutenberg Canvas Iframe Exists And Inject Styles */
        function checkIframe() {
            var iframes = document.querySelectorAll('iframe[name="editor-canvas"], .editor-canvas__iframe');
            if (iframes && iframes.length > 0) {
                iframes.forEach(function(iframe) {
                    try {
                        if (iframe.contentDocument && iframe.contentDocument.head) {
                            injectScrollbarStyle(iframe.contentDocument);
                        }
                    } catch (e) {}
                });
            }
        }

        setInterval(checkIframe, 400);
        document.addEventListener('DOMContentLoaded', checkIframe);
        window.addEventListener('load', checkIframe);
    })();
    </script>
    <?php
}
add_action( 'admin_footer', 'learnquran_admin_editor_iframe_scrollbar_script' );

/* Frontend WordPress Admin Panel Toggle / Auto Hide And Show Toggle Button */
function learnquran_frontend_admin_bar_toggle_head() {
    if ( ! is_admin_bar_showing() ) {
        return;
    }
    ?>
    <script type="text/javascript">
    (function(){
        try {
            var savedAdminBarState = localStorage.getItem('learnquran_admin_bar_state');
            /* Default To Hidden State Unless User Explicitly Set To Visible */
            if (savedAdminBarState !== 'visible') {
                document.documentElement.classList.add('learnquran-admin-bar-hidden');
            }
        } catch(e) {}
    })();
    </script>
    <style type="text/css">
        /* Admin Bar Smooth Transition */
        #wpadminbar {
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        html {
            transition: margin-top 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        /* Hidden Admin Bar State */
        html.learnquran-admin-bar-hidden {
            margin-top: 0 !important;
        }

        * html body.learnquran-admin-bar-hidden {
            margin-top: 0 !important;
        }

        html.learnquran-admin-bar-hidden #wpadminbar {
            transform: translateY(-100%) !important;
        }

        /* Toggle Button Styling */
        #learnquran-admin-bar-toggle-button {
            position: fixed;
            top: 32px;
            right: 18px;
            z-index: 999999;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            font-size: 11px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            font-weight: 600;
            color: #d1d5db;
            background: #1d2327;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-top: none;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            user-select: none;
            opacity: 0.85;
        }

        #learnquran-admin-bar-toggle-button:hover {
            opacity: 1;
            color: #ffffff;
            background: #1f4c8f;
            border-color: rgba(255, 255, 255, 0.3);
        }

        html.learnquran-admin-bar-hidden #learnquran-admin-bar-toggle-button {
            top: 0 !important;
            opacity: 0.65;
            background: rgba(29, 35, 39, 0.9);
            backdrop-filter: blur(4px);
        }

        html.learnquran-admin-bar-hidden #learnquran-admin-bar-toggle-button:hover {
            opacity: 1;
            background: #1f4c8f;
        }

        @media screen and (max-width: 782px) {
            #learnquran-admin-bar-toggle-button {
                top: 46px;
                right: 10px;
                padding: 3px 8px;
                font-size: 10px;
            }
        }
    </style>
    <?php
}
add_action( 'wp_head', 'learnquran_frontend_admin_bar_toggle_head', 99 );

function learnquran_frontend_admin_bar_toggle_footer() {
    if ( ! is_admin_bar_showing() ) {
        return;
    }
    ?>
    <button 
        id="learnquran-admin-bar-toggle-button" 
        type="button" 
        aria-label="Toggle WordPress Admin Panel"
        title="Tampilkan WordPress Admin Panel / Shortcut: Alt + A"
    >
        <svg class="learnquran-toggle-icon-wp" style="width: 13px; height: 13px; fill: currentColor;" viewBox="0 0 24 24">
            <path d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.865 8.167 6.839 9.49l-3.89-10.66A9.957 9.957 0 0 1 12 4c2.25 0 4.321.745 5.992 2.001L14.2 16.59l-2.427-7.24a1.2 1.2 0 0 0-1.14-.82h-.077c-.503 0-.94.316-1.1.795L7.042 16.27A10.02 10.02 0 0 1 4 12c0-4.411 3.589-8 8-8 2.052 0 3.926.778 5.347 2.057l-1.442 4.195-2.072 6.032A9.97 9.97 0 0 1 12 22a9.98 9.98 0 0 1-5.18-1.455l4.89-14.193a.6.6 0 0 1 .57-.402h.02c.264 0 .498.172.57.427l3.65 10.643c1.782-1.393 2.93-3.547 2.93-5.97 0-4.411-3.589-8-8-8z"/>
        </svg>
        <span id="learnquran-admin-bar-toggle-text">WordPress Admin Panel</span>
        <svg class="learnquran-toggle-arrow" style="width: 10px; height: 10px; fill: currentColor; transition: transform 0.25s; transform: rotate(180deg);" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
    </button>
    <script type="text/javascript">
    (function(){
        var toggleButton = document.getElementById('learnquran-admin-bar-toggle-button');
        var toggleText = document.getElementById('learnquran-admin-bar-toggle-text');
        var arrowIcon = toggleButton ? toggleButton.querySelector('.learnquran-toggle-arrow') : null;

        function updateToggleUi(isHidden) {
            if (!toggleText) return;
            if (isHidden) {
                toggleText.textContent = 'WordPress Admin Panel';
                if (arrowIcon) arrowIcon.style.transform = 'rotate(180deg)';
                toggleButton.setAttribute('title', 'Tampilkan WordPress Admin Panel / Shortcut: Alt + A');
            } else {
                toggleText.textContent = 'Sembunyikan';
                if (arrowIcon) arrowIcon.style.transform = 'rotate(0deg)';
                toggleButton.setAttribute('title', 'Sembunyikan WordPress Admin Panel / Shortcut: Alt + A');
            }
        }

        function toggleAdminBar() {
            var isHidden = document.documentElement.classList.toggle('learnquran-admin-bar-hidden');
            try {
                localStorage.setItem('learnquran_admin_bar_state', isHidden ? 'hidden' : 'visible');
            } catch(e) {}
            updateToggleUi(isHidden);
        }

        if (toggleButton) {
            toggleButton.addEventListener('click', toggleAdminBar);
            var isCurrentlyHidden = document.documentElement.classList.contains('learnquran-admin-bar-hidden');
            updateToggleUi(isCurrentlyHidden);
        }

        /* Keyboard Shortcut / Alt + A To Toggle Admin Bar */
        window.addEventListener('keydown', function(event) {
            if (event.altKey && (event.key === 'a' || event.key === 'A')) {
                event.preventDefault();
                toggleAdminBar();
            }
        });
    })();
    </script>
    <?php
}
add_action( 'wp_footer', 'learnquran_frontend_admin_bar_toggle_footer', 99 );

/* Auto-Activate LearnQuran Core Plugin If Present */
function learnquran_auto_activate_core_plugin() {
    if ( ! function_exists( 'activate_plugin' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $plugin_file = 'learnquran/learnquran.php';
    if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin_file ) && ! is_plugin_active( $plugin_file ) ) {
        activate_plugin( $plugin_file );
    }
}
add_action( 'init', 'learnquran_auto_activate_core_plugin', 5 );

