# Task Manager

CV atau Resume    : https://shorturl.at/BEwnQ

Detail Portofolio : https://shorturl.at/ZbnPc

Aplikasi ini adalah sistem manajemen tugas sederhana yang memiliki fitur CRUD menggunakan Laravel sebagai backend dan AJAX untuk interaksi frontend.

#### Backend

##### 1. Model & Migrasi Database

Tabel `tasks` memiliki struktur sebagai berikut:

- `id` (integer, primary key, auto-increment)
- `title` (string, max 255, wajib diisi)
- `description` (text, opsional)
- `is_completed` (boolean, default false)
- `created_at` dan `updated_at` (timestamps)

##### 2. API Endpoints

| Method | Endpoint          | Deskripsi                       |
| ------ | ----------------- | ------------------------------- |
| GET    | `/api/tasks`      | Mengambil semua daftar tugas    |
| POST   | `/api/tasks`      | Menambahkan tugas baru          |
| PUT    | `/api/tasks/{id}` | Mengupdate tugas berdasarkan ID |
| DELETE | `/api/tasks/{id}` | Menghapus tugas berdasarkan ID  |

##### 3. Validasi Backend

- `title` wajib diisi dengan maksimal 255 karakter.
- `description` opsional.
- `is_completed` harus berupa boolean.

##### 4. Response JSON Format

```json
{
  "status": "success",
  "message": "Deskripsi pesan",
  "data": {...}
}
```

#### Frontend

##### 1. Tampilan Utama

- Tabel daftar tugas.
- Tombol "Add Task" untuk menambah tugas baru.
- Tombol "Edit" dan "Delete" untuk mengubah atau menghapus tugas.

##### 2. Fitur CRUD

- **Create**: Form untuk menambah tugas baru.
- **Read**: Mengambil daftar tugas dari API.
- **Update**: Edit tugas melalui modal/form yang telah terisi sebelumnya.
- **Delete**: Hapus tugas dengan konfirmasi sebelum menghapus.

##### 3. Interaksi Asinkron

Menggunakan AJAX untuk semua operasi CRUD tanpa reload halaman. Setelah operasi berhasil, daftar tugas diperbarui secara otomatis.

##### 4. Desain Sederhana

Menggunakan **Bootstrap** untuk styling.

### Bukti Pengerjaan

Setiap fitur yang telah dikerjakan disertai dengan screenshot hasil implementasi:

1. **Model & Migrasi Database**  
   ![Model & Migrasi](./screenshots/model_migrasi.png)

2. **API Endpoints**
   - GET `/api/tasks`  
     ![GET Tasks](./screenshots/get_tasks.png)
   - POST `/api/tasks`  
     ![POST Task](./screenshots/post_task.png)
   - PUT `/api/tasks/{id}`  
     ![PUT Task](./screenshots/put_task.png)
   - DELETE `/api/tasks/{id}`  
     ![DELETE Task](./screenshots/delete_task.png)

3. **Validasi Backend**  
   ![Validasi Backend 1](./screenshots/validasi_backend.png)

4. **Tampilan Frontend**  
   ![Tampilan Frontend](./screenshots/frontend.png)


---

### Cara Menjalankan Proyek

1. Clone repositori:

2. Install dependencies:
   ```sh
   composer install
   npm install
   ```
3. Konfigurasi **.env** dan jalankan migrasi:
   ```sh
   cp .env.example .env
   php artisan migrate
   ```
4. Jalankan server backend:
   ```sh
   php artisan serve
   ```
5. Akses di browser menggunakan localhost

---

### Teknologi yang Digunakan

- **Backend**: Laravel
- **Frontend**: JavaScript (AJAX, Bootstrap)
- **Database**: MySQL, PHPmyadmin

---

### Lisensi

MIT License

