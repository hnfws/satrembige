<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>CETAK STRUK - SATE REMBIGE</title>
    <style>
    body {
        font-family: 'Courier New', Courier, monospace;
        /* Font kasir khas struk */
        background-color: #fff;
        margin: 0;
        padding: 20px;
        font-size: 14px;
    }

    .container {
        max-width: 500px;
        margin: 0 auto;
        border: 1px solid #000;
        padding: 15px;
    }

    .header {
        text-align: left;
        border-bottom: 1px dashed #000;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    .header h2 {
        margin: 0;
        text-transform: uppercase;
    }

    .info-table {
        width: 100%;
        margin-bottom: 10px;
    }

    .info-table td {
        vertical-align: top;
    }

    .item-table {
        width: 100%;
        border-collapse: collapse;
        border-top: 1px dashed #000;
        border-bottom: 1px dashed #000;
    }

    .item-table th {
        border-bottom: 1px dashed #000;
        padding: 5px 0;
        text-align: center;
    }

    .item-table td {
        padding: 5px 0;
    }

    .footer-section {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    .signature {
        text-align: center;
        width: 40%;
        margin-top: 10px;
    }

    .summary-table {
        width: 55%;
    }

    .summary-table td {
        padding: 2px 0;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    @media print {
        body {
            background-color: #white;
            padding: 0;
        }

        .container {
            border: none;
            width: 100%;
        }

        .no-print {
            display: none;
        }
    }
    </style>
</head>

<body>

    <?php
include '../koneksi.php';
// Query Header sesuai ERD (transaksi, konsumen, kasir)
$id_trans = $_GET['id_transaksi'];
$query = mysqli_query($conn, "
    SELECT t.*, k.nama_konsumen, ks.nama_kasir 
    FROM transaksi t 
    LEFT JOIN konsumen k ON t.id_konsumen = k.id_konsumen 
    LEFT JOIN kasir ks ON t.id_kasir = ks.id_kasir 
    WHERE t.id_transaksi = '$id_trans'
");
$data = mysqli_fetch_array($query);
$tanggal = date('d F Y', strtotime($data['tanggal']));
?>

    <div class="container">
        <div class="header">
            <h2>SATE REMBIGE</h2>
            <p>KHAS LOMBOK - HP. 081280755365<br>HP. KOTABARU SELATAN - Martapura (delivery order)</p>
        </div>

        <table class="info-table">
            <tr>
                <td width="30%">Nama Konsumen</td>
                <td width="5%">:</td>
                <td><?php echo $data['nama_konsumen']; ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><?php echo $tanggal; ?></td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td>:</td>
                <td><?php echo $data['nama_kasir']; ?></td>
            </tr>
        </table>

        <table class="item-table">
            <thead>
                <tr>
                    <th width="10%">Qty.</th>
                    <th width="45%">item</th>
                    <th width="20%">@</th>
                    <th width="25%">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php
            // Query Detail sesuai ERD (detail_transaksi join item)
            $query_detail = mysqli_query($conn, "
                SELECT dt.*, i.item as nama_barang, i.harga 
                FROM detail_transaksi dt 
                JOIN item i ON dt.id_item = i.id_item 
                WHERE dt.id_transaksi = '$id_trans'
            ");
            $total_murni = 0;
            while ($item = mysqli_fetch_array($query_detail)) {
                $total_murni += $item['subtotal'];
            ?>
                <tr>
                    <td class="text-center"><?php echo $item['qty']; ?></td>
                    <td><?php echo $item['nama_barang']; ?></td>
                    <td class="text-right"><?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td class="text-right"><?php echo number_format($item['subtotal'], 0, ',', '.'); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="footer-section">
            <div class="signature">
                <p>Tanda Terima,</p>
                <br><br>
                <p>(...................)</p>
            </div>

            <div class="summary-table">
                <table width="100%">
                    <tr>
                        <td>TOTAL</td>
                        <td class="text-right"><?php echo number_format($total_murni, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td>TUNAI</td>
                        <td class="text-right"><?php echo number_format($data['tunai'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td>PAJAK</td>
                        <td class="text-right"><?php echo number_format($data['pajak'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>DIBAYAR</strong></td>
                        <td class="text-right">
                            <strong><?php echo number_format($data['dibayar'], 0, ',', '.'); ?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td>KEMBALIAN</td>
                        <td class="text-right"><?php echo number_format($data['kembalian'], 0, ',', '.'); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="text-center" style="margin-top: 20px;">
            <p>**** terima kasih atas kunjungan anda ****</p>
        </div>
    </div>

    <script>
    window.print();
    </script>

</body>

</html>