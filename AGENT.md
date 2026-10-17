Berikut adalah hasil penggabungan dokumen **`AGENT.md`** dan **`AGENTS.md`** menjadi satu dokumen panduan yang utuh, komprehensif, dan konsisten (mengintegrasikan aturan penamaan ketat tanpa singkatan, aturan format komentar bahasa Inggris dengan *Word Case* dan pemisah garis miring `/`, serta panduan teknis khusus untuk tema WordPress / Vue.js):

---

# AGENT.md

## 1. Tujuan Dan Prinsip Utama

Dokumen ini merupakan pedoman resmi dan wajib bagi AI coding agent dan pengembang saat membuat, membaca, memperbaiki, mengembangkan, serta melakukan refactoring kode dalam codebase tema **LearnQuran** (`wp-content/themes/learnquran`), yang mencakup PHP, JavaScript, TypeScript, dan Vue.js.

Semua implementasi wajib mengutamakan:

* Keterbacaan kode.


* Penamaan identifier yang jelas dan lengkap (tanpa singkatan).


* Konsistensi gaya penulisan.


* Kemudahan pemeliharaan.


* Keamanan aplikasi.


* Ketepatan implementasi dan pemisahan tanggung jawab (*separation of concerns*).


* Kompatibilitas dengan arsitektur dan kontrak project yang sudah ada.



---

## 2. Aturan Utama (Core Rules)

1. **Dilarang Menyingkat Identifier**: Dilarang keras menggunakan singkatan buatan sendiri untuk identifier aplikasi. Semua nama variabel, konstanta, fungsi, method, class, property, parameter, interface, type, enum, komponen, props, event, dan composable harus menggunakan kata lengkap dan deskriptif.


2. **Bahasa Komentar**: Seluruh komentar penjelasan dalam kode **wajib ditulis dalam Bahasa Inggris**.


3. **Format Huruf Komentar (Word Case)**: Semua komentar penjelasan wajib menggunakan format **Word Case** (Capitalize Each Word / Title Case).


4. **Hindari Tanda Kurung dalam Komentar**: Jangan gunakan tanda kurung `(...)` untuk kualifikasi atau konteks tambahan pada komentar. Gunakan karakter garis miring (`/`) sebagai pemisah konteks alternatif.


5. **Format Blok Komentar**: Gunakan sintaks komentar blok standar (`/* ... */` untuk script, `<!-- ... -->` untuk template). Dilarang menggunakan komentar inline `//` atau `#` untuk komentar penjelasan umum.


6. **Integritas Kontrak Eksternal**: Jangan mengubah kontrak eksternal, API, framework, atau library jika perubahan dapat merusak kompatibilitas.


7. **Refactoring Terfokus**: Jangan melakukan perubahan/refactoring yang tidak berkaitan dengan tugas yang diminta.


8. **Minimalisasi Dependency**: Jangan menambahkan dependency baru tanpa alasan teknis yang jelas.



---

## 3. Standar Penulisan & Format Komentar

### 3.1. Ketentuan Umum Komentar

* **Language**: All comments must be written in **English**.


* **Capitalization**: Use **Word Case** (Capitalize Each Word) for summaries, section headers, and explanatory comments.


* **No Parentheses**: Use forward slashes `/` instead of parentheses `(...)` for qualifiers, source origins, or alternatives.


* *Avoid*: `<!-- Mini Need Help Card (Dynamic from Edit Program or Customizer) -->`

* *Good*: `<!-- Mini Need Help Card / Dynamic From Edit Program Or Customizer -->`

* *Avoid*: `<!-- Card Points of Learning (Using Navy & Orange) -->`

* *Good*: `<!-- Card Points Of Learning / Navy And Orange Accent -->`

* *Avoid*: `/* Mentor Quality Checklist (Per-program override or Customizer) */`

* *Good*: `/* Mentor Quality Checklist / Per-Program Override Or Customizer Default */`




### 3.2. Format Komentar Berdasarkan Jenis File

#### A. JavaScript (`.js`), TypeScript (`.ts`), dan Vue Script (`.vue <script>`)

Gunakan sintaks *block comment*:

