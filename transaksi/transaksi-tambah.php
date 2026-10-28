<?php
include '../koneksi.php';

if (isset($_POST['proses'])) {
    $id_konsumen = $_POST['id_konsumen'];
    $id_kasir = $_POST['id_kasir'];
    $tanggal = $_POST['tanggal'];

    $conn->query("
        INSERT INTO transaksi 
        (id_konsumen, id_kasir, tanggal) 
        VALUES 
        ('$id_konsumen', '$id_kasir', '$tanggal')
    ");

    // Ambil ID transaksi yang baru ditambahkan
    $id_transaksi = $conn->insert_id;
    
    // Redirect ke halaman tambah detail menu
    echo "<script>window.location.href = 'transaksidetail-tambah.php?id_transaksi=" . $id_transaksi . "';</script>";
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Transaksi Baru - Sate Rembige</title>
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

    #sidebar ul li a i {
        margin-right: 15px;
        color: var(--primary-accent);
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
        max-width: 700px;
        margin: 0 auto;
    }

    .welcome-text h2 {
        font-family: 'Playfair Display', serif;
        font-weight: 900;
        font-size: 32px;
        color: #222;
        text-align: center;
    }

    /* FIX: Memastikan input dan select tidak kepotong */
    .form-group label {
        display: block;
        font-weight: 700;
        margin-bottom: 10px;
        color: #444;
    }

    .form-control {
        display: block !important;
        width: 100% !important;
        height: auto !important;
        padding: 12px 15px;
        border-radius: 10px;
        border: 1px solid #ddd;
        background-color: #fff;
    }

    .btn-next {
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
                    <h2>Transaksi Baru</h2>
                    <p class="text-muted">Informasi Dasar Penjualan</p>
                    <hr style="width: 50px; border: 2px solid var(--primary-accent);">
                </div>

                <form action="" method="post">
                    <div class="form-group mb-4">
                        <label><i class="fa fa-calendar-alt mr-2 text-danger"></i> TANGGAL</label>
                        <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>"
                            required>
                    </div>

                    <div class="form-group mb-4">
                        <label><i class="fa fa-id-badge mr-2 text-danger"></i> KASIR</label>
                        <select class="form-control" name="id_kasir" required>
                            <option selected disabled value="">--- Pilih Kasir yang Bertugas ---</option>
                            <?php
                            $query_kasir = mysqli_query($conn, "SELECT * FROM kasir");
                            while ($k = mysqli_fetch_array($query_kasir)) {
                                echo "<option value='".$k['id_kasir']."'>".$k['nama_kasir']."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label><i class="fa fa-user mr-2 text-danger"></i> KONSUMEN</label>
                        <select class="form-control" name="id_konsumen" required>
                            <option selected disabled value="">--- Pilih Konsumen ---</option>
                            <?php
                            $query_konsumen = mysqli_query($conn, "SELECT * FROM konsumen");
                            while ($kon = mysqli_fetch_array($query_konsumen)) {
                                echo "<option value='".$kon['id_konsumen']."'>".$kon['nama_konsumen']."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="text-right mt-5 pt-3 border-top">
                        <a href="transaksi-lihat.php" class="btn btn-light mr-2"
                            style="border-radius: 10px; padding: 12px 25px;">Batal</a>
                        <button type="submit" name="proses" class="btn btn-next shadow-sm">
                            Lanjut Pilih Menu <i class="fa fa-chevron-right ml-2"></i>
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