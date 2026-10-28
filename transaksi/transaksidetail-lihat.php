<?php
include '../koneksi.php';

// ambil id transaksi
if (isset($_GET['id_transaksi'])) {
    $transaksi_no = $_GET['id_transaksi'];

    $query = mysqli_query($conn, "
        SELECT t.*, k.nama_konsumen, ks.nama_kasir
        FROM transaksi t
        LEFT JOIN konsumen k ON t.id_konsumen = k.id_konsumen
        LEFT JOIN kasir ks ON t.id_kasir = ks.id_kasir
        WHERE t.id_transaksi = '$transaksi_no'
    ");

    if (!$query) {
        die("Query error: " . mysqli_error($conn));
    }

    $data = mysqli_fetch_array($query);

    if (!$data) {
        die("Data transaksi tidak ditemukan.");
    }

    $tanggal = date('d/m/Y', strtotime($data['tanggal']));
} else {
    die("ID transaksi tidak ada.");
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Detail Transaksi - Sate Rembige</title>
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

    /* Bingkai Dekoratif */
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

    /* Sidebar Styling - DISAMAKAN PERSIS */
    #sidebar {
        background: var(--dark-bg) !important;
        min-width: 280px;
        max-width: 280px;
        box-shadow: 10px 0 30px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        transition: all 0.3s;
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
        transition: 0.3s;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
        display: block;
        text-decoration: none;
    }

    #sidebar ul li.active>a,
    #sidebar ul li a:hover {
        color: #fff;
        background: rgba(245, 55, 0, 0.1);
        border-left: 5px solid var(--primary-accent);
    }

    #sidebar ul li a i {
        margin-right: 15px;
        color: var(--primary-accent);
    }

    /* Content Area */
    #content {
        padding: 60px !important;
        width: 100%;
    }

    .form-container {
        background: #fff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        margin: 0 auto;
    }

    .welcome-text h2 {
        font-family: 'Playfair Display', serif;
        font-weight: 900;
        font-size: 32px;
        color: #222;
        text-align: center;
    }

    /* Tabel & Info Styling */
    .info-box {
        background: #fdfdfd;
        border: 1px solid #f1f1f1;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .table thead th {
        background-color: var(--dark-bg);
        color: white;
        border: none;
        text-transform: uppercase;
        font-size: 12px;
    }

    .total-highlight {
        background: #fff5f2;
        font-weight: bold;
    }

    .btn-custom-toggle {
        background: var(--primary-accent) !important;
        border: none;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        color: white;
    }

    @media print {

        #sidebar,
        #left,
        #right,
        #top,
        #bottom,
        .btn,
        .custom-menu,
        .nav-back {
            display: none !important;
        }

        #content {
            padding: 0 !important;
            margin: 0 !important;
        }

        .form-container {
            box-shadow: none;
            border: 1px solid #eee;
            width: 100% !important;
            max-width: 100% !important;
        }
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
                <button type="button" id="sidebarCollapse" class="btn btn-custom-toggle">
                    <i class="fa fa-bars"></i>
                </button>
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
                    <li style="margin-top: 50px;">
                        <a href="../index.php" style="color: #ff4d4d;" onclick="return confirm('Yakin keluar?')">
                            <i class="fa fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="content">
            <div class="form-container">
                <div class="welcome-text mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="transaksi-lihat.php" class="btn btn-sm btn-light nav-back"><i
                                class="fa fa-arrow-left"></i></a>
                        <h2 class="m-0">Detail Transaksi</h2>
                        <a href="transaksicetak.php?id_transaksi=<?php echo $data['id_transaksi']; ?>"
                            class="btn btn-sm btn-dark"><i class="fa fa-print"></i></a>
                    </div>
                    <p class="text-center text-muted mt-2">ID: #<?php echo $data['id_transaksi']; ?></p>
                    <hr>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box">
                            <small class="text-muted d-block">KONSUMEN</small>
                            <strong><?php echo $data['nama_konsumen']; ?></strong>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <small class="text-muted d-block">TANGGAL</small>
                            <strong><?php echo $tanggal; ?></strong>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <small class="text-muted d-block">KASIR</small>
                            <strong><?php echo $data['nama_kasir']; ?></strong>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item Menu</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $index = 1;
                            $total_murni = 0;
                            $query_detail = mysqli_query($conn, "
                                SELECT DT.id_item, I.item, I.harga, DT.qty, DT.subtotal
                                FROM detail_transaksi DT
                                JOIN item I ON DT.id_item = I.id_item
                                WHERE DT.id_transaksi = '$transaksi_no'
                            ");

                            while ($d = mysqli_fetch_array($query_detail)) {
                                $total_murni += $d['subtotal'];
                            ?>
                            <tr>
                                <td><?php echo $index++; ?></td>
                                <td class="text-left font-weight-bold"><?php echo $d['item']; ?></td>
                                <td><?php echo $d['qty']; ?></td>
                                <td><?php echo number_format($d['harga']); ?></td>
                                <td><?php echo number_format($d['subtotal']); ?></td>
                                <td class='text-center'>
                                    <a href="lihatdetail-ubah.php?id_transaksi=<?php echo $transaksi_no; ?>&id_item=<?php echo $d['id_item']; ?>"
                                        class='btn btn-sm btn-outline-primary mr-1' title='Ubah item'>
                                        <i class='fa fa-edit'></i>
                                    </a>
                                    <a href="transaksidetail-hapus.php?id_transaksi=<?php echo $transaksi_no; ?>&id_item=<?php echo $d['id_item']; ?>"
                                        class='btn btn-sm btn-outline-danger' title='Hapus item'
                                        onclick='return confirm("Hapus item ini dari transaksi?")'>
                                        <i class='fa fa-trash'></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right"><strong>TOTAL ITEM</strong></td>
                                <td><strong><?php echo number_format($total_murni); ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right">PAJAK (10%)</td>
                                <td><?php echo number_format($data['pajak']); ?></td>
                            </tr>
                            <tr class="total-highlight">
                                <td colspan="5" class="text-right text-danger">TOTAL AKHIR</td>
                                <td class="text-danger">Rp <?php echo number_format($data['total']); ?></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right text-primary">DIBAYAR</td>
                                <td class="text-primary"><?php echo number_format($data['dibayar']); ?></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right">KEMBALIAN</td>
                                <td><?php echo number_format($data['kembalian']); ?></td>
                            </tr>

                        </tfoot>
                    </table>
                </div>

                <div class="text-center mt-5">
                    <p class="text-muted italic" style="font-size: 12px;">~ Terima Kasih Atas Kunjungan Anda ~</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>