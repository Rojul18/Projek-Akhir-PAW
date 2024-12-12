// script.js

// Fungsi untuk menampilkan alert ketika form pemesanan berhasil
function showBookingAlert() {
    alert("Pemesanan Anda berhasil! Terima kasih telah memilih destinasi kami.");
}

// Event listener untuk tombol submit pada form booking
const bookingForm = document.querySelector('#bookingForm');
if (bookingForm) {
    bookingForm.addEventListener('submit', function(e) {
        e.preventDefault();  // Mencegah form melakukan refresh halaman secara default
        showBookingAlert();  // Menampilkan alert saat pemesanan berhasil
    });
}

// Fungsi untuk menampilkan gambar besar di modal saat user mengklik gambar destinasi
function openImageModal(imageUrl) {
    const modal = document.querySelector('#imageModal');
    const modalImage = document.querySelector('#modalImage');
    modal.style.display = 'block';
    modalImage.src = imageUrl;
}

// Menutup modal gambar saat user mengklik tombol close
const closeModalButton = document.querySelector('#closeModal');
if (closeModalButton) {
    closeModalButton.addEventListener('click', function() {
        const modal = document.querySelector('#imageModal');
        modal.style.display = 'none';
    });
}
