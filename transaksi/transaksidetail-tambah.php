<?php
include '../koneksi.php';

if (!isset($_GET['id_transaksi']) || empty($_GET['id_transaksi'])) {
    die("ID transaksi tidak ditemukan.");
}

$error_message = '';

// AMBIL DATA UNTUK TAMPILAN
$id_transaksi = $_GET['id_transaksi'];
$query = mysqli_query($conn, "SELECT t.*, k.nama_konsumen, ks.nama_kasir FROM transaksi t 
    LEFT JOIN konsumen k ON t.id_konsumen = k.id_konsumen 
    LEFT JOIN kasir ks ON t.id_kasir = ks.id_kasir 
    WHERE t.id_transaksi = '$id_transaksi'");
$data = mysqli_fetch_array($query);

if (!$data) {
    die("Data transaksi tidak ditemukan.");
}

// ================== 1. PROSES TAMBAH ITEM ==================
if (isset($_POST['tambah_item'])) {
    $id_transaksi = $_POST['id_transaksi'];
    $id_item = $_POST['no_item'];
    $qty = $_POST['banyaknya'];
    $subtotal = $_POST['jumlah'];

    mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_item, qty, subtotal) VALUES ('$id_transaksi', '$id_item', '$qty', '$subtotal')");
    
    $q_sum = mysqli_query($conn, "SELECT SUM(subtotal) as total_bersih FROM detail_transaksi WHERE id_transaksi = '$id_transaksi'");
    $total_bersih = mysqli_fetch_assoc($q_sum)['total_bersih'];
    $pajak = $total_bersih * 0.1;
    $total_akhir = $total_bersih + $pajak;

    mysqli_query($conn, "UPDATE transaksi SET total = '$total_akhir', pajak = '$pajak' WHERE id_transaksi = '$id_transaksi'");
    
    header("Location: transaksidetail-tambah.php?id_transaksi=$id_transaksi");
    exit;
}

