<?php
include 'lib/koneksi.php';

$total = $_GET['jum'];
$id = $_GET['id'];

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Memindahkan barang dari keranjang ke tabel pesanan
    $insert = $conn->prepare("INSERT INTO tbl_pesanan (id_user, id_barang, ukuran, qty, kurir, date_in, total) SELECT id_user, id_barang, ukuran, qty, kurir, date_in, total FROM tbl_keranjang WHERE id_user = :id");
    $insert->bindParam(':id', $id);
    $insert->execute();

    // Menambahkan qty pesanan ke stok barang
    $updateStock = $conn->prepare("UPDATE tbl_barang SET stok = stok + (SELECT SUM(qty) FROM tbl_keranjang WHERE id_user = :id) WHERE id_barang IN (SELECT id_barang FROM tbl_keranjang WHERE id_user = :id)");
    $updateStock->bindParam(':id', $id);
    $updateStock->execute();

    // Menghapus barang dari keranjang
    $delete = $conn->prepare("DELETE FROM tbl_keranjang WHERE id_user = :id");
    $delete->bindParam(':id', $id);
    $delete->execute();

    // Menampilkan pesan konfirmasi pembayaran
    ?>

    <table class="article">
        <!-- Konten pesan konfirmasi pembayaran -->
    </table>
    <table class="article">
        <tr>
            <td>Status</td>
            <td><a class="tombol-biru">Pesanan Berhasil</a></td>
        </tr>
        <tr>
            <td>Jumlah Pembayaran</td>
            <td><b><?php echo "Rp. " . $total; ?></b></td>
        </tr>
        <tr>
            <td>Deskripsi</td>
            <td>
                Lakukan pembayaran dengan mentransfer nominal <b>Jumlah Pembayaran</b> pada rekening :<br>
                BANK MANDIRI<br>
                Rekening : 118-000-972525-9<br>
                A.N : Yohan Permana<br>
                Referensi : bayar/id user/jersey <b>contoh : bayar/<?php echo $id . "/jersey"; ?></b>
            </td>
        </tr>
        <tr>
            <td>Lanjutan</td>
            <td>
                Jika sudah melakukan pembayaran, segera <b>Konfirmasi Pembayaran</b> dengan mengirimkan bukti pembayaran di : <br>
                <b>WA</b> : 082248080870 <br>
                <b>LINE</b> : yohanppp
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                Terima kasih telah membeli jersey di website kami <br>
                Anda dapat melihat <a class="link" href="?page=belanja">Detail Pesanan</a>
            </td>
        </tr>
    </table>

    <?php
} catch (PDOException $e) {
    print "Added data failed: " . $e->getMessage() . "<br/>";
    die();
}
?>
