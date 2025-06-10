
---

**Food Ordering Web Application**

**Introduction**
Aplikasi ini adalah aplikasi pemesanan makanan berbasis web yang dikembangkan menggunakan Laravel. Ikuti panduan berikut untuk menginstal dan menjalankannya di mesin lokal Anda.

---

**Panduan Instalasi**

**Prasyarat**
Pastikan sistem Anda telah memiliki:

* PHP versi 8.1 atau lebih tinggi (beserta ekstensi yang dibutuhkan)
* Composer (untuk mengelola dependensi PHP)
* Node.js dan npm (untuk mengelola aset frontend)
* MySQL (atau database lain yang didukung Laravel)

**Langkah-langkah Instalasi**

1. **Clone Repository**

   * Jalankan perintah:
     `git clone https://github.com/ulilabror/foodordering.git`
   * Masuk ke folder proyek:
     `cd foodordering`

2. **Instalasi Dependensi**

   * Instal dependensi PHP:
     `composer install`
   * Instal dependensi Node.js:
     `npm install`

3. **Atur File Environment**

   * Salin `.env.example` menjadi `.env`:
     `cp .env.example .env`
   * Sesuaikan informasi koneksi database pada file `.env`:

     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=nama_database_anda
     DB_USERNAME=user_database_anda
     DB_PASSWORD=password_database_anda
     ```

4. **Generate Application Key**

   * Jalankan perintah:
     `php artisan key:generate`

5. **Jalankan Migrasi**

   * Jalankan perintah:
     `php artisan migrate`

6. **Seed Database (Opsional)**

   * Jika ingin mengisi database dengan data contoh:
     `php artisan db:seed`

7. **Buat Storage Link**

   * Agar file yang diunggah bisa diakses publik, jalankan:
     `php artisan storage:link`

8. **Bangun Aset Frontend**

   * Kompilasi aset frontend:
     `npm run dev`

---

**Menjalankan Aplikasi**

1. **Jalankan Server**

   * Jalankan:
     `php artisan serve`

2. **Akses Aplikasi**

   * Buka browser dan kunjungi:
     `http://127.0.0.1:8000`

---

**Perintah Tambahan**

* Membersihkan cache:

  * `php artisan cache:clear`
  * `php artisan config:clear`
  * `php artisan view:clear`
  * `php artisan route:clear`

---

**Lisensi**
Framework Laravel dilisensikan di bawah [Lisensi MIT](https://opensource.org/licenses/MIT).

---

