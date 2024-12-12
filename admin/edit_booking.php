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



// Ambil ID pemesanan dari URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT b.*, d.name AS destination FROM bookings b JOIN destinations d ON b.destination_id = d.id WHERE b.id = $id";
    $result = $conn->query($sql);
    $booking = $result->fetch_assoc();

    // Proses pembaruan pemesanan
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $travel_date = $_POST['travel_date'];
        $num_people = $_POST['num_people'];
        $destination_id = $_POST['destination_id'];
        $status = $_POST['status'];

        $sql = "UPDATE bookings SET name='$name', email='$email', phone='$phone', travel_date='$travel_date', num_people='$num_people', destination_id='$destination_id', status='$status' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Pemesanan berhasil diperbarui.'); window.location.href='bookings.php';</script>";
            exit;
        } else {
            echo "<p class='text-center text-danger mt-5'>Terjadi kesalahan saat memperbarui pemesanan.</p>";
        }
    }
} else {
    echo "<p class='text-center text-danger mt-5'>ID pemesanan tidak ditemukan.</p>";
    exit;
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
    <title>Edit Pemesanan</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Pemesanan</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($booking['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($booking['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">No Telepon</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($booking['phone']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="travel_date" class="form-label">Tanggal Perjalanan</label>
                <input type="date" class="form-control" id="travel_date" name="travel_date" value="<?php echo htmlspecialchars($booking['travel_date']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="num_people" class="form-label">Jumlah Orang</label>
                <input type="number" class="form-control" id="num_people" name="num_people" value="<?php echo htmlspecialchars($booking['num_people']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="destination_id" class="form-label">Destinasi</label>
                <select class="form-select" id="destination_id" name="destination_id" required>
                    <option value="">Pilih Destinasi</option>
                    <?php while ($destination = $destinations_result->fetch_assoc()): ?>
                        <option value="<?php echo $destination['id']; ?>" <?php echo $destination['id'] == $booking['destination_id'] ? 'selected' : ''; ?>><?php echo $destination['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status </label>
                <select class="form-select" id="status" name="status" required>
                    <option value="pending" <?php echo $booking['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="confirmed" <?php echo $booking['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                    <option value="canceled" <?php echo $booking['status'] == 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Perbarui Pemesanan</button>
            <a href="booking.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?> 
