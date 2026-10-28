<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['id_kasir'])) {
    $id_kasir = $_GET['id_kasir'];
} else {
    header("Location:kasir-lihat.php");
    exit;
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM kasir WHERE id_kasir='$id_kasir'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:kasir-lihat.php");
?>