```javascript
/* Comment In English With Word Case */
const activeUserProfile = await retrieveUserProfile(userIdentifier);

```

Untuk dokumentasi multi-baris:

```javascript
/*
 * Fetch Active Program By Slug
 * Handles Application Programming Interface Requests And Fallback Handling
 */

```

#### B. Vue Template (`.vue <template>`)

Gunakan komentar HTML standar:

```html
<template>
  <section>
    <!-- Right Sidebar Sticky Pricing Card / Dynamic From Program Options -->
    <ProgramPricingCard
      v-if="isProgramPricingAvailable"
      :program-details="activeProgramDetails"
    />

    <!-- Loading Indicator While Fetching Program Data -->
    <LoadingIndicator v-else />
  </section>
</template>

```

#### C. PHP (`.php`)

Gunakan block comment C-style atau PHPDoc (hindari `//` atau `#`):

```php
/* Register Custom Post Type For Mentors */
register_post_type('mentor', $mentorPostTypeArguments);

/**
 * Retrieve Program By Slug Representational State Transfer Endpoint
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
public function retrieveProgramBySlug(WP_REST_Request $request): WP_REST_Response
{
    /* Query Program Data From Database */
    return new WP_REST_Response($programData, 200);
}

```

#### D. Pengecualian Komentar Tooling

Anotasi khusus yang diwajibkan oleh compiler atau linter boleh dipertahankan apa adanya (misal: `// @ts-ignore`, `// eslint-disable-next-line`).

---

## 4. Aturan Penamaan Identifier

### 4.1. Dilarang Menggunakan Singkatan

Semua identifier wajib menggunakan kata lengkap yang jelas dan deskriptif.

| Salah (Dilarang) | Benar (Wajib Digunakan) |
| --- | --- |
| `$usr`, `$usrNm`, `$usrId`<br> | `$authenticatedUser`, `$authenticatedUserName`, `$userIdentifier`<br> |
| `$cnt`, `$qty`<br> | `$totalItemCount`, `$itemQuantity` |
| `$cfg`, `$conf`<br> | `$applicationConfiguration`<br> |
| `$tmp`, `$res`<br> | `$processedResult`, `$apiResponse`<br> |
| `maxRetry`, `ordLst`<br> | `maximumRetryCount`, `customerOrderList`<br> |
| `getUsr()`, `calcTot()`<br> | `getUserProfile()`, `calculateTotalPrice()`<br> |
| `UsrSvc`, `OrdRepo`<br> | `UserService`, `OrderRepository`<br> |
| `UsrCard.vue`, `PayForm.vue`<br> | `UserProfileCard.vue`, `CustomerPaymentForm.vue`<br> |

### 4.2. Pengecualian Singkatan Teknis Baku

Singkatan teknis standar industri atau identifier kontrak resmi yang telah baku diperbolehkan:

* `HTTP`, `HTTPS`, `URL`, `URI`, `JSON`, `HTML`, `CSS`, `SQL`, `API`, `REST`, `ID`, `WP` (WordPress).



*Catatan integrasi:* Jika payload eksternal mengandung singkatan seperti `usr_id`, petakan langsung ke variabel internal berpenamaan lengkap:

```typescript
const userIdentifier = apiResponse.usr_id;

```

### 4.3. Konvensi Penamaan Berdasarkan Jenis Identifier

| Jenis Identifier | Konvensi | Contoh |
| --- | --- | --- |
| Variabel PHP / JS / TS

 | `camelCase`<br> | `$currentUserProfile`, `customerOrderList`<br> |
| Konstanta

 | `UPPER_SNAKE_CASE`<br> | `MAXIMUM_RETRY_COUNT`, `DEFAULT_CACHE_DURATION` |
| Fungsi & Method

 | `camelCase`<br> | `fetchActivePrograms()`, `calculateTotalPrice()`<br> |
| Class & Trait

 | `PascalCase`<br> | `PaymentProcessingService`, `ProgramRepository` |
| Interface & Type Alias

 | `PascalCase`<br> | `ProgramMetadataInterface`, `OrderStatus`<br> |
| Enum & Enum Members

 | `PascalCase` / `UPPER_SNAKE_CASE`<br> | `enum OrderStatus { PENDING = 'pending' }`<br> |
