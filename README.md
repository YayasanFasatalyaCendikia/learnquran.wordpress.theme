# LearnQuran – WordPress Theme untuk Kursus & Rumah Tahfidz Al-Qur'an

**LearnQuran** adalah tema WordPress premium yang dirancang khusus untuk platform edukasi Islam, kursus online Al-Qur'an, kelas Tahfidz intensif, pembelajaran Qaidah Nuraniah, hingga manajemen Daurah Quran.

Dibangun dengan kombinasi visual yang elegan, bersih, dan modern, tema ini memadukan keindahan tipografi **Poppins** untuk teks Latin serta **Almarai** yang sangat rapi untuk teks Arab. LearnQuran hadir dengan perpaduan warna yang profesional—sentuhan warna **Biru** yang menenangkan, aksen **Orange** yang penuh energi dan semangat belajar, serta latar belakang **Putih** yang bersih dan minimalis.

Tema ini adalah solusi *all-in-one* terbaik sebagai pembeda (*Furqan*) dari platform edukasi standar, memberikan pengalaman belajar interaktif yang modern bagi santri di seluruh dunia.

---

## 🚀 Fitur Utama & Keunggulan LearnQuran

- **Integrasi LMS Islami yang Matang**  
  Kelola kelas talaqqi, setoran hafalan, ujian tajwid, hingga tracking progress hafalan santri dengan mudah melalui sistem manajemen pembelajaran (LMS) yang intuitif.

- **Optimal untuk Program Kelas & Daurah**  
  Tersedia layout khusus untuk manajemen Daurah Quran (kelas intensif/pendaftaran berbatas waktu) lengkap dengan countdown timer, jadwal sesi, dan profil ustadz/pengajar.

- **Dukungan Penuh Metode Pembelajaran**  
  Sangat ramah untuk metode pembelajaran berstruktur seperti Qaidah Nuraniah, kelas tartil, kelas makharijul huruf, hingga program tahfidz anak maupun dewasa.

- **Sistem Audio Pembelajaran Interaktif**  
  Dilengkapi dengan pemutar audio bawaan yang responsif untuk mendengarkan contoh bacaan murottal/tilawah langsung di halaman materi.

- **Desain Minimalis, Cepat, dan Ringan**  
  Bebas dari elemen visual yang terlalu padat atau bulky. Layout didesain presisi, ramping, dan modern untuk memastikan kecepatan loading yang maksimal di segala perangkat.

- **Tipografi & Font yang Presisi**  
  Menggunakan font Poppins untuk navigasi dan teks informasi umum, serta font Almarai untuk teks Arab/ayat agar harakat dan tulisan Al-Qur'an terbaca dengan sangat jelas dan sahih.

- **Kompatibilitas Multi-Bahasa & RTL**  
  Mendukung penuh penerjemahan sistem ke berbagai bahasa, serta siap digunakan untuk layout RTL (Right-to-Left) jika Anda ingin menyediakan platform dalam bahasa Arab murni.

---

## 🎨 Palet Warna Identitas

- **Primary Blue (`#1f4c8f`)**: Memberikan kesan tepercaya, fokus, dan ketenangan dalam belajar.
- **Accent Orange (`#f59931`)**: Menandakan energi, motivasi, dan kehangatan interaksi antara guru dan murid.
- **Base White (`#ffffff`)**: Menjamin keterbacaan tingkat tinggi (*readability*) dan ruang desain yang bersih.

---

## 📋 Cocok Digunakan Untuk:

- **Sekolah Islam, Pesantren, dan Rumah Tahfidz modern.**
- **Platform Kursus Online Al-Qur'an & Tajwid Mandiri.**
- **Penyelenggara Pelatihan/Daurah Al-Qur'an Intensif.**
- **Ustadz, Pengajar, atau Lembaga Dakwah yang ingin mendigitalisasi kurikulum belajarnya.**

---

## 🛠 Panduan Arsitektur & Pengembang (Developer Guide)

Tema ini dirancang dari nol (*ground-up original architecture*) menggabungkan kekuatan CMS WordPress dengan performa aplikasi modern Single Page Application (SPA):

