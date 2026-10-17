<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

/* Register Testimonials Post Type / learnquran_testimoni */
$testimonial_labels = array(
    'name'                  => _x('Testimoni', 'Post Type General Name', 'learnquran'),
    'singular_name'         => _x('Testimoni', 'Post Type Singular Name', 'learnquran'),
    'menu_name'             => __('Testimoni', 'learnquran'),
    'name_admin_bar'        => __('Testimoni', 'learnquran'),
    'all_items'             => __('Semua Testimoni', 'learnquran'),
    'add_new_item'          => __('Tambah Testimoni Baru', 'learnquran'),
    'add_new'               => __('Tambah Baru', 'learnquran'),
    'edit_item'             => __('Edit Testimoni', 'learnquran'),
    'view_item'             => __('Lihat Testimoni', 'learnquran'),
    'search_items'          => __('Cari Testimoni', 'learnquran'),
    'featured_image'        => __('Foto Profil Wali/Santri', 'learnquran'),
    'set_featured_image'    => __('Pilih Foto Profil', 'learnquran'),
    'remove_featured_image' => __('Hapus Foto Profil', 'learnquran'),
);

$testimonial_args = array(
    'label'                 => __('Testimoni', 'learnquran'),
    'labels'                => $testimonial_labels,
    'supports'              => array('title', 'editor', 'thumbnail', 'custom-fields'),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'menu_position'         => 26,
    'menu_icon'             => 'dashicons-format-quote',
    'show_in_rest'          => true,
    'rest_base'             => 'testimonials',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => false,
    'exclude_from_search'   => true,
    'publicly_queryable'    => true,
    'capability_type'       => 'post',
    'rewrite'               => array('slug' => 'testimonials', 'with_front' => false),
);
register_post_type('learnquran_testimoni', $testimonial_args);

