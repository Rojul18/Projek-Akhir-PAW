<?php
include '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /wisata-nusantara/login.php");
    exit();
}

$username = $_SESSION['name'];

$user_query = "SELECT name FROM users WHERE name = '$username'";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_result);
$nama_user = $user_data['name'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Nusantara</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <style>
        /* Custom Navbar Styling */
        .navbar {
            background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
            color: white;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: white;
        }

        .navbar-brand:hover {
            color: #ffd700;
        }

        .nav-link {
            color: white;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: #ffd700;
        }

        .dropdown-menu {
            background: #f8f9fa;
        }

        .dropdown-item:hover {
            background: #6a11cb;
            color: white;
        }

        .user-icon {
            margin-right: 8px;
            font-size: 1.2rem;
        }

        .navbar-toggler {
            border: none;
            outline: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
    </style>
</head>
<body>
    <!-- Navbar/Header -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">Wisata Nusantara</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="destination.php">Data Destinasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="booking.php">Data Pemesan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="datauser.php">Data Pengguna</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-lg-3">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle user-icon"></i><?php echo $nama_user;?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="/wisata-nusantara/logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS dan dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Debugging dropdown
        $(document).ready(function() {
            $('.dropdown-toggle').dropdown();
            
            // Log debugging information
            console.log('Dropdown initialized');
            
            $('.dropdown-toggle').on('click', function() {
                console.log('Dropdown clicked');
                $(this).next('.dropdown-menu').toggle();
            });
        });
    </script>
</body>
</html>