<?php
session_start();
include '../config/config.php'; // Pastikan Anda sudah mengatur koneksi database
include 'header_admin.php';

// Cek apakah pengguna sudah login
// Periksa apakah pengguna sudah login dan memiliki level admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    echo '<script type="text/javascript">
            window.location.href = "/wisata-nusantara/logout.php";
          </script>';
    exit();
}


// Ambil data untuk ditampilkan di dashboard
$jumlah_destinasi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM destinations"))['total'];
$jumlah_pemesan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM bookings"))['total'];
$jumlah_pengguna = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
     <style>
        html, body {
    		height: 100%;
    		margin: 0;
		}

		body {
		    display: flex;
		    flex-direction: column;
		}

		.container {
		    flex: 1; /* Membuat kontainer utama mengisi ruang yang tersedia */
		}
		a {
			color: white;
			text-decoration: none;
		}
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Dashboard</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3" >
                    <div class="card-header"> <a href="destination.php">Jumlah Destinasi</a></div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $jumlah_destinasi; ?></h5>
                        <p class="card-text">Total destinasi yang tersedia.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header"> <a href="booking.php">Jumlah Pemesan</a></div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $jumlah_pemesan; ?></h5>
                        <p class="card-text">Total pemesan yang telah melakukan pemesanan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header"><a href="datauser.php">Jumlah Pengguna</a></div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $jumlah_pengguna; ?></h5>
                        <p class="card-text">Total pengguna yang terdaftar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>