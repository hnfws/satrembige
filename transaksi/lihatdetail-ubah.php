<?php
include '../koneksi.php';

// 1. Ambil data ID Transaksi dari URL
if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];

    // Simpan URL halaman sebelumnya supaya bisa kembali dinamis
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['previous_url']) && $_GET['previous_url'] !== '') {
            $previous_url = $_GET['previous_url'];
        } else {
            $previous_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        }
    } else {
        $previous_url = isset($_POST['previous_url']) ? $_POST['previous_url'] : '';
    }

    // Ambil data header transaksi lengkap (JOIN ke Konsumen & Kasir)
    $query_transaksi = mysqli_query($conn, "
        SELECT t.*, k.nama_konsumen, ks.nama_kasir 
        FROM transaksi t 
        LEFT JOIN konsumen k ON t.id_konsumen = k.id_konsumen 
        LEFT JOIN kasir ks ON t.id_kasir = ks.id_kasir 
        WHERE t.id_transaksi = '$id_transaksi'
    ");
    $data_transaksi = mysqli_fetch_array($query_transaksi);

    if (!$data_transaksi) {
        die("Data transaksi tidak ditemukan di database.");
    }

    // Cek mode: Edit item tunggal atau List semua item
    if (isset($_GET['id_item'])) {
        $id_item = $_GET['id_item'];
        $query_item = mysqli_query($conn, "
            SELECT dt.*, i.item as nama_barang, i.harga 
            FROM detail_transaksi dt 
            JOIN item i ON dt.id_item = i.id_item 
            WHERE dt.id_transaksi = '$id_transaksi' AND dt.id_item = '$id_item'
        ");
        $data = mysqli_fetch_array($query_item);
        $mode = 'edit_item';
    } else {
        $mode = 'list';
    }
} else {
    die("ID transaksi tidak disediakan.");
}

// 2. PROSES UPDATE
if (isset($_POST['proses'])) {
    if ($mode === 'edit_item') {
        $qty_baru = (int)$_POST['qty'];
        $subtotal_baru = (float)$_POST['subtotal'];
        mysqli_query($conn, "UPDATE detail_transaksi SET qty='$qty_baru', subtotal='$subtotal_baru' WHERE id_transaksi='$id_transaksi' AND id_item='$id_item'");
    }

    // Hitung ulang total transaksi setelah perubahan
    $q_sum = mysqli_query($conn, "SELECT SUM(subtotal) as total_murni FROM detail_transaksi WHERE id_transaksi = '$id_transaksi'");
    $res_sum = mysqli_fetch_assoc($q_sum);
    $total_murni = (float)($res_sum['total_murni'] ?? 0);

    $pajak = $total_murni * 0.1;
    $total_akhir = $total_murni + $pajak;

    $update_header = mysqli_query($conn, "UPDATE transaksi SET 
        total='$total_akhir', pajak='$pajak' 
        WHERE id_transaksi = '$id_transaksi'");

    if ($update_header) {
        $redirect_url = $previous_url ?: "transaksidetail-lihat.php?id_transaksi=$id_transaksi";
        $safe_redirect = htmlspecialchars($redirect_url, ENT_QUOTES, 'UTF-8');
        echo "<script>alert('Data Berhasil Diperbarui!'); window.location.href = '$safe_redirect';</script>";
        exit;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Koreksi Transaksi - Sate Rembige</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&family=Playfair+Display:wght@700;900&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <style>
    :root {
        --primary-accent: #f53700;
        --beige-border: #F5F5DC;
        --dark-bg: #1a1a1a;
    }

    body {
        font-family: 'Lato', sans-serif;
        background-color: #f8f9fa;
        overflow-x: hidden;
    }

    #left,
    #right,
    #top,
    #bottom {
        background: var(--beige-border) !important;
        position: fixed;
        z-index: 9999;
    }

    #left,
    #right {
        top: 0;
        bottom: 0;
        width: 12px;
    }

    #left {
        left: 0;
    }

    #right {
        right: 0;
    }

    #top,
    #bottom {
        left: 0;
        right: 0;
        height: 12px;
    }

    #top {
        top: 0;
    }

    #bottom {
        bottom: 0;
    }

    #sidebar {
        background: var(--dark-bg) !important;
        min-width: 280px;
        max-width: 280px;
        z-index: 1000;
    }

    #sidebar .logo {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        color: #fff;
        padding: 30px 20px;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    #sidebar .logo span {
        color: var(--primary-accent);
    }

    #sidebar ul li a {
        padding: 15px 30px;
        color: rgba(255, 255, 255, 0.6);
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
        display: block;
        text-decoration: none;
        transition: 0.3s;
    }

    #sidebar ul li.active>a {
        color: #fff;
        background: rgba(245, 55, 0, 0.1);
        border-left: 5px solid var(--primary-accent);
    }

    #sidebar ul li a i {
        margin-right: 15px;
        color: var(--primary-accent);
    }

    #content {
        padding: 60px !important;
        width: 100%;
    }

    .form-container {
        background: #fff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    }

    .btn-custom-toggle {
        background: var(--primary-accent) !important;
        border: none;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        color: white;
    }

    .section-title {
        font-weight: 800;
        font-size: 13px;
        color: var(--primary-accent);
        text-transform: uppercase;
        letter-spacing: 2px;
        border-left: 4px solid var(--primary-accent);
        padding-left: 15px;
        margin: 30px 0 20px 0;
    }

    /* Header Info Box */
    .header-info {
        background: #fdfdfd;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
    }

    .header-info label {
        font-size: 11px;
        color: #aaa;
        text-transform: uppercase;
        margin-bottom: 0;
        font-weight: bold;
    }

    .header-info p {
        font-weight: 700;
        color: #333;
        margin-bottom: 0;
        font-size: 16px;
    }
    </style>
</head>

<body>
    <div id="left"></div>
    <div id="right"></div>
    <div id="top"></div>
    <div id="bottom"></div>

    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-custom-toggle"><i
                        class="fa fa-bars"></i></button>
            </div>
            <div class="p-4 pt-5">
                <div class="logo">Sate <span>Rembige</span></div>
                <ul class="list-unstyled components mb-5">
                    <li><a href="../home.php"><i class="fa fa-th-large"></i> Dashboard</a></li>
                    <li><a href="../konsumen/konsumen-lihat.php"><i class="fa fa-user"></i> Konsumen</a></li>
                    <li><a href="../kasir/kasir-lihat.php"><i class="fa fa-cash-register"></i> Kasir</a></li>
                    <li><a href="../item/item-lihat.php"><i class="fa fa-utensils"></i> Item Menu</a></li>
                    <li class="active"><a href="transaksi-lihat.php"><i class="fa fa-file-invoice-dollar"></i>
                            Transaksi</a></li>
                    <li style="margin-top: 50px;"><a href="../index.php" style="color: #ff4d4d;"
                            onclick="return confirm('Yakin?')"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </nav>

        <div id="content">
            <form action="" method="post">
                <input type="hidden" name="previous_url"
                    value="<?php echo htmlspecialchars($previous_url, ENT_QUOTES, 'UTF-8'); ?>">
                <div class="form-container">
                    <div class="text-center mb-5">
                        <h2 style="font-family: 'Playfair Display'; font-weight: 900;">Koreksi Transaksi</h2>
                        <hr style="width: 40px; border: 2px solid var(--primary-accent);">
                    </div>

                    <div class="header-info">
                        <div class="row text-center">
                            <div class="col-md-4 border-right">
                                <label>No Transaksi</label>
                                <p>#<?php echo $data_transaksi['id_transaksi']; ?></p>
                            </div>
                            <div class="col-md-4 border-right">
                                <label>Konsumen</label>
                                <p><?php echo $data_transaksi['nama_konsumen']; ?></p>
                            </div>
                            <div class="col-md-4">
                                <label>Kasir</label>
                                <p><?php echo $data_transaksi['nama_kasir']; ?></p>
                            </div>
                        </div>
                    </div>

                    <?php if ($mode === 'list'): ?>
                    <div class="section-title">Item Terdaftar</div>
                    <div class="table-responsive mb-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">Subtotal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query_detail = mysqli_query($conn, "SELECT dt.*, i.item FROM detail_transaksi dt JOIN item i ON dt.id_item = i.id_item WHERE dt.id_transaksi = '$id_transaksi'");
                                    while ($row = mysqli_fetch_array($query_detail)) { ?>
                                <tr>
                                    <td class="font-weight-bold"><?php echo $row['item']; ?></td>
                                    <td class="text-center"><?php echo $row['qty']; ?></td>
                                    <td class="text-right"><?php echo number_format($row['subtotal']); ?></td>
                                    <td class="text-center">
                                        <a href="transaksidetail-ubah.php?id_transaksi=<?php echo $id_transaksi; ?>&id_item=<?php echo $row['id_item']; ?><?php echo $previous_url ? '&previous_url='.rawurlencode($previous_url) : ''; ?>"
                                            class="btn btn-sm btn-outline-success" style="border-radius:15px;">Ubah
                                            Qty</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center mt-4">
                        <a href="<?php echo $previous_url ? htmlspecialchars($previous_url, ENT_QUOTES, 'UTF-8') : 'transaksidetail-tambah.php?id_transaksi='.$id_transaksi; ?>"
                            class="btn btn-light">Kembali ke Input Pesanan</a>
                    </div>

                    <?php else: ?>
                    <div class="section-title">Edit Quantity: <?php echo $data['nama_barang']; ?></div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Quantity</label>
                            <input type="number" name="qty" id="qty" class="form-control border-danger"
                                value="<?php echo $data['qty']; ?>" oninput="hitungTotal()">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Subtotal Baru</label>
                            <input type="number" name="subtotal" id="subtotal" class="form-control"
                                value="<?php echo $data['subtotal']; ?>" readonly>
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <a href="<?php echo $previous_url ? htmlspecialchars($previous_url) : 'transaksidetail-tambah.php?id_transaksi='.$id_transaksi; ?>"
                            class="btn btn-light">Batal</a>
                        <button type="submit" name="proses" class="btn btn-success px-5"
                            style="border-radius:10px;">Update Qty</button>
                    </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <script>
    function hitungTotal() {
        var qty = document.getElementById("qty").value;
        var harga = <?php echo $data['harga'] ?? 0; ?>;
        document.getElementById("subtotal").value = qty * harga;
    }
    </script>
</body>

</html>