<!doctype html>
<html lang="en">

<head>
    <title>Dashboard Admin - Sate Rembige</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&family=Playfair+Display:wght@700;900&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
    :root {
        --primary-accent: #f53700;
        --beige-border: #F5F5DC;
        --dark-bg: #1a1a1a;
        --glass-white: rgba(255, 255, 255, 0.95);
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

    /* Content Area */
    #content {
        padding: 60px !important;
        width: 100%;
    }

    .welcome-text h2 {
        font-family: 'Playfair Display', serif;
        font-weight: 900;
        font-size: 42px;
        color: #222;
        margin-bottom: 5px;
    }

    .hint-text {
        font-family: 'Playfair Display', serif;
        font-style: italic;
        color: #888;
        font-size: 18px;
        margin-bottom: 50px;
    }

    /* CARD STYLE */
    .modern-card {
        background: #fff;
        border: none;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        transition: 0.4s;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
        border: 1px solid #eee;
    }

    .modern-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
    }

    .card-icon {
        width: 65px;
        height: 65px;
        background: rgba(245, 55, 0, 0.08);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        color: var(--primary-accent);
        margin-bottom: 25px;
    }

    .card-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #aaa;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .card-number {
        font-size: 38px;
        font-weight: 800;
        color: #222;
        font-family: 'Montserrat', sans-serif;
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
                    <li class="active"><a href="home.php"><i class="fa fa-th-large"></i> Dashboard</a></li>
                    <li><a href="konsumen/konsumen-lihat.php"><i class="fa fa-user"></i> Konsumen</a></li>
                    <li><a href="kasir/kasir-lihat.php"><i class="fa fa-cash-register"></i> Kasir</a></li>
                    <li><a href="item/item-lihat.php"><i class="fa fa-utensils"></i> Item Menu</a></li>
                    <li><a href="transaksi/transaksi-lihat.php"><i class="fa fa-file-invoice-dollar"></i> Transaksi</a>
                    </li>
                    <li style="margin-top: 50px;">
                        <a href="index.php" style="color: #ff4d4d;" onclick="return confirm('Yakin ingin keluar?')">
                            <i class="fa fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="content">
            <div class="welcome-text">
                <h2>Dashboard</h2>
                <p class="hint-text">"Cita rasa yang abadi"</p>
            </div>

            <div class="row">
                <?php include 'koneksi.php'; ?>

                <div class="col-md-4">
                    <div class="modern-card">
                        <div class="card-icon"><i class="fa fa-users"></i></div>
                        <div class="card-label">Total Konsumen</div>
                        <div class="card-number">
                            <?php
                            $res = mysqli_query($conn, "SELECT COUNT(*) as total FROM konsumen");
                            echo mysqli_fetch_assoc($res)['total'] ?? 0;
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="modern-card">
                        <div class="card-icon"><i class="fa fa-id-badge"></i></div>
                        <div class="card-label">Petugas Kasir</div>
                        <div class="card-number">
                            <?php
                            $res = mysqli_query($conn, "SELECT COUNT(*) as total FROM kasir");
                            echo ($res) ? mysqli_fetch_assoc($res)['total'] : 0;
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="modern-card">
                        <div class="card-icon"><i class="fa fa-utensils"></i></div>
                        <div class="card-label">Item Menu</div>
                        <div class="card-number">
                            <?php
                            $res = mysqli_query($conn, "SELECT COUNT(*) as total FROM item");
                            echo ($res) ? mysqli_fetch_assoc($res)['total'] : 0;
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>