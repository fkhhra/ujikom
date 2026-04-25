# Trivo - Expedition Management System

Trivo adalah platform manajemen ekspedisi modern berbasis fullstack yang dirancang untuk efisiensi pengiriman paket, mulai dari input di kasir hingga tracking real-time oleh pelanggan.

---

## 🚀 Fitur Utama

### 🛠️ Admin & Manager
*   **Manajemen Cabang & Tarif:** Kelola master data cabang dan setting tarif pengiriman antar kota.
*   **Manajemen User:** Administrasi akun Admin, Manajer, Kasir, dan Kurir.
*   **Oversight Pengiriman:** Memantau seluruh paket, membatalkan resi, dan mengassign kurir ke paket tertentu.
*   **Pelaporan:** Dashboard statistik dan fitur ekspor laporan pengiriman/pendapatan.

### 💰 Kasir
*   **Input Pengiriman:** Form input paket cepat dengan integrasi barcode.
*   **Sistem Pembayaran:** Mendukung pembayaran tunai (Cash) dan otomatis cetak struk/resi (Waybill).
*   **Penerimaan Paket:** Scan barcode saat paket tiba di cabang untuk update status secara kolektif.

### 🚚 Kurir
*   **Dashboard Pengantaran:** Daftar paket yang harus diantar ke penerima.
*   **Update Status Real-time:** Fitur foto bukti kirim dan update status "Terkirim" langsung dari lapangan.

### 👤 Pelanggan
*   **Dashboard Personal:** Memantau daftar paket keluar (dikirim) dan paket masuk (diterima) secara terpisah.
*   **Pembayaran Online:** Integrasi Midtrans untuk pembayaran via QRIS, GoPay, dan Virtual Account.
*   **Tracking Detail:** Riwayat perjalanan paket yang detail dan transparan.

---

## 🛠️ Tech Stack

*   **Framework:** [Laravel 13](https://laravel.com)
*   **PHP Version:** 8.4 (Optimized for Docker)
*   **Frontend:** Tailwind CSS 4.0 + Flowbite (Premium UI)
*   **Database:** MySQL 8.4
*   **Integration:** Midtrans Core API (Payment Gateway)
*   **Icons:** Lucide Icons
*   **Containerization:** Docker & Docker Compose

---

## 📦 Instalasi & Menjalankan Proyek

Pastikan Anda sudah menginstal **Docker** dan **Docker Compose** di sistem Anda.

1.  **Clone Repositori:**
    ```bash
    git clone https://github.com/Fruzh/trivo.git
    cd trivo
    ```

2.  **Konfigurasi Environment:**
    ```bash
    cp .env.example .env
    ```

3.  **Build & Jalankan Container:**
    ```bash
    docker compose up -d --build
    ```

4.  **Install Dependensi & Reset Database:**
    ```bash
    docker exec trivo_app composer install
    docker exec trivo_app php artisan migrate:fresh --seed --force
    ```

5.  **Akses Aplikasi:**
    Buka `http://localhost:8000` di browser Anda.

---

## 🔑 Akun Default (Testing)

Semua akun di bawah menggunakan password: `password`

### 🏢 Staff (Akses via `/staff/login`)

| Role | Nama | Email | Cabang |
| :--- | :--- | :--- | :--- |
| **Admin** | Super Admin | `admin@trivo.id` | Pusat |
| **Manager** | Budi Santoso | `manager.jkt@trivo.id` | Jakarta |
| **Manager** | Sari Dewi | `manager.bdg@trivo.id` | Bandung |
| **Manager** | Hendra Wijaya | `manager.sby@trivo.id` | Surabaya |
| **Kasir** | Rina Kasir | `kasir1.jkt@trivo.id` | Jakarta |
| **Kasir** | Wati Kasir | `kasir1.bdg@trivo.id` | Bandung |
| **Kurir** | Zaki Kurir | `kurir1.jkt@trivo.id` | Jakarta |
| **Kurir** | Gilang Kurir | `kurir1.bdg@trivo.id` | Bandung |

### 👤 Pelanggan (Akses via `/login`)

| Nama | Email | Kota |
| :--- | :--- | :--- |
| Ahmad Fauzi | `ahmad@example.com` | Jakarta |
| Siti Rahayu | `siti@example.com` | Bandung |
| Budi Prakoso | `budi@example.com` | Surabaya |
| Dewi Lestari | `dewi@example.com` | Yogyakarta |

---

## 📂 Struktur Penting (Backend)

*   `app/Http/Controllers/Admin/`: Logika manajemen platform.
*   `app/Http/Controllers/Cashier/`: Logika transaksi loket dan pembayaran tunai.
*   `app/Http/Controllers/Courier/`: Logika update status pengiriman lapangan.
*   `app/Http/Controllers/Customer/`: Dashboard dan payment gateaway pelanggan.
*   `app/Models/Shipment.php`: Inti dari sistem (Tracking Number, Status, Relationships).