| Property & Parameter

 | `camelCase`<br> | `userIdentifier`, `emailAddress`<br> |
| Komponen Vue

 | `PascalCase`<br> | `ProgramSidebarCard.vue` |
| Props & Event Vue (Template)

 | `kebab-case`<br> | `:program-identifier="..."`, `@program-selected="..."` |
| Composable Vue

 | `camelCase` (awalan `use`)

 | `useUserAuthentication()`, `useActivePrograms()` |
| File Class PHP

 | Mengikuti PSR-4

 | `ThemeOptionsController.php` |

---

## 5. Panduan Khusus Proyek NLC & WordPress

### 5.1. Brand Identity & Colors

Saat mendesain atau mengedit komponen tampilan, patuhi token warna resmi NLC:

* **Primary Navy**: `#1f4c8f`

* **Primary Amber/Orange**: `#f59931`

* Gunakan utilitas opasitas Tailwind yang sesuai (misal: `bg-[#1f4c8f]/10`) untuk menjaga kohesi desain.



### 5.2. Dynamic Data & Integrasi WordPress

* Konten yang dikelola administrator wajib dapat dikonfigurasi melalui **WP Customizer** atau **Post Meta (Custom Metaboxes)**.


* Sediakan nilai default (*fallback*) yang aman pada template dan REST API agar tidak ada bagian tampilan yang kosong jika data belum dikonfigurasi.



### 5.3. Build & Quality Verification

* Setiap kali selesai melakukan modifikasi pada file frontend (`src/`), selalu jalankan dan verifikasi perintah:


```bash
npm run build

```


* Pastikan build bersih tanpa error sintaks, warning fatal, atau dependensi yang tidak teresolusi.



---

## 6. Standar Keamanan & Kualitas Kode

1. **Kredensial**: Dilarang meletakkan kredensial rahasia (API key, token, kata sandi) di dalam kode sumber.


2. **Sanitasi & Validasi**: Selalu sanitasi dan validasi input pengguna di sisi backend (PHP) menggunakan fungsi bawaan WordPress yang relevan (`sanitize_text_field()`, `esc_html()`, dll.).


3. **Query Aman**: Gunakan WordPress Data Layer (`WP_Query`, `$wpdb->prepare()`) untuk mencegah celah keamanan SQL Injection.


4. **Vue.js**: Utamakan Vue 3 Composition API dengan `<script setup>`. Hindari modifikasi props secara langsung (*mutation*).



---

## 7. Checklist Verifikasi Sebelum Menyelesaikan Pekerjaan

### Penamaan

* [ ] Semua variabel, fungsi, parameter, class, dan tipe menggunakan nama lengkap tanpa singkatan buatan sendiri.


* [ ] Tidak ada nama generik ambigu (`$tmp`, `$data`, `res`) jika maknanya bisa diperjelas.



### Komentar

* [ ] Semua komentar ditulis dalam **Bahasa Inggris**.


* [ ] Semua komentar penjelasan menggunakan format **Word Case**.


* [ ] Komentar tidak menggunakan tanda kurung `(...)`, melainkan pemisah garis miring `/`.


* [ ] File PHP & JS/TS menggunakan format blok `/* ... */`.


* [ ] File Vue template menggunakan format `<!-- ... -->`.



### Kualitas & Build

* [ ] Tidak ada perubahan perilaku (*breaking changes*) pada fitur yang sudah ada tanpa instruksi.


* [ ] Perintah `npm run build` sukses dijalankan jika mengedit aset frontend.


* [ ] Integrasi Customizer / Post Meta memiliki nilai fallback yang aman.



---

## 8. Prioritas Aturan

Jika terdapat pertentangan dalam penerapan instruksi, ikuti urutan prioritas berikut:

1. Kebenaran sintaks dan runtime bahasa pemrograman.


2. Keamanan aplikasi dan integritas data.


3. Kompatibilitas dengan WordPress Core, framework, dan library yang terpasang.


4. Permintaan eksplisit dari pengguna.


5. Aturan penamaan, komentar, dan gaya kode dalam dokumen ini.