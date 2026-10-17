<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

/* Register Custom Post Type: Guru And Mentor / learnquran_mentor */
$mentor_labels = array(
    'name'                  => __('Guru & Mentor', 'learnquran'),
    'singular_name'         => __('Guru / Mentor', 'learnquran'),
    'menu_name'             => __('Guru & Mentor', 'learnquran'),
    'name_admin_bar'        => __('Guru / Mentor', 'learnquran'),
    'all_items'             => __('Semua Guru & Mentor', 'learnquran'),
    'add_new_item'          => __('Tambah Guru / Mentor Baru', 'learnquran'),
    'add_new'               => __('Tambah Baru', 'learnquran'),
    'new_item'              => __('Guru Baru', 'learnquran'),
    'edit_item'             => __('Edit Profil Guru', 'learnquran'),
    'update_item'           => __('Perbarui Profil Guru', 'learnquran'),
    'view_item'             => __('Lihat Profil', 'learnquran'),
    'search_items'          => __('Cari Guru / Mentor', 'learnquran'),
);

$mentor_args = array(
    'label'                 => __('Guru & Mentor', 'learnquran'),
    'labels'                => $mentor_labels,
    'supports'              => array('title', 'editor', 'thumbnail', 'custom-fields'),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'menu_position'         => 27,
    'menu_icon'             => 'dashicons-welcome-learn-more',
    'show_in_rest'          => true,
    'rest_base'             => 'mentors',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => false,
    'exclude_from_search'   => true,
    'publicly_queryable'    => true,
    'capability_type'       => 'post',
    'rewrite'               => array('slug' => 'mentors', 'with_front' => false),
);
register_post_type('learnquran_mentor', $mentor_args);

