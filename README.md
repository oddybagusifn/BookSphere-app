# 📚 Langkah Konfigurasi Project BookSphere

Ikuti langkah-langkah berikut untuk menjalankan proyek Laravel **BookSphere** di komputer lokal kamu:

1. **Buat Database**

    - Buka [http://127.0.0.1/phpmyadmin](http://127.0.0.1/phpmyadmin)
    - Buat database baru dengan nama:
        ```
        booksphere_app
        ```
    - Tidak perlu membuat tabel secara manual.

2. **Buka Proyek di VS Code**

    - Buka folder project menggunakan Visual Studio Code.
    - Buka terminal dengan shortcut:
        ```
        Ctrl + `
        ```

3. **Install Dependency Composer**

    - Jalankan perintah:
        ```
        composer install
        ```

4. **Jalankan Server Laravel**

    - Setelah instalasi selesai, jalankan:
        ```
        php artisan serve
        ```
    - Akan muncul link lokal ke project, misalnya `http://127.0.0.1:8000`
    - Klik atau salin link tersebut untuk membuka website.

5. **Migrasi Database**

    - Untuk membuat tabel di database, jalankan:
        ```
        php artisan migrate
        ```

6. **Isi Data Admin**

    - Jalankan seeder admin:
        ```
        php artisan db:seed --class=AdminSeeder
        ```
    - Data login admin yang tersedia:
        - Email: `admin@booksphere.com`
        - Username: `Admin`
        - Password: `password123`
        - Role: `admin`

7. **Import Buku dari Google Books API**

    - Gunakan perintah berikut sesuai kategori buku yang diinginkan (boleh dijalankan semuanya):

    **Fiksi / Novel**

    - php artisan googlebooks:import "novel"
    - php artisan googlebooks:import "fiction"
    - php artisan googlebooks:import "novel indonesia"
    - php artisan googlebooks:import "cerpen"

    **Sains & Teknologi**

    - php artisan googlebooks:import "science"
    - php artisan googlebooks:import "artificial intelligence"
    - php artisan googlebooks:import "machine learning"
    - php artisan googlebooks:import "data science"
    - php artisan googlebooks:import "programming"

    **Pendidikan**

    - php artisan googlebooks:import "matematika"
    - php artisan googlebooks:import "sejarah indonesia"
    - php artisan googlebooks:import "biologi"
    - php artisan googlebooks:import "geografi"
    - php artisan googlebooks:import "psikologi pendidikan"

    **Pengembangan Diri & Motivasi**

    - php artisan googlebooks:import "self improvement"
    - php artisan googlebooks:import "motivasi"
    - php artisan googlebooks:import "leadership"
    - php artisan googlebooks:import "time management"

    **Agama**

    - php artisan googlebooks:import "islam"
    - php artisan googlebooks:import "tafsir alquran"
    - php artisan googlebooks:import "agama hindu"
    - php artisan googlebooks:import "bible study"

    **Bisnis & Ekonomi**

    - php artisan googlebooks:import "entrepreneurship"
    - php artisan googlebooks:import "marketing"
    - php artisan googlebooks:import "investasi"
    - php artisan googlebooks:import "ekonomi makro"

8. **Masukkan Data Review & Rating Buku**

-   Jalankan perintah berikut untuk membuat review otomatis agar fitur rating dan buku populer aktif:
    ```
    php artisan db:seed --class=ReviewSeeder
    ```

9. **(Opsional) Masukkan Data Dummy Peminjaman Buku**

-   Jalankan:
    ```
    php artisan db:seed --class=BorrowingSeeder
    ```

10. **Akses dan Gunakan Aplikasi**

-   Kamu bisa membuat akun sendiri melalui halaman register.
-   Atau login menggunakan akun admin yang sudah disediakan:
    -   Email: `admin@booksphere.com`
    -   Password: `password123`
-   Login menggunakan akun admin akan diarahkan ke Dashboard Admin.
-   Akun biasa akan diarahkan ke halaman Homepage.
-   Login juga bisa menggunakan akun Google (fitur Google OAuth sudah tersedia).

---

Selamat! 🎉  
Aplikasi **BookSphere** sekarang sudah siap digunakan secara lokal.  
Selamat membaca dan mengelola koleksi buku digital! 📖✨
