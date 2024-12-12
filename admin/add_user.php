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




// Proses penambahan pengguna
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $no_telp = $_POST['no_telp'];
    $level = $_POST['level'];

    $sql = "INSERT INTO users (name, email, password, no_telp, level) VALUES ('$name', '$email', '$password', '$no_telp', '$level')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Pengguna berhasil ditambahkan.'); window.location.href='users.php';</script>";
        exit;
    } else {
        echo "<p class='text-center text-danger mt-5'>Terjadi kesalahan saat menambahkan pengguna.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah Pengguna</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="no_telp" class="form-label">No Telepon</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" required>
            </div>
            <div class="mb-3">
                <label for="level" class="form-label">Level</label>
                <select class="form-select" id="level" name="level" required>
                    <option value="admin">Admin</option>
                    <option value="user">User </option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
            <a href="datauser.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>