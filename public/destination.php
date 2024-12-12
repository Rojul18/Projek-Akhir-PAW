<?php
// Mulai sesi dan panggil koneksi database
session_start();
include '../config/config.php';
include '../includes/header.php';

// Ambil ID destinasi dari URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    // Query untuk mendapatkan detail destinasi
    $sql = "SELECT * FROM destinations WHERE id = $id";
    $result = $conn->query($sql);
    $destination = $result->fetch_assoc();

    if (!$destination) {
        echo "<p class='text-center mt-5'>Destinasi tidak ditemukan.</p>";
        exit;
    }
} else {
    echo "<p class='text-center mt-5'>ID destinasi tidak valid.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($destination['name']); ?> - Wisata Nusantara</title>
    <link rel="icon" type="image/jpg" href="../assets/img/bromo.jpg">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Contoh Bootstrap -->
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        main {
            background: linear-gradient(rgba(0, 0, 0, 0.5), #00000080), url('https://rakyatjambi.co/wp-content/uploads/2017/02/wayag.jpg') no-repeat center center / cover;
            padding-top: 56px;
            min-height: 100%;
        }
        .content-box {
            background-color: rgba(255, 255, 255, 0.9); /* Latar belakang putih dengan sedikit transparansi */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .ticket-card {
            border: 1px solid #007bff; /* Warna border */
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            background-color: rgba(255, 255, 255, 0.8); /* Latar belakang kotak tiket */
            height: 270px;
        }
    </style>
</head>
<body>

<main>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 content-box">
                <div class="row">
                    <div class="col-md-6">
                        <img src="../<?php echo htmlspecialchars($destination['image_url']); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($destination['name']); ?>">
                    </div>
                    <div class="col-md-6">
                        <h1><?php echo htmlspecialchars($destination['name']); ?></h1>
                        <p class="text-muted">Kategori: <?php echo htmlspecialchars($destination['category']); ?></p>
                        <p><?php echo nl2br(htmlspecialchars($destination['description'])); ?></p>
                        <a href="booking.php?destination_id=<?php echo $destination['id']; ?>" class="btn btn-primary mt-3">Pesan Sekarang</a>
                    </div>
                </div>

                <!-- Tipe Tiket -->
            <div class="mt-4">
            <h3>Tipe Tiket</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="ticket-card">
                        <h5>Tiket Normal</h5>
                        <p>Yang Didapat:</p>
                        <ul>
                            <li>Tiket Masuk ke Gili Labak</li>
                            <li>Parkir</li>
                            <li>Sewa Perahu</li>
                        </ul>
                        <div class="price">Rp 110.000</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ticket-card">
                        <h5>Tiket VIP</h5>
                        <p>Yang Didapat:</p>
                        <ul>
                            <li>Tiket Masuk ke Gili Labak</li>
                            <li>Parkir</li>
                            <li>Sewa Perahu</li>
                            <li>Snack dan Minuman</li>
                        </ul>
                        <div class="price">Rp 200.000</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ticket-card">
                        <h5>Tiket Keluarga</h5>
                        <p>Yang Didapat:</p>
                        <ul>
                            <li>Tiket Masuk ke Gili Labak</li>
                            <li>Parkir</li>
                            <li>Sewa Perahu</li>
                            <li>Diskon 10% untuk 4 orang</li>
                        </ul>
                        <div class="price">Rp 400.000</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>