<?php
include '../koneksi.php';

if (isset($_GET['id_transaksi']) && isset($_GET['id_item'])) {
    $id_transaksi = mysqli_real_escape_string($conn, $_GET['id_transaksi']);
    $id_item = mysqli_real_escape_string($conn, $_GET['id_item']);

    $result = mysqli_query($conn, "DELETE FROM detail_transaksi WHERE id_transaksi = '$id_transaksi' AND id_item = '$id_item' LIMIT 1");

    if ($result) {
        $q_sum = mysqli_query($conn, "SELECT SUM(subtotal) AS total_bersih FROM detail_transaksi WHERE id_transaksi = '$id_transaksi'");
        $sum_row = mysqli_fetch_assoc($q_sum);
        $total_bersih = $sum_row['total_bersih'] ?? 0;
        $pajak = $total_bersih * 0.1;
        $total_akhir = $total_bersih + $pajak;

        $update = mysqli_query($conn, "UPDATE transaksi SET total = '$total_akhir', pajak = '$pajak' WHERE id_transaksi = '$id_transaksi'");

        if ($update) {
            header("Location: transaksidetail-tambah.php?id_transaksi=$id_transaksi");
            exit();
        } else {
            echo "Error updating transaction total: " . mysqli_error($conn);
        }
    } else {
        echo "Error deleting item: " . mysqli_error($conn);
    }
} else {
    echo "Invalid parameters.";
}
?>