/* Register Meta Boxes For Mentors */
function learnquran_mentor_add_meta_boxes() {
    add_meta_box(
        'learnquran_mentor_meta',
        __( 'Detail & Kualifikasi Guru / Mentor', 'learnquran' ),
        'learnquran_mentor_meta_box_html',
        'learnquran_mentor',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'learnquran_mentor_add_meta_boxes' );

function learnquran_mentor_meta_box_html( $post ) {
    wp_nonce_field( 'learnquran_save_mentor_meta', 'learnquran_mentor_meta_nonce' );

    $role  = get_post_meta( $post->ID, '_learnquran_mentor_role', true );
    $badge = get_post_meta( $post->ID, '_learnquran_mentor_badge', true ) ?: 'Tersertifikasi Sanad';
    $cert  = get_post_meta( $post->ID, '_learnquran_mentor_cert', true );
    ?>
    <div style="display: grid; gap: 14px; padding: 6px 0;">
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">Peran / Spesialisasi Mengajar:</label>
            <input type="text" name="learnquran_mentor_role" value="<?php echo esc_attr( $role ); ?>" placeholder="Contoh: Quran Mentor & Spesialis Balita atau Senior Quran Educator" style="width: 100%; max-width: 480px; padding: 6px 10px;" />
            <p style="color: #64748b; font-size: 12px; margin: 4px 0 0;">Ditampilkan di bawah nama guru.</p>
        </div>

        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">Label Badge Keahlian:</label>
            <input type="text" name="learnquran_mentor_badge" value="<?php echo esc_attr( $badge ); ?>" placeholder="Contoh: Tersertifikasi Sanad atau Pedagogi Anak" style="width: 100%; max-width: 480px; padding: 6px 10px;" />
        </div>

        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">Sertifikasi / Sanad / Latar Belakang:</label>
            <input type="text" name="learnquran_mentor_cert" value="<?php echo esc_attr( $cert ); ?>" placeholder="Contoh: Hafidzah 30 Juz & Sertifikasi Metode Nuraniah" style="width: 100%; max-width: 480px; padding: 6px 10px;" />
            <p style="color: #64748b; font-size: 12px; margin: 4px 0 0;">Ditampilkan dalam tanda kutip di bagian bawah kartu guru.</p>
        </div>
    </div>
    <?php
}

function learnquran_save_mentor_meta( $post_id ) {
    if ( ! isset( $_POST['learnquran_mentor_meta_nonce'] ) || ! wp_verify_nonce( $_POST['learnquran_mentor_meta_nonce'], 'learnquran_save_mentor_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['learnquran_mentor_role'] ) ) {
        update_post_meta( $post_id, '_learnquran_mentor_role', sanitize_text_field( $_POST['learnquran_mentor_role'] ) );
    }
    if ( isset( $_POST['learnquran_mentor_badge'] ) ) {
        update_post_meta( $post_id, '_learnquran_mentor_badge', sanitize_text_field( $_POST['learnquran_mentor_badge'] ) );
    }
    if ( isset( $_POST['learnquran_mentor_cert'] ) ) {
        update_post_meta( $post_id, '_learnquran_mentor_cert', sanitize_text_field( $_POST['learnquran_mentor_cert'] ) );
    }
}
add_action( 'save_post_learnquran_mentor', 'learnquran_save_mentor_meta' );

/* Auto-seed Starter Mentors If None Exist */
function learnquran_seed_default_mentors() {
    $existing = get_posts([
        'post_type'      => 'learnquran_mentor',
        'posts_per_page' => 1,
        'post_status'    => 'any',
    ]);

    if ( ! empty( $existing ) ) {
        return;
    }

    $default_mentors = [
        [
            'title'   => 'Ustadzah Fatimah Azzahra, S.Pd.I',
            'role'    => 'Quran Mentor & Spesialis Balita',
            'badge'   => 'Tersertifikasi Sanad',
            'cert'    => 'Hafidzah 30 Juz & Sertifikasi Metode Nuraniah',
            'avatar'  => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&q=80',
            'content' => 'Berpengalaman 6 tahun membimbing anak usia balita dengan pendekatan ramah, sabar, dan interaktif.',
        ],
        [
            'title'   => 'Ustadzah Nabila Khairunnisa, M.Ag',
            'role'    => 'Senior Quran Educator',
            'badge'   => 'Pedagogi Anak',
            'cert'    => "Sanad Riwayat Hafs 'an 'Ashim",
            'avatar'  => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=80',
            'content' => 'Fokus pada penguatan makharijul huruf dan tajwid aplikatif dengan media visual yang menyenangkan.',
        ],
        [
            'title'   => 'Ustadz Ahmad Fauzi, Lc',
            'role'    => 'Konsultan Kurikulum Tahsin',
            'badge'   => 'Al-Azhar Cairo',
            'cert'    => "Magister Studi Qur'an & Hadits",
            'avatar'  => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80',
            'content' => "Membimbing ratusan santri cilik dan dewasa mencintai interaksi membaca Al-Qur'an secara fasih dan tartil.",
        ],
    ];

    foreach ( $default_mentors as $order => $mentor ) {
        $post_id = wp_insert_post([
            'post_title'   => $mentor['title'],
            'post_content' => $mentor['content'],
            'post_status'  => 'publish',
            'post_type'    => 'learnquran_mentor',
            'menu_order'   => $order + 1,
        ]);

        if ( ! is_wp_error( $post_id ) ) {
            update_post_meta( $post_id, '_learnquran_mentor_role', $mentor['role'] );
            update_post_meta( $post_id, '_learnquran_mentor_badge', $mentor['badge'] );
            update_post_meta( $post_id, '_learnquran_mentor_cert', $mentor['cert'] );
            update_post_meta( $post_id, '_learnquran_mentor_avatar_fallback', $mentor['avatar'] );
        }
    }
}
if ( did_action( 'init' ) ) {
    learnquran_seed_default_mentors();
} else {
    add_action( 'init', 'learnquran_seed_default_mentors', 30 );
}
