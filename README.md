<img width="434" height="180" alt="Screenshot 2025-11-05 at 07 33 55" src="https://github.com/user-attachments/assets/4e27d97e-2b29-43f9-8bb5-765b26fedb49" />

# Overall Description

## Product Description 

### 1.1.1	Latar belakang
Bisnis dessert dengan sistem Pre-Order (PO) menjadi salah salah satu tren usaha yang banyak digeluti karena lebih fleksibel, minim risiko, dan tidak membutuhkan modal besar untuk stok barang. Namun, dalam praktiknya masih terdapat berbagai permasalahan yang dialami baik penjual maupun pembeli.

Dari sisi penjual, permasalahan yang muncul antara lain kesulitan melakukan pembayaran di muka, ketersediaan bahan baku, serta strategi promosi yang masih terbatas dan kurang menarik bagi pelanggan. Hal ini berdampak pada rendahnya keterlibatan konsumen serta kurang efisiennya pengelolaan pesanan. Dari sisi pembeli, terdapat tantangan utama seperti keterbatasan waktu pemesanan, ketakutan tertinggal tren dessert viral, kekhawatiran pesanan tidak segera sampai, hingga kesulitan dalam perubahan pesanan yang masih dilakukan secara manual. Selain itu, ketidakjelasan biaya tambahan dan metode pembayaran yang tidak menentu semakin menurunkan kenyamanan bertransaksi.

Permasalahan-permasalahan tersebut menunjukkan bahwa masih ada gap yang cukup besar dalam sistem jual-beli dessert berbasis PO. Dibutuhkan sebuah solusi digital yang dapat mengakomodasi kebutuhan seller dalam promosi dan operasional, sekaligus memberikan pengalaman berbelanja yang nyaman, efisien, dan menyenangkan bagi buyer.

### 1.1.2	Tujuan
Oleh sebab itu, kami hendak mengembangkan sebuah aplikasi sistem jual-beli dessert berbasis PO bernama MystiCake dengan tujuan sebagai berikut:
* Membantu penjual dalam membuat dan mengelola konten promosi dengan template yang relevan dan menarik, sehingga penjual tidak perlu memikirkan ide promosi dari nol, memangkas waktu dan energi dalam proses kreatif, serta menjaga kualitas kontennya tetap menarik.
* Memberikan notifikasi real time kepada pembeli terkait jadwal pembukaan, penutupan, serta ketersediaan stok PO, sehingga pembeli tidak lagi khawatir ketinggalan informasi atau kehilangan kesempatan membeli dessert yang sedang tren.
* Menyediakan fitur pemesanan sederhana dengan alur yang jelas dan metode pembayaran yang fleksibel, sehingga, proses transaksi menjadi lebih praktis, transparan, dan nyaman bagi pembeli maupun penjual.

### 1.1.3	Manfaat
Dengan demikian, diharapkan bahwa:

**Bagi Penjual**
* Lebih mudah membuat promosi yang konsisten dan menarik
* Pengelolaan pesanan dan stok lebih efisien.
* Risiko kelebihan atau kekurangan stok dapat diminimalkan.

**Bagi Pembeli**
* Selalu update dengan informasi PO.
* Mendapatkan pengalaman pemesanan yang cepat, sederhana, dan menyenangkan.
* Memiliki pilihan metode pembayaran yang beragam dan jelas.

**Secara Umum:**
* Tercipta ekosistem transaksi PO yang modern, efisien, dan responsif.
* Pengalaman jual-beli menjadi lebih nyaman, menarik, dan berkesinambungan.

## Product Features

Aplikasi MystiCake memiliki beberapa fitur utama sebagai berikut

**Mystery Box Page (Regular & Premium)**
Fitur pembelian produk secara acak sesuai kategori masing-masing. Produk-produk terbagi ke berbagai kategori kelangkaan dengan persentase yang berbeda-beda. 

**Recommendation Page**
Halaman yang berisi produk-produk yang dipersonalisasi sesuai kebiasaan pengguna. Toko dan produk sejenis yang sering dikunjungi akan muncul lebih sering di halaman ini.

**Search Page**
Halaman pencarian untuk produk atau toko dengan kata kunci yang dimasukkan oleh pengguna melalui masukan keyboard. Daftar produk dengan nama yang paling mendekati kata kunci akan ditampilkan pada hasil pencarian.

**Chat with Seller**
Halaman untuk mengirim pesan kepada pelanggan. Halaman ini berisi daftar seller yang pernah dihubungi. Pengguna dapat mengirim gambar dan file kepada seller.

**Cashback Bonus Page (After Mystery Box purchase)**
Setelah melakukan pembelian mystery box, pengguna mendapatkan cashback untuk produk yang didapatkan. Cashback dapat diambil langsung atau disimpan untuk digunakan nanti.

