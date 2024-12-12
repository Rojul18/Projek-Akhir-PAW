<?php
// Mulai sesi dan panggil koneksi database
session_start();
include '../config/config.php';
include 'header_admin.php';


if (!isset($_SESSION['user_id']) || !isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    echo '<script type="text/javascript">
            window.location.href = "/wisata-nusantara/logout.php";
          </script>';
    exit();
}


// Ambil daftar pemesanan dari database
$sql = "SELECT b.id, b.name, b.email, b.phone, b.travel_date, b.num_people, d.name AS destination, b.created_at, b.Status
        FROM bookings b
        JOIN destinations d ON b.destination_id = d.id
        ORDER BY b.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Halaman Dashboard Admin - Wisata Nusantara">
    <title>Dashboard Admin</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1 0 auto;
        }
        footer {
            flex-shrink: 0;
        }
    </style>
</head>
<body>
 <!-- Main Content -->
    <main class="page-container">
        <div class="container mt-5">
            <<div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Data Pemesan</h2>
                <!-- Tombol Tambah Pengguna -->
                <a href="add_booking.php" class="btn btn-success">Tambah pemesanan</a>
            </div>

            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Destinasi</th>
                        <th>Tanggal Perjalanan</th>
                        <th>Jumlah Orang</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "
                            <tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['destination']}</td>
                                <td>{$row['travel_date']}</td>
                                <td>{$row['num_people']}</td>
                                <td>{$row['Status']}</td>
                                <td>
                                    <a href='edit_booking.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete_booking.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Delete</a>
                                </td>
                            </tr>
                            ";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>Tidak ada pemesanan yang tersedia.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Tambahkan link ke file JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>
   