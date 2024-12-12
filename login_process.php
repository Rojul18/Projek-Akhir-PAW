<?php
session_start();
include 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil input dari form
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Query untuk mendapatkan user berdasarkan email
    $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password menggunakan password_verify
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['level'] = $user['level'];
            // Pastikan kolom sesuai dengan database Anda
            
            // Redirect berdasarkan level pengguna
            if (isset($user['level']) && $user['level'] === 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: public/index.php");
            }
            exit();
        } else {
            // Jika password salah
            header("Location: login.php?error=Password salah.");
            exit();
        }
    } else {
        // Jika email tidak ditemukan
        header("Location: login.php?error=Email tidak ditemukan.");
        exit();
    }
}

// Jika akses langsung ke halaman ini
header("Location: login.php");
exit();
?>
