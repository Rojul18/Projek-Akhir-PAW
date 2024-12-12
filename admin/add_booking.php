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



// Proses penambahan pemesanan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $travel_date = $_POST['travel_date'];
    $num_people = $_POST['num_people'];
    $destination_id = $_POST['destination_id'];
    $status = $_POST['status'];

    $sql = "INSERT INTO bookings (name, email, phone, travel_date, num_people, destination_id, status) 
            VALUES ('$name', '$email', '$phone', '$travel_date', '$num_people', '$destination_id', '$status')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Pemesanan berhasil ditambahkan.'); window.location.href='bookings.php';</script>";
        exit;
    } else {
        echo "<p class='text-center text-danger mt-5'>Terjadi kesalahan saat menambahkan pemesanan.</p>";
    }
}

// Ambil daftar destinasi untuk dropdown
$destinations_sql = "SELECT * FROM destinations";
$destinations_result = $conn->query($destinations_sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pemesanan</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah Pemesanan</h2>
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
                <label for="phone" class="form-label">No Telepon</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="travel_date" class="form-label">Tanggal Perjalanan</label>
                <input type="date" class="form-control" id="travel_date" name="travel_date" required>
            </div>
            <div class="mb-3">
                <label for="num_people" class="form-label">Jumlah Orang</label>
                <input type="number" class="form-control" id="num_people" name="num_people" required>
            </div>
            <div class="mb-3">
                <label for="destination_id" class="form-label">Destinasi</label>
                <select class="form-select" id="destination_id" name="destination_id" required>
                    <option value="">Pilih Destinasi</option>
                    <?php while ($destination = $destinations_result->fetch_assoc()): ?>
                        <option value="<?php echo $destination['id']; ?>"><?php echo $destination['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="canceled">Canceled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Pemesanan</button>
            <a href="booking.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>