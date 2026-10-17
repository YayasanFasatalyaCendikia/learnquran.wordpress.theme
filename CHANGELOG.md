# Changelog

All notable changes to the **LearnQuran** WordPress theme will be documented in this file.

---

## [1.0.0] - 2026-10-15

### 🌟 Pernyataan Orisinalitas (Statement of Originality)
> **LearnQuran** adalah tema WordPress premium dan platform edukasi Quran yang dirancang, dikonsep, dan dibangun secara orisinal dari nol (*ground-up original architecture*). 
> 
> **Aplikasi/tema ini BUKAN remake, saduran, fork, maupun turunan dari tema atau template manapun.** Seluruh struktur data, integrasi WordPress REST API, komponen antarmuka Vue 3, sistem Customizer, dan alur pendaftaran program dirancang secara mandiri dan khusus untuk memenuhi kebutuhan ekosistem pembelajaran Al-Qur'an, kelas tahfidz, dan rumah Quran modern.

---

### ✨ Rilis Perdana (Initial Production Release)

#### 🚀 Arsitektur & Performa Inti
- **Headless SPA WordPress + Vue 3:** Arsitektur modern menggabungkan kemudahan manajemen konten WordPress dengan kecepatan dan kelancaran Single Page Application berbasis Vue 3 (Composition API) dan Vite.
- **REST API Dedicated (`learnquran/v1`):** Endpoint REST API khusus berkecepatan tinggi untuk pertukaran data program, testimoni santri, direktori FAQ, dan opsi kustomisasi tema secara reaktif.
- **Tailwind CSS v4 Terintegrasi:** Styling berbasis utility class dengan CSS variables modular, memastikan ukuran bundel ultra-ringan dan waktu rendering cepat di semua ukuran layar.
- **Smart Sticky Header Navigation:** Navigasi desktop pintar dengan mekanisme *auto-hide* saat scroll ke bawah dan *quick-reveal* saat scroll ke atas sedikit, memaksimalkan area baca santri.

#### 📖 Kurikulum & Manajemen Program Quran
- **Custom Post Type Program (`learnquran_program`):** Manajemen kelas Quran lengkap dengan kategori taksonomi (`learnquran_program_category`), target usia, lencana program, ringkasan fitur, dan integrasi WhatsApp pendaftaran dinamis.
- **Dukungan Metode Qaidah Nuraniah & Tartil:** Layout materi yang terstruktur rapi untuk bimbingan berjenjang mulai dari balita (sensorial), anak~anak, remaja, hingga tahsin privat dewasa.
- **Dukungan Audio Pembelajaran:** Pemutar audio interaktif untuk contoh bacaan tartil, makharijul huruf, dan talaqqi langsung pada materi pelajaran.

#### 👥 Direktori Ustadz & Testimoni Santri
- **Direktori Mentor & Pengajar (`learnquran_mentor`):** Modul profil asatidz/asatidzah lengkap dengan kualifikasi pendidikan, sanad tilawah, spesialisasi keilmuan, dan foto profil.
- **Sistem Ulasan & Testimoni (`learnquran_testimoni`):** Manajemen ulasan nyata dari wali santri dan murid dengan rating bintang, identitas peran, dan foto profil.
- **Modul Tanya Jawab Interaktif (`learnquran_faq`):** Akordeon FAQ dinamis yang dapat dikelola langsung dari Dashboard Admin WordPress tanpa perlu mengubah kode sumber.

#### 🎨 Desain, Tipografi & Customizer
- **Dual Typography Poppins & Almarai:** Tipografi Poppins yang modern untuk teks Latin dan font Almarai yang sangat presisi dan nyaman dibaca untuk teks Arab/harakat ayat.
- **Palet Warna Identitas:**
  - *Primary Blue (`#1f4c8f`):* Menghadirkan kesan tepercaya, fokus, dan ketenangan belajar.
  - *Accent Orange (`#f59931`):* Menghadirkan semangat belajar, kehangatan, dan energi interaktif.
  - *Base White (`#ffffff`):* Memberikan ruang baca yang bersih, rapi, dan mudah dipahami.
- **Efek Hero Wave Gradient:** Efek visual gelombang gradasi halus warna tema di area Hero section untuk tampilan modern dan dinamis.
- **Live Customizer WordPress:** Lebih dari 50 kontrol kustomisasi langsung di `Appearance > Customize` (pengaturan hero, keunggulan, tata letak, warna aksen, hingga tombol kontak terapung).

#### 🔒 Keamanan, Standar Kode & Lisensi
- **Proprietary Closed Source (Gratis Pemakaian Selamanya):** Lisensi kepemilikan tertutup yang memberikan hak guna gratis tanpa batas waktu untuk lembaga pendidikan dan dakwah Islam.
- **Kepatuhan Terhadap Standar AGENT.md:** Standarisasi penamaan identifier tanpa singkatan, sanitasi data ketat (`sanitize_text_field`, `wp_kses_post`), serta dokumentasi kode berbahasa Inggris berformat Word Case.
