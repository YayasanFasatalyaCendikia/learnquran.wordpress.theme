<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

/* Return All Theme Customization Options With Sensible Defaults */
function learnquran_get_theme_options() {
    return [
        'privacy' => [
            'privacy_policy_url'   => learnquran_get_privacy_policy_url(),
            'terms_conditions_url' => get_theme_mod( 'learnquran_terms_conditions_url', '/termsconditions' ),
        ],
        'footer' => [
            'bio_desc' => get_theme_mod( 'learnquran_footer_desc', "Platform pembelajaran Al-Qur'an modern dan interaktif untuk anak~anak, remaja, hingga dewasa dengan metode teruji dan guru tersertifikasi." ),
        ],
        'contact' => [
            'whatsapp'    => get_theme_mod( 'learnquran_whatsapp', '628111032458' ),
            'email'       => get_theme_mod( 'learnquran_email', 'info@nuraniahlearningcenter.com' ),
            'address'     => get_theme_mod( 'learnquran_address', 'Indonesia (Layanan Guru ke Rumah & Online Seluruh Kota)' ),
            'instagram'   => get_theme_mod( 'learnquran_instagram', 'https://instagram.com' ),
            'youtube'     => get_theme_mod( 'learnquran_youtube', 'https://youtube.com' ),
            'tiktok'      => get_theme_mod( 'learnquran_tiktok', 'https://tiktok.com' ),
            'footer_desc' => get_theme_mod( 'learnquran_footer_desc', "Platform pembelajaran Al-Qur'an modern dan interaktif untuk anak~anak, remaja, hingga dewasa dengan metode teruji dan guru tersertifikasi." ),
        ],
        'hero' => [
            'badge'         => get_theme_mod( 'learnquran_hero_badge', "Bimbingan Belajar Al-Qur'an Ramah Anak & Dewasa" ),
            'arabic'        => get_theme_mod( 'learnquran_hero_arabic', 'خَيْرُكُمْ مَنْ تَعَلَّمَ الْقُرْآنَ وَعَلَّمَهُ' ),
            'title'         => get_theme_mod( 'learnquran_hero_title', "Mengenalkan Al-Qur'an Lebih Dekat Bersama Guru Privat Terbaik" ),
            'subtitle'      => get_theme_mod( 'learnquran_hero_subtitle', "Assalamu’alaikum, Ayah & Bunda. Nuraniah Learning Center menghadirkan guru ngaji privat ke rumah dan online yang ramah, profesional, serta tersertifikasi dengan Metode Nuraniah yang menyenangkan untuk anak~anak hingga dewasa." ),
            'btn_primary'   => get_theme_mod( 'learnquran_hero_btn_primary', 'Daftar Trial Class' ),
            'btn_secondary' => get_theme_mod( 'learnquran_hero_btn_secondary', 'Lihat Pilihan Program' ),
            'rating'        => get_theme_mod( 'learnquran_hero_rating', '4.9/5 dari 1.500+ Santri & Wali Terdaftar' ),
            'image'         => get_theme_mod( 'learnquran_hero_image_one', get_theme_mod( 'learnquran_hero_image', 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=900&q=80' ) ),
            'image_one'     => get_theme_mod( 'learnquran_hero_image_one', get_theme_mod( 'learnquran_hero_image', 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=900&q=80' ) ),
            'image_2'       => get_theme_mod( 'learnquran_hero_image_two', get_theme_mod( 'learnquran_hero_image_2', 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=900&q=80' ) ),
            'image_two'     => get_theme_mod( 'learnquran_hero_image_two', get_theme_mod( 'learnquran_hero_image_2', 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=900&q=80' ) ),
            'image_3'       => get_theme_mod( 'learnquran_hero_image_three', get_theme_mod( 'learnquran_hero_image_3', 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=900&q=80' ) ),
            'image_three'   => get_theme_mod( 'learnquran_hero_image_three', get_theme_mod( 'learnquran_hero_image_3', 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=900&q=80' ) ),
            'badge1_icon'   => get_theme_mod( 'learnquran_hero_badge1_icon', 'Check' ),
            'badge1_label'  => get_theme_mod( 'learnquran_hero_badge1_label', 'Asatidz Pilihan' ),
            'badge1_title'  => get_theme_mod( 'learnquran_hero_badge1_title', 'Tersertifikasi Sanad' ),
            'badge2_icon'   => get_theme_mod( 'learnquran_hero_badge2_icon', 'BookOpen' ),
            'badge2_label'  => get_theme_mod( 'learnquran_hero_badge2_label', 'Metode Efektif' ),
            'badge2_title'  => get_theme_mod( 'learnquran_hero_badge2_title', 'Mudah & Menyenangkan' ),
        ],
        'stats' => [
            'stat1_number' => get_theme_mod( 'learnquran_stat1_number', '1.500+' ),
            'stat1_label'  => get_theme_mod( 'learnquran_stat1_label', 'Sholeh & Sholehah Students' ),
            'stat2_number' => get_theme_mod( 'learnquran_stat2_number', '8+ Tahun' ),
            'stat2_label'  => get_theme_mod( 'learnquran_stat2_label', "Berdedikasi Mengajar Al-Qur'an" ),
            'stat3_number' => get_theme_mod( 'learnquran_stat3_number', '120+' ),
            'stat3_label'  => get_theme_mod( 'learnquran_stat3_label', 'Guru Ngaji Tersertifikasi' ),
            'stat4_number' => get_theme_mod( 'learnquran_stat4_number', '100%' ),
            'stat4_label'  => get_theme_mod( 'learnquran_stat4_label', 'Kurikulum Loving Quran' ),
        ],
        'features' => [
            'badge'       => get_theme_mod( 'learnquran_feat_badge', 'Why Choose Us' ),
            'title'       => get_theme_mod( 'learnquran_feat_title', 'Keunggulan Nuraniah Learning Center' ),
            'subtitle'    => get_theme_mod( 'learnquran_feat_desc', "Komitmen kami menghadirkan pengalaman belajar membaca Al-Qur'an yang berkesan, ramah anak, dan terukur perkembangannya." ),
            'feat1_icon'  => get_theme_mod( 'learnquran_feat1_icon', 'GraduationCap' ),
            'feat1_title' => get_theme_mod( 'learnquran_feat1_title', 'Guru Tersertifikasi' ),
            'feat1_desc'  => get_theme_mod( 'learnquran_feat1_desc', 'Pengajar telah melalui seleksi hafalan, penguasaan tajwid standar, dan pelatihan pedagogi anak.' ),
            'feat2_icon'  => get_theme_mod( 'learnquran_feat2_icon', 'TrendingUp' ),
            'feat2_title' => get_theme_mod( 'learnquran_feat2_title', 'Laporan Berkala' ),
            'feat2_desc'  => get_theme_mod( 'learnquran_feat2_desc', "Orang tua santri menerima laporan capaian materi dan mutaba'ah setiap bulan secara transparan." ),
            'feat3_icon'  => get_theme_mod( 'learnquran_feat3_icon', 'Sparkles' ),
            'feat3_title' => get_theme_mod( 'learnquran_feat3_title', 'Kurikulum Menyenangkan' ),
            'feat3_desc'  => get_theme_mod( 'learnquran_feat3_desc', 'Memadukan tajwid, akhlak, dan kisah nabi dengan metode interaktif agar ananda tidak cepat bosan.' ),
            'feat4_icon'  => get_theme_mod( 'learnquran_feat4_icon', 'Home' ),
            'feat4_title' => get_theme_mod( 'learnquran_feat4_title', 'Fleksibel Rumah / Online' ),
            'feat4_desc'  => get_theme_mod( 'learnquran_feat4_desc', 'Bebas menentukan jadwal dan lokasi belajar, baik guru datang ke rumah maupun tatap muka online privat.' ),
        ],
        'programs' => [
            'badge'         => get_theme_mod( 'learnquran_programs_badge', 'Our Programs' ),
            'title'         => get_theme_mod( 'learnquran_programs_title', 'Pilih Program Les Ngaji Sesuai Kebutuhan' ),
            'subtitle'      => get_theme_mod( 'learnquran_programs_desc', 'Pilihan bimbingan intensif bersama guru privat untuk balita, anak~anak, remaja, hingga dewasa.' ),
            'categories'    => array_values( array_filter( array_map( 'trim', explode( ',', (string) get_theme_mod( 'learnquran_programs_categories', '' ) ) ) ) ),
            'max_items'     => (int) get_theme_mod( 'learnquran_programs_max_items', 6 ),
            'view_all_text' => get_theme_mod( 'learnquran_programs_btn_text', 'Lihat Semua Program' ),
            'archive_title' => get_theme_mod( 'learnquran_programs_archive_title', "Semua Program Belajar Al-Qur'an" ),
            'archive_desc'  => get_theme_mod( 'learnquran_programs_archive_desc', "Pilihan program bimbingan intensif membaca Al-Qur'an dengan metode terstruktur untuk balita, anak-anak, remaja, hingga dewasa bersama guru privat profesional." ),
        ],
        'bestseller' => [
            'badge'         => get_theme_mod( 'learnquran_bs_badge', 'Best Seller Program' ),
            'arabic'        => get_theme_mod( 'learnquran_bs_arabic', 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ' ),
            'title'         => get_theme_mod( 'learnquran_bs_title', "I Can Read Qur'an: Awal Perjalanan Mencintai Al-Qur'an (3+ Tahun)" ),
            'desc'          => get_theme_mod( 'learnquran_bs_desc', "Kami mengubah momen belajar huruf hijaiyah dan membaca Al-Qur'an menjadi petualangan seru yang dinanti-nanti oleh ananda setiap pekan." ),
            'alumni_number' => get_theme_mod( 'learnquran_bs_alumni_count', '300+' ),
            'alumni_label'  => get_theme_mod( 'learnquran_bs_alumni_label', 'Alumni Santri Cilik Bulan Ini' ),
        ],
        'testimonials' => [
            'badge'          => get_theme_mod( 'learnquran_testi_badge', 'Testimonials' ),
            'title'          => get_theme_mod( 'learnquran_testi_title', 'Apa Kata Ayah & Bunda' ),
            'subtitle'       => get_theme_mod( 'learnquran_testi_desc', "Kisah nyata para wali santri yang mempercayakan pembelajaran Al-Qur'an ananda di Nuraniah Learning Center." ),
            'max_items'      => (int) get_theme_mod( 'learnquran_testimonials_max_items', 9 ),
            'autoplay'       => (bool) get_theme_mod( 'learnquran_testimonials_autoplay', true ),
            'autoplay_speed' => (int) get_theme_mod( 'learnquran_testimonials_autoplay_speed', 5 ),
        ],
        'blog' => [
            'badge'          => get_theme_mod( 'learnquran_blog_badge', 'Artikel & Edukasi' ),
            'title'          => get_theme_mod( 'learnquran_blog_title', 'Kumpulan Artikel Terkini' ),
            'max_items'      => (int) get_theme_mod( 'learnquran_blog_max_items', 6 ),
            'autoplay'       => (bool) get_theme_mod( 'learnquran_blog_autoplay', true ),
            'autoplay_speed' => (int) get_theme_mod( 'learnquran_blog_autoplay_speed', 5 ),
            /* Blog Archive Page Settings / For Route /blog */
            'page_badge'     => get_theme_mod( 'learnquran_blog_page_badge', 'Artikel & Wawasan' ),
            'page_title'     => get_theme_mod( 'learnquran_blog_page_title', "Blog Edukasi Al-Qur'an" ),
            'page_desc'      => get_theme_mod( 'learnquran_blog_page_desc', "Tips mendidik anak mencintai Al-Qur'an, tajwid praktis, dan kabar seputar Nuraniah Learning Center." ),
            'per_page'       => (int) get_theme_mod( 'learnquran_blog_per_page', 9 ),
        ],
        'cta' => [
            'arabic'   => get_theme_mod( 'learnquran_cta_arabic', 'اقْرَأْ بِاسْمِ رَبِّكَ الَّذِي خَلَقَ' ),
            'title'    => get_theme_mod( 'learnquran_cta_title', "Wujudkan Generasi Cinta Al-Qur'an Bersama Kami" ),
            'subtitle' => get_theme_mod( 'learnquran_cta_subtitle', 'Konsultasikan kebutuhan belajar ananda dan dapatkan jadwal sesi uji coba (trial class) sekarang juga.' ),
            'btn_text' => get_theme_mod( 'learnquran_cta_button_text', 'Hubungi Kami via WhatsApp' ),
        ],
        'program_detail' => [
            'kit_badge'    => get_theme_mod( 'learnquran_kit_badge', 'Fasilitas Eksklusif' ),
            'kit_title'    => get_theme_mod( 'learnquran_kit_title', "Student's Learning Kit" ),
            'kit_desc'     => get_theme_mod( 'learnquran_kit_desc', "Setiap santri yang mendaftar akan memperoleh paket modul cetak metode Nuraniah, flashcard sensorik huruf hijaiyah, dan buku panduan mutaba'ah harian." ),
            'kit_items'    => array_values( array_filter( array_map( 'trim', explode( "\n", get_theme_mod( 'learnquran_kit_items', "Modul Nuraniah\nFlashcard Sensorik\nBuku Mutaba'ah" ) ) ) ) ),
            'banner_title' => get_theme_mod( 'learnquran_banner_curriculum_title', 'Cari Tahu Apa Itu Metode Nuraniah' ),
            'banner_desc'  => get_theme_mod( 'learnquran_banner_curriculum_desc', 'Konsultasikan kebutuhan belajar ananda dan diskusikan kurikulum terbaik dengan konsultan kami.' ),
            'banner_btn'   => get_theme_mod( 'learnquran_banner_curriculum_btn', 'Konsultasi Gratis' ),
            'mentor_points' => array_values( array_filter( array_map( 'trim', explode( "\n", get_theme_mod( 'learnquran_mentor_quality_points', "Hafalan terjaga dan menguasai kaidah tajwid\nTerlatih menangani berbagai mood anak\nLatar belakang pendidikan Islam & Ma'had terpercaya\nTepat waktu, sopan, dan menjaga privasi keluarga" ) ) ) ) ),
            'consult_icon'  => get_theme_mod( 'learnquran_consult_icon', 'MessageCircle' ),
            'consult_title' => get_theme_mod( 'learnquran_consult_title', 'Butuh Rekomendasi Program?' ),
            'consult_desc'  => get_theme_mod( 'learnquran_consult_desc', "Konsultasikan usia dan kemampuan membaca Al-Qur'an ananda bersama tim akademik kami." ),
            'consult_btn'   => get_theme_mod( 'learnquran_consult_btn', 'Chat Konsultan Akademik →' ),
            'consult_wa_msg'=> get_theme_mod( 'learnquran_consult_wa_msg', 'Halo Admin LearnQuran, saya ingin konsultasi memilih program yang cocok' ),
            'mentor_badge'  => get_theme_mod( 'learnquran_mentor_badge', 'Tenaga Pengajar' ),
            'mentor_title'  => get_theme_mod( 'learnquran_mentor_title', 'Profile Guru / Quran Mentor' ),
            'mentor_tag'    => get_theme_mod( 'learnquran_mentor_tag', 'Tersertifikasi' ),
            'mentor_desc'   => get_theme_mod( 'learnquran_mentor_desc', 'Didampingi oleh asatidz dan asatidzah berkarakter lembut, bersanad, dan berpengalaman pedagogi anak:' ),
            /* Additional Dynamic Strings */
            'bc_home'          => get_theme_mod( 'learnquran_pd_bc_home', 'Home' ),
            'bc_program'       => get_theme_mod( 'learnquran_pd_bc_program', 'Program' ),
            'curriculum_badge' => get_theme_mod( 'learnquran_pd_curriculum_badge', 'Kurikulum Nuraniah' ),
            'pol_badge'        => get_theme_mod( 'learnquran_pd_pol_badge', 'Keterampilan & Nilai' ),
            'pol_title'        => get_theme_mod( 'learnquran_pd_pol_title', 'Points of Learning' ),
            'pol_desc'         => get_theme_mod( 'learnquran_pd_pol_desc', 'Setiap sesi dirancang untuk menstimulasi pemahaman ananda secara menyenangkan melalui aktivitas interaktif:' ),
            'about_badge'      => get_theme_mod( 'learnquran_pd_about_badge', 'Metode Pembelajaran' ),
            'about_title'      => get_theme_mod( 'learnquran_pd_about_title', 'Tentang Program Ini' ),
            'specs_badge'      => get_theme_mod( 'learnquran_pd_specs_badge', 'Parameter Kelas' ),
            'specs_title'      => get_theme_mod( 'learnquran_pd_specs_title', 'Spesifikasi & Target Program' ),
            'kit_included_tag' => get_theme_mod( 'learnquran_pd_kit_included', 'Exclusive Kit Included' ),
            'testi_badge'      => get_theme_mod( 'learnquran_pd_testi_badge', 'Kisah Wali Santri' ),
            'testi_title'      => get_theme_mod( 'learnquran_pd_testi_title', 'What Parents Say About' ),
            'related_badge'    => get_theme_mod( 'learnquran_pd_related_badge', 'Pilihan Lainnya' ),
            'related_title'    => get_theme_mod( 'learnquran_pd_related_title', 'More Program in All Ages' ),
            'price_from_label' => get_theme_mod( 'learnquran_pd_price_from', 'Mulai dari' ),
            'select_pkg_btn'   => get_theme_mod( 'learnquran_pd_select_pkg', 'Pilih Paket' ),
            'pricing_label'    => get_theme_mod( 'learnquran_pd_pricing_label', 'Investasi Belajar:' ),
            'pricing_unit'     => get_theme_mod( 'learnquran_pd_pricing_unit', '/ bulan' ),
            'pricing_desc'     => get_theme_mod( 'learnquran_pd_pricing_desc', 'Paket privat personal sesuai jadwal keluarga.' ),
            'pricing_points'   => array_values( array_filter( array_map( 'trim', explode( "\n", get_theme_mod( 'learnquran_pd_pricing_points', "Sesi Evaluasi & Placement Test kemampuan awal ananda\nJadwal Fleksibel bebas pilih guru datang ke rumah / online\nTermasuk Modul Eksklusif & kartu mutaba'ah harian\nLaporan Evaluasi Bulanan capaian tajwid dan hafalan" ) ) ) ) ),
            'cta_btn_text'     => get_theme_mod( 'learnquran_pd_cta_btn', 'Hubungi Kami' ),
            'more_btn_text'    => get_theme_mod( 'learnquran_pd_more_btn', 'Lihat Pilihan Program Lainnya' ),
            'trust_rating'     => get_theme_mod( 'learnquran_pd_trust_rating', 'Rating 4.9/5 dari 1.500+ Santri' ),
            'trust_guarantee'  => get_theme_mod( 'learnquran_pd_trust_guarantee', 'Garansi kecocokan guru privat & fleksibilitas jadwal.' ),
            'show_pol'          => get_theme_mod( 'learnquran_pd_show_pol', true ),
            'show_about'        => get_theme_mod( 'learnquran_pd_show_about', true ),
            'show_mentors'      => get_theme_mod( 'learnquran_pd_show_mentors', true ),
            'show_specs'        => get_theme_mod( 'learnquran_pd_show_specs', true ),
            'show_kit'          => get_theme_mod( 'learnquran_pd_show_kit', true ),
            'show_banner'       => get_theme_mod( 'learnquran_pd_show_banner', true ),
            'show_testimonials' => get_theme_mod( 'learnquran_pd_show_testimonials', true ),
            'show_related'      => get_theme_mod( 'learnquran_pd_show_related', true ),
            'show_pricing'      => get_theme_mod( 'learnquran_pd_show_pricing', true ),
            'show_consult'      => get_theme_mod( 'learnquran_pd_show_consult', true ),
        ],
    ];
}

/* Sanitize Callback For Multi-Select Values (Array Or Comma-Separated String) */
function learnquran_sanitize_multi_select( $input ) {
    if ( is_array( $input ) ) {
        return implode( ',', array_map( 'sanitize_text_field', $input ) );
    }
    return sanitize_text_field( (string) $input );
}

/* Custom Multi-Select Checkboxes Control For WordPress Customizer */
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'LearnQuran_Customize_Multi_Select_Control' ) ) {
    class LearnQuran_Customize_Multi_Select_Control extends WP_Customize_Control {
        public $type = 'learnquran_multi_select';

        public function render_content() {
            if ( empty( $this->choices ) ) {
                return;
            }

            $raw_val = $this->value();
            $values  = is_array( $raw_val ) ? $raw_val : array_filter( array_map( 'trim', explode( ',', (string) $raw_val ) ) );
            ?>
            <div class="learnquran-multi-select-control">
                <?php if ( ! empty( $this->label ) ) : ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $this->description ) ) : ?>
                    <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <?php endif; ?>

                <div class="learnquran-checkbox-container" style="margin-top: 8px; max-height: 170px; overflow-y: auto; padding: 8px 10px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px;">
                    <?php foreach ( $this->choices as $key => $label ) : 
                        $is_checked = in_array( (string) $key, $values, true );
                    ?>
                        <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px; cursor: pointer; font-size: 13px; font-weight: 500; color: #1e293b;">
                            <input 
                                type="checkbox" 
                                class="learnquran-multi-check-item" 
                                value="<?php echo esc_attr( $key ); ?>" 
                                <?php checked( $is_checked, true ); ?> 
                                style="margin: 0; cursor: pointer; border-radius: 4px;"
                            />
                            <span><?php echo esc_html( $label ); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( is_array( $raw_val ) ? implode( ',', $raw_val ) : $raw_val ); ?>" class="learnquran-multi-hidden-input" />

                <div style="display: flex; justify-content: space-between; margin-top: 6px; font-size: 11px;">
                    <button type="button" class="button-link learnquran-select-all" style="color: #1f4c8f; text-decoration: underline; cursor: pointer;">
                        <?php _e( 'Pilih Semua', 'learnquran' ); ?>
                    </button>
                    <button type="button" class="button-link learnquran-clear-all" style="color: #64748b; text-decoration: underline; cursor: pointer;">
                        <?php _e( 'Hapus Pilihan / Tampilkan Semua', 'learnquran' ); ?>
                    </button>
                </div>
            </div>

            <script type="text/javascript">
            if (typeof window.learnquranMultiSelectInit === 'undefined') {
                window.learnquranMultiSelectInit = true;
                jQuery(document).on('change', '.learnquran-multi-check-item', function() {
                    var $wrap = jQuery(this).closest('.learnquran-multi-select-control');
                    var vals = [];
                    $wrap.find('.learnquran-multi-check-item:checked').each(function() {
                        vals.push(jQuery(this).val());
                    });
                    $wrap.find('.learnquran-multi-hidden-input').val(vals.join(',')).trigger('change');
                });
                jQuery(document).on('click', '.learnquran-select-all', function(e) {
                    e.preventDefault();
                    var $wrap = jQuery(this).closest('.learnquran-multi-select-control');
                    $wrap.find('.learnquran-multi-check-item').prop('checked', true);
                    var vals = [];
                    $wrap.find('.learnquran-multi-check-item').each(function() { vals.push(jQuery(this).val()); });
                    $wrap.find('.learnquran-multi-hidden-input').val(vals.join(',')).trigger('change');
                });
                jQuery(document).on('click', '.learnquran-clear-all', function(e) {
                    e.preventDefault();
                    var $wrap = jQuery(this).closest('.learnquran-multi-select-control');
                    $wrap.find('.learnquran-multi-check-item').prop('checked', false);
                    $wrap.find('.learnquran-multi-hidden-input').val('').trigger('change');
                });
            }
            </script>
            <?php
        }
    }
}

/* Register LearnQuran Theme Settings In WordPress Customizer */
function learnquran_customize_register( $wp_customize ) {

    /* Add Main Customizer Panel For LearnQuran Theme */
    $wp_customize->add_panel( 'learnquran_theme_panel', [
        'title'       => __( 'Pengaturan Theme', 'learnquran' ),
        'description' => __( 'Kustomisasi konten landing page, hero, kontak, dan statistik Nuraniah Learning Center.', 'learnquran' ),
        'priority'    => 20,
    ] );

    /* Section 1: Contact And WhatsApp */
    $wp_customize->add_section( 'learnquran_contact_section', [
        'title'    => __( 'Kontak & Media Sosial', 'learnquran' ),
        'panel'    => 'learnquran_theme_panel',
        'priority' => 10,
    ] );

    /* WhatsApp Contact */
    $wp_customize->add_setting( 'learnquran_whatsapp', [
        'default'           => '628111032458',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_whatsapp', [
        'label'       => __( 'Nomor WhatsApp, Format: 6282266331136', 'learnquran' ),
        'description' => __( 'Digunakan untuk semua tombol konsultasi & pendaftaran.', 'learnquran' ),
        'section'     => 'learnquran_contact_section',
        'type'        => 'text',
    ] );

    /* Email Address */
    $wp_customize->add_setting( 'learnquran_email', [
        'default'           => 'info@nuraniahlearningcenter.com',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_email', [
        'label'   => __( 'Email Kontak', 'learnquran' ),
        'section' => 'learnquran_contact_section',
        'type'    => 'email',
    ] );

    /* Physical Address */
    $wp_customize->add_setting( 'learnquran_address', [
        'default'           => 'Indonesia (Layanan Guru ke Rumah & Online Seluruh Kota)',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_address', [
        'label'   => __( 'Alamat / Area Layanan', 'learnquran' ),
        'section' => 'learnquran_contact_section',
        'type'    => 'text',
    ] );

    /* Instagram Profile URL */
    $wp_customize->add_setting( 'learnquran_instagram', [
        'default'           => 'https://instagram.com',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_instagram', [
        'label'   => __( 'URL Instagram', 'learnquran' ),
        'section' => 'learnquran_contact_section',
        'type'    => 'url',
    ] );

    /* YouTube Channel URL */
    $wp_customize->add_setting( 'learnquran_youtube', [
        'default'           => 'https://youtube.com',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_youtube', [
        'label'   => __( 'URL YouTube', 'learnquran' ),
        'section' => 'learnquran_contact_section',
        'type'    => 'url',
    ] );

    /* TikTok Profile URL */
    $wp_customize->add_setting( 'learnquran_tiktok', [
        'default'           => 'https://tiktok.com',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_tiktok', [
        'label'   => __( 'URL TikTok', 'learnquran' ),
        'section' => 'learnquran_contact_section',
        'type'    => 'url',
    ] );


    /* Section 2: Hero Banner */
    $wp_customize->add_section( 'learnquran_hero_section', [
        'title'    => __( 'Bagian Hero ~ Banner Utama', 'learnquran' ),
        'panel'    => 'learnquran_theme_panel',
        'priority' => 20,
    ] );

    /* Hero Badge Text */
    $wp_customize->add_setting( 'learnquran_hero_badge', [
        'default'           => "Bimbingan Belajar Al~Qur'an Ramah Anak & Dewasa",
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_hero_badge', [
        'label'   => __( 'Badge Kecil Hero', 'learnquran' ),
        'section' => 'learnquran_hero_section',
        'type'    => 'text',
    ] );

    /* Hero Arabic Hadith */
    $wp_customize->add_setting( 'learnquran_hero_arabic', [
        'default'           => 'خَيْرُكُمْ مَنْ تَعَلَّمَ الْقُرْآنَ وَعَلَّمَهُ',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_hero_arabic', [
        'label'   => __( 'Teks Hadits / Arab Hero', 'learnquran' ),
        'section' => 'learnquran_hero_section',
        'type'    => 'text',
    ] );

    /* Hero Main Title */
    $wp_customize->add_setting( 'learnquran_hero_title', [
        'default'           => "Mengenalkan Al-Qur'an Lebih Dekat Bersama Guru Privat Terbaik",
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_hero_title', [
        'label'   => __( 'Judul Utama / Headline', 'learnquran' ),
        'section' => 'learnquran_hero_section',
        'type'    => 'text',
    ] );

    /* Hero Subtitle Description */
    $wp_customize->add_setting( 'learnquran_hero_subtitle', [
        'default'           => "Assalamu’alaikum, Ayah & Bunda. Nuraniah Learning Center menghadirkan guru ngaji privat ke rumah dan online yang ramah, profesional, serta tersertifikasi dengan Metode Nuraniah yang menyenangkan untuk anak~anak hingga dewasa.",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_hero_subtitle', [
        'label'   => __( 'Deskripsi Singkat Hero', 'learnquran' ),
        'section' => 'learnquran_hero_section',
        'type'    => 'textarea',
    ] );

    /* Hero Primary CTA Button */
    $wp_customize->add_setting( 'learnquran_hero_btn_primary', [
        'default'           => 'Daftar Trial Class',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_hero_btn_primary', [
        'label'   => __( 'Teks Tombol Utama', 'learnquran' ),
        'section' => 'learnquran_hero_section',
        'type'    => 'text',
    ] );

    /* Hero Secondary CTA Button */
    $wp_customize->add_setting( 'learnquran_hero_btn_secondary', [
        'default'           => 'Lihat Pilihan Program',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_hero_btn_secondary', [
        'label'   => __( 'Teks Tombol Kedua', 'learnquran' ),
        'section' => 'learnquran_hero_section',
        'type'    => 'text',
    ] );

    /* Hero Rating Text */
    $wp_customize->add_setting( 'learnquran_hero_rating', [
        'default'           => '4.9/5 dari 1.500+ Santri & Wali Terdaftar',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_hero_rating', [
        'label'   => __( 'Teks Rating & Santri', 'learnquran' ),
        'section' => 'learnquran_hero_section',
        'type'    => 'text',
    ] );

    /* Hero Featured Image One */
    $wp_customize->add_setting( 'learnquran_hero_image_one', [
        'default'           => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=900&q=80',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'learnquran_hero_image_one', [
        'label'       => __( 'Gambar Hero Utama / Tumpukan Satu', 'learnquran' ),
        'description' => __( 'Upload foto kegiatan belajar layer Satu.', 'learnquran' ),
        'section'     => 'learnquran_hero_section',
    ] ) );

    /* Hero Featured Image Two */
    $wp_customize->add_setting( 'learnquran_hero_image_two', [
        'default'           => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=900&q=80',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'learnquran_hero_image_two', [
        'label'       => __( 'Gambar Hero Dua / Tumpukan Dua', 'learnquran' ),
        'description' => __( 'Upload foto kegiatan belajar layer Dua.', 'learnquran' ),
        'section'     => 'learnquran_hero_section',
    ] ) );

    /* Hero Featured Image Three */
    $wp_customize->add_setting( 'learnquran_hero_image_three', [
        'default'           => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=900&q=80',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'learnquran_hero_image_three', [
        'label'       => __( 'Gambar Hero Tiga / Tumpukan Tiga', 'learnquran' ),
        'description' => __( 'Upload foto kegiatan belajar layer Tiga.', 'learnquran' ),
        'section'     => 'learnquran_hero_section',
    ] ) );

    /* Hero Floating Badge 1: Subtitle / Label */
    $wp_customize->add_setting( 'learnquran_hero_badge1_label', [
        'default'           => 'Asatidz Pilihan',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_hero_badge1_label', [
        'label'   => __( 'Badge Melayang Satu ~ Label Kecil', 'learnquran' ),
        'section' => 'learnquran_hero_section',
        'type'    => 'text',
    ] );

    /* Hero Floating Badge 1: Main Title */
    $wp_customize->add_setting( 'learnquran_hero_badge1_title', [
        'default'           => 'Tersertifikasi Sanad',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_hero_badge1_title', [
        'label'   => __( 'Badge Melayang Satu ~ Judul Utama', 'learnquran' ),
        'section' => 'learnquran_hero_section',
        'type'    => 'text',
    ] );

    /* Hero Floating Badge 2: Subtitle / Label */
    $wp_customize->add_setting( 'learnquran_hero_badge2_label', [
        'default'           => 'Metode Efektif',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_hero_badge2_label', [
        'label'   => __( 'Badge Melayang Dua ~ Label Kecil', 'learnquran' ),
        'section' => 'learnquran_hero_section',
        'type'    => 'text',
    ] );

    /* Hero Floating Badge 2: Main Title */
    $wp_customize->add_setting( 'learnquran_hero_badge2_title', [
        'default'           => 'Mudah & Menyenangkan',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_hero_badge2_title', [
        'label'   => __( 'Badge Melayang Dua ~ Judul Utama', 'learnquran' ),
        'section' => 'learnquran_hero_section',
        'type'    => 'text',
    ] );


    /* Section 3: Statistics And Counter */
    $wp_customize->add_section( 'learnquran_stats_section', [
        'title'    => __( 'Statistik & Counter', 'learnquran' ),
        'panel'    => 'learnquran_theme_panel',
        'priority' => 30,
    ] );

    /* Metric Stat 1 */
    $wp_customize->add_setting( 'learnquran_stat1_number', [ 'default' => '1.500+', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_stat1_number', [ 'label' => __( 'Stat Satu: Angka', 'learnquran' ), 'section' => 'learnquran_stats_section', 'type' => 'text' ] );
    $wp_customize->add_setting( 'learnquran_stat1_label', [ 'default' => 'Sholeh & Sholehah Students', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_stat1_label', [ 'label' => __( 'Stat Satu: Label', 'learnquran' ), 'section' => 'learnquran_stats_section', 'type' => 'text' ] );

    /* Metric Stat 2 */
    $wp_customize->add_setting( 'learnquran_stat2_number', [ 'default' => '8+ Tahun', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_stat2_number', [ 'label' => __( 'Stat Dua: Angka', 'learnquran' ), 'section' => 'learnquran_stats_section', 'type' => 'text' ] );
    $wp_customize->add_setting( 'learnquran_stat2_label', [ 'default' => "Berdedikasi Mengajar Al-Qur'an", 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_stat2_label', [ 'label' => __( 'Stat Dua: Label', 'learnquran' ), 'section' => 'learnquran_stats_section', 'type' => 'text' ] );

    /* Metric Stat 3 */
    $wp_customize->add_setting( 'learnquran_stat3_number', [ 'default' => '120+', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_stat3_number', [ 'label' => __( 'Stat Tiga: Angka', 'learnquran' ), 'section' => 'learnquran_stats_section', 'type' => 'text' ] );
    $wp_customize->add_setting( 'learnquran_stat3_label', [ 'default' => 'Guru Ngaji Tersertifikasi', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_stat3_label', [ 'label' => __( 'Stat Tiga: Label', 'learnquran' ), 'section' => 'learnquran_stats_section', 'type' => 'text' ] );

    /* Metric Stat 4 */
    $wp_customize->add_setting( 'learnquran_stat4_number', [ 'default' => '100%', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_stat4_number', [ 'label' => __( 'Stat Empat: Angka', 'learnquran' ), 'section' => 'learnquran_stats_section', 'type' => 'text' ] );
    $wp_customize->add_setting( 'learnquran_stat4_label', [ 'default' => 'Kurikulum Loving Quran', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_stat4_label', [ 'label' => __( 'Stat Empat: Label', 'learnquran' ), 'section' => 'learnquran_stats_section', 'type' => 'text' ] );


    /* Section 4: Why Choose Us / Features */
    $wp_customize->add_section( 'learnquran_features_section', [
        'title'       => __( 'Keunggulan ~ Why Choose Us', 'learnquran' ),
        'description' => __( 'Kustomisasi judul pengantar dan 4 kartu keunggulan Nuraniah Learning Center.', 'learnquran' ),
        'panel'       => 'learnquran_theme_panel',
        'priority'    => 32,
    ] );

    /* Features Badge */
    $wp_customize->add_setting( 'learnquran_feat_badge', [ 'default' => 'Why Choose Us', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_feat_badge', [ 'label' => __( 'Badge / Label Atas', 'learnquran' ), 'section' => 'learnquran_features_section', 'type' => 'text' ] );

    /* Features Title */
    $wp_customize->add_setting( 'learnquran_feat_title', [ 'default' => 'Keunggulan Nuraniah Learning Center', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_feat_title', [ 'label' => __( 'Judul Utama', 'learnquran' ), 'section' => 'learnquran_features_section', 'type' => 'text' ] );

    /* Features Description */
    $wp_customize->add_setting( 'learnquran_feat_desc', [ 'default' => "Komitmen kami menghadirkan pengalaman belajar membaca Al-Qur'an yang berkesan, ramah anak, dan terukur perkembangannya.", 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_feat_desc', [ 'label' => __( 'Deskripsi Singkat', 'learnquran' ), 'section' => 'learnquran_features_section', 'type' => 'textarea' ] );

    /* Feature Card 1 */
    $wp_customize->add_setting( 'learnquran_feat1_icon', [ 'default' => 'GraduationCap', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_feat1_icon', [
        'label'       => __( 'Kartu Satu: Ikon Lucide', 'learnquran' ),
        'description' => __( 'Nama ikon Lucide (misal: GraduationCap, Award, BookOpen). <a href="https://lucide.dev/icons/" target="_blank" rel="noopener noreferrer">Buka Galeri Ikon Lucide ↗</a>', 'learnquran' ),
        'section'     => 'learnquran_features_section',
        'type'        => 'text',
    ] );
    $wp_customize->add_setting( 'learnquran_feat1_title', [ 'default' => 'Guru Tersertifikasi', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_feat1_title', [ 'label' => __( 'Kartu Satu: Judul', 'learnquran' ), 'section' => 'learnquran_features_section', 'type' => 'text' ] );
    $wp_customize->add_setting( 'learnquran_feat1_desc', [ 'default' => 'Pengajar telah melalui seleksi hafalan, penguasaan tajwid standar, dan pelatihan pedagogi anak.', 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_feat1_desc', [ 'label' => __( 'Kartu Satu: Deskripsi', 'learnquran' ), 'section' => 'learnquran_features_section', 'type' => 'textarea' ] );

    /* Feature Card 2 */
    $wp_customize->add_setting( 'learnquran_feat2_icon', [ 'default' => 'TrendingUp', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_feat2_icon', [
        'label'       => __( 'Kartu Dua: Ikon Lucide', 'learnquran' ),
        'description' => __( 'Nama ikon Lucide (misal: TrendingUp, BarChart3, LineChart). <a href="https://lucide.dev/icons/" target="_blank" rel="noopener noreferrer">Buka Galeri Ikon Lucide ↗</a>', 'learnquran' ),
        'section'     => 'learnquran_features_section',
        'type'        => 'text',
    ] );
    $wp_customize->add_setting( 'learnquran_feat2_title', [ 'default' => 'Laporan Berkala', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_feat2_title', [ 'label' => __( 'Kartu Dua: Judul', 'learnquran' ), 'section' => 'learnquran_features_section', 'type' => 'text' ] );
    $wp_customize->add_setting( 'learnquran_feat2_desc', [ 'default' => "Orang tua santri menerima laporan capaian materi dan mutaba'ah setiap bulan secara transparan.", 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_feat2_desc', [ 'label' => __( 'Kartu Dua: Deskripsi', 'learnquran' ), 'section' => 'learnquran_features_section', 'type' => 'textarea' ] );

    /* Feature Card 3 */
    $wp_customize->add_setting( 'learnquran_feat3_icon', [ 'default' => 'Sparkles', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_feat3_icon', [
        'label'       => __( 'Kartu Tiga: Ikon Lucide', 'learnquran' ),
        'description' => __( 'Nama ikon Lucide (misal: Sparkles, Puzzle, Smile). <a href="https://lucide.dev/icons/" target="_blank" rel="noopener noreferrer">Buka Galeri Ikon Lucide ↗</a>', 'learnquran' ),
        'section'     => 'learnquran_features_section',
        'type'        => 'text',
    ] );
    $wp_customize->add_setting( 'learnquran_feat3_title', [ 'default' => 'Kurikulum Menyenangkan', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_feat3_title', [ 'label' => __( 'Kartu Tiga: Judul', 'learnquran' ), 'section' => 'learnquran_features_section', 'type' => 'text' ] );
    $wp_customize->add_setting( 'learnquran_feat3_desc', [ 'default' => 'Memadukan tajwid, akhlak, dan kisah nabi dengan metode interaktif agar ananda tidak cepat bosan.', 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_feat3_desc', [ 'label' => __( 'Kartu Tiga: Deskripsi', 'learnquran' ), 'section' => 'learnquran_features_section', 'type' => 'textarea' ] );

    /* Feature Card 4 */
    $wp_customize->add_setting( 'learnquran_feat4_icon', [ 'default' => 'Home', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_feat4_icon', [
        'label'       => __( 'Kartu Empat: Ikon Lucide', 'learnquran' ),
        'description' => __( 'Nama ikon Lucide (misal: Home, Laptop, Video). <a href="https://lucide.dev/icons/" target="_blank" rel="noopener noreferrer">Buka Galeri Ikon Lucide ↗</a>', 'learnquran' ),
        'section'     => 'learnquran_features_section',
        'type'        => 'text',
    ] );
    $wp_customize->add_setting( 'learnquran_feat4_title', [ 'default' => 'Fleksibel Rumah / Online', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_feat4_title', [ 'label' => __( 'Kartu Empat: Judul', 'learnquran' ), 'section' => 'learnquran_features_section', 'type' => 'text' ] );
    $wp_customize->add_setting( 'learnquran_feat4_desc', [ 'default' => 'Bebas menentukan jadwal dan lokasi belajar, baik guru datang ke rumah maupun tatap muka online privat.', 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_feat4_desc', [ 'label' => __( 'Kartu Empat: Deskripsi', 'learnquran' ), 'section' => 'learnquran_features_section', 'type' => 'textarea' ] );


    /* Section 5: Program Courses */
    $wp_customize->add_section( 'learnquran_programs_section', [
        'title'       => __( 'Program Belajar', 'learnquran' ),
        'description' => __( 'Atur teks judul dan pengantar seksi Program Belajar. Untuk menambah atau mengubah kartu paket program, gunakan menu "Program Belajar" di sidebar WordPress.', 'learnquran' ),
        'panel'       => 'learnquran_theme_panel',
        'priority'    => 35,
    ] );

    /* Programs Badge */
    $wp_customize->add_setting( 'learnquran_programs_badge', [
        'default'           => 'Our Programs',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_programs_badge', [
        'label'       => __( 'Badge / Label Atas', 'learnquran' ),
        'description' => __( 'Contoh: Our Programs', 'learnquran' ),
        'section'     => 'learnquran_programs_section',
        'type'        => 'text',
    ] );

    /* Programs Title */
    $wp_customize->add_setting( 'learnquran_programs_title', [
        'default'           => 'Pilih Program Les Ngaji Sesuai Kebutuhan',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_programs_title', [
        'label'   => __( 'Judul Utama', 'learnquran' ),
        'section' => 'learnquran_programs_section',
        'type'    => 'text',
    ] );

    /* Programs Description */
    $wp_customize->add_setting( 'learnquran_programs_desc', [
        'default'           => 'Pilihan bimbingan intensif bersama guru privat untuk balita, anak~anak, remaja, hingga dewasa.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_programs_desc', [
        'label'   => __( 'Deskripsi Singkat', 'learnquran' ),
        'section' => 'learnquran_programs_section',
        'type'    => 'textarea',
    ] );

    /* Query Dynamic Program Categories for Multi-Select Control */
    $program_terms = get_terms([
        'taxonomy'   => 'learnquran_program_category',
        'hide_empty' => false,
    ]);
    $cat_choices = [];
    if ( ! empty( $program_terms ) && ! is_wp_error( $program_terms ) ) {
        foreach ( $program_terms as $term ) {
            $cat_choices[ $term->slug ] = $term->name . ' (' . $term->count . ')';
        }
    } else {
        $cat_choices = [
            'kids'       => __( 'Balita & Anak~anak', 'learnquran' ),
            'teen-adult' => __( 'Remaja & Dewasa', 'learnquran' ),
            'intensive'  => __( 'Privat Khusus', 'learnquran' ),
        ];
    }

    /* Programs Categories Multi-Select */
    $wp_customize->add_setting( 'learnquran_programs_categories', [
        'default'           => '',
        'sanitize_callback' => 'learnquran_sanitize_multi_select',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( new LearnQuran_Customize_Multi_Select_Control( $wp_customize, 'learnquran_programs_categories', [
        'label'       => __( 'Filter Kategori yang Ditampilkan / Multi Select', 'learnquran' ),
        'description' => __( 'Pilih kategori program apa saja yang ingin dimunculkan. Jika tidak ada yang dicentang, semua kategori akan otomatis ditampilkan.', 'learnquran' ),
        'section'     => 'learnquran_programs_section',
        'choices'     => $cat_choices,
    ] ) );

    /* Programs Maximum Items Limit */
    $wp_customize->add_setting( 'learnquran_programs_max_items', [
        'default'           => 6,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_programs_max_items', [
        'label'       => __( 'Maksimal Jumlah Program yang Ditampilkan', 'learnquran' ),
        'description' => __( 'Tentukan batas maksimal kartu program yang dimunculkan (contoh: 6). Isi 0 untuk menampilkan semua program tanpa dibatasi.', 'learnquran' ),
        'section'     => 'learnquran_programs_section',
        'type'        => 'number',
        'input_attrs' => [
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
        ],
    ] );

    /* Programs View All Button Text */
    $wp_customize->add_setting( 'learnquran_programs_btn_text', [
        'default'           => 'Lihat Semua Program',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_programs_btn_text', [
        'label'       => __( 'Teks Tombol Lihat Semua Program (Beranda)', 'learnquran' ),
        'section'     => 'learnquran_programs_section',
        'type'        => 'text',
    ] );

    /* Programs Archive Page Title */
    $wp_customize->add_setting( 'learnquran_programs_archive_title', [
        'default'           => "Semua Program Belajar Al-Qur'an",
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_programs_archive_title', [
        'label'       => __( 'Judul Halaman Semua Program (/programs)', 'learnquran' ),
        'section'     => 'learnquran_programs_section',
        'type'        => 'text',
    ] );

    /* Programs Archive Page Description */
    $wp_customize->add_setting( 'learnquran_programs_archive_desc', [
        'default'           => "Pilihan program bimbingan intensif membaca Al-Qur'an dengan metode terstruktur untuk balita, anak-anak, remaja, hingga dewasa bersama guru privat profesional.",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_programs_archive_desc', [
        'label'       => __( 'Deskripsi Halaman Semua Program (/programs)', 'learnquran' ),
        'section'     => 'learnquran_programs_section',
        'type'        => 'textarea',
    ] );

    /* Section 6: Best Seller Highlight */
    $wp_customize->add_section( 'learnquran_bestseller_section', [
        'title'    => __( 'Best Seller Highlight', 'learnquran' ),
        'panel'    => 'learnquran_theme_panel',
        'priority' => 40,
    ] );

    /* Best Seller Badge Text */
    $wp_customize->add_setting( 'learnquran_bs_badge', [ 'default' => 'Best Seller Program', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_bs_badge', [ 'label' => __( 'Badge Best Seller', 'learnquran' ), 'section' => 'learnquran_bestseller_section', 'type' => 'text' ] );

    /* Best Seller Arabic Text */
    $wp_customize->add_setting( 'learnquran_bs_arabic', [ 'default' => 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_bs_arabic', [ 'label' => __( 'Teks Arab', 'learnquran' ), 'section' => 'learnquran_bestseller_section', 'type' => 'text' ] );

    /* Best Seller Title */
    $wp_customize->add_setting( 'learnquran_bs_title', [ 'default' => "I Can Read Qur'an: Awal Perjalanan Mencintai Al-Qur'an (3+ Tahun)", 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_bs_title', [ 'label' => __( 'Judul Program', 'learnquran' ), 'section' => 'learnquran_bestseller_section', 'type' => 'text' ] );

    /* Best Seller Description */
    $wp_customize->add_setting( 'learnquran_bs_desc', [ 'default' => "Kami mengubah momen belajar huruf hijaiyah dan membaca Al-Qur'an menjadi petualangan seru yang dinanti-nanti oleh ananda setiap pekan.", 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_bs_desc', [ 'label' => __( 'Deskripsi Singkat', 'learnquran' ), 'section' => 'learnquran_bestseller_section', 'type' => 'textarea' ] );

    /* Best Seller Alumni Count */
    $wp_customize->add_setting( 'learnquran_bs_alumni_count', [ 'default' => '300+', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_bs_alumni_count', [ 'label' => __( 'Angka Alumni', 'learnquran' ), 'section' => 'learnquran_bestseller_section', 'type' => 'text' ] );

    /* Best Seller Alumni Label */
    $wp_customize->add_setting( 'learnquran_bs_alumni_label', [ 'default' => 'Alumni Santri Cilik Bulan Ini', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_bs_alumni_label', [ 'label' => __( 'Label Alumni', 'learnquran' ), 'section' => 'learnquran_bestseller_section', 'type' => 'text' ] );


    /* Section 7: Testimonials */
    $wp_customize->add_section( 'learnquran_testimonials_section', [
        'title'       => __( 'Testimoni / Testimonials', 'learnquran' ),
        'description' => __( 'Atur teks judul dan pengantar seksi Testimoni. Untuk menambah atau mengubah ulasan wali santri, gunakan menu "Testimoni" di sidebar WordPress.', 'learnquran' ),
        'panel'       => 'learnquran_theme_panel',
        'priority'    => 45,
    ] );

    /* Testimonials Badge */
    $wp_customize->add_setting( 'learnquran_testi_badge', [ 'default' => 'Testimonials', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_testi_badge', [ 'label' => __( 'Badge / Label Atas', 'learnquran' ), 'section' => 'learnquran_testimonials_section', 'type' => 'text' ] );

    /* Testimonials Title */
    $wp_customize->add_setting( 'learnquran_testi_title', [ 'default' => 'Apa Kata Ayah & Bunda', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_testi_title', [ 'label' => __( 'Judul Utama', 'learnquran' ), 'section' => 'learnquran_testimonials_section', 'type' => 'text' ] );

    /* Testimonials Description */
    $wp_customize->add_setting( 'learnquran_testi_desc', [ 'default' => "Kisah nyata para wali santri yang mempercayakan pembelajaran Al-Qur'an ananda di Nuraniah Learning Center.", 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_testi_desc', [ 'label' => __( 'Deskripsi Singkat', 'learnquran' ), 'section' => 'learnquran_testimonials_section', 'type' => 'textarea' ] );

    /* Testimonials Maximum Items */
    $wp_customize->add_setting( 'learnquran_testimonials_max_items', [
        'default'           => 9,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_testimonials_max_items', [
        'label'       => __( 'Maksimal Testimoni yang Ditampilkan', 'learnquran' ),
        'description' => __( 'Tentukan batas maksimal kartu ulasan wali santri (contoh: 6). Isi 0 untuk menampilkan semua ulasan tanpa dibatasi.', 'learnquran' ),
        'section'     => 'learnquran_testimonials_section',
        'type'        => 'number',
        'input_attrs' => [
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
        ],
    ] );

    /* Testimonials Autoplay Toggle */
    $wp_customize->add_setting( 'learnquran_testimonials_autoplay', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_testimonials_autoplay', [
        'label'       => __( 'Aktifkan Auto Slide Testimoni', 'learnquran' ),
        'description' => __( 'Otomatis geser kartu testimoni secara berkala.', 'learnquran' ),
        'section'     => 'learnquran_testimonials_section',
        'type'        => 'checkbox',
    ] );

    /* Testimonials Autoplay Speed */
    $wp_customize->add_setting( 'learnquran_testimonials_autoplay_speed', [
        'default'           => 5,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_testimonials_autoplay_speed', [
        'label'       => __( 'Durasi Auto Slide Testimoni ~ Detik', 'learnquran' ),
        'section'     => 'learnquran_testimonials_section',
        'type'        => 'number',
        'input_attrs' => [
            'min'  => 2,
            'max'  => 30,
            'step' => 1,
        ],
    ] );


    /* Section: Blog / Articles And Educational Content */
    $wp_customize->add_section( 'learnquran_blog_section', [
        'title'       => __( 'Artikel & Blog', 'learnquran' ),
        'description' => __( 'Atur seksi Artikel & Edukasi di Beranda. Tampilan akan berupa horizontal carousel loop 3 - 3.', 'learnquran' ),
        'panel'       => 'learnquran_theme_panel',
        'priority'    => 48,
    ] );

    /* Blog Badge */
    $wp_customize->add_setting( 'learnquran_blog_badge', [
        'default'           => 'Artikel & Edukasi',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_blog_badge', [
        'label'   => __( 'Badge / Label Atas', 'learnquran' ),
        'section' => 'learnquran_blog_section',
        'type'    => 'text',
    ] );

    /* Blog Title */
    $wp_customize->add_setting( 'learnquran_blog_title', [
        'default'           => 'Kumpulan Artikel Terkini',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_blog_title', [
        'label'   => __( 'Judul Utama Seksi Artikel', 'learnquran' ),
        'section' => 'learnquran_blog_section',
        'type'    => 'text',
    ] );

    /* Blog Maximum Items Limit */
    $wp_customize->add_setting( 'learnquran_blog_max_items', [
        'default'           => 6,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_blog_max_items', [
        'label'       => __( 'Maksimal Artikel yang Ditampilkan', 'learnquran' ),
        'description' => __( 'Tentukan batas maksimal artikel yang dimunculkan di carousel (contoh: 6 atau 9). Isi 0 untuk menampilkan semua yang terambil.', 'learnquran' ),
        'section'     => 'learnquran_blog_section',
        'type'        => 'number',
        'input_attrs' => [
            'min'  => 0,
            'max'  => 50,
            'step' => 1,
        ],
    ] );

    /* Blog Autoplay Toggle */
    $wp_customize->add_setting( 'learnquran_blog_autoplay', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_blog_autoplay', [
        'label'       => __( 'Aktifkan Auto Slide Artikel', 'learnquran' ),
        'description' => __( 'Otomatis geser kartu artikel secara berkala.', 'learnquran' ),
        'section'     => 'learnquran_blog_section',
        'type'        => 'checkbox',
    ] );

    /* Blog Autoplay Speed */
    $wp_customize->add_setting( 'learnquran_blog_autoplay_speed', [
        'default'           => 5,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_blog_autoplay_speed', [
        'label'       => __( 'Durasi Auto Slide Artikel ~ Detik', 'learnquran' ),
        'section'     => 'learnquran_blog_section',
        'type'        => 'number',
        'input_attrs' => [
            'min'  => 2,
            'max'  => 30,
            'step' => 1,
        ],
    ] );

    /* Blog Archive Page Badge / For Route /blog */
    $wp_customize->add_setting( 'learnquran_blog_page_badge', [
        'default'           => 'Artikel & Wawasan',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_blog_page_badge', [
        'label'       => __( 'Badge / Label Atas Halaman Blog', 'learnquran' ),
        'description' => __( 'Teks badge kecil di bagian atas halaman utama /blog.', 'learnquran' ),
        'section'     => 'learnquran_blog_section',
        'type'        => 'text',
    ] );

    /* Blog Archive Page Title / For Route /blog */
    $wp_customize->add_setting( 'learnquran_blog_page_title', [
        'default'           => "Blog Edukasi Al-Qur'an",
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_blog_page_title', [
        'label'       => __( 'Judul Utama Halaman Blog', 'learnquran' ),
        'description' => __( 'Judul besar di bagian atas halaman utama /blog.', 'learnquran' ),
        'section'     => 'learnquran_blog_section',
        'type'        => 'text',
    ] );

    /* Blog Archive Page Description / For Route /blog */
    $wp_customize->add_setting( 'learnquran_blog_page_desc', [
        'default'           => "Tips mendidik anak mencintai Al-Qur'an, tajwid praktis, dan kabar seputar Nuraniah Learning Center.",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_blog_page_desc', [
        'label'       => __( 'Deskripsi Halaman Blog', 'learnquran' ),
        'description' => __( 'Teks paragraf pengantar di bawah judul halaman /blog.', 'learnquran' ),
        'section'     => 'learnquran_blog_section',
        'type'        => 'textarea',
    ] );

    /* Blog Archive Page Per Page Limit / For Route /blog */
    $wp_customize->add_setting( 'learnquran_blog_per_page', [
        'default'           => 9,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_blog_per_page', [
        'label'       => __( 'Jumlah Artikel Per Halaman di /blog', 'learnquran' ),
        'description' => __( 'Berapa banyak kartu artikel yang dimunculkan per halaman pagination.', 'learnquran' ),
        'section'     => 'learnquran_blog_section',
        'type'        => 'number',
        'input_attrs' => [
            'min'  => 1,
            'max'  => 30,
            'step' => 1,
        ],
    ] );


    /* Section 8: Final CTA Banner */
    $wp_customize->add_section( 'learnquran_cta_section', [
        'title'    => __( 'Banner CTA Bawah', 'learnquran' ),
        'panel'    => 'learnquran_theme_panel',
        'priority' => 50,
    ] );

    /* Final CTA Arabic Text */
    $wp_customize->add_setting( 'learnquran_cta_arabic', [ 'default' => 'اقْرَأْ بِاسْمِ رَبِّكَ الَّذِي خَلَقَ', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_cta_arabic', [ 'label' => __( 'Teks Arab CTA', 'learnquran' ), 'section' => 'learnquran_cta_section', 'type' => 'text' ] );

    /* Final CTA Title */
    $wp_customize->add_setting( 'learnquran_cta_title', [ 'default' => "Wujudkan Generasi Cinta Al-Qur'an Bersama Kami", 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_cta_title', [ 'label' => __( 'Judul CTA', 'learnquran' ), 'section' => 'learnquran_cta_section', 'type' => 'text' ] );

    /* Final CTA Subtitle Description */
    $wp_customize->add_setting( 'learnquran_cta_subtitle', [ 'default' => 'Konsultasikan kebutuhan belajar ananda dan dapatkan jadwal sesi uji coba (trial class) sekarang juga.', 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_cta_subtitle', [ 'label' => __( 'Deskripsi CTA', 'learnquran' ), 'section' => 'learnquran_cta_section', 'type' => 'textarea' ] );

    /* Final CTA WhatsApp Button Text */
    $wp_customize->add_setting( 'learnquran_cta_button_text', [ 'default' => 'Hubungi Kami via WhatsApp', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_cta_button_text', [ 'label' => __( 'Teks Tombol WhatsApp', 'learnquran' ), 'section' => 'learnquran_cta_section', 'type' => 'text' ] );


    /* Section 9: Facilities And Program Detail */
    $wp_customize->add_section( 'learnquran_program_detail_section', [
        'title'       => __( 'Fasilitas & Detail Program', 'learnquran' ),
        'description' => __( 'Atur teks Student Learning Kit dan Banner Kurikulum pada halaman detail program.', 'learnquran' ),
        'panel'       => 'learnquran_theme_panel',
        'priority'    => 55,
    ] );

    /* Learning Kit Badge */
    $wp_customize->add_setting( 'learnquran_kit_badge', [ 'default' => 'Fasilitas Eksklusif', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_kit_badge', [ 'label' => __( 'Badge Learning Kit', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    /* Learning Kit Title */
    $wp_customize->add_setting( 'learnquran_kit_title', [ 'default' => "Student's Learning Kit", 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_kit_title', [ 'label' => __( 'Judul Learning Kit', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    /* Learning Kit Description */
    $wp_customize->add_setting( 'learnquran_kit_desc', [ 'default' => "Setiap santri yang mendaftar akan memperoleh paket modul cetak metode Nuraniah, flashcard sensorik huruf hijaiyah, dan buku panduan mutaba'ah harian.", 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_kit_desc', [ 'label' => __( 'Deskripsi Learning Kit', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'textarea' ] );

    /* Learning Kit Items Checklist */
    $wp_customize->add_setting( 'learnquran_kit_items', [ 'default' => "Modul Nuraniah\nFlashcard Sensorik\nBuku Mutaba'ah", 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_kit_items', [ 'label' => __( 'Daftar Isi Kit, Satu Baris Per Item', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'textarea' ] );

    /* Curriculum Banner Title */
    $wp_customize->add_setting( 'learnquran_banner_curriculum_title', [ 'default' => 'Cari Tahu Apa Itu Metode Nuraniah', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_banner_curriculum_title', [ 'label' => __( 'Judul Banner Metode / Kurikulum', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    /* Curriculum Banner Description */
    $wp_customize->add_setting( 'learnquran_banner_curriculum_desc', [ 'default' => 'Konsultasikan kebutuhan belajar ananda dan diskusikan kurikulum terbaik dengan konsultan kami.', 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_banner_curriculum_desc', [ 'label' => __( 'Deskripsi Banner Metode', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'textarea' ] );

    /* Curriculum Banner Button Text */
    $wp_customize->add_setting( 'learnquran_banner_curriculum_btn', [ 'default' => 'Konsultasi Gratis', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_banner_curriculum_btn', [ 'label' => __( 'Teks Tombol Konsultasi', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    /* Teacher Standard And Qualification Points / Checklist */
    $wp_customize->add_setting( 'learnquran_mentor_quality_points', [ 
        'default' => "Hafalan terjaga dan menguasai kaidah tajwid\nTerlatih menangani berbagai mood anak\nLatar belakang pendidikan Islam & Ma'had terpercaya\nTepat waktu, sopan, dan menjaga privasi keluarga", 
        'sanitize_callback' => 'sanitize_textarea_field', 
        'transport' => 'refresh' 
    ] );
    $wp_customize->add_control( 'learnquran_mentor_quality_points', [ 
        'label' => __( 'Poin Keunggulan / Kualifikasi Guru (1 baris per poin)', 'learnquran' ), 
        'description' => __( 'Daftar checklist keunggulan guru di bawah kartu mentor (tanpa batas banyaknya, tekan Enter untuk membuat poin baru).', 'learnquran' ),
        'section' => 'learnquran_program_detail_section', 
        'type' => 'textarea' 
    ] );

    /* Recommendation Widget / Sidebar */
    $wp_customize->add_setting( 'learnquran_consult_icon', [ 'default' => 'MessageCircle', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_consult_icon', [
        'label'       => __( 'Ikon Lucide Kotak Konsultasi Sidebar', 'learnquran' ),
        'description' => __( 'Nama ikon Lucide (misal: MessageCircle, MessagesSquare, Phone, Headset). <a href="https://lucide.dev/icons/" target="_blank" rel="noopener noreferrer">Buka Galeri Ikon Lucide ↗</a>', 'learnquran' ),
        'section'     => 'learnquran_program_detail_section',
        'type'        => 'text',
    ] );

    $wp_customize->add_setting( 'learnquran_consult_title', [ 'default' => 'Butuh Rekomendasi Program?', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_consult_title', [ 'label' => __( 'Judul Kotak Rekomendasi', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_consult_desc', [ 'default' => "Konsultasikan usia dan kemampuan membaca Al-Qur'an ananda bersama tim akademik kami.", 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_consult_desc', [ 'label' => __( 'Deskripsi Kotak Rekomendasi', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'textarea' ] );

    $wp_customize->add_setting( 'learnquran_consult_btn', [ 'default' => 'Chat Konsultan Akademik →', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_consult_btn', [ 'label' => __( 'Teks Tombol Chat', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_consult_wa_msg', [ 'default' => 'Halo Admin LearnQuran, saya ingin konsultasi memilih program yang cocok', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_consult_wa_msg', [ 'label' => __( 'Draft Pesan WhatsApp Konsultasi', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    /* Teacher Profile Card Header */
    $wp_customize->add_setting( 'learnquran_mentor_badge', [ 'default' => 'Tenaga Pengajar', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_mentor_badge', [ 'label' => __( 'Badge / Subtitle Guru', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_mentor_title', [ 'default' => 'Profile Guru / Quran Mentor', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_mentor_title', [ 'label' => __( 'Judul Bagian Guru / Mentor', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_mentor_tag', [ 'default' => 'Tersertifikasi', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_mentor_tag', [ 'label' => __( 'Tag / Badge Kanan Guru', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_mentor_desc', [ 'default' => 'Didampingi oleh asatidz dan asatidzah berkarakter lembut, bersanad, dan berpengalaman pedagogi anak:', 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_mentor_desc', [ 'label' => __( 'Teks Pengantar Guru / Mentor', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'textarea' ] );

    /* Points Of Learning Section */
    $wp_customize->add_setting( 'learnquran_pd_pol_badge', [ 'default' => 'Keterampilan & Nilai', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_pol_badge', [ 'label' => __( 'Badge Points of Learning', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_pd_pol_title', [ 'default' => 'Points of Learning', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_pol_title', [ 'label' => __( 'Judul Points of Learning', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_pd_pol_desc', [ 'default' => 'Setiap sesi dirancang untuk menstimulasi pemahaman ananda secara menyenangkan melalui aktivitas interaktif:', 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_pol_desc', [ 'label' => __( 'Pengantar Points of Learning', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'textarea' ] );

    /* About This Program Section */
    $wp_customize->add_setting( 'learnquran_pd_about_badge', [ 'default' => 'Metode Pembelajaran', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_about_badge', [ 'label' => __( 'Badge Tentang Program', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_pd_about_title', [ 'default' => 'Tentang Program Ini', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_about_title', [ 'label' => __( 'Judul Tentang Program', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    /* Class Parameters And Specifications Section */
    $wp_customize->add_setting( 'learnquran_pd_specs_badge', [ 'default' => 'Parameter Kelas', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_specs_badge', [ 'label' => __( 'Badge Spesifikasi & Target', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_pd_specs_title', [ 'default' => 'Spesifikasi & Target Program', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_specs_title', [ 'label' => __( 'Judul Spesifikasi & Target', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    /* Program Detail Testimonials Section */
    $wp_customize->add_setting( 'learnquran_pd_testi_badge', [ 'default' => 'Kisah Wali Santri', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_testi_badge', [ 'label' => __( 'Badge Testimoni Detail', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_pd_testi_title', [ 'default' => 'What Parents Say About', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_testi_title', [ 'label' => __( 'Judul Testimoni Detail', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    /* Related Programs Section */
    $wp_customize->add_setting( 'learnquran_pd_related_badge', [ 'default' => 'Pilihan Lainnya', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_related_badge', [ 'label' => __( 'Badge Program Lainnya', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_pd_related_title', [ 'default' => 'More Program in All Ages', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_related_title', [ 'label' => __( 'Judul Program Lainnya', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    /* Tuition Investment And CTA Card / Sidebar */
    $wp_customize->add_setting( 'learnquran_pd_pricing_label', [ 'default' => 'Investasi Belajar:', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_pricing_label', [ 'label' => __( 'Label Harga Sidebar', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_pd_pricing_unit', [ 'default' => '/ bulan', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_pricing_unit', [ 'label' => __( 'Satuan Waktu Harga', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_pd_pricing_desc', [ 'default' => 'Paket privat personal sesuai jadwal keluarga.', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_pricing_desc', [ 'label' => __( 'Keterangan Singkat Paket Harga', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_pd_pricing_points', [ 
        'default' => 'Sesi Evaluasi & Placement Test kemampuan awal ananda\nJadwal Fleksibel bebas pilih guru datang ke rumah / online\nTermasuk Modul Eksklusif & kartu mutaba\'ah harian\nLaporan Evaluasi Bulanan capaian tajwid dan hafalan', 
        'sanitize_callback' => 'sanitize_textarea_field', 
        'transport' => 'refresh' 
    ] );
    $wp_customize->add_control( 'learnquran_pd_pricing_points', [ 
        'label' => __( 'Poin Checklist Paket di Sidebar (1 baris per poin)', 'learnquran' ), 
        'section' => 'learnquran_program_detail_section', 
        'type' => 'textarea' 
    ] );

    $wp_customize->add_setting( 'learnquran_pd_cta_btn', [ 'default' => 'Hubungi Kami', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_cta_btn', [ 'label' => __( 'Teks Tombol Utama Sidebar', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_pd_more_btn', [ 'default' => 'Lihat Pilihan Program Lainnya', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_more_btn', [ 'label' => __( 'Teks Tombol Sekunder Sidebar', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_pd_trust_rating', [ 'default' => 'Rating 4.9/5 dari 1.500+ Santri', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_trust_rating', [ 'label' => __( 'Teks Rating Trust Footer Sidebar', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    $wp_customize->add_setting( 'learnquran_pd_trust_guarantee', [ 'default' => 'Garansi kecocokan guru privat & fleksibilitas jadwal.', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'learnquran_pd_trust_guarantee', [ 'label' => __( 'Teks Garansi Trust Footer Sidebar', 'learnquran' ), 'section' => 'learnquran_program_detail_section', 'type' => 'text' ] );

    /* Section Visibility Options / Global Toggles */
    $visibility_blocks = [
        'learnquran_pd_show_pol'          => [ 'label' => __( 'Tampilkan Card Points of Learning', 'learnquran' ), 'default' => true ],
        'learnquran_pd_show_about'        => [ 'label' => __( 'Tampilkan Card Tentang Program Ini', 'learnquran' ), 'default' => true ],
        'learnquran_pd_show_mentors'      => [ 'label' => __( 'Tampilkan Card Profil Guru & Quran Mentor', 'learnquran' ), 'default' => true ],
        'learnquran_pd_show_specs'        => [ 'label' => __( 'Tampilkan Card Parameter Kelas & Spesifikasi Target', 'learnquran' ), 'default' => true ],
        'learnquran_pd_show_kit'          => [ 'label' => __( 'Tampilkan Card Student\'s Learning Kit', 'learnquran' ), 'default' => true ],
        'learnquran_pd_show_banner'       => [ 'label' => __( 'Tampilkan Card Banner Konsultasi Kurikulum', 'learnquran' ), 'default' => true ],
        'learnquran_pd_show_testimonials' => [ 'label' => __( 'Tampilkan Card Testimoni Wali Santri', 'learnquran' ), 'default' => true ],
        'learnquran_pd_show_related'      => [ 'label' => __( 'Tampilkan Card Pilihan Program Lainnya', 'learnquran' ), 'default' => true ],
        'learnquran_pd_show_pricing'      => [ 'label' => __( 'Tampilkan Sidebar Kartu Harga & Registrasi', 'learnquran' ), 'default' => true ],
        'learnquran_pd_show_consult'      => [ 'label' => __( 'Tampilkan Sidebar Kotak Bantuan Konsultasi', 'learnquran' ), 'default' => true ],
    ];

    foreach ( $visibility_blocks as $visibility_key => $visibility_data ) {
        $wp_customize->add_setting( $visibility_key, [
            'default'           => $visibility_data['default'],
            'sanitize_callback' => 'wp_validate_boolean',
            'transport'         => 'refresh',
        ] );
        $wp_customize->add_control( $visibility_key, [
            'label'   => $visibility_data['label'],
            'section' => 'learnquran_program_detail_section',
            'type'    => 'checkbox',
        ] );
    }

    /* Section: Footer Navigation Menu Guidance & Bio Description */
    $wp_customize->add_section( 'learnquran_footer_menu_section', [
        'title'       => __( 'Pengaturan Footer & Menu Bawah', 'learnquran' ),
        'description' => __( 'Atur teks deskripsi profil brand di bawah logo footer, serta navigasi 3 kolom menu utama bawah.', 'learnquran' ),
        'panel'       => 'learnquran_theme_panel',
        'priority'    => 58,
    ] );

    /* Footer Brand Bio Description Setting */
    $wp_customize->add_setting( 'learnquran_footer_desc', [
        'default'           => "Platform pembelajaran Al-Qur'an modern dan interaktif untuk anak~anak, remaja, hingga dewasa dengan metode teruji dan guru tersertifikasi.",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_footer_desc', [
        'label'       => __( 'Deskripsi Singkat / Bio Brand Footer', 'learnquran' ),
        'description' => __( 'Teks ringkas pengenalan profil lembaga di bawah logo footer.', 'learnquran' ),
        'section'     => 'learnquran_footer_menu_section',
        'type'        => 'textarea',
    ] );

    /* Section: Kebijakan Privasi */
    $wp_customize->add_section( 'learnquran_privacy_section', [
        'title'       => __( 'Kebijakan Privasi', 'learnquran' ),
        'description' => __( 'Atur tautan URL Kebijakan Privasi dan Syarat & Ketentuan untuk bagian footer website.', 'learnquran' ),
        'panel'       => 'learnquran_theme_panel',
        'priority'    => 59,
    ] );

    $default_privacy_policy_url = function_exists( 'get_privacy_policy_url' ) && get_privacy_policy_url()
        ? get_privacy_policy_url()
        : '/privacypolicy';

    /* Kebijakan Privasi URL Setting And Control */
    $wp_customize->add_setting( 'learnquran_privacy_policy_url', [
        'default'           => $default_privacy_policy_url,
        'sanitize_callback' => 'learnquran_sanitize_relative_or_absolute_url',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_privacy_policy_url', [
        'label'       => __( 'URL Kebijakan Privasi', 'learnquran' ),
        'description' => __( 'Tautan halaman Kebijakan Privasi / contoh: /privacypolicy atau https://... /', 'learnquran' ),
        'section'     => 'learnquran_privacy_section',
        'type'        => 'text',
    ] );

    /* Syarat & Ketentuan URL Setting And Control */
    $wp_customize->add_setting( 'learnquran_terms_conditions_url', [
        'default'           => '/termsconditions',
        'sanitize_callback' => 'learnquran_sanitize_relative_or_absolute_url',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'learnquran_terms_conditions_url', [
        'label'       => __( 'URL Syarat & Ketentuan', 'learnquran' ),
        'description' => __( 'Tautan halaman Syarat & Ketentuan / contoh: /termsconditions atau https://... /', 'learnquran' ),
        'section'     => 'learnquran_privacy_section',
        'type'        => 'text',
    ] );
}

/* Return Configured Privacy Policy URL Or Core WordPress Fallback */
function learnquran_get_privacy_policy_url() {
    $configured_privacy_url = get_theme_mod( 'learnquran_privacy_policy_url', '' );
    if ( ! empty( $configured_privacy_url ) ) {
        return $configured_privacy_url;
    }

    if ( function_exists( 'get_privacy_policy_url' ) ) {
        $core_privacy_policy_url = get_privacy_policy_url();
        if ( ! empty( $core_privacy_policy_url ) ) {
            return $core_privacy_policy_url;
        }
    }

    return '/kebijakan-privasi';
}

/* Sanitize Relative Or Absolute URL Inputs */
function learnquran_sanitize_relative_or_absolute_url( $raw_url_string ) {
    $trimmed_url = trim( (string) $raw_url_string );
    if ( empty( $trimmed_url ) || $trimmed_url === '#' ) {
        return $trimmed_url;
    }
    return esc_url_raw( $trimmed_url );
}

/* Hook Customizer Registration Callback Into WordPress */
add_action( 'customize_register', 'learnquran_customize_register' );


