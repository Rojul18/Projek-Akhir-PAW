<?php
// Mulai sesi dan panggil koneksi database
session_start();
include '../config/config.php';
include '../includes/header.php';

// Ambil data destinasi dari database
$sql = "SELECT * FROM destinations LIMIT 6";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Jelajahi keindahan Indonesia bersama Wisata Nusantara. Temukan destinasi terbaik untuk liburan Anda.">
    <meta name="author" content="Wisata Nusantara">
    <title>Wisata Nusantara</title>
    <style>
        main{
            background: url('https://rakyatjambi.co/wp-content/uploads/2017/02/wayag.jpg') no-repeat center center / cover;
            padding-top: 56px
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <main style=";">
        <div class="container mt-0">
            <h1 class="text-center mb-4">Selamat Datang di Wisata Nusantara</h1>
            <p class="text-center">Jelajahi keindahan Indonesia bersama kami. Temukan destinasi terbaik untuk liburan Anda.</p>
            
            <div class="row mt-5">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="../' . $row['image_url'] . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">
                                <div class="card-body">
                                    <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                                    <p class="card-text">' . htmlspecialchars(substr($row['description'], 0, 100)) . '...</p>
                                    <a href="destination.php?id=' . $row['id'] . '" class="btn btn-primary">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                } else {
                    echo '<p class="text-center">Belum ada destinasi yang tersedia.</p>';
                }
                ?>
            </div>
        </div>
    </main>
    <!-- Tambahkan link JS (Bootstrap, script.js, dll.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
   
</html>
<?php
$conn->close();
?>