/* Register Meta Boxes For Testimonials */
function learnquran_testimoni_add_meta_boxes() {
    add_meta_box(
        'learnquran_testimoni_meta',
        __( 'Detail Wali Santri / Testimoni', 'learnquran' ),
        'learnquran_testimoni_meta_box_html',
        'learnquran_testimoni',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'learnquran_testimoni_add_meta_boxes' );

function learnquran_testimoni_meta_box_html( $post ) {
    wp_nonce_field( 'learnquran_save_testimonial_meta', 'learnquran_testimoni_meta_nonce' );

    $role   = get_post_meta( $post->ID, '_learnquran_testi_role', true );
    $rating = get_post_meta( $post->ID, '_learnquran_testi_rating', true ) ?: '5';
    ?>
    <div style="display: grid; gap: 14px; padding: 6px 0;">
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">Peran / Keterangan Wali Santri:</label>
            <input type="text" name="learnquran_testi_role" value="<?php echo esc_attr( $role ); ?>" placeholder="Contoh: Wali Santri (Ananda Kenzi, 5 thn) atau Peserta Kelas Dewasa" style="width: 100%; max-width: 480px; padding: 6px 10px;" />
            <p style="color: #64748b; font-size: 12px; margin: 4px 0 0;">Ditampilkan di bawah nama pemberi ulasan.</p>
        </div>

        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">Rating Bintang:</label>
            <select name="learnquran_testi_rating" style="width: 100%; max-width: 200px; padding: 6px 10px;">
                <option value="5" <?php selected( $rating, '5' ); ?>>â­â­â­â­â­ (5 Bintang)</option>
                <option value="4" <?php selected( $rating, '4' ); ?>>â­â­â­â­ (4 Bintang)</option>
                <option value="3" <?php selected( $rating, '3' ); ?>>â­â­â­ (3 Bintang)</option>
            </select>
        </div>
    </div>
    <?php
}

function learnquran_save_testimonial_meta( $post_id ) {
    if ( ! isset( $_POST['learnquran_testimoni_meta_nonce'] ) || ! wp_verify_nonce( $_POST['learnquran_testimoni_meta_nonce'], 'learnquran_save_testimonial_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['learnquran_testi_role'] ) ) {
        update_post_meta( $post_id, '_learnquran_testi_role', sanitize_text_field( $_POST['learnquran_testi_role'] ) );
    }
    if ( isset( $_POST['learnquran_testi_rating'] ) ) {
        update_post_meta( $post_id, '_learnquran_testi_rating', sanitize_text_field( $_POST['learnquran_testi_rating'] ) );
    }
}
add_action( 'save_post_learnquran_testimoni', 'learnquran_save_testimonial_meta' );

/* Auto-seed Starter Testimonials If Fewer Than 9 Exist */
function learnquran_seed_default_testimonials() {
    $existing = get_posts([
        'post_type'      => 'learnquran_testimoni',
        'posts_per_page' => -1,
        'post_status'    => 'any',
        'fields'         => 'ids',
        'orderby'        => 'ID',
        'order'          => 'ASC',
    ]);

    $existing_titles = [];
    if ( ! empty( $existing ) ) {
        foreach ( $existing as $existing_id ) {
            $title = get_the_title( $existing_id );
            if ( in_array( $title, $existing_titles, true ) ) {
                wp_delete_post( $existing_id, true );
            } else {
                $existing_titles[] = $title;
            }
        }
    }

    $default_testimonials = [
        [
            'title'   => 'Bunda Sarah Ramadhani',
            'role'    => 'Wali Santri (Ananda Kenzi, 5 thn)',
            'rating'  => '5',
            'avatar'  => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&q=80',
            'content' => 'Awalnya Kenzi gampang bosan kalau belajar mengaji. Sejak ikut privat Nuraniah Learning Center dengan metode bermain sensorial, dia sekarang selalu antusias nunggu ustadzah datang. Masya Allah!',
        ],
        [
            'title'   => 'Ayah Dimas Prasetyo',
            'role'    => 'Wali Santri (Ananda Aisyah, 8 thn)',
            'rating'  => '5',
            'avatar'  => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80',
            'content' => 'Laporan perkembangan rutinnya sangat detail dan membantu kami memantau progres hafalan Aisyah. Pengajarnya sopan, tepat waktu, dan sangat sabar mengoreksi tajwid.',
        ],
        [
            'title'   => 'Ibu Ratna Kumalasari',
            'role'    => 'Peserta Kelas Tahsin Dewasa',
            'rating'  => '5',
            'avatar'  => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=150&q=80',
            'content' => 'Dulu sempat malu mau belajar ngaji lagi di usia kepala empat. Alhamdulillah ustadzahnya sangat membimbing dengan sabar, fleksibel atur jam belajar, dan pembawaannya nyaman sekali.',
        ],
        [
            'title'   => 'Umi Fauziyah & Abi Wildan',
            'role'    => 'Wali Santri (Ananda Fatih, 6 thn)',
            'rating'  => '5',
            'avatar'  => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80',
            'content' => 'Metode Nuraniah sangat terstruktur. Hanya dalam 3 bulan, Fatih sudah bisa menyambung huruf dan bacaan makhrajnya makin terdengar jelas dan tartil.',
        ],
        [
            'title'   => 'Bunda Kartika Sari',
            'role'    => 'Wali Santri (Ananda Rayyan, 4 thn)',
            'rating'  => '5',
            'avatar'  => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=150&q=80',
            'content' => 'Guru ngajinya sangat sabar menghadapi anak balita yang aktif. Flashcard hijaiyah sensoriknya sangat membantu Rayyan cepat hafal huruf tanpa merasa tertekan.',
        ],
        [
            'title'   => 'dr. H. Hendra Wicaksono',
            'role'    => 'Peserta Kelas Tahsin Eksekutif',
            'rating'  => '5',
            'avatar'  => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&q=80',
            'content' => 'Jadwal fleksibel privat ke rumah sangat ideal untuk kesibukan saya. Ustadz pembimbing sangat mutqin dan penjelasan tajwidnya mudah dipahami secara logis.',
        ],
        [
            'title'   => 'Bunda Nadhira Putri',
            'role'    => 'Wali Santri (Ananda Malik, 7 thn)',
            'rating'  => '5',
            'avatar'  => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=150&q=80',
            'content' => 'Sebelumnya Malik sering tertukar antara huruf jim, kho, dan ha. Di Nuraniah Learning Center diajarkan titik artikulasi dengan cara visual yang sangat mudah diingat ananda.',
        ],
        [
            'title'   => 'Ayah Rian Setiawan',
            'role'    => 'Wali Santri (Ananda Zaid, 5 thn)',
            'rating'  => '5',
            'avatar'  => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=150&q=80',
            'content' => 'Pendampingan intensif satu per satu membuat perkembangan ananda terpantau maksimal. Sangat direkomendasikan untuk orang tua yang ingin fondasi Al-Qur\'an anak kokoh sejak dini.',
        ],
        [
            'title'   => 'Ibu Nurul Hidayati',
            'role'    => 'Peserta Kelas Tilawah Dewasa',
            'rating'  => '5',
            'avatar'  => 'https://images.unsplash.com/photo-1567532939604-b6b5b0db2604?auto=format&fit=crop&w=150&q=80',
            'content' => 'Suasana belajarnya sangat ramah dan menenangkan hati. Koreksi makhraj hurufnya sangat teliti tanpa membuat minder sama sekali. Sangat bersyukur bisa belajar di sini.',
        ],
    ];

    foreach ( $default_testimonials as $order => $testi ) {
        if ( in_array( $testi['title'], $existing_titles, true ) ) {
            continue;
        }

        $post_id = wp_insert_post([
            'post_title'   => $testi['title'],
            'post_content' => $testi['content'],
            'post_status'  => 'publish',
            'post_type'    => 'learnquran_testimoni',
            'menu_order'   => $order + 1,
        ]);

        if ( ! is_wp_error( $post_id ) ) {
            update_post_meta( $post_id, '_learnquran_testi_role', $testi['role'] );
            update_post_meta( $post_id, '_learnquran_testi_rating', $testi['rating'] );
            update_post_meta( $post_id, '_learnquran_testi_avatar_fallback', $testi['avatar'] );
        }
    }

    update_option( 'learnquran_testimonials_seeded_v3', 1 );
}
add_action( 'init', 'learnquran_seed_default_testimonials', 30 );

/* Register REST API Fields For learnquran_testimoni */
function learnquran_register_testimonial_rest_fields() {
    register_rest_field( 'learnquran_testimoni', 'testimonial_details', [
        'get_callback' => function( $post ) {
            $post_id = $post['id'];
            $thumb   = get_the_post_thumbnail_url( $post_id, 'thumbnail' );
            if ( ! $thumb ) {
                $thumb = get_post_meta( $post_id, '_learnquran_testi_avatar_fallback', true );
            }
            if ( ! $thumb ) {
                $thumb = 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&q=80';
            }

            return [
                'role'   => html_entity_decode( get_post_meta( $post_id, '_learnquran_testi_role', true ) ?: 'Wali Santri', ENT_QUOTES, 'UTF-8' ),
                'rating' => (int) ( get_post_meta( $post_id, '_learnquran_testi_rating', true ) ?: 5 ),
                'avatar' => $thumb,
            ];
        },
        'schema' => null,
    ] );
}
add_action( 'rest_api_init', 'learnquran_register_testimonial_rest_fields' );
