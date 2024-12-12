<?php
// Mulai sesi dan panggil koneksi database
session_start();
include '../config/config.php';

// Cek apakah pengguna adalah admin
if (isset($_SESSION['user_id'])) {
    if ($role === 'admin') {
        header("Location: admin/index.php");
        exit;
    }else{
        header("Location: public/index.php");
    }
    
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus pemesanan dari database
    $sql = "DELETE FROM bookings WHERE id = $id";
    if ($conn->query($sql)) {
        echo "<p class='text-center mt-5 text-success'>Pemesanan berhasil dihapus.</p>";
    } else {
        echo "<p class='text-center mt-5 text-danger'>Terjadi kesalahan saat menghapus pemesanan.</p>";
    }
} else {
    echo "<p class='text-center mt-5'>ID pemesanan tidak valid.</p>";
}

echo "<p class='text-center mt-3'><a href='index.php'>Kembali ke Dashboard</a></p>";

$conn->close();
?>
