MC07 PORTAL - UI TAILWIND (15 SCREEN)
======================================

Paket ini dibuat berdasarkan desain Figma/kolase MC07 yang diberikan:
1 Login
2 Dashboard Admin
3 Dashboard Operator
4 Kelola Produk
5 Tambah Produk
6 Edit Produk
7 Detail Produk
8 Manajemen Pengguna
9 Edit Role Pengguna
10 Restock/Stok
11 Slot Mapping
12 Approval Queue
14 Konfirmasi Pengiriman Konfigurasi
15 Log Aktivitas
+ Konfigurasi Mesin (screen form) sebagai screen 13/10 sesuai alur.

CATATAN
- CRUD ProductController/model yang sudah bekerja tetap dipakai.
- Tailwind dipakai melalui CDN agar tidak perlu mengubah setup Vite terlebih dahulu.
- Route/Controller tambahan untuk User, Approval, Machine Configuration, Activity disediakan.
- Restock dan Slot Mapping saat ini merupakan UI operational/mock karena schema khusus restock/slot belum diberikan.
- Machine Configuration menyimpan payload ke tabel machine_configurations. Pengiriman aktual ke MC12 perlu disambungkan ke API Contract v1.

CARA PASANG
1. Backup project:
   cp -r /home/irawan/pbl/mc07-portal /home/irawan/pbl/mc07-portal-backup

2. Copy folder resources/views dari paket ini ke:
   /home/irawan/pbl/mc07-portal/resources/views

3. Copy controller tambahan:
   app/Http/Controllers/UserController.php
   app/Http/Controllers/ApprovalController.php
   app/Http/Controllers/ActivityController.php
   app/Http/Controllers/MachineConfigurationController.php

4. Merge routes/web.php dengan routes/web.php paket.
   Jangan menghapus middleware RoleMiddleware/bootstrap/app.php yang sudah bekerja.

5. Jalankan:
   php artisan optimize:clear
   php artisan route:list

6. Login:
   Admin: admin@mc07.test
   Operator: operator@mc07.test

7. Buka:
   http://127.0.0.1:8000/login

Jika memakai Apache/virtual host, gunakan URL project Laravel yang biasa dipakai.

TARGET M5
- CRUD produk
- form tambah/edit + validation
- harga/status
- soft delete
- RBAC
- panel konfigurasi MC12
- activity log
