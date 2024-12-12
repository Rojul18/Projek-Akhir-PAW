<?php
include 'config/config.php'; // Koneksi database

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil input dan trim whitespace
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $no_telp = trim($_POST['no_telp']);

    // Validasi Nama
    if (empty($nama)) {
        $errors['nama'] = "Nama tidak boleh kosong.";
    } elseif (!preg_match("/^[a-zA-Z .]+$/", $nama)) {
        $errors['nama'] = "Nama hanya boleh berisi huruf dan spasi.";
    }

    // Validasi Email
    if (empty($email)) {
        $errors['email'] = "Email tidak boleh kosong.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Format email tidak valid.";
    }

    // Validasi Password
    if (empty($password)) {
        $errors['password'] = "Password tidak boleh kosong.";
    } elseif (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
        $errors['password'] = "Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol.";
    }

    // Validasi No Telp
    if (empty($no_telp)) {
        $errors['no_telp'] = "Nomor telepon tidak boleh kosong.";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $no_telp)) {
        $errors['no_telp'] = "Nomor telepon hanya boleh berisi angka dan panjang antara 10-15 digit.";
    }

    // Cek jika tidak ada error
    if (empty($errors)) {
        // Cek apakah email sudah terdaftar
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Jika email sudah ada, alihkan ke halaman login
            header('Location: login.php');
            exit;
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Query insert
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, no_telp) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama, $email, $hashed_password, $no_telp);

            if ($stmt->execute()) {
                $success = true; // Registrasi berhasil
            } else {
                die("Terjadi kesalahan: " . $stmt->error);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #2c3e50;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Roboto', sans-serif;
        }
        .login-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        .login-header {
            font-size: 1.5rem;
            font-weight: bold;
            color: #6a11cb;
        }
        .form-label {
            font-weight: 500;
        }
        .btn-primary {
            background: #6a11cb;
            border: none;
        }
        .btn-primary:hover {
            background: #2575fc;
        }
        .login-footer {
            color: #6a11cb;
            font-size: 0.9rem;
        }
        .login-footer a {
            color: #2575fc;
            text-decoration: none;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h3 class="login-header text-center mb-4">Form Register</h3>
        <?php if ($success): ?>
            <div class="alert alert-success">Registrasi berhasil! Silakan login.</div>
            <?php header('Location: login.php'); ?>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" name="nama" value="<?= htmlspecialchars($nama ?? '') ?>" placeholder="Masukkan nama Anda">
                <?php if (isset($errors['nama'])): ?>
                    <div class="invalid-feedback"><?= $errors['nama'] ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" name="email" value="<?= htmlspecialchars($email ?? '') ?>" placeholder="Masukkan email Anda">
                <?php if (isset($errors['email'])): ?>
                    <div class="invalid-feedback"><?= $errors['email'] ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" name="password" placeholder="Masukkan password Anda">
                <?php if (isset($errors['password'])): ?>
                    <div class="invalid-feedback"><?= $errors['password'] ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="no_telp" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control <?= isset($errors['no_telp']) ? 'is-invalid' : '' ?>" name="no_telp" value="<?= htmlspecialchars($no_telp ?? '') ?>" placeholder="Masukkan nomor telepon Anda">
                <?php if (isset($errors['no_telp'])): ?>
                    <div class="invalid-feedback"><?= $errors['no_telp'] ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        
        <div class="mt-3 text-center">
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