**Profile & Setting Page**
Halaman untuk mengatur dan menyesuaikan pengaturan menurut kenyamanan pengguna. Mulai dari sistem hingga profil pengguna.

**Product Page**
Halaman produk beserta detail dan deskripsinya.

**Shopping Cart Page**
Halaman yang menunjukkan barang-barang dan total harga barang yang akan dibeli.

**Topup Page**
Halaman pembelian mata uang pada aplikasi dari transaksi tunai

**Payment Page**
Halaman pembayaran barang di shopping cart atau barang per unit dengan mata uang aplikasi.

**Gacha History Page**
Histori pembelian mystery box dan hasil yang didapat pengguna.

**Shopping History Page**
Histori transaksi pembelian shopping cart milik pengguna

**Rating Page**
Halaman pemberian rating terhadap barang/produk yang dijual oleh toko

## High-Level Functional Requirements

| Code | Fitur | Deskripsi |
| :--- | :--- | :--- |
| FR01 | Sistem harus memungkinkan pengguna untuk membuat akun dan melakukan autentikasi (registrasi, login, logout). | |
| FR02 | Sistem harus menyediakan katalog produk dessert yang dapat dilihat, dicari, dan difilter oleh pengguna. | |
| FR03 | Sistem harus memfasilitasi pengelolaan profil pengguna, termasuk riwayat pembelian dan pencapaian gamifikasi. | |
| FR04 | Sistem harus memungkinkan pengguna untuk mengelola keranjang belanja sebelum melakukan checkout. | |
| FR05 | Sistem harus menyediakan fitur gamifikasi gacha yang memberikan dessert spesial, diskon, atau hadiah virtual sebagai bentuk reward. | |
| FR06 | Sistem harus memungkinkan pengguna untuk menukarkan hadiah gacha dengan produk atau voucher sesuai ketentuan. | |
| FR07 | Sistem harus menyediakan notifikasi terkait status pesanan, promosi, atau hasil gacha. | |
| FR08 | Sistem harus memberikan akses bagi admin untuk mengelola produk dessert, termasuk stok, harga, dan deskripsi. | |
| FR09 | Sistem harus menyediakan laporan penjualan dan aktivitas gacha bagi admin untuk mendukung pengambilan keputusan. | |
| FR10 | Sistem harus mendukung ulasan dan rating pengguna terhadap dessert untuk meningkatkan kepercayaan dan pengalaman pengguna. | |
| FR11 | Sistem harus menjamin keamanan transaksi dan data pengguna melalui enkripsi dan manajemen hak akses. | |
| FR12 | Mystery Box Page (Regular & Premium) | Sistem harus menyediakan halaman Mystery Box (Regular dan Premium) yang memungkinkan pengguna melakukan pembelian dengan mudah. |
| FR13 | Recommendation Page | Sistem harus menampilkan rekomendasi produk yang relevan untuk meningkatkan keterlibatan dan penjualan. |
| FR14 | Search Page | Sistem harus memungkinkan pengguna mencari produk berdasarkan kata kunci atau kategori agar memudahkan pencarian. |
| FR15 | Chat with Seller | Sistem harus memfasilitasi komunikasi langsung antara pembeli dan penjual melalui fitur chat. |
| FR16 | Cashback Bonus Page (After Mystery Box purchase) | Sistem harus memberikan informasi cashback kepada pengguna setelah pembelian Mystery Box untuk meningkatkan loyalitas. |
| FR17 | Profile & Setting Page | Sistem harus mengizinkan pengguna mengelola profil dan pengaturan akun sesuai kebutuhan mereka. |
| FR18 | Product Page | Sistem harus menyediakan halaman detail produk untuk membantu pengguna membuat keputusan pembelian. |
| FR19 | Shopping Cart Page | Sistem harus memfasilitasi pengguna dalam meninjau, mengubah, dan melanjutkan pesanan sebelum pembayaran. |
| FR20 | Topup Page | Sistem harus memungkinkan pengguna melakukan top-up saldo agar dapat digunakan untuk transaksi |
| FR21 | Payment Page | Sistem harus menyediakan berbagai metode pembayaran untuk mendukung kelancaran transaksi. |
| FR22 | Gacha History Page | Sistem harus menampilkan riwayat pembelian Mystery Box agar pengguna dapat meninjau hasil transaksi sebelumnya. |
| FR23 | Shopping History Page | Sistem harus menyimpan dan menampilkan riwayat belanja pengguna untuk memudahkan pelacakan transaksi. |
| FR24 | Rating Page | Sistem harus menyediakan fitur penilaian dan ulasan agar pengguna dapat memberikan feedback terhadap produk. |
