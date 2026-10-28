<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['id_item'])) {
    $id_item=$_GET['id_item'];
} else {
    header("Location:item-lihat.php");
    exit;
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM item WHERE id_item='$id_item'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:item-lihat.php");
?>