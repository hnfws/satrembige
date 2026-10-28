<?php
// include database connection file
include '../koneksi.php';

// Get id from URL to delete that user
if (isset($_GET['id_konsumen'])) {
    $id_konsumen = $_GET['id_konsumen'];

    // 1. Hapus dulu data di tabel transaksi yang pakai id_konsumen ini
    // Ini penting supaya tidak melanggar Foreign Key Constraint
    mysqli_query($conn, "DELETE FROM transaksi WHERE id_konsumen='$id_konsumen'");

    // 2. Baru setelah bersih, hapus data di tabel konsumen
    $result = mysqli_query($conn, "DELETE FROM konsumen WHERE id_konsumen='$id_konsumen'");
}

// After delete redirect to Home
header("Location:konsumen-lihat.php");
exit(); // Tambahkan exit supaya script berhenti di sini
?>