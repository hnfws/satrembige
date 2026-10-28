<?php
// include database connection file
include '../koneksi.php';


if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];

    mysqli_query($conn, "DELETE FROM detail_transaksi WHERE id_transaksi='$id_transaksi'");

    $result = mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'");

    if ($result) {
        header("Location: transaksi-lihat.php");
        exit;
    } else {
        echo "Gagal hapus data";
    }
}
?>