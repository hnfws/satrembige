<!doctype html>
<html lang="en">

<head>
    <title>Item Menu - Sate Rembige</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&family=Playfair+Display:wght@700;900&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
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

    /* Decorative Borders */
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

    /* Content Area */
    #content {
        padding: 60px !important;
        width: 100%;
    }

    .welcome-text h2 {
        font-family: 'Playfair Display', serif;
        font-weight: 900;
        font-size: 36px;
        color: #222;
    }

    /* Table & Card Design */
    .table-container {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    }

    .btn-warning {
        background-color: var(--primary-accent) !important;
        border: none;
        color: white !important;
        font-weight: 700;
        border-radius: 10px;
        padding: 10px 25px;
    }

    .btn-custom-toggle {
        background: var(--primary-accent) !important;
        border: none;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        color: white;
    }

    thead.table-primary {
        background-color: var(--dark-bg) !important;
    }

    thead.table-primary th {
        border: none;
        background-color: var(--dark-bg) !important;
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
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
                        <a href="../logout.php" style="color: #ff4d4d;"><i class="fa fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="welcome-text">
                    <h2>Item Menu</h2>
                    <p style="color: #888; font-style: italic;">Manajemen daftar menu makanan & minuman</p>
                </div>
                <a href="item-tambah.php" class="btn btn-warning shadow-sm">
                    <i class="fa fa-plus mr-2"></i> TAMBAH ITEM
                </a>
            </div>

            <div class="table-container">
                <table id="example" class="table table-hover" style="width:100%;">
                    <thead class="table-primary">
                        <tr>
                            <th width="10%">ID</th>
                            <th>Nama Item</th>
                            <th>Harga</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../koneksi.php';
                        $query = mysqli_query($conn, "SELECT id_item, item, harga FROM item");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td><strong>#<?php echo $data['id_item']; ?></strong></td>
                            <td><?php echo $data['item']; ?></td>
                            <td>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                            <td>
                                <a class="btn btn-sm btn-outline-success"
                                    href="item-ubah.php?id_item=<?php echo $data['id_item']; ?>">
                                    <i class="fa fa-edit"></i> Ubah
                                </a>
                                <a class="btn btn-sm btn-outline-danger"
                                    href="item-hapus.php?id_item=<?php echo $data['id_item']; ?>"
                                    onclick="return confirm('Yakin ingin menghapus item ini?')">
                                    <i class="fa fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="../js/main.js"></script>
    <script>
    $(document).ready(function() {
        $('#example').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
            }
        });
    });
    </script>
</body>

</html>