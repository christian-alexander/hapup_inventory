# HappyInventory
Project ini dibuat sebagai bagian dari technical test untuk posisi Web Developer di PT. Imperium Happy Puppy.
Fokus utama adalah membangun sistem inventory sederhana dengan perhatian pada performa, user experience, dan scalability.

## Tech Stack
- Backend: Laravel 12 (PHP 8.2+)
- Frontend: Bootstrap 4, jQuery
- Database: MySQL
- Library: Yajra Datatables, Toastr, jQuery Loading Overlay

### fitur utama yang diminta
1. simple auth 
2. CRUD inventory product 
3. tambahan UX : pagination & toast
4. middleware auth, jika belum login tidak bisa akses dashboard product

### fitur tambahan improvement
1. serverside datatable agar tidak berat dengan data besar
2. semua call backend by ajax (kecuali saat pindah halaman dan logout), agar web lebih cepat dan responsif karena tidak perlu load all dependency ulang. ini berdasarkan pengalaman saya di perusahaan-perusahaan saya sebelumnya.
3. validasi inputan, penting untuk memastikan integritas data product
4. last login at user, sangat berguna jika kedepannya ada user logging
5. simple rupiah display di form add / edit. Ini membantu display format rupiah saat input

### rencana improvement lanjutan (opsional)
1. manajemen hak akses user. Akan berguna jika nanti app ini scalable ke skala lebih besar dan butuh authorize di beberapa module. 
2. user logging untuk log aktivitas. Terkait dengan rencana #1, sangat berguna untuk tracking perubahan data dilakukan oleh siapa.
3. Pemisahan table stock. Idealnya table stock sendiri jika nanti aplikasi inventory ini berkembang lebih kompleks.
4. module stock opname, dengan log riwayat opname. ini akan mencatat perubahan stock karena stock adalah hal krusial
5. pembelian dan penjualan. Ini jika mau dikembangkan lebih serius ke arah POS, akan berkaitan langsung dengan stock

--- 
# Plugins

## Backend Plugins
1. semua vendor default laravel dari `composer create project laravel/laravel`
2. yajrabox untuk serverside datatable https://yajrabox.com/docs/laravel-datatables/13.0

## Frontend Plugins 
1. template frontend memakai template bootstrap 4 "ruang admin" by indri junanda (open source free to download di https://themewagon.com/themes/free-bootstrap-4-html-5-admin-dashboard-website-template-ruang/)
2. bootstrap 4 https://getbootstrap.com/
3. toastr by CodeSeven https://github.com/CodeSeven/toastr
4. datatables by SpryMedia https://datatables.net
5. loading overlay jquery by Gaspare Sganga https://gasparesganga.com/labs/jquery-loading-overlay/
6. icons by fontawesome v4.7.0 https://fontawesome.com/v4/icons/

--- 
# Installation

## Requirement 
1. PHP > 8.2
2. mysql terinstall 
3. composer

## Cara Install 
1. git clone ke folder pc
2. masuk ke folder hasil clone, jalankan `composer install`
3. copy file .env.example dan sesuaikan pengaturan database (defaultnya laravel pakai sql lite, tapi di project ini saya pakai mysql). Jika pakai mysql bisa dibuat dulu databasenya di pc dan isikan crednya di .env
4. jalankan `php artisan key:generate` 
5. jalankan `php artisan migrate:fresh --seed`. sudah ada seeder untuk demo login admin dan 3 dummy kategori product 
6. jalankan `php artisan serve`. maka web dapat diakses di localhost:8000

## Demo Account
- Email: admin@gmail.com
- Password: admin

---
# Struktur Code

## Routes
1. semua route di web.php, termasuk perlindungan route product dengan auth middleware laravel.

## Controllers
1. LoginController - untuk perloginan dan perlogoutan
2. ProductController - untuk CRUD product + serverside datatablenya

## Models 
1. Product - model untuk product 
2. ProductCategory - model untuk kategori product
3. User - bawaan laravel untuk user

## Views 
1. layout > mainlayout - main layout untuk setelah login 
2. layout > landinglayout - layout untuk sebelum login (login page)
3. layout > menubar > sidebar - layout untuk sidebar after login 
4. layout > menubar > topbar - layout untuk top bar after login
5. login - view untuk halaman login
6. product > index - view untuk halaman product
7. product > add - modal add product + ajax add
8. product > edit - modal edit product + ajax edit
9. product > delete - script simple untuk ajax delete product 

## migrations 
1. create_products_table - migrasi untuk struktur tabel product 
2. create_product_categories_table - migrasi untuk struktur tabel product category
3. create_users_table - bawaan init project tapi modif kolom 'email_verified_at' saya ganti 'last_login_at', lebih berguna.
3. sisanya bawaan migrasi dari init project laravel

## seeder
1. UserSeeder - seeder untuk buat user demo 
2. ProductCategorySeeeder - seeder untuk 3 dummy product category

---
# Business Logic 
## Login 
1. login melalui halaman login dengan mengisikan email dan password 
2. diverifikasi dengan laravel auth
3. jika credential salah -> toastr kredensial salah dan diminta login ulang
4. jika credential benar -> toastr berhasil login dan diredirect ke halaman product after login 

## Product 
### Index 
1. untuk kesini harus lolos middleware auth dari web.php. jika belum login dan akses url ini, akan redirect ke halaman login.
2. halaman index product di load, kemudian datatable ajax call ke backend untuk serverside datatable
3. setiap ada event di tabel (search / page), datatable re render dan call back ke backend untuk get data (behavior datatable) 
4. setiap ada perubahan data (add / edit / delete), saya re render datatablenya agar hit lagi ke backend untuk mengupdate data dengan terbaru

### Add
1. ketika user klik tombol tambah di index, buka modal popup untuk isian data product
2. user isi dan klik tombol tambah -> ajax call ke backend
3. ada validasi inputan di backend, jika salah kembali ke poin #2
4. jika benar, muncul toastr dengan pesan data product tersimpan dan modal terclose

### Edit
1. ketika user klik tombol ubah di row tabel product, trigger fungsi untuk call ajax ke backend.
2. ajax call ke backend untuk mendapatkan data product yang ingin diubah, dengan parameter id product dan on done ajax modal terbuka dengan datanya
3. user mengubah data dan klik tombol ubah -> ajax call ke backend
4. ada validasi inputan di backend, jika salah kembali ke poin #3
5. jika benar, muncul toastr dengan pesan data product berhasil diubah dan modal terclose

### Delete 
1. ketika user klik tombol ubah di row tabel product, munculkan popup konfirmasi hapus.
2. jika yes, lanjut ajax call ke backend untuk menghapus data 
3. muncul toastr dengan pesan berhasil hapus

### logout 
1. klik logout di top bar
2. hapus session dan invalidate session
3. redirect ke halaman login