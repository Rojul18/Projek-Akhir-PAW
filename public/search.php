<?php
// Mulai sesi dan koneksi ke database
session_start();
include('../config/config.php');

// Fungsi untuk menangani pencarian
function searchDestinations($conn, $keyword) {
    // Query untuk mencari destinasi berdasarkan nama atau deskripsi
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $sql = "SELECT * FROM destinations WHERE name LIKE '%$keyword%' OR description LIKE '%$keyword%'";
    $result = mysqli_query($conn, $sql);
    
    $searchResults = [];
    // Jika ada hasil pencarian
    if (mysqli_num_rows($result) > 0) {
        // Menyimpan hasil pencarian dalam array
        while ($row = mysqli_fetch_assoc($result)) {
            $searchResults[] = $row;
        }
    }
    
    return $searchResults;
}

// Cek apakah ini adalah permintaan AJAX
if (isset($_GET['ajax']) && isset($_GET['keyword'])) {
    $results = searchDestinations($conn, $_GET['keyword']);
    
    // Kembalikan hasil dalam format JSON
    header('Content-Type: application/json');
    echo json_encode($results);
    exit();
}

include('../includes/header.php'); 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Destinasi | Wisata Nusantara</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <section class="search-section flex-grow-1">
        <div class="container">
            <h2 class="text-center mb-4">Cari Destinasi Wisata</h2>
            
            <!-- Form Pencarian -->
            <div class="input-group mb-5">
                <input type="text" id="searchInput" class="form-control" placeholder="Masukkan kata kunci..." required>
                <button id="searchButton" class="btn btn-primary" type="button">Cari</button>
            </div>
            
            <!-- Kontainer Hasil Pencarian -->
            <div id="searchResults" class="row">
                <!-- Hasil pencarian akan dimuat di sini -->
            </div>
        </div>
    </section>

    <footer class="mt-auto bg-light text-center py-3">
        <p class="mb-0">&copy; 2024 Wisata Nusantara. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const searchResults = document.getElementById('searchResults');

        // Fungsi untuk melakukan pencarian
        function performSearch() {
            const keyword = searchInput.value.trim();
            
            // Validasi input
            if (keyword.length < 2) {
                searchResults.innerHTML = '<div class="col-12"><p class="alert alert-warning">Masukkan minimal 2 karakter untuk pencarian.</p></div>';
                return;
            }

            // Tampilkan loading
            searchResults.innerHTML = '<div class="col-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            // Kirim permintaan AJAX
            fetch(`search.php?ajax=1&keyword=${encodeURIComponent(keyword)}`)
                .then(response => response.json())
                .then(data => {
                    // Bersihkan hasil sebelumnya
                    searchResults.innerHTML = '';

                    // Cek apakah ada hasil
                    if (data.length === 0) {
                        searchResults.innerHTML = `
                            <div class="col-12">
                                <p class="alert alert-warning">Tidak ada hasil yang ditemukan untuk kata kunci "${keyword}"</p>
                            </div>
                        `;
                        return;
                    }

                    // Tampilkan hasil
                    data.forEach(destination => {
                        // Potong deskripsi
                        const shortDesc = destination.description.length > 100 
                            ? destination.description.substring(0, 100) + '...' 
                            : destination.description;

                        searchResults.innerHTML += `
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="../${destination.image_url}" class="card-img-top" alt="${destination.name}">
                                    <div class="card-body">
                                        <h5 class="card-title">${destination.name}</h5>
                                        <p class="card-text">${shortDesc}</p>
                                        <a href="destination.php?id=${destination.id}" class="btn btn-primary">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    searchResults.innerHTML = '<div class="col-12"><p class="alert alert-danger">Terjadi kesalahan dalam pencarian.</p></div>';
                });
        }

        // Tambahkan event listener untuk tombol pencarian
        searchButton.addEventListener('click', performSearch);

        // Tambahkan event listener untuk pencarian saat mengetik (opsional)
        searchInput.addEventListener('input', function() {
            // Tunggu 500ms setelah berhenti mengetik sebelum melakukan pencarian
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(performSearch, 500);
        });
    });
    </script>
</body>
</html>
<?php
$conn->close();
?>