### 🧠 Teknologi Inti
- **Vue 3** (Composition API) & **Vite 6**
- **Tailwind CSS v4** dengan CSS Variables terstruktur
- **Pinia** untuk manajemen state global reaktif
- **Vue Router** dengan dukungan dynamic slug & history navigation
- **WordPress REST API** kustom ber-namespace `learnquran/v1`

### 🗂 Struktur Direktori Proyek
```text
wp-content/themes/learnquran/
├── functions/                     # Modul PHP backend WordPress
│   ├── api.php                    # Endpoint REST API kustom (learnquran/v1)
│   ├── customizer.php             # Registrasi panel & kontrol Live Customizer
│   ├── helpers.php                # Pembantu fungsi registrasi REST API & utilitas
│   ├── posttype/                  # Definisi Custom Post Types & Meta Boxes
│   │   ├── faq.php                # CPT Tanya Jawab (learnquran_faq)
│   │   ├── mentor.php             # CPT Pengajar / Asatidz (learnquran_mentor)
│   │   ├── program.php            # CPT Program Kursus (learnquran_program)
│   │   └── testimonial.php        # CPT Ulasan Santri (learnquran_testimoni)
│   ├── settings.php               # Konfigurasi tema, menu, & dukungan fitur WP
│   └── vite.php                   # Integrasi injeksi aset build & Vite dev server
├── src/                           # Source code frontend Vue 3
│   ├── api/                       # REST API client & fetchers
│   ├── assets/                    # Gambar, logo, & ikon lokal
│   ├── components/                # Komponen Vue modular
│   │   ├── common/                # Komponen reusable (Button, Badge, Card, dll.)
│   │   └── layout/                # Komponen layout (Header, Footer, NavMenu, dll.)
│   ├── composables/               # Vue composables (useApi, useWp, dll.)
│   ├── page/                      # Halaman view (Home, ProgramDetail, Content, Blog)
│   ├── router/                    # Konfigurasi Vue Router & route guards
│   ├── stores/                    # Store Pinia (site info, menu, post data)
│   ├── App.vue                    # Komponen root aplikasi Vue
│   ├── main.js                    # Inisialisasi aplikasi Vue
│   ├── settings.js                # Pengambilan variabel konteks dari WordPress
│   └── style.css                  # Konfigurasi CSS utama & tema warna
├── dist/                          # Aset terkompilasi siap produksi (npm run build)
├── footer.php                     # Template footer WordPress
├── header.php                     # Template header WordPress
├── index.php                      # Entry point WordPress fallback
├── style.css                      # Metadata resmi tema WordPress LearnQuran
├── CHANGELOG.md                   # Catatan rilis resmi & pernyataan orisinalitas
├── LICENSE                        # Lisensi kepemilikan tertutup (Closed Source)
└── package.json                   # Dependensi frontend & script otomasi
```

---

## ⚡ Langkah Pengembangan (Development & Build)

### 1. Prasyarat Lingkungan
- **PHP**: 8.1 atau yang lebih baru
- **WordPress**: 6.7 atau yang lebih baru
- **Node.js**: 20.x atau yang lebih baru
- **NPM**: 10.x atau yang lebih baru

### 2. Mode Pengembangan (Development)
Untuk menjalankan mode pengembangan dengan Vite Hot Module Replacement (HMR):
```bash
npm install
npm run dev
```

### 3. Kompilasi Produksi (Production Build)
Untuk memproduksi file aset yang dioptimalkan, di-minify, dan siap diluncurkan:
```bash
npm run build
```

---

## 📄 Lisensi & Hak Cipta

**Hak Cipta (c) 2026 LearnQuran. Seluruh Hak Cipta Dilindungi Undang-Undang.**

Tema ini berlisensi **Proprietary Closed Source (Gratis Pemakaian Selamanya)**. Anda dan lembaga Anda diberikan hak penuh untuk memasang, mengoperasikan, dan menggunakan tema ini untuk kebutuhan website dakwah, yayasan, rumah tahfidz, atau kursus Quran selamanya tanpa biaya langganan, dengan ketentuan dilarang memperjualbelikan ulang atau mendistribusikan ulang kode sumber kepada pihak ketiga.

Silakan merujuk ke berkas [LICENSE](LICENSE) untuk syarat dan ketentuan lengkap.
