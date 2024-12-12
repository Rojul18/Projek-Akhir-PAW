<?php
session_start();
include '../config/config.php';
include 'header_admin.php';


if (!isset($_SESSION['user_id']) || !isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    echo '<script type="text/javascript">
            window.location.href = "/wisata-nusantara/logout.php";
          </script>';
    exit();
}


// Ambil ID pengguna dari URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    // Proses pembaruan pengguna
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $no_telp = $_POST['no_telp'];
        $level = $_POST['level'];

        // Jika password diisi, update password
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql = "UPDATE users SET name='$name', email='$email', password='$password', no_telp='$no_telp', level='$level' WHERE id=$id";
        } else {
            $sql = "UPDATE users SET name='$name', email='$email', no_telp='$no_telp', level='$level' WHERE id=$id";
        }

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Pengguna berhasil diperbarui.'); window.location.href='users.php';</script>";
            exit;
        } else {
            echo "<p class='text-center text-danger mt-5'>Terjadi kesalahan saat memperbarui pengguna.</p>";
        }
    }
} else {
    echo "<p class='text-center text-danger mt-5'>ID pengguna tidak ditemukan.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Pengguna</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password (kosongkan jika tidak ingin mengubah)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="no_telp" class="form-label">No Telepon</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo htmlspecialchars($user['no_telp']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="level" class="form-label">Level</label>
                <select class="form-select" id="level" name="level" required>
                    <option value="admin" <?php echo $user['level'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="user" <?php echo $user['level'] == 'user' ? 'selected' : ''; ?>>User </option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Perbarui Pengguna</button>
            <a href="datauser.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>