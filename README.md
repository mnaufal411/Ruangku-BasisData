# Ruangku-BasisData
Project ini bertujuan untuk membuat suatu aplikasi berbasis web yang digunakan untuk mengelola sewa ruang meeting oleh UMKM Ruangku.
## Ketentuan penggunaan aplikasi:
UMKM “Ruangku”, yang membutuhkan aplikasi ini, memiliki beberapa ruang meeting untuk disewakan kepada publik. Lama sewa minium 2 jam. Tiap ruang memiliki kapasitas (jumlah tempat duduk) yang bervariasi (antara 7 s.d 20). Terdapat juga alat meeting untuk disewakan (komputer, proyektor, dll).  Pada masalah yang disederhanakan ini, Pelanggan tidak boleh memesan (booking) terlebih dahulu, tapi hanya boleh memesan kepada Operator pada saat orang(-orang) yang mau melakukan meeting sudah datang ke gedung Ruangku. Pada saat transaksi pemesanan dilakukan, Pelanggan menyampaikan waktu mulai dan akhir dari meeting, kapasitas ruang yang akan disewa, dan alat yang akan disewa. Operator lalu akan mencarikan ruang dan alat yang sesuai dari aplikasi, jika  yang dicari tidak ditemukan akan memberikan info dan memberikan opsi (pilihan lain) ke Pelanggan. Jika sudah setuju, Operator akan merekam transaksi dan Pelanggan melunasi pembayaran di depan.  
## Fitur-fitur PL: 
### Bagi Admin: 
1) Mengelola (create/insert/-read/show-update-delete → CRUD) data user (Operator dan Manajer) 
2) Mengelola data ruang-ruang 
3) Mengelola data alat-alat.  
### Bagi Operator: 
1) Mencari/melihat informasi alat-alat, termasuk ketersediaan setiap alat yang tersedia untuk disewa pada waktu tertentu. 
2) Mencari/melihat informasi ruang-ruang, termasuk ketersediaan setiap ruang yang tersedia untuk disewa pada waktu tertentu. 
3) Memproses/merekam transaksi penyewaan ruang dan alat, dengan merekam no HP, nama pelanggan, ruangan, alat yang disewa, jam mulai dan jam berakhir penyewaan. 
### Bagi Manajer: 
1) Mengelola tarf sewa ruangan dan alat. 
2) Melihat informasi ruang dan alat. 
3) Melihat laporan transaksi harian dan perioda tertentu (dari tanggal tertentu sampai tanggal tertentu). 
4) Melihat statistik (grafik) okupansi ruang dan pendapatan dari ruang pada perioda tertentu (dari tanggal tertentu sampai tanggal tertentu). 
5) Melihat statistik (grafik) penyewaan alat dan pendapatannya pada perioda tertentu (dari tanggal tertentu sampai tanggal tertentu). 
## Data yang dikelola a.l.: 
1) Pengguna (Operator dan Manajer) 
2) Ruang (termasuk kapasitas dan kondisinya) 
3) Alat 
4) Tarif 
5) Pelanggan 
6) Transaksi penyewaan ruang dan alat.
