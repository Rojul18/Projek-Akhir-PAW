<?php
// Mulai sesi dan panggil koneksi database
session_start();
include '../config/config.php';
include '../includes/header.php';

if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn ->query($sql);
    $user = $result->fetch_assoc();

    if (empty($user)) {
        header('Location: ../logout.php');
    }
}



// Ambil ID destinasi dari URL
if (isset($_GET['destination_id']) && is_numeric($_GET['destination_id'])) {
    $destination_id = $_GET['destination_id'];
    $sql = "SELECT * FROM destinations WHERE id = $destination_id";
    $result = $conn->query($sql);
    $destination = $result->fetch_assoc();

    if (!$destination) {
        echo "<p class='text-center mt-5'>Destinasi tidak ditemukan.</p>";
        include '../includes/footer.php';
        exit;
    }
} else {
    echo "<p class='text-center mt-5'>ID destinasi tidak valid.</p>";
    exit;
}

// Proses pengiriman formulir
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $travel_date = $_POST['travel_date'];
    $num_people = $_POST['num_people'];
    $ticket_type = $_POST['ticket_type'];

    $stmt = $conn->prepare("INSERT INTO bookings (destination_id, name, email, phone, travel_date, num_people, ticket_type) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssis", $destination_id, $name, $email, $phone, $travel_date, $num_people, $ticket_type);

    if ($stmt->execute()) {
        echo "<p class='text-center mt-5 text-success'>Pemesanan berhasil disimpan!</p>";
    } else {
        echo "<p class='text-center mt-5 text-danger'>Terjadi kesalahan saat menyimpan pemesanan. Silakan coba lagi.</p>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Perjalanan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
         }
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .content-box {
            background-color: rgba(255, 255, 255, 0.9); /* Latar belakang putih dengan sedikit transparansi */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <main>
        <div class="container mt-5">
            <div class="content-box">
                <h1 class="text-center">Pesan Perjalanan</h1>
                <p class="text-center">Isi formulir di bawah ini untuk memesan perjalanan ke <strong><?php echo htmlspecialchars($destination['name']); ?></strong>.</p>
                <form method="POST" class="mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" disabled value="<?php echo $user['email'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="phone" name="phone" disabled value="<?php echo $user['no_telp'] ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="travel_date" class="form-label">Tanggal Perjalanan</label>
                                <input type="date" class="form-control" id="travel_date" name="travel_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="num_people" class="form-label">Jumlah Orang</label>
                                <input type="number" class="form-control" id="num_people" name="num_people" min="1" required>
                            </div>
                            <div class="mb-3">
                                <label for="ticket_type" class="form-label">Jenis Tiket</label>
                                <select name="ticket_type" required>
                                    <option value="">Pilih Jenis Tiket</option>
                                    <option value="Reguler">Paket Reguler</option>
                                    <option value="Hemat">Paket Hemat</option>
                                    <option value="VIP">Paket VIP</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Pesan Sekarang</button>
                </form>
            </div>
        </div>
    </main>
    <?php
    $conn->close();
    ?>
</body>
</htm