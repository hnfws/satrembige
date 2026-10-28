<?php
include '../koneksi.php';

// AMBIL DATA TRANSAKSI + RELASI UNTUK FORM
$id_get = $_GET['id_transaksi'];
$query = mysqli_query($conn, "
    SELECT t.*, k.nama_konsumen, ks.nama_kasir
    FROM transaksi t
    LEFT JOIN konsumen k ON t.id_konsumen = k.id_konsumen
    LEFT JOIN kasir ks ON t.id_kasir = ks.id_kasir
    WHERE t.id_transaksi = '$id_get'
");
$data = mysqli_fetch_array($query);

// PROSES UPDATE
if (isset($_POST['proses'])) {
    $id_transaksi = $_POST['id_transaksi']; 
    $tanggal      = $_POST['tanggal'];
    $id_konsumen  = $_POST['id_konsumen'];
    $id_kasir     = $_POST['id_kasir'];

    // UPDATE KE TABEL TRANSAKSI
    mysqli_query($conn, "
        UPDATE transaksi SET 
            tanggal='$tanggal',
            id_konsumen='$id_konsumen',
            id_kasir='$id_kasir'
        WHERE id_transaksi='$id_transaksi'
    ");

    echo "<script>window.location.href = 'transaksidetail-lihat.php?id_transaksi=" . $id_transaksi . "';</script>";
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Ubah Transaksi - Sate Rembige</title>
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

    /* Sidebar Styling */
    #sidebar {
        background: var(--dark-bg) !important;
        min-width: 280px;
        max-width: 280px;
        box-shadow: 10px 0 30px rgba(0, 0, 0, 0.1);
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

    /* Content Area & Form Fix */
    #content {
        padding: 60px !important;
        width: 100%;
    }

    .form-container {
        background: #fff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        max-width: 750px;
        margin: 0 auto;
    }

    /* PERBAIKAN DROPDOWN BIAR GAK KEPOTONG */
    .form-group label {
        display: block;
        font-weight: 700;
        margin-bottom: 8px;
        color: #333;
    }

    .form-control {
        display: block !important;
        width: 100% !important;
        /* Gunakan 100% penuh */
        height: auto !important;
        padding: 12px 15px;
        border-radius: 10px;
        border: 1px solid #ddd;
    }

    .readonly-field {
        background-color: #f1f1f1 !important;
        font-weight: bold;
    }

    .btn-update {
        background: var(--primary-accent) !important;
        border: none;
        color: white;
        font-weight: 700;
        padding: 12px 30px;
        border-radius: 10px;
    }

    .btn-custom-toggle {
        background: var(--primary-accent) !important;
        border: none;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        color: white;
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
                <div class="welcome-text mb-4 text-center">
                    <h2 style="font-family: 'Playfair Display'; font-weight: 900;">Ubah Transaksi</h2>
                    <p class="text-muted">ID: #<?php echo $data['id_transaksi']; ?></p>
                    <hr style="width: 50px; border: 2px solid var(--primary-accent);">
                </div>

                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small">NO. TRANSAKSI</label>
                            <input type="text" class="form-control readonly-field" name="id_transaksi"
                                value="<?php echo $data['id_transaksi']; ?>" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small">TANGGAL</label>
                            <input type="date" class="form-control" name="tanggal"
                                value="<?php echo $data['tanggal']; ?>" required>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="small">TOTAL PEMBAYARAN</label>
                        <input type="text" class="form-control readonly-field"
                            value="Rp <?php echo number_format($data['total'], 0, ',', '.'); ?>" readonly>
                    </div>

                    <div class="form-group mt-3">
                        <label class="small">KONSUMEN</label>
                        <select class="form-control" name="id_konsumen" required>
                            <?php
                            $k = mysqli_query($conn, "SELECT * FROM konsumen");
                            while ($row = mysqli_fetch_array($k)) {
                                $selected = ($data['id_konsumen'] == $row['id_konsumen']) ? 'selected' : '';
                                echo "<option value='$row[id_konsumen]' $selected>$row[nama_konsumen]</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label class="small">KASIR BERTUGAS</label>
                        <select class="form-control" name="id_kasir" required>
                            <?php
                            $ks = mysqli_query($conn, "SELECT * FROM kasir");
                            while ($row = mysqli_fetch_array($ks)) {
                                $selected = ($data['id_kasir'] == $row['id_kasir']) ? 'selected' : '';
                                echo "<option value='$row[id_kasir]' $selected>$row[nama_kasir]</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="text-right mt-5 pt-3 border-top">
                        <a href="transaksi-lihat.php" class="btn btn-light mr-2"
                            style="border-radius: 10px; padding: 12px 25px;">Batal</a>
                        <button type="submit" name="proses" class="btn btn-update shadow-sm">
                            <i class="fa fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>