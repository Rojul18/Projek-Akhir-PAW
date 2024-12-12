<?php
session_start(); // Pastikan sesi dimulai
include '../config/config.php';
include 'header_admin.php';



if (!isset($_SESSION['user_id']) || !isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    echo '<script type="text/javascript">
            window.location.href = "/wisata-nusantara/logout.php";
          </script>';
    exit();
}


// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Ambil data destinasi
    $sql = "SELECT * FROM destinations WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $destination = $result->fetch_assoc();
    } else {
        echo "<p class='text-center mt-5'>Destinasi tidak ditemukan.</p>";
        include '../includes/footer.php';
        exit;
    }
} else {
    echo "<p class='text-center mt-5'>ID destinasi tidak valid.</p>";
    include '../includes/footer.php';
    exit;
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $category = $conn->real_escape_string($_POST['category']);
    $latitude = $conn->real_escape_string($_POST['latitude']);
    $longitude = $conn->real_escape_string($_POST['longitude']);
    $image_url = $conn->real_escape_string($_POST['image_url']);

    $update_sql = "UPDATE destinations 
                   SET name='$name', description='$description', category='$category', latitude='$latitude', longitude='$longitude', image_url='$image_url'
                   WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        header('Location: home.php');
        exit;
    } else {
        echo "<p class='text-danger'>Terjadi kesalahan: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Destinasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<main>
    <div class="container mt-5">
        <h2>Edit Destinasi</h2>
        <form method="POST">
            <div class="form-group">
                <label>Nama Destinasi</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($destination['name']); ?>" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" required><?php echo htmlspecialchars($destination['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="category" class="form-control" value="<?php echo htmlspecialchars($destination['category']); ?>" required>
            </div>
            <div class="form-group">
                <label>Latitude</label>
                <input type="text" name="latitude" class="form-control" value="<?php echo htmlspecialchars($destination['latitude']); ?>" required>
            </div>
            <div class="form-group">
                <label>Longitude</label>
                <input type="text" name="longitude" class="form-control" value="<?php echo htmlspecialchars($destination['longitude']); ?>" required>
            </div>
            <div class="form-group">
                <label>URL Gambar</label>
                <input type="text" name="image_url" class="form-control" value="<?php echo htmlspecialchars($destination['image_url']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="destination.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</main>

<?php
$conn->close();
?>