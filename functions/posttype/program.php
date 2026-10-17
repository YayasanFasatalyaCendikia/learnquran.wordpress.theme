<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

/* 1. Register Learning Programs Post Type / learnquran_program */
$program_labels = array(
    'name'                  => _x('Program Belajar', 'Post Type General Name', 'learnquran'),
    'singular_name'         => _x('Program Belajar', 'Post Type Singular Name', 'learnquran'),
    'menu_name'             => __('Program Belajar', 'learnquran'),
    'name_admin_bar'        => __('Program Belajar', 'learnquran'),
    'archives'              => __('Arsip Program', 'learnquran'),
    'attributes'            => __('Urutan Program', 'learnquran'),
    'all_items'             => __('Semua Program', 'learnquran'),
    'add_new_item'          => __('Tambah Program Baru', 'learnquran'),
    'add_new'               => __('Tambah Baru', 'learnquran'),
    'new_item'              => __('Program Baru', 'learnquran'),
    'edit_item'             => __('Edit Program', 'learnquran'),
    'update_item'           => __('Perbarui Program', 'learnquran'),
    'view_item'             => __('Lihat Program', 'learnquran'),
    'view_items'            => __('Lihat Semua Program', 'learnquran'),
    'search_items'          => __('Cari Program', 'learnquran'),
    'not_found'             => __('Tidak ada program ditemukan', 'learnquran'),
    'not_found_in_trash'    => __('Tidak ada program di Tong Sampah', 'learnquran'),
    'featured_image'        => __('Foto Cover Program', 'learnquran'),
    'set_featured_image'    => __('Pilih Foto Cover', 'learnquran'),
    'remove_featured_image' => __('Hapus Foto Cover', 'learnquran'),
    'use_featured_image'    => __('Gunakan sebagai Foto Cover', 'learnquran'),
);

$program_args = array(
    'label'                 => __('Program Belajar', 'learnquran'),
    'labels'                => $program_labels,
    'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'menu_position'         => 25,
    'menu_icon'             => 'dashicons-welcome-learn-more',
    'show_in_rest'          => true,
    'rest_base'             => 'programs',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'post',
    'rewrite'               => array('slug' => 'program', 'with_front' => false),
);
register_post_type('learnquran_program', $program_args);

/* Register Program Category Taxonomy */
$cat_labels = array(
    'name'              => _x('Kategori Program', 'taxonomy general name', 'learnquran'),
    'singular_name'     => _x('Kategori Program', 'taxonomy singular name', 'learnquran'),
    'search_items'      => __('Cari Kategori', 'learnquran'),
    'all_items'         => __('Semua Kategori', 'learnquran'),
    'edit_item'         => __('Edit Kategori', 'learnquran'),
    'update_item'       => __('Perbarui Kategori', 'learnquran'),
    'add_new_item'      => __('Tambah Kategori Baru', 'learnquran'),
    'new_item_name'     => __('Nama Kategori Baru', 'learnquran'),
    'menu_name'         => __('Kategori Program', 'learnquran'),
);

register_taxonomy('learnquran_program_category', array('learnquran_program'), array(
    'hierarchical'      => true,
    'labels'            => $cat_labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'show_in_rest'      => true,
    'rest_base'         => 'program-categories',
    'rewrite'           => array('slug' => 'program-category', 'with_front' => false),
));

