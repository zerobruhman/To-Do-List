# To-Do List App

Aplikasi To-Do List sederhana berbasis PHP Native menggunakan pola MVC (Model View Controller), MySQL, Session Authentication, dan CSRF Protection.

## Fitur

* Login & Logout User
* Menambah To-Do
* Melihat Daftar To-Do
* Proteksi CSRF
* Data Todo terpisah untuk setiap user
* Struktur MVC sederhana

---

## Teknologi yang Digunakan

* PHP 8+
* MySQL
* HTML
* CSS 
* MVC Architecture
* Session Authentication

---

## Alur MVC

### Model

Bertugas berkomunikasi dengan database.

Contoh method:

```php
getAll(int $user_id);
createTodo(int $user_id, string $judul, string $deskripsi = '');
findById(int $id);
update(array $todo_data);
updateStatus(int $id, string $status);
delete(int $id, int $user_id);
```

---

### Controller

Bertugas menerima request dari user.

Contoh method:
```php
index();
store();
toggleStatus();
deleteTodo();
updateTodo();
```

---

### View

Bertugas menampilkan data ke pengguna.

File:

```text
views/todo/index.php
views/todo/edit.php
```

---

## Keamanan

### CSRF Protection

Semua form menggunakan token CSRF.

Contoh:

```php
<?= CSRF::generateToken(); ?>
```

Verifikasi:

```php
CSRF::verifyCsrfToken();
```

---

### Ownership Check

User hanya bisa:

* Melihat todo miliknya sendiri

---

## Routing

Contoh routing pada `index.php`:

```php
switch ($action) {
        case "todo":
            $todo->index();
            break;
        case "todo-store":
            $todo->store();
            break;
        case "todo-toggle":
            $todo->toggleStatus();
            break;
        case "todo-delete":
            $todo->deleteTodo();
            break;
        case "todo-edit":
            $todo->updateTodo();
            break;
            //hanya bisa lewat method POST!
}
```

---

## Tujuan Project

Project ini dibuat untuk belajar:

* Update & Delete
* Front End Basic
* MVC Pattern
* CRUD
* Session Login
* CSRF Protection
* Relasi Database
* OOP Dasar
* Struktur Project Backend
* Persiapan Menuju Laravel

---

## Pengembangan Selanjutnya

Beberapa fitur yang mungkin bisa ditambahkan:

* Pagination
* Search Todo
* Filter Status
* Deadline Todo
* Reminder
* Light Mode
* REST API
* AJAX / Fetch API
* Upload Lampiran
* Multi Category Todo

---

## Note

Dibuat sebagai project latihan PHP MVC dan MySQL untuk meningkatkan kemampuan backend development.