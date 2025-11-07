<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Konfigurasi Database
$host = "localhost";
$user = "root";
$pass = "EST.1106";
$database = "incleen";

// Koneksi ke database
$db = new mysqli($host, $user, $pass, $database);

// Cek koneksi
if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}

$baseUrl = "http://localhost/incleen/landingpage";
$baseImagePath = "$baseUrl/uploads/incleen/produk/";
?>