/* Register Meta Boxes For Program Belajar */
function learnquran_program_add_meta_boxes() {
    add_meta_box(
        'learnquran_program_meta',
        __( 'Pengaturan & Detail Program', 'learnquran' ),
        'learnquran_program_meta_box_html',
        'learnquran_program',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'learnquran_program_add_meta_boxes' );

function learnquran_admin_enqueue_media( $hook ) {
    global $post_type;
    if ( in_array( $hook, [ 'post.php', 'post-new.php' ], true ) && 'learnquran_program' === $post_type ) {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'learnquran_admin_enqueue_media' );

function learnquran_program_meta_box_html( $post ) {
    wp_nonce_field( 'learnquran_save_program_meta', 'learnquran_program_meta_nonce' );

    $headline        = get_post_meta( $post->ID, '_learnquran_program_headline', true );
    $price           = get_post_meta( $post->ID, '_learnquran_program_price', true ) ?: 'Rp 275.000';
    $age             = get_post_meta( $post->ID, '_learnquran_program_age', true );
    $badge_color     = get_post_meta( $post->ID, '_learnquran_program_badge_color', true ) ?: 'bg-teal-100 text-teal-800';
    $features        = get_post_meta( $post->ID, '_learnquran_program_features', true );
    $learning_points = get_post_meta( $post->ID, '_learnquran_program_learning_points', true );
    $target_group    = get_post_meta( $post->ID, '_learnquran_program_target_group', true );
    $format          = get_post_meta( $post->ID, '_learnquran_program_format', true );
    $duration        = get_post_meta( $post->ID, '_learnquran_program_duration', true );
    $output          = get_post_meta( $post->ID, '_learnquran_program_output', true );
    $gallery_img1    = get_post_meta( $post->ID, '_learnquran_program_gallery_img1', true );
    $gallery_img2    = get_post_meta( $post->ID, '_learnquran_program_gallery_img2', true );
    $consult_icon    = get_post_meta( $post->ID, '_learnquran_program_consult_icon', true );
    $consult_title   = get_post_meta( $post->ID, '_learnquran_program_consult_title', true );
    $consult_desc    = get_post_meta( $post->ID, '_learnquran_program_consult_desc', true );
    $consult_btn     = get_post_meta( $post->ID, '_learnquran_program_consult_btn', true );
    $consult_wa_msg  = get_post_meta( $post->ID, '_learnquran_program_consult_wa_msg', true );
    $mentor_sec_badge= get_post_meta( $post->ID, '_learnquran_program_mentor_badge', true );
    $mentor_sec_title= get_post_meta( $post->ID, '_learnquran_program_mentor_title', true );
    $mentor_sec_tag  = get_post_meta( $post->ID, '_learnquran_program_mentor_tag', true );
    $mentor_sec_desc = get_post_meta( $post->ID, '_learnquran_program_mentor_desc', true );
    $pricing_desc    = get_post_meta( $post->ID, '_learnquran_program_pricing_desc', true );
    $pricing_points  = get_post_meta( $post->ID, '_learnquran_program_pricing_points', true );

    /* Section Visibility Settings / Default True If Not Explicitly Disabled */
    $show_pol          = get_post_meta( $post->ID, '_learnquran_program_show_pol', true );
    $show_about        = get_post_meta( $post->ID, '_learnquran_program_show_about', true );
    $show_mentors      = get_post_meta( $post->ID, '_learnquran_program_show_mentors', true );
    $show_specs        = get_post_meta( $post->ID, '_learnquran_program_show_specs', true );
    $show_kit          = get_post_meta( $post->ID, '_learnquran_program_show_kit', true );
    $show_banner       = get_post_meta( $post->ID, '_learnquran_program_show_banner', true );
    $show_testimonials = get_post_meta( $post->ID, '_learnquran_program_show_testimonials', true );
    $show_related      = get_post_meta( $post->ID, '_learnquran_program_show_related', true );
    $show_pricing      = get_post_meta( $post->ID, '_learnquran_program_show_pricing', true );
    $show_consult      = get_post_meta( $post->ID, '_learnquran_program_show_consult', true );

    $is_show_pol          = ( $show_pol === '' || $show_pol === '1' );
    $is_show_about        = ( $show_about === '' || $show_about === '1' );
    $is_show_mentors      = ( $show_mentors === '' || $show_mentors === '1' );
    $is_show_specs        = ( $show_specs === '' || $show_specs === '1' );
    $is_show_kit          = ( $show_kit === '' || $show_kit === '1' );
    $is_show_banner       = ( $show_banner === '' || $show_banner === '1' );
    $is_show_testimonials = ( $show_testimonials === '' || $show_testimonials === '1' );
    $is_show_related      = ( $show_related === '' || $show_related === '1' );
    $is_show_pricing      = ( $show_pricing === '' || $show_pricing === '1' );
    $is_show_consult      = ( $show_consult === '' || $show_consult === '1' );

    /* Dynamic Specifications List */
    $specs_list = get_post_meta( $post->ID, '_learnquran_program_specs_list', true );
    if ( ! is_array( $specs_list ) || empty( $specs_list ) ) {
        $specs_list = [
            [
                'label' => 'Kelompok Sasaran',
                'value' => $target_group ?: ( $age ? $age . ', Balita & Pra-TK' : 'Balita & Pra TK, Usia 3 ~ 5 Tahun' ),
            ],
            [
                'label' => 'Format Pembelajaran',
                'value' => $format ?: 'Privat 1 Guru 1 Murid, Ke Rumah / Online Tatap Muka',
            ],
            [
                'label' => 'Durasi & Frekuensi',
                'value' => $duration ?: '45 - 60 Menit per Sesi, Jadwal Fleksibel',
            ],
            [
                'label' => 'Output yang Diharapkan',
                'value' => $output ?: 'Menumbuhkan kecintaan pada Al-Qur\'an sejak dini, mengenali hijaiyah, dan terbiasa berakhlak mulia.',
            ],
        ];
    }
    ?>
    <div style="display: grid; gap: 16px; padding: 8px 0;">

        <!-- Section 0: General Hero Information And Program Overview -->
        <div style="border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; overflow: hidden;">
            <div style="background: #f8fafc; padding: 10px 14px; border-bottom: 1px solid #e2e8f0;">
                <h4 style="margin: 0; font-size: 13px; font-weight: 700; color: #1e293b;">
                    Informasi Hero & Ringkasan Program
                </h4>
            </div>
            <div style="padding: 14px 16px; display: grid; gap: 14px;">
                <div>
                    <label style="font-weight: 600; display: block; margin-bottom: 4px;">Headline Utama Halaman Detail:</label>
                    <input type="text" name="learnquran_program_headline" value="<?php echo esc_attr( $headline ); ?>" placeholder="Contoh: Stimulasi Tumbuh Kembang & Pondasi Islami Si Kecil Sejak Dini" style="width: 100%; max-width: 600px; padding: 6px 10px;" />
                    <p style="color: #64748b; font-size: 12px; margin: 4px 0 0;">Judul besar penjelas di bagian atas halaman detail program.</p>
                </div>

                <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 250px;">
                        <label style="font-weight: 600; display: block; margin-bottom: 4px;">Target Usia / Kelompok Santri:</label>
                        <input type="text" name="learnquran_program_age" value="<?php echo esc_attr( $age ); ?>" placeholder="Contoh: Usia 3 ~ 5 Tahun atau Remaja & Dewasa" style="width: 100%; padding: 6px 10px;" />
                    </div>
                    <div style="flex: 1; min-width: 250px;">
                        <label style="font-weight: 600; display: block; margin-bottom: 4px;">Warna Badge Usia:</label>
                        <select name="learnquran_program_badge_color" style="width: 100%; padding: 6px 10px;">
                            <option value="bg-emerald-100 text-emerald-800" <?php selected( $badge_color, 'bg-emerald-100 text-emerald-800' ); ?>>Emerald / Hijau Lembut</option>
                            <option value="bg-teal-100 text-teal-800" <?php selected( $badge_color, 'bg-teal-100 text-teal-800' ); ?>>Teal / Toska Lembut</option>
                            <option value="bg-amber-100 text-amber-800" <?php selected( $badge_color, 'bg-amber-100 text-amber-800' ); ?>>Amber / Oranye/Kuning Emas</option>
                            <option value="bg-cyan-100 text-cyan-800" <?php selected( $badge_color, 'bg-cyan-100 text-cyan-800' ); ?>>Cyan / Biru Muda</option>
                            <option value="bg-indigo-100 text-indigo-800" <?php selected( $badge_color, 'bg-indigo-100 text-indigo-800' ); ?>>Indigo / Ungu Biru</option>
                            <option value="bg-rose-100 text-rose-800" <?php selected( $badge_color, 'bg-rose-100 text-rose-800' ); ?>>Rose / Merah Muda Lembut</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="font-weight: 600; display: block; margin-bottom: 4px;">Poin Keunggulan / Fitur Kartu, Satu Baris Per Item:</label>
                    <textarea name="learnquran_program_features" rows="3" style="width: 100%; max-width: 600px; padding: 8px 10px;" placeholder="Bermain & bernyanyi Islami&#10;Kartu huruf sensorik&#10;Guru ramah & penyabar"><?php echo esc_textarea( $features ); ?></textarea>
                </div>
            </div>
        </div>

        <!-- Card Points Of Learning / Dynamic Skills Pills -->
        <div style="border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 10px 14px; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 8px;">
                <h4 style="margin: 0; font-size: 13px; font-weight: 700; color: #1f4c8f;">
                    Card Points of Learning
                </h4>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #1f4c8f; cursor: pointer; background: #ffffff; padding: 4px 10px; border-radius: 6px; border: 1px solid #cbd5e1;">
                    <input type="checkbox" name="learnquran_show_pol" value="1" <?php checked( $is_show_pol, true ); ?> />
                    <span>Tampilkan Blok Ini</span>
                </label>
            </div>
            <div style="padding: 14px 16px;">
                <label style="font-weight: 600; display: block; margin-bottom: 4px;">Points of Learning / Keterampilan yang Dipelajari, Satu Baris Per item:</label>
                <textarea name="learnquran_program_learning_points" rows="4" style="width: 100%; max-width: 600px; padding: 8px 10px;" placeholder="Bermain & Gerak Aktif&#10;Mengenal Huruf Hijaiyah&#10;Kartu Sensorik&#10;Dongeng Karakter Nabi & Akhlak&#10;Hafalan Surat Pendek Pilihan&#10;Adab Harian Anak Muslim&#10;Stimulasi Motorik Halus & Kasar"><?php echo esc_textarea( $learning_points ); ?></textarea>
                <p style="color: #64748b; font-size: 12px; margin: 4px 0 0;">Akan ditampilkan dalam bentuk pill/tag interaktif di bagian Points of Learning.</p>
            </div>
        </div>

        <!-- Card About This Program / Managed Via Main WordPress Editor -->
        <div style="border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 10px 14px; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 8px;">
                <h4 style="margin: 0; font-size: 13px; font-weight: 700; color: #1f4c8f;">
                    Card Tentang Program Ini
                </h4>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #1f4c8f; cursor: pointer; background: #ffffff; padding: 4px 10px; border-radius: 6px; border: 1px solid #cbd5e1;">
                    <input type="checkbox" name="learnquran_show_about" value="1" <?php checked( $is_show_about, true ); ?> />
                    <span>Tampilkan Blok Ini</span>
                </label>
            </div>
            <div style="padding: 14px 16px;">
                <p style="margin: 0; color: #475569; font-size: 13px; line-height: 1.5;">
                    â„¹ï¸ Konten penjelasan lengkap mengenai program ini dikelola langsung melalui <strong>Editor Konten Utama WordPress</strong> di atas. Gunakan checkbox di atas untuk mengaktifkan atau menyembunyikan blok ini di halaman program.
                </p>
            </div>
        </div>

        <!-- Card Mentor Profile Showcase / Asatidz And Asatidzah -->
        <div style="border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 10px 14px; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 8px;">
                <h4 style="margin: 0; font-size: 13px; font-weight: 700; color: #1f4c8f;">
                    Card Profil Guru & Quran Mentor
                </h4>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #1f4c8f; cursor: pointer; background: #ffffff; padding: 4px 10px; border-radius: 6px; border: 1px solid #cbd5e1;">
                    <input type="checkbox" name="learnquran_show_mentors" value="1" <?php checked( $is_show_mentors, true ); ?> />
                    <span>Tampilkan Blok Ini</span>
                </label>
            </div>
            <div style="padding: 14px 16px;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; margin-bottom: 12px;">
                    <div>
                        <label style="font-size: 11px; font-weight: 600; display: block; margin-bottom: 3px; color: #475569;">Badge / Subtitle Atas:</label>
                        <input type="text" name="learnquran_program_mentor_badge" value="<?php echo esc_attr( $mentor_sec_badge ); ?>" placeholder="Default: Tenaga Pengajar" style="width: 100%; padding: 6px 8px;" />
                    </div>
                    <div>
                        <label style="font-size: 11px; font-weight: 600; display: block; margin-bottom: 3px; color: #475569;">Judul Utama Bagian:</label>
                        <input type="text" name="learnquran_program_mentor_title" value="<?php echo esc_attr( $mentor_sec_title ); ?>" placeholder="Default: Profile Guru / Quran Mentor" style="width: 100%; padding: 6px 8px;" />
                    </div>
                    <div>
                        <label style="font-size: 11px; font-weight: 600; display: block; margin-bottom: 3px; color: #475569;">Badge Kanan:</label>
                        <input type="text" name="learnquran_program_mentor_tag" value="<?php echo esc_attr( $mentor_sec_tag ); ?>" placeholder="Default: Tersertifikasi" style="width: 100%; padding: 6px 8px;" />
                    </div>
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="font-size: 11px; font-weight: 600; display: block; margin-bottom: 3px; color: #475569;">Teks Deskripsi / Pengantar Guru:</label>
                    <textarea name="learnquran_program_mentor_desc" rows="2" style="width: 100%; padding: 6px 8px;" placeholder="Default: Didampingi oleh asatidz dan asatidzah berkarakter lembut, bersanad, dan berpengalaman pedagogi anak:"><?php echo esc_textarea( $mentor_sec_desc ); ?></textarea>
                </div>

                <label style="font-weight: 600; display: block; margin-bottom: 4px; color: #1e293b;">Pilih Guru / Quran Mentor, Ditampilkan di Halaman Program Ini:</label>
                <p style="color: #64748b; font-size: 12px; margin: 0 0 10px;">Centang ustadz/ustadzah yang mengajar program ini. Jika tidak ada yang dicentang, sistem akan otomatis menampilkan semua pengajar secara default.</p>
                
                <?php
                $all_mentors = get_posts([
                    'post_type'      => 'learnquran_mentor',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'orderby'        => 'menu_order title',
                    'order'          => 'ASC',
                ]);
                $saved_mentors = get_post_meta( $post->ID, '_learnquran_program_mentor_ids', true );
                $selected_mentors = is_array( $saved_mentors ) ? $saved_mentors : [];
                ?>
                <?php if ( ! empty( $all_mentors ) ) : ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 10px; background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <?php foreach ( $all_mentors as $m ) : 
                            $is_checked = in_array( (int) $m->ID, array_map( 'intval', $selected_mentors ), true );
                            $m_role = get_post_meta( $m->ID, '_learnquran_mentor_role', true );
                            $m_badge = get_post_meta( $m->ID, '_learnquran_mentor_badge', true );
                        ?>
                            <label style="display: flex; align-items: flex-start; gap: 10px; padding: 8px 10px; background: #ffffff; border: 1px solid <?php echo $is_checked ? '#1f4c8f' : '#cbd5e1'; ?>; border-radius: 6px; cursor: pointer;">
                                <input type="checkbox" name="learnquran_program_mentor_ids[]" value="<?php echo esc_attr( $m->ID ); ?>" <?php checked( $is_checked, true ); ?> style="margin-top: 3px;" />
                                <span style="line-height: 1.3;">
                                    <strong style="color: #0f172a; font-size: 13px;"><?php echo esc_html( get_the_title( $m ) ); ?></strong>
                                    <?php if ( $m_role ) : ?>
                                        <br><span style="font-size: 11px; color: #f59931; font-weight: 600;"><?php echo esc_html( $m_role ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $m_badge ) : ?>
                                        <br><span style="display: inline-block; margin-top: 3px; font-size: 10px; padding: 1px 6px; background: #e0f2fe; color: #0369a1; border-radius: 4px;"><?php echo esc_html( $m_badge ); ?></span>
                                    <?php endif; ?>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <p style="color: #94a3b8; font-size: 12px; font-style: italic;">Belum ada data guru. Anda dapat menambahkannya melalui menu "Guru & Mentor" di sidebar.</p>
                <?php endif; ?>

                <div style="margin-top: 14px;">
                    <label style="font-weight: 600; display: block; margin-bottom: 4px; color: #1e293b;">Poin Standar / Kualifikasi Pengajar Khusus Program Ini, Satu Baris Per item:</label>
                    <?php $custom_mentor_points = get_post_meta( $post->ID, '_learnquran_program_mentor_points', true ); ?>
                    <textarea name="learnquran_program_mentor_points" rows="4" style="width: 100%; max-width: 600px; padding: 8px 10px;" placeholder="Hafalan terjaga dan menguasai kaidah tajwid&#10;Terlatih menangani berbagai mood anak&#10;Latar belakang pendidikan Islam & Ma'had terpercaya&#10;Tepat waktu, sopan, dan menjaga privasi keluarga"><?php echo esc_textarea( $custom_mentor_points ); ?></textarea>
                    <p style="color: #64748b; font-size: 12px; margin: 4px 0 0;">Tekan Enter untuk membuat poin checklist baru di bawah kartu pengajar (tanpa batas banyaknya). Biarkan kosong jika ingin menggunakan teks default dari Customizer.</p>
                </div>
            </div>
        </div>

        <!-- Card Class Specifications And Objectives / Parameters And Documentation -->
        <div style="border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 10px 14px; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 8px;">
                <h4 style="margin: 0; font-size: 13px; font-weight: 700; color: #1f4c8f;">
                    Card Parameter Kelas & Target Program
                </h4>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #1f4c8f; cursor: pointer; background: #ffffff; padding: 4px 10px; border-radius: 6px; border: 1px solid #cbd5e1;">
                    <input type="checkbox" name="learnquran_show_specs" value="1" <?php checked( $is_show_specs, true ); ?> />
                    <span>Tampilkan Blok Ini</span>
                </label>
            </div>
            <div style="padding: 14px 16px;">
                <!-- Documentation Photos -->
                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; display: block; margin-bottom: 4px; color: #1e293b;">Foto Galeri / Dokumentasi Program, 2 Foto:</label>
                    <p style="color: #64748b; font-size: 12px; margin: 0 0 12px;">Foto dokumentasi kegiatan belajar yang tampil di atas box Spesifikasi & Target Program. Format horizontal/landscape disarankan.</p>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                        <!-- Foto 1 -->
                        <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; background: #f8fafc;">
                            <strong style="display: block; font-size: 13px; margin-bottom: 8px; color: #0f172a;">Foto Satu</strong>
                            <div style="width: 100%; height: 160px; background: #e2e8f0; border-radius: 6px; overflow: hidden; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; position: relative;">
                                <img id="learnquran-gallery1-preview" src="<?php echo esc_url( $gallery_img1 ); ?>" style="width: 100%; height: 100%; object-fit: cover; <?php echo empty( $gallery_img1 ) ? 'display: none;' : ''; ?>" />
                                <span id="learnquran-gallery1-placeholder" style="<?php echo ! empty( $gallery_img1 ) ? 'display: none;' : ''; ?> color: #64748b; font-size: 12px; text-align: center; padding: 10px;">
                                    ðŸ“· Belum ada foto khusus<br><small style="color: #94a3b8;">menggunakan foto default</small>
                                </span>
                            </div>
                            <input type="hidden" id="learnquran_program_gallery_img1" name="learnquran_program_gallery_img1" value="<?php echo esc_attr( $gallery_img1 ); ?>" />
                            <div style="display: flex; gap: 8px;">
                                <button type="button" class="button button-secondary learnquran-upload-btn" data-target="learnquran_program_gallery_img1" data-preview="learnquran-gallery1-preview" data-placeholder="learnquran-gallery1-placeholder" data-remove="learnquran_program_gallery_img1-remove">
                                    Pilih / Unggah Foto
                                </button>
                                <button type="button" class="button button-link-delete learnquran-remove-btn" id="learnquran_program_gallery_img1-remove" data-target="learnquran_program_gallery_img1" data-preview="learnquran-gallery1-preview" data-placeholder="learnquran-gallery1-placeholder" style="<?php echo empty( $gallery_img1 ) ? 'display: none;' : ''; ?>">
                                    Hapus Foto
                                </button>
                            </div>
                        </div>

                        <!-- Foto 2 -->
                        <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; background: #f8fafc;">
                            <strong style="display: block; font-size: 13px; margin-bottom: 8px; color: #0f172a;">Foto Dua</strong>
                            <div style="width: 100%; height: 160px; background: #e2e8f0; border-radius: 6px; overflow: hidden; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; position: relative;">
                                <img id="learnquran-gallery2-preview" src="<?php echo esc_url( $gallery_img2 ); ?>" style="width: 100%; height: 100%; object-fit: cover; <?php echo empty( $gallery_img2 ) ? 'display: none;' : ''; ?>" />
                                <span id="learnquran-gallery2-placeholder" style="<?php echo ! empty( $gallery_img2 ) ? 'display: none;' : ''; ?> color: #64748b; font-size: 12px; text-align: center; padding: 10px;">
                                    ðŸ“· Belum ada foto khusus<br><small style="color: #94a3b8;">menggunakan foto default</small>
                                </span>
                            </div>
                            <input type="hidden" id="learnquran_program_gallery_img2" name="learnquran_program_gallery_img2" value="<?php echo esc_attr( $gallery_img2 ); ?>" />
                            <div style="display: flex; gap: 8px;">
                                <button type="button" class="button button-secondary learnquran-upload-btn" data-target="learnquran_program_gallery_img2" data-preview="learnquran-gallery2-preview" data-placeholder="learnquran-gallery2-placeholder" data-remove="learnquran_program_gallery_img2-remove">
                                    Pilih / Unggah Foto
                                </button>
                                <button type="button" class="button button-link-delete learnquran-remove-btn" id="learnquran_program_gallery_img2-remove" data-target="learnquran_program_gallery_img2" data-preview="learnquran-gallery2-preview" data-placeholder="learnquran-gallery2-placeholder" style="<?php echo empty( $gallery_img2 ) ? 'display: none;' : ''; ?>">
                                    Hapus Foto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parameters Repeater -->
                <div style="border-top: 1px solid #e2e8f0; padding-top: 14px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; flex-wrap: wrap; gap: 8px;">
                        <div>
                            <h4 style="margin: 0; color: #1e293b; font-size: 14px; font-weight: 700;">Parameter Kelas & Spesifikasi Program:</h4>
                            <p style="color: #64748b; font-size: 12px; margin: 3px 0 0;">Kustomisasi judul parameter dan isinya secara bebas tanpa batas jumlah box.</p>
                        </div>
                        <button type="button" id="learnquran-add-spec-btn" class="button button-secondary" style="font-weight: 600;">
                            + Tambah Parameter Baru
                        </button>
                    </div>

                    <div id="learnquran-specs-container" style="display: flex; flex-direction: column; gap: 10px;">
                        <?php foreach ( $specs_list as $spec ) : 
                            $s_label = $spec['label'] ?? '';
                            $s_value = $spec['value'] ?? '';
                        ?>
                            <div class="learnquran-spec-row" style="display: flex; gap: 10px; align-items: center; background: #f8fafc; padding: 10px 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                                <div style="width: 35%; min-width: 180px;">
                                    <label style="display: block; font-size: 11px; font-weight: 600; color: #475569; margin-bottom: 3px;">Judul / Label Parameter:</label>
                                    <input type="text" name="learnquran_spec_labels[]" value="<?php echo esc_attr( $s_label ); ?>" placeholder="Misal: Kelompok Sasaran" style="width: 100%; padding: 6px 8px; font-size: 13px;" />
                                </div>
                                <div style="flex: 1;">
                                    <label style="display: block; font-size: 11px; font-weight: 600; color: #475569; margin-bottom: 3px;">Isi / Nilai Keterangan:</label>
                                    <input type="text" name="learnquran_spec_values[]" value="<?php echo esc_attr( $s_value ); ?>" placeholder="Misal: Balita & Pra-TK (Usia 3 ~ 5 Tahun)" style="width: 100%; padding: 6px 8px; font-size: 13px;" />
                                </div>
                                <div style="padding-top: 18px;">
                                    <button type="button" class="button button-link-delete learnquran-remove-spec-btn" title="Hapus Parameter" style="color: #ef4444; font-size: 18px; font-weight: bold; line-height: 1; padding: 4px 8px;">
                                        &times;
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Student Learning Kit / Exclusive Facilities -->
        <div style="border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 10px 14px; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 8px;">
                <h4 style="margin: 0; font-size: 13px; font-weight: 700; color: #1f4c8f;">
                    Card Student's Learning Kit
                </h4>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #1f4c8f; cursor: pointer; background: #ffffff; padding: 4px 10px; border-radius: 6px; border: 1px solid #cbd5e1;">
                    <input type="checkbox" name="learnquran_show_kit" value="1" <?php checked( $is_show_kit, true ); ?> />
                    <span>Tampilkan Blok Ini</span>
                </label>
            </div>
            <div style="padding: 14px 16px;">
                <p style="margin: 0; color: #475569; font-size: 13px; line-height: 1.5;">
                    â„¹ï¸ Menampilkan fasilitas kit eksklusif santri / modul cetak metode Nuraniah, flashcard sensorik, & buku mutaba'ah harian. Pengaturan teks dan daftar item kit dapat diubah secara global melalui menu <strong>Appearance > Customize > Detail Program Page</strong>.
                </p>
            </div>
        </div>

        <!-- Card Curriculum Consultation Callout Banner -->
        <div style="border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 10px 14px; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 8px;">
                <h4 style="margin: 0; font-size: 13px; font-weight: 700; color: #1f4c8f;">
                    Card Banner Konsultasi Kurikulum
                </h4>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #1f4c8f; cursor: pointer; background: #ffffff; padding: 4px 10px; border-radius: 6px; border: 1px solid #cbd5e1;">
                    <input type="checkbox" name="learnquran_show_banner" value="1" <?php checked( $is_show_banner, true ); ?> />
                    <span>Tampilkan Blok Ini</span>
                </label>
            </div>
            <div style="padding: 14px 16px;">
                <p style="margin: 0; color: #475569; font-size: 13px; line-height: 1.5;">
                    â„¹ï¸ Banner ajakan "Cari Tahu Apa Itu Metode Nuraniah / Konsultasi Gratis" yang langsung terhubung ke nomor WhatsApp admin. Kustomisasi judul dan teks tombol dapat diatur melalui menu <strong>Appearance > Customize > Detail Program Page</strong>.
                </p>
            </div>
        </div>

        <!-- Card Parent Testimonials Showcase -->
        <div style="border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 10px 14px; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 8px;">
                <h4 style="margin: 0; font-size: 13px; font-weight: 700; color: #1f4c8f;">
                    Card Testimoni Wali Santri
                </h4>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #1f4c8f; cursor: pointer; background: #ffffff; padding: 4px 10px; border-radius: 6px; border: 1px solid #cbd5e1;">
                    <input type="checkbox" name="learnquran_show_testimonials" value="1" <?php checked( $is_show_testimonials, true ); ?> />
                    <span>Tampilkan Blok Ini</span>
                </label>
            </div>
            <div style="padding: 14px 16px;">
                <p style="margin: 0; color: #475569; font-size: 13px; line-height: 1.5;">
                    â„¹ï¸ Menampilkan ulasan bintang lima dan cerita wali santri yang belajar di Nuraniah Learning Center. Kustomisasi badge dan judul bagian dapat diatur melalui menu <strong>Appearance > Customize > Detail Program Page</strong>.
                </p>
            </div>
        </div>

        <!-- Card Related Programs Selection -->
        <div style="border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 10px 14px; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 8px;">
                <h4 style="margin: 0; font-size: 13px; font-weight: 700; color: #1f4c8f;">
                    Card Pilihan Program Lainnya
                </h4>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #1f4c8f; cursor: pointer; background: #ffffff; padding: 4px 10px; border-radius: 6px; border: 1px solid #cbd5e1;">
                    <input type="checkbox" name="learnquran_show_related" value="1" <?php checked( $is_show_related, true ); ?> />
                    <span>Tampilkan Blok Ini</span>
                </label>
            </div>
            <div style="padding: 14px 16px;">
                <p style="margin: 0; color: #475569; font-size: 13px; line-height: 1.5;">
                    â„¹ï¸ Menampilkan kartu rekomendasi program-program lainnya untuk kelompok usia yang berbeda di bagian bawah halaman. Kustomisasi badge dan judul dapat diatur melalui menu <strong>Appearance > Customize > Detail Program Page</strong>.
                </p>
            </div>
        </div>

        <!-- Sidebar Card Sticky Pricing And Registration -->
        <div style="border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 10px 14px; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 8px;">
                <h4 style="margin: 0; font-size: 13px; font-weight: 700; color: #1f4c8f;">
                    Sidebar: Kartu Harga & Registrasi
                </h4>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #1f4c8f; cursor: pointer; background: #ffffff; padding: 4px 10px; border-radius: 6px; border: 1px solid #cbd5e1;">
                    <input type="checkbox" name="learnquran_show_pricing" value="1" <?php checked( $is_show_pricing, true ); ?> />
                    <span>Tampilkan Blok Ini</span>
                </label>
            </div>
            <div style="padding: 14px 16px; display: grid; gap: 14px;">
                <div>
                    <label style="font-weight: 600; display: block; margin-bottom: 4px;">Harga Paket / Mulai Dari:</label>
                    <input type="text" name="learnquran_program_price" value="<?php echo esc_attr( $price ); ?>" placeholder="Contoh: Rp 275.000" style="width: 100%; max-width: 400px; padding: 6px 10px;" />
                </div>

                <div>
                    <label style="font-weight: 600; display: block; margin-bottom: 4px;">Keterangan / Subtitle Paket Harga (Sidebar):</label>
                    <input type="text" name="learnquran_program_pricing_desc" value="<?php echo esc_attr( $pricing_desc ); ?>" placeholder="Default: Paket privat personal sesuai jadwal keluarga." style="width: 100%; max-width: 600px; padding: 6px 10px;" />
                </div>

                <div>
                    <label style="font-weight: 600; display: block; margin-bottom: 4px;">Poin Fasilitas Paket di Sidebar (Khusus Program Ini, 1 baris per poin):</label>
                    <textarea name="learnquran_program_pricing_points" rows="4" style="width: 100%; max-width: 600px; padding: 8px 10px;" placeholder="Sesi Evaluasi & Placement Test kemampuan awal ananda&#10;Jadwal Fleksibel bebas pilih guru datang ke rumah / online&#10;Termasuk Modul Eksklusif & kartu mutaba'ah harian&#10;Laporan Evaluasi Bulanan capaian tajwid dan hafalan"><?php echo esc_textarea( $pricing_points ); ?></textarea>
                    <p style="color: #64748b; font-size: 12px; margin: 4px 0 0;">Biarkan kosong jika ingin menggunakan poin fasilitas paket default dari Customizer.</p>
                </div>
            </div>
        </div>

        <!-- Sidebar Card Consultation And Recommendation Box -->
        <div style="border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 10px 14px; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 8px;">
                <h4 style="margin: 0; font-size: 13px; font-weight: 700; color: #1f4c8f;">
                    Sidebar: Kotak Rekomendasi / Bantuan Konsultasi
                </h4>
                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #1f4c8f; cursor: pointer; background: #ffffff; padding: 4px 10px; border-radius: 6px; border: 1px solid #cbd5e1;">
                    <input type="checkbox" name="learnquran_show_consult" value="1" <?php checked( $is_show_consult, true ); ?> />
                    <span>Tampilkan Blok Ini</span>
                </label>
            </div>
            <div style="padding: 14px 16px;">
                <p style="color: #64748b; font-size: 12px; margin: 0 0 12px;">Kustomisasi kotak konsultasi / bantuan di samping halaman detail program. Kosongkan jika ingin memakai teks default dari Customizer.</p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <div style="max-width: 140px;">
                        <label style="font-size: 11px; font-weight: 600; display: block; margin-bottom: 3px; color: #475569;">Icon Lucide:</label>
                        <input type="text" name="learnquran_program_consult_icon" value="<?php echo esc_attr( $consult_icon ); ?>" placeholder="MessageCircle" style="width: 100%; padding: 6px 8px;" />
                    </div>
                    <div style="flex: 1; min-width: 220px;">
                        <label style="font-size: 11px; font-weight: 600; display: block; margin-bottom: 3px; color: #475569;">Judul Kotak Rekomendasi:</label>
                        <input type="text" name="learnquran_program_consult_title" value="<?php echo esc_attr( $consult_title ); ?>" placeholder="Default: Butuh Rekomendasi Program?" style="width: 100%; padding: 6px 8px;" />
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <label style="font-size: 11px; font-weight: 600; display: block; margin-bottom: 3px; color: #475569;">Deskripsi Kotak Rekomendasi:</label>
                        <textarea name="learnquran_program_consult_desc" rows="2" style="width: 100%; padding: 6px 8px;" placeholder="Default: Konsultasikan usia dan kemampuan membaca Al-Qur'an ananda bersama tim akademik kami."><?php echo esc_textarea( $consult_desc ); ?></textarea>
                    </div>
                    <div>
                        <label style="font-size: 11px; font-weight: 600; display: block; margin-bottom: 3px; color: #475569;">Teks Tombol Chat:</label>
                        <input type="text" name="learnquran_program_consult_btn" value="<?php echo esc_attr( $consult_btn ); ?>" placeholder="Default: Chat Konsultan Akademik â†’" style="width: 100%; padding: 6px 8px;" />
                    </div>
                    <div>
                        <label style="font-size: 11px; font-weight: 600; display: block; margin-bottom: 3px; color: #475569;">Draft Pesan WhatsApp:</label>
                        <input type="text" name="learnquran_program_consult_wa_msg" value="<?php echo esc_attr( $consult_wa_msg ); ?>" placeholder="Default: Halo Admin LearnQuran, saya ingin konsultasi memilih program yang cocok" style="width: 100%; padding: 6px 8px;" />
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
    jQuery(document).ready(function($){
        /* Dynamic Specifications Repeater */
        $('#learnquran-add-spec-btn').on('click', function(e){
            e.preventDefault();
            var rowCount = $('#learnquran-specs-container .learnquran-spec-row').length + 1;
            var rowHtml = '<div class="learnquran-spec-row" style="display: flex; gap: 10px; align-items: center; background: #f8fafc; padding: 10px 12px; border-radius: 8px; border: 1px solid #e2e8f0;">' +
                '<div style="width: 35%; min-width: 180px;">' +
                    '<label style="display: block; font-size: 11px; font-weight: 600; color: #475569; margin-bottom: 3px;">Judul / Label Parameter:</label>' +
                    '<input type="text" name="learnquran_spec_labels[]" value="" placeholder="Misal: ' + rowCount + '. Parameter Baru" style="width: 100%; padding: 6px 8px; font-size: 13px;" />' +
                '</div>' +
                '<div style="flex: 1;">' +
                    '<label style="display: block; font-size: 11px; font-weight: 600; color: #475569; margin-bottom: 3px;">Isi / Nilai Keterangan:</label>' +
                    '<input type="text" name="learnquran_spec_values[]" value="" placeholder="Isi penjelasan parameter ini..." style="width: 100%; padding: 6px 8px; font-size: 13px;" />' +
                '</div>' +
                '<div style="padding-top: 18px;">' +
                    '<button type="button" class="button button-link-delete learnquran-remove-spec-btn" title="Hapus Parameter" style="color: #ef4444; font-size: 18px; font-weight: bold; line-height: 1; padding: 4px 8px;">' +
                        '&times;' +
                    '</button>' +
                '</div>' +
            '</div>';
            $('#learnquran-specs-container').append(rowHtml);
        });

        $(document).on('click', '.learnquran-remove-spec-btn', function(e){
            e.preventDefault();
            if ($('#learnquran-specs-container .learnquran-spec-row').length <= 1) {
                $(this).closest('.learnquran-spec-row').find('input').val('');
            } else {
                $(this).closest('.learnquran-spec-row').remove();
            }
        });

        /* Media Uploader */
        $('.learnquran-upload-btn').on('click', function(e){
            e.preventDefault();
            var targetInput = $(this).data('target');
            var targetPreview = $(this).data('preview');
            var targetPlaceholder = $(this).data('placeholder');
            var targetRemove = $(this).data('remove');

            var frame = wp.media({
                title: 'Pilih atau Unggah Foto Dokumentasi Program',
                button: { text: 'Gunakan Foto Ini' },
                multiple: false,
                library: { type: 'image' }
            });

            frame.on('select', function(){
                var attachment = frame.state().get('selection').first().toJSON();
                var imgUrl = (attachment.sizes && attachment.sizes.large) ? attachment.sizes.large.url : attachment.url;
                $('#' + targetInput).val(imgUrl);
                $('#' + targetPreview).attr('src', imgUrl).show();
                $('#' + targetPlaceholder).hide();
                $('#' + targetRemove).show();
            });

            frame.open();
        });

        $('.learnquran-remove-btn').on('click', function(e){
            e.preventDefault();
            var targetInput = $(this).data('target');
            var targetPreview = $(this).data('preview');
            var targetPlaceholder = $(this).data('placeholder');

            $('#' + targetInput).val('');
            $('#' + targetPreview).attr('src', '').hide();
            $('#' + targetPlaceholder).show();
            $(this).hide();
        });
    });
    </script>
    <?php
}

function learnquran_save_program_meta( $post_id ) {
    if ( ! isset( $_POST['learnquran_program_meta_nonce'] ) || ! wp_verify_nonce( $_POST['learnquran_program_meta_nonce'], 'learnquran_save_program_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = [
        'learnquran_program_headline'        => '_learnquran_program_headline',
        'learnquran_program_price'           => '_learnquran_program_price',
        'learnquran_program_age'             => '_learnquran_program_age',
        'learnquran_program_badge_color'     => '_learnquran_program_badge_color',
        'learnquran_program_features'        => '_learnquran_program_features',
        'learnquran_program_learning_points' => '_learnquran_program_learning_points',
        'learnquran_program_mentor_points'   => '_learnquran_program_mentor_points',
        'learnquran_program_target_group'    => '_learnquran_program_target_group',
        'learnquran_program_format'          => '_learnquran_program_format',
        'learnquran_program_duration'        => '_learnquran_program_duration',
        'learnquran_program_output'          => '_learnquran_program_output',
        'learnquran_program_consult_icon'    => '_learnquran_program_consult_icon',
        'learnquran_program_consult_title'   => '_learnquran_program_consult_title',
        'learnquran_program_consult_desc'    => '_learnquran_program_consult_desc',
        'learnquran_program_consult_btn'     => '_learnquran_program_consult_btn',
        'learnquran_program_consult_wa_msg'  => '_learnquran_program_consult_wa_msg',
        'learnquran_program_mentor_badge'    => '_learnquran_program_mentor_badge',
        'learnquran_program_mentor_title'    => '_learnquran_program_mentor_title',
        'learnquran_program_mentor_tag'      => '_learnquran_program_mentor_tag',
        'learnquran_program_mentor_desc'     => '_learnquran_program_mentor_desc',
        'learnquran_program_pricing_desc'    => '_learnquran_program_pricing_desc',
        'learnquran_program_pricing_points'  => '_learnquran_program_pricing_points',
    ];

    foreach ( $fields as $input_key => $meta_key ) {
        if ( isset( $_POST[$input_key] ) ) {
            $val = ( strpos( $input_key, 'features' ) !== false || strpos( $input_key, 'points' ) !== false || strpos( $input_key, 'desc' ) !== false ) 
                ? sanitize_textarea_field( $_POST[$input_key] ) 
                : sanitize_text_field( $_POST[$input_key] );
            update_post_meta( $post_id, $meta_key, $val );
        }
    }

    /* Save Section Visibility Flags / Enable Or Show Blocks */
    $visibility_keys = [
        'learnquran_show_pol'          => '_learnquran_program_show_pol',
        'learnquran_show_about'        => '_learnquran_program_show_about',
        'learnquran_show_mentors'      => '_learnquran_program_show_mentors',
        'learnquran_show_specs'        => '_learnquran_program_show_specs',
        'learnquran_show_kit'          => '_learnquran_program_show_kit',
        'learnquran_show_banner'       => '_learnquran_program_show_banner',
        'learnquran_show_testimonials' => '_learnquran_program_show_testimonials',
        'learnquran_show_related'      => '_learnquran_program_show_related',
        'learnquran_show_pricing'      => '_learnquran_program_show_pricing',
        'learnquran_show_consult'      => '_learnquran_program_show_consult',
    ];

    foreach ( $visibility_keys as $post_var => $meta_key ) {
        update_post_meta( $post_id, $meta_key, isset( $_POST[$post_var] ) ? '1' : '0' );
    }

    /* Save Dynamic Specifications List */
    if ( isset( $_POST['learnquran_spec_labels'] ) && is_array( $_POST['learnquran_spec_labels'] ) ) {
        $labels = $_POST['learnquran_spec_labels'];
        $values = isset( $_POST['learnquran_spec_values'] ) && is_array( $_POST['learnquran_spec_values'] ) ? $_POST['learnquran_spec_values'] : [];
        $specs_list = [];

        foreach ( $labels as $i => $label ) {
            $cleaned_label = sanitize_text_field( $label );
            $cleaned_val   = isset( $values[$i] ) ? sanitize_text_field( $values[$i] ) : '';
            if ( $cleaned_label !== '' || $cleaned_val !== '' ) {
                $specs_list[] = [
                    'label' => $cleaned_label,
                    'value' => $cleaned_val,
                ];
            }
        }
        update_post_meta( $post_id, '_learnquran_program_specs_list', $specs_list );

        /* Synchronize Legacy Field Values */
        if ( isset( $specs_list[0]['value'] ) ) update_post_meta( $post_id, '_learnquran_program_target_group', $specs_list[0]['value'] );
        if ( isset( $specs_list[1]['value'] ) ) update_post_meta( $post_id, '_learnquran_program_format', $specs_list[1]['value'] );
        if ( isset( $specs_list[2]['value'] ) ) update_post_meta( $post_id, '_learnquran_program_duration', $specs_list[2]['value'] );
        if ( isset( $specs_list[3]['value'] ) ) update_post_meta( $post_id, '_learnquran_program_output', $specs_list[3]['value'] );
    }

    /* Save Program Gallery Images */
    $gallery_fields = [
        'learnquran_program_gallery_img1' => '_learnquran_program_gallery_img1',
        'learnquran_program_gallery_img2' => '_learnquran_program_gallery_img2',
    ];
    foreach ( $gallery_fields as $input_key => $meta_key ) {
        if ( isset( $_POST[$input_key] ) ) {
            update_post_meta( $post_id, $meta_key, esc_url_raw( trim( $_POST[$input_key] ) ) );
        }
    }

    /* Save Selected Mentors Array */
    if ( isset( $_POST['learnquran_program_mentor_ids'] ) && is_array( $_POST['learnquran_program_mentor_ids'] ) ) {
        $mentor_ids = array_map( 'absint', $_POST['learnquran_program_mentor_ids'] );
        update_post_meta( $post_id, '_learnquran_program_mentor_ids', $mentor_ids );
    } else {
        update_post_meta( $post_id, '_learnquran_program_mentor_ids', [] );
    }
}
add_action( 'save_post_learnquran_program', 'learnquran_save_program_meta' );

/* Auto-seed Starter Programs If None Exist */
function learnquran_seed_default_programs() {
    $existing = get_posts([
        'post_type'      => 'learnquran_program',
        'posts_per_page' => 1,
        'post_status'    => 'any',
    ]);

    if ( ! empty( $existing ) ) {
        return;
    }

    /* Default Categories / Consistent Naming And Slug-First Lookup */
    $cats = [
        'kids'        => 'Balita & Anak-anak',
        'teen-adult'  => 'Remaja & Dewasa',
        'intensive'   => 'Privat Khusus',
    ];
    $term_ids = [];
    foreach ( $cats as $slug => $name ) {
        $term = get_term_by( 'slug', $slug, 'learnquran_program_category' );
        if ( ! $term ) {
            $term = get_term_by( 'name', $name, 'learnquran_program_category' );
        }
        if ( ! $term ) {
            $created = wp_insert_term( $name, 'learnquran_program_category', [ 'slug' => $slug ] );
            if ( ! is_wp_error( $created ) ) {
                $term_ids[$slug] = $created['term_id'];
            }
        } else {
            $term_ids[$slug] = $term->term_id;
        }
    }

    $default_programs = [
        [
            'title'       => 'Islamic Sensory & Balita',
            'category'    => 'kids',
            'age'         => 'Usia 3 ~ 5 Tahun',
            'badge_color' => 'bg-emerald-100 text-emerald-800',
            'content'     => 'Stimulasi motorik, pengenalan huruf Hijaiyah dengan metode bermain sensorial dan penanaman adab islami sejak dini.',
            'features'    => "Bermain & bernyanyi Islami\nKartu huruf sensorik\nGuru ramah & penyabar",
            'img'         => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=700&q=80',
        ],
        [
            'title'       => "I Can Read Qur'an Kids",
            'category'    => 'kids',
            'age'         => 'Usia 6 ~ 12 Tahun',
            'badge_color' => 'bg-teal-100 text-teal-800',
            'content'     => "Bimbingan membaca Al-Qur'an dari dasar hingga mahir dengan metode Nuraniah praktis dan makharijul huruf yang fasih.",
            'features'    => "Metode Nuraniah berjenjang\nTajwid & irama tartil\nEvaluasi buku mutaba'ah",
            'img'         => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=700&q=80',
        ],
        [
            'title'       => "Tahfidz Juz 'Amma Mutqin",
            'category'    => 'kids',
            'age'         => 'Usia 7 ~ 15 Tahun',
            'badge_color' => 'bg-amber-100 text-amber-800',
            'content'     => "Program bimbingan hafalan Al-Qur'an Juz 30 dengan metode talaqqi dan muraja'ah terstruktur agar hafalan kuat dan tartil.",
            'features'    => "Talaqqi 1-on-1 dengan Ustadz\nTarget hafalan terukur\nSertifikat kelulusan juz",
            'img'         => 'https://images.unsplash.com/photo-1609599006353-e629aaabfeae?auto=format&fit=crop&w=700&q=80',
        ],
        [
            'title'       => 'Tahsin & Tajwid Dewasa',
            'category'    => 'teen-adult',
            'age'         => 'Remaja & Dewasa',
            'badge_color' => 'bg-cyan-100 text-cyan-800',
            'content'     => "Kelas perbaikan bacaan Al-Qur'an dari nol untuk dewasa. Suasana santai, privat, menjaga privasi tanpa perlu merasa canggung.",
            'features'    => "Jadwal fleksibel seusai kerja\nPrivat 1 pengajar 1 murid\nFokus kelancaran & tajwid",
            'img'         => 'https://images.unsplash.com/photo-1584281722573-f925c48b2611?auto=format&fit=crop&w=700&q=80',
        ],
        [
            'title'       => 'Bahasa Arab & Tadabbur',
            'category'    => 'teen-adult',
            'age'         => 'Remaja s/d Dewasa',
            'badge_color' => 'bg-indigo-100 text-indigo-800',
            'content'     => "Memahami kosa kata Al-Qur'an dan bacaan sholat sehari-hari agar ibadah semakin khusyuk dan bermakna.",
            'features'    => "Kosakata pilihan Al-Qur'an\nKaidah dasar mudah dipahami\nModul ringkas aplikatif",
            'img'         => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=700&q=80',
        ],
        [
            'title'       => 'Privat Guru Datang ke Rumah',
            'category'    => 'intensive',
            'age'         => 'Semua Usia',
            'badge_color' => 'bg-rose-100 text-rose-800',
            'content'     => 'Layanan guru ngaji pilihan datang langsung ke rumah Anda. Belajar lebih fokus, nyaman, dan aman di lingkungan keluarga.',
            'features'    => "Guru tersertifikasi & terverifikasi\nWaktu ditentukan keluarga\nLaporan perkembangan berkala",
            'img'         => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=700&q=80',
        ],
    ];

    foreach ( $default_programs as $order => $prog ) {
        $post_id = wp_insert_post([
            'post_title'   => $prog['title'],
            'post_content' => $prog['content'],
            'post_status'  => 'publish',
            'post_type'    => 'learnquran_program',
            'menu_order'   => $order + 1,
        ]);

        if ( ! is_wp_error( $post_id ) ) {
            update_post_meta( $post_id, '_learnquran_program_age', $prog['age'] );
            update_post_meta( $post_id, '_learnquran_program_badge_color', $prog['badge_color'] );
            update_post_meta( $post_id, '_learnquran_program_features', $prog['features'] );
            update_post_meta( $post_id, '_learnquran_program_img_fallback', $prog['img'] );

            if ( ! empty( $term_ids[$prog['category']] ) ) {
                wp_set_post_terms( $post_id, [ (int) $term_ids[$prog['category']] ], 'learnquran_program_category' );
            }
        }
    }
}
if ( did_action( 'init' ) ) {
    learnquran_seed_default_programs();
} else {
    add_action( 'init', 'learnquran_seed_default_programs', 30 );
}

/* Register REST API Fields For learnquran_program */
function learnquran_register_program_rest_fields() {
    register_rest_field( 'learnquran_program', 'program_details', [
        'get_callback' => function( $post ) {
            $post_id = $post['id'];
            $features_raw = get_post_meta( $post_id, '_learnquran_program_features', true );
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
            $cats = wp_get_post_terms( $post_id, 'learnquran_program_category' );
            $cat_name = ! empty( $cats ) && ! is_wp_error( $cats ) ? html_entity_decode( wp_specialchars_decode( $cats[0]->name, ENT_QUOTES ), ENT_QUOTES, 'UTF-8' ) : '';

            $thumb = get_the_post_thumbnail_url( $post_id, 'large' );
            if ( ! $thumb ) {
                $thumb = get_post_meta( $post_id, '_learnquran_program_img_fallback', true );
            }

            return [
                'age'         => get_post_meta( $post_id, '_learnquran_program_age', true ) ?: 'Semua Usia',
                'badge_color' => get_post_meta( $post_id, '_learnquran_program_badge_color', true ) ?: 'bg-teal-100 text-teal-800',
                'features'    => $features,
                'category'    => $cat_name,
                'image_url'   => $thumb ?: '',
            ];
        },
        'schema' => null,
    ] );
}
add_action( 'rest_api_init', 'learnquran_register_program_rest_fields' );
