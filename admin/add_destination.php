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



// Proses tambah data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $category = $conn->real_escape_string($_POST['category']);
    $latitude = $conn->real_escape_string($_POST['latitude']);
    $longitude = $conn->real_escape_string($_POST['longitude']);

    // Proses upload gambar
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['image']['name']);
        // Anda bisa menyimpan nama file atau URL gambar ke dalam database
        // Misalnya, jika Anda menggunakan layanan penyimpanan eksternal, Anda bisa mendapatkan URL-nya di sini
        $image_url = 'assets/img/' . $image_name; // Ganti dengan URL yang sesuai

        // Simpan data ke database
        $insert_sql = "INSERT INTO destinations (name, description, category, latitude, longitude, image_url) 
                       VALUES ('$name', '$description', '$category', '$latitude', '$longitude', '$image_url')";
        if ($conn->query($insert_sql)) {
            header("Location: destinations.php?message=added");
            exit;
        } else {
            echo "<p class='text-danger'>Terjadi kesalahan: " . $conn->error . "</p>";
        }
    } else {
        echo "<p class='text-danger'>Terjadi kesalahan saat meng-upload gambar.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Destinasi</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Ganti dengan path yang sesuai -->
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1 0 auto;
        }
</head>
<body>

<main>
    <div class="container mt-5">
        <h2>Tambah Destinasi</h2>
        <form method="POST" enctype="multipart/form-data"> <!-- Tambahkan enctype -->
            <div class="form-group">
                <label>Nama Destinasi</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="category" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Latitude</label>
                <input type="text" name="latitude" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Longitude</label>
                <input type="text" name="longitude" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Upload Gambar</label><br>
                <input type="file" name="image" class="form-control-file" accept="image/*" required> <!-- Input file untuk gambar -->
            </div>
            <div class="form-group" style="margin-top: 10px;">
                <button type="submit" class="btn btn-success">Tambah Destinasi</button>
                <a href="destinations.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</main>

<?php
$conn->close();
?>

</body>
</html>