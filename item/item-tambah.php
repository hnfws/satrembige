<?php
if (isset($_POST['proses'])){
    include '../koneksi.php';
  
    $id_item = $_POST['id_item'];
    $nama_item = $_POST['item'];
    $harga = $_POST['harga'];  
    mysqli_query($conn, "INSERT INTO item (id_item, item, harga) VALUES ('$id_item', '$nama_item', '$harga')");
    header("location:item-lihat.php");
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Tambah Item - Sate Rembige</title>
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

    /* Dekorasi Border Beige */
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

    /* Sidebar Styling Plek Ketiplek */
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

    .btn-custom-toggle {
        background: var(--primary-accent) !important;
        border: none;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        color: white;
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
        max-width: 700px;
        margin: 0 auto;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #eee;
    }

    .form-control:focus {
        border-color: var(--primary-accent);
        box-shadow: none;
    }

    .welcome-text h2 {
        font-family: 'Playfair Display', serif;
        font-weight: 900;
        font-size: 32px;
        color: #222;
        text-align: center;
    }

    .btn-save {
        background: var(--primary-accent) !important;
        border: none;
        color: white;
        font-weight: 700;
        padding: 12px 30px;
        border-radius: 10px;
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
                    <li>
                        <a href="../home.php"><i class="fa fa-th-large"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="../konsumen/konsumen-lihat.php"><i class="fa fa-user"></i> Konsumen</a>
                    </li>
                    <li>
                        <a href="../kasir/kasir-lihat.php"><i class="fa fa-cash-register"></i> Kasir</a>
                    </li>
                    <li class="active">
                        <a href="item-lihat.php"><i class="fa fa-box"></i> Item Menu</a>
                    </li>
                    <li>
                        <a href="../transaksi/transaksi-lihat.php"><i class="fa fa-list-alt"></i> Transaksi</a>
                    </li>
                    <li style="margin-top: 50px;">
                        <a href="../logout.php" style="color: #ff4d4d;" onclick="return confirm('yakin keluar?')">
                            <i class="fa fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="content">
            <div class="form-container">
                <div class="welcome-text mb-4">
                    <h2>Tambah Item Baru</h2>
                    <p class="text-center text-muted">Input detail menu makanan atau minuman</p>
                    <hr>
                </div>

                <form action="" method="post">
                    <div class="form-group">
                        <label>ID Item</label>
                        <input type="text" name="id_item" class="form-control" placeholder="Contoh: ITM001">
                    </div>

                    <div class="form-group mt-3">
                        <label>Nama Item</label>
                        <input type="text" name="item" class="form-control" placeholder="Masukkan nama menu" required>
                    </div>

                    <div class="form-group mt-3">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" placeholder="Contoh: 25000" required>
                    </div>

                    <div class="text-right mt-5">
                        <a href="item-lihat.php" class="btn btn-light mr-2"
                            style="border-radius: 10px; padding: 12px 25px;">Batal</a>
                        <button type="submit" name="proses" class="btn btn-save shadow-sm">
                            <i class="fa fa-save mr-2"></i> Simpan Menu
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