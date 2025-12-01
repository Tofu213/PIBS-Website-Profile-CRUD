<?php
/* ================================
   KONFIGURASI KONEKSI DATABASE
   ================================ */

$host = "localhost";
$user = "root";       // default XAMPP
$pass = "";           // default XAMPP (kosong)
$db   = "database_profil"; // nama database kamu

// Coba koneksi
$DB = new mysqli($host, $user, $pass, $db);

// Cek error
if ($DB->connect_error) {
    die("Koneksi ke database gagal: " . $DB->connect_error);
}

// Agar teks UTF-8 lancar
$DB->set_charset("utf8mb4");
?>
