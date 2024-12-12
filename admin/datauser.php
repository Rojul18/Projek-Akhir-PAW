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


// Proses hapus pengguna jika ada permintaan
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete_sql = "DELETE FROM users WHERE id = $id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Pengguna berhasil dihapus.'); window.location.href='users.php';</script>";
        exit;
    } else {
        echo "<p class='text-center text-danger mt-5'>Terjadi kesalahan saat menghapus pengguna.</p>";
    }
}

// Ambil semua data pengguna
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .page-container {
            flex: 1;
        }
        footer {
            background-color: #343a40; /* Warna latar belakang footer */
            color: white; /* Warna teks footer */
            text-align: center; /* Teks rata tengah */
            padding: 1rem; /* Padding untuk footer */
        }
    </style>
</head>
<body>
    <main class="page-container">
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Data Pengguna</h2>
                <!-- Tombol Tambah Pengguna -->
                <a href="add_user.php" class="btn btn-success">Tambah Pengguna</a>
            </div>

            <!-- Tabel Data Pengguna -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No Telepon</th>
                        <th>Tanggal Dibuat</th>
                        <th>Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['no_telp']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td><?php echo htmlspecialchars($row['level']); ?></td>
                                <td class="d-flex gap-2">
                                    <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="users.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pengguna ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pengguna.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>