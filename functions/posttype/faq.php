<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

/* Register FAQ Post Type / learnquran_faq */
$faq_labels = array(
    'name'               => __('Tanya Jawab', 'learnquran'),
    'singular_name'      => __('FAQ', 'learnquran'),
    'menu_name'          => __('FAQ', 'learnquran'),
    'name_admin_bar'     => __('FAQ', 'learnquran'),
    'all_items'          => __('Semua FAQ', 'learnquran'),
    'add_new_item'       => __('Tambah FAQ Baru', 'learnquran'),
    'add_new'            => __('Tambah Baru', 'learnquran'),
    'edit_item'          => __('Edit FAQ', 'learnquran'),
    'view_item'          => __('Lihat FAQ', 'learnquran'),
    'search_items'       => __('Cari FAQ', 'learnquran'),
);

$faq_args = array(
    'label'               => __('FAQ', 'learnquran'),
    'labels'              => $faq_labels,
    'supports'            => array('title', 'editor', 'page-attributes'),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'menu_position'       => 28,
    'menu_icon'           => 'dashicons-editor-help',
    'show_in_rest'        => true,
    'rest_base'           => 'faqs',
    'show_in_admin_bar'   => true,
    'show_in_nav_menus'   => true,
    'can_export'          => true,
    'has_archive'         => false,
    'exclude_from_search' => true,
    'publicly_queryable'  => true,
    'capability_type'     => 'post',
    'rewrite'             => array('slug' => 'faqs', 'with_front' => false),
);
register_post_type('learnquran_faq', $faq_args);

/* Seed Default FAQs If Database Has No Records */
function learnquran_seed_default_faqs() {
    $existing = get_posts([
        'post_type'      => 'learnquran_faq',
        'posts_per_page' => 1,
        'post_status'    => 'any',
    ]);

    if ( ! empty( $existing ) ) {
        return;
    }

    $default_faqs = [
        [
            'q' => 'Apakah bisa memilih antara guru ngaji ke rumah atau kelas online?',
            'a' => 'Tentu bisa! Kami menyediakan dua pilihan format: Guru Ngaji ke Rumah (Home Tutoring) untuk wilayah yang terjangkau, serta Kelas Privat Online interaktif via Zoom/Google Meet yang bisa diakses dari mana saja.',
        ],
        [
            'q' => 'Bagaimana kualifikasi guru ngaji di Nuraniah Learning Center?',
            'a' => 'Seluruh asatidz dan asatidzah kami melalui seleksi ketat, memiliki sanad/sertifikasi tilawah atau tajwid, berlatar belakang pesantren atau universitas Islam terkemuka, serta dibekali pelatihan psikologi anak.',
        ],
        [
            'q' => 'Apakah jadwal belajar bisa disesuaikan dengan rutinitas anak?',
            'a' => 'Bisa sekali. Waktu, hari, dan frekuensi pertemuan (misal 2x atau 3x seminggu) dapat disepakati bersama sesuai jadwal luang ananda dan keluarga.',
        ],
        [
            'q' => 'Apakah ada kelas uji coba (Trial Class)?',
            'a' => 'Ya, kami menyediakan sesi konsultasi dan Trial Class untuk mengetahui tingkat kemampuan awal (placement test) ananda sebelum memulai paket reguler.',
        ],
    ];

    foreach ( $default_faqs as $order => $faq ) {
        wp_insert_post([
            'post_title'   => $faq['q'],
            'post_content' => $faq['a'],
            'post_status'  => 'publish',
            'post_type'    => 'learnquran_faq',
            'menu_order'   => $order + 1,
        ]);
    }
}
if ( did_action( 'init' ) ) {
    learnquran_seed_default_faqs();
} else {
    add_action( 'init', 'learnquran_seed_default_faqs', 30 );
}

