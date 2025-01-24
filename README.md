# crud-php-ajax

Aplikasi web untuk mengelola gambar dengan fitur seperti menambahkan, mengedit, dan menghapus. Aplikasi ini menggunakan desain modern dan responsif serta terintegrasi dengan sistem backend.

## Fitur
- Menambahkan gambar dengan nama dan file upload.
- Mengedit detail gambar yang sudah ada (nama dan file).
- Menghapus gambar dengan konfirmasi.
- Desain responsif menggunakan Tailwind CSS.
- Integrasi backend menggunakan PHP dan MySQL dengan PDO.

## Teknologi yang Digunakan

### Front-End
- **HTML**: Untuk membuat struktur halaman web.
- **JavaScript**: Untuk menangani perilaku dinamis dan fungsi AJAX.
- **Tailwind CSS**: Untuk desain modern dan responsif.

### Back-End
- **PHP**: Untuk logika di sisi server.
- **AJAX**: Untuk komunikasi asinkron antara front-end dan back-end.
- **MySQL**: Untuk manajemen database.
- **PDO**: Untuk interaksi database yang aman.

## Instalasi

### Prasyarat
- Web server (contoh: Apache, Nginx).
- PHP 7.4 atau lebih tinggi.
- Database MySQL.
- Composer (opsional, jika menggunakan paket tambahan PHP).

### Langkah-Langkah
1. Clone repositori:
   ```bash
   git clone https://github.com/your-repo/image-management-dashboard.git

```project/
├── index.html        # File utama HTML
├── assets/           # Berisi CSS, JS, dan file aset lainnya
│   ├── css/
│   └── js/
├── uploads/          # Direktori untuk menyimpan gambar yang diupload
├── config.php        # Konfigurasi database
├── fetch_images.php  # Mengambil daftar gambar dari database
├── process_image.php # Memproses permintaan tambah/edit gambar
├── delete_image.php  # Memproses permintaan hapus gambar
└── README.md         # Dokumentasi proyek
