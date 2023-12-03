<div class="box-title">
    <p>Transaksi / <b>Transaksi Pembelian Barang</b></p>
</div>
<div id="box">
    <h1>Transaksi</h1>

    <?php
    include 'lib/koneksi.php';

    // Menampilkan data pesanan barang
    $query_pesanan = $conn->prepare("SELECT * FROM tbl_pesanan
                           JOIN tbl_barang ON tbl_pesanan.id_barang=tbl_barang.id_barang
                           JOIN tbl_users ON tbl_pesanan.id_user=tbl_users.id_user
                           ORDER BY date_in DESC");
    $query_pesanan->execute();
    $data_pesanan = $query_pesanan->fetchAll();
    $count_pesanan = $query_pesanan->rowCount();
    ?>
    <table class="news" style="margin-bottom: 10px;">
        <tr>
            <th>No.</th>
            <th>Pemesan</th>
            <th>Ukuran</th>
            <th>Qty</th>
            <th>Kurir</th>
            <th>Tanggal Masuk</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
        <?php
        $nomor = 1;
        foreach ($data_pesanan as $value):
        ?>
            <tr>
                <td><?php echo $nomor; ?></td>
                <td><?php echo htmlspecialchars($value['nama_lengkap']); ?></td>
                <td><?php echo $value['ukuran']; ?></td>
                <td><?php echo $value['qty']; ?></td>
                <td><?php echo $value['kurir']; ?></td>
                <td><?php echo $value['date_in']; ?></td>
                <td><?php echo $value['total']; ?></td>
                <td>
                    <a class="tombol-biru">Sukses</a><br><br>
                    <a class="tombol-biru" href="?page=transaksi_detail&id=<?php echo $value['id_pesanan']; ?>">Detail</a>
                </td>
            </tr>
        <?php
        $nomor++;
        endforeach;
        ?>
    </table>

    <?php if ($count_pesanan == 0): ?>
        <p style="text-align: center;">-- Belum ada pesanan barang --</p>
    <?php endif; ?>
</div>


 