// ================== 2. PROSES BAYAR (Finalisasi) ==================
if (isset($_POST['proses_bayar'])) {
    $id_transaksi = $_POST['id_transaksi'];
    $tunai = (float)$_POST['tunai'];
    $kembalian = (float)$_POST['kembalian'];

    $q_sum = mysqli_query($conn, "SELECT SUM(subtotal) as total_bersih FROM detail_transaksi WHERE id_transaksi = '$id_transaksi'");
    $total_bersih = mysqli_fetch_assoc($q_sum)['total_bersih'];
    $pajak = $total_bersih * 0.1;
    $grand_total_post = $total_bersih + $pajak;

    if ($tunai < $grand_total_post) {
        $error_message = 'Tunai masih kurang. Tambahkan jumlah tunai sampai minimal Rp '.number_format($grand_total_post).'.';
    } else {
        mysqli_query($conn, "UPDATE transaksi SET 
            tunai = '$tunai', 
            dibayar = '$tunai', 
            kembalian = '$kembalian' 
            WHERE id_transaksi = '$id_transaksi'");

        echo "<script>alert('Pembayaran Berhasil!'); window.location.href = 'transaksidetail-lihat.php?id_transaksi=" . $data['id_transaksi'] . "';</script>";
        exit;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Input Pesanan - Sate Rembige</title>
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
        /* Memastikan body tidak goyang secara horizontal */
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

    /* ==========================================================
       SIDEBAR - FIX: GAK ADA SCROLLBAR & GAK BISA DISCROLL
       ========================================================== */
    #sidebar {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        height: 100% !important;
        width: 280px !important;
        background: var(--dark-bg) !important;
        box-shadow: 10px 0 30px rgba(0, 0, 0, 0.1) !important;
        z-index: 1001 !important;
        /* KUNCI UTAMA DI SINI: */
        overflow: hidden !important;
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

    /* ==========================================================
       CONTENT AREA - TETAP BISA SCROLL HALAMAN SEPERTI BIASA
       ========================================================== */
    #content {
        margin-left: 280px !important;
        padding: 60px !important;
        width: calc(100% - 280px) !important;
        min-height: 100vh;
        position: relative;
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

    .section-title {
        font-weight: 800;
        font-size: 14px;
        color: var(--primary-accent);
        text-transform: uppercase;
        letter-spacing: 2px;
        border-left: 4px solid var(--primary-accent);
        padding-left: 15px;
        margin: 30px 0 20px 0;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
        border: 1px solid #eee;
    }

    .btn-custom-toggle {
        background: var(--primary-accent) !important;
        border: none;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        color: white;
    }

    .table thead th {
        background: #fdfdfd;
        border-top: none;
        text-transform: uppercase;
        font-size: 12px;
        color: #888;
    }

    .payment-card {
        background: #fafafa;
        border-radius: 15px;
        padding: 25px;
    }

    .wrapper {
        display: flex;
        align-items: stretch;
    }

    @media (max-width: 991.98px) {
        #sidebar {
            margin-left: -280px !important;
        }

        #sidebar.active {
            margin-left: 0 !important;
        }

        #content {
            margin-left: 0 !important;
            width: 100% !important;
            padding: 30px !important;
        }
    }
    </style>

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
                    <h2>Input Detail Pesanan</h2>
                    <p class="text-center text-muted">ID Transaksi: #<?php echo $data['id_transaksi']; ?> | Konsumen:
                        <?php echo $data['nama_konsumen']; ?></p>
                    <hr style="width: 50px; border: 2px solid var(--primary-accent);">
                </div>

                <div class="section-title">Tambah Item Menu</div>
                <form action="" method="post" class="mb-5">
                    <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi; ?>">
                    <div class="row">
                        <div class="col-md-5 form-group">
                            <label><i class="fa fa-utensils mr-2"></i> Pilih Menu</label>
                            <select class="form-control" name="no_item" id="no_item" required>
                                <option selected disabled value="">--- Pilih Menu ---</option>
                                <?php
                                $q = mysqli_query($conn, "SELECT * FROM item");
                                while ($i = mysqli_fetch_array($q)) {
                                    echo "<option value='{$i['id_item']}' data-harga='{$i['harga']}'>{$i['item']} - Rp ".number_format($i['harga'])."</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-2 form-group">
                            <label><i class="fa fa-sort-numeric-up mr-2"></i> Qty</label>
                            <input type="number" name="banyaknya" id="qty" class="form-control" placeholder="0"
                                required>
                        </div>
                        <div class="col-md-3 form-group">
                            <label><i class="fa fa-money-bill-wave mr-2"></i> Subtotal</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" readonly
                                style="background: #f9f9f9;">
                        </div>
                        <div class="col-md-2 form-group text-right" style="margin-top: 32px;">
                            <button type="submit" name="tambah_item" class="btn btn-danger btn-block"
                                style="border-radius: 10px; height: 48px;">
                                <i class="fa fa-plus mr-2"></i> Tambah
                            </button>
                        </div>
                    </div>
                </form>

                <div class="section-title">Rincian Pesanan</div>
                <div class="table-responsive mb-5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-right">Harga Satuan</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Subtotal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $list = mysqli_query($conn, "SELECT dt.*, i.item, i.harga FROM detail_transaksi dt JOIN item i ON dt.id_item = i.id_item WHERE dt.id_transaksi = '$id_transaksi'");
                            $total_belanja = 0;
                            if(mysqli_num_rows($list) > 0) {
                                while($row = mysqli_fetch_array($list)){
                                    $total_belanja += $row['subtotal'];
                                    echo "<tr>
                                            <td class='font-weight-bold'>{$row['item']}</td>
                                            <td class='text-right'>".number_format($row['harga'])."</td>
                                            <td class='text-center'>{$row['qty']}</td>
                                            <td class='text-right font-weight-bold'>".number_format($row['subtotal'])."</td>
                                            <td class='text-center'>
                                                <a href='lihatdetail-ubah.php?id_transaksi={$id_transaksi}&id_item={$row['id_item']}' class='btn btn-sm btn-outline-primary mr-1' title='Ubah item'>
                                                    <i class='fa fa-edit'></i>
                                                </a>
                                                <a href='transaksidetail-hapus.php?id_transaksi={$id_transaksi}&id_item={$row['id_item']}' class='btn btn-sm btn-outline-danger' title='Hapus item' onclick='return confirm(\"Hapus item ini dari transaksi?\")'>
                                                    <i class='fa fa-trash'></i>
                                                </a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center text-muted'>Belum ada item ditambahkan</td></tr>";
                            }
                            $pajak = $total_belanja * 0.1;
                            $grand_total = $total_belanja + $pajak;
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="section-title">Finalisasi Pembayaran</div>
                <?php if ($error_message): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
                <?php endif; ?>
                <form action="" method="post">
                    <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi; ?>">
                    <div class="row payment-card mx-0 shadow-sm border">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total:</span>
                                <span>Rp <?php echo number_format($total_belanja); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Pajak (10%):</span>
                                <span>Rp <?php echo number_format($pajak); ?></span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between h5 font-weight-bold text-danger">
                                <span>GRAND TOTAL:</span>
                                <span>Rp <?php echo number_format($grand_total); ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-primary font-weight-bold">TUNAI (Rp)</label>
                                <input type="number" name="tunai" id="tunai" value="<?php echo $data['tunai']; ?>"
                                    class="form-control border-primary" style="font-size: 20px; font-weight: bold;"
                                    required>
                                <small id="tunaiHelp" class="form-text text-danger" style="display:none;">Tunai kurang,
                                    tambahkan lagi.</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>KEMBALIAN (Rp)</label>
                                <input type="number" name="kembalian" id="kembalian"
                                    value="<?php echo $data['kembalian']; ?>" class="form-control" readonly
                                    style="font-size: 20px; font-weight: bold; background: #eee;">
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-4">
                        <a href="transaksi-lihat.php" class="btn btn-light mr-2"
                            style="border-radius:10px; padding:12px 25px;">Batal</a>
                        <button type="submit" id="btnSubmitBayar" name="proses_bayar" class="btn btn-success"
                            style="border-radius:10px; padding:12px 35px; font-weight: bold;">
                            <i class="fa fa-save mr-2"></i> Selesai & Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>

    <script>
    const selectitem = document.getElementById("no_item");
    const qty = document.getElementById("qty");
    const jumlah = document.getElementById("jumlah");
    const tunai = document.getElementById("tunai");
    const kembalian = document.getElementById("kembalian");
    const btnSubmitBayar = document.getElementById("btnSubmitBayar");
    const tunaiHelp = document.getElementById("tunaiHelp");
    const grandTotalValue = <?php echo (int)$grand_total; ?>;

    function hitungItem() {
        var harga = selectitem.options[selectitem.selectedIndex].getAttribute("data-harga") || 0;
        jumlah.value = harga * qty.value;
    }

    function hitungKembali() {
        var bayar = parseInt(tunai.value) || 0;
        var selisih = bayar - grandTotalValue;
        kembalian.value = selisih;

        if (selisih < 0) {
            tunaiHelp.style.display = 'block';
            btnSubmitBayar.disabled = true;
            btnSubmitBayar.classList.add('disabled');
        } else {
            tunaiHelp.style.display = 'none';
            btnSubmitBayar.disabled = false;
            btnSubmitBayar.classList.remove('disabled');
        }
    }

    function cekTunaiAwal() {
        var bayar = parseInt(tunai.value) || 0;
        var selisih = bayar - grandTotalValue;
        if (selisih < 0) {
            tunaiHelp.style.display = 'block';
            btnSubmitBayar.disabled = true;
            btnSubmitBayar.classList.add('disabled');
        } else {
            tunaiHelp.style.display = 'none';
            btnSubmitBayar.disabled = false;
            btnSubmitBayar.classList.remove('disabled');
        }
    }

    selectitem.addEventListener("change", hitungItem);
    qty.addEventListener("input", hitungItem);
    tunai.addEventListener("input", hitungKembali);
    document.addEventListener("DOMContentLoaded", cekTunaiAwal);
    </script>

</body>

</html>