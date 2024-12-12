<?php
// Mulai sesi dan koneksi ke database
session_start();
include('../config/config.php');

// Mengecek apakah data pemesanan diterima
if (isset($_POST['submit_booking'])) {
    // Menangkap data dari form pemesanan
    $destination_id = mysqli_real_escape_string($conn, $_POST['destination_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $number_of_people = mysqli_real_escape_string($conn, $_POST['number_of_people']);
    $booking_date = mysqli_real_escape_string($conn, $_POST['booking_date']);

    // Menyimpan data pemesanan ke dalam tabel bookings
    $sql = "INSERT INTO bookings (destination_id, name, email, phone, number_of_people, booking_date) 
            VALUES ('$destination_id', '$name', '$email', '$phone', '$number_of_people', '$booking_date')";
    
    if (mysqli_query($conn, $sql)) {
        // Jika berhasil, arahkan ke halaman sukses
        $_SESSION['booking_success'] = 'Pemesanan Anda berhasil!';
        header('Location: booking_success.php');
    } else {
        // Jika gagal, tampilkan pesan error
        $_SESSION['booking_error'] = 'Terjadi kesalahan saat memproses pemesanan.';
        header('Location: booking.php');
    }
} else {
    // Jika tidak ada data yang dikirim, arahkan kembali ke halaman booking
    header('Location: booking.php');
}
?>
