<div class="box-title">
    <p>Barang / <b>Manajemen Barang Jualan</b></p>
</div>
<div id="box">
    <?php
    include 'lib/koneksi.php';

    $hal = isset($_GET['hal']) ? $_GET['hal'] : 1;
    $batas = 5;
    $posisi = ($hal - 1) * $batas;

    // Menampilkan daftar barang
    $stmt = $conn->prepare("CALL GetBarang(:posisi, :batas)");
    $stmt->bindParam(':posisi', $posisi, PDO::PARAM_INT);
    $stmt->bindParam(':batas', $batas, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetchAll();
    $count = $stmt->rowCount();
    $stmt->closeCursor();

    if (isset($_SESSION['success_message'])) {
        echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']);
    }
    ?>

    <h1>Barang Jualan</h1>

    <a href="?page=tambah_barang" class="tombol-biru">Tambah Barang</a><br><br>
    <table class="news">
        <tr>
            <th>No</th>
            <th style="display: none;">Id Barang</th>
            <th>Gambar</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Created</th>
            <th>Aksi</th>
        </tr>

        <?php
        $nomor = ($hal - 1) * $batas + 1;
        foreach ($data as $value):
            ?>
            <tr>
                <td><?php echo $nomor; ?></td>
                <td style="display: none;"><?php echo $value['id_barang'] ?></td>
                <td>
                    <img src="img/jersey/<?= $value['nama_image']; ?>" width="80">
                </td>
                <td><?php echo $value['deskripsi'] ?></td>
                <td><?php echo $value['harga'] ?></td>
                <td><?php echo $value['stok'] ?></td>
                <td><?php echo $value['created'] ?></td>
                <td>
                    <a class="tombol-biru" href="?page=edit_barang&id=<?php echo $value['id_barang']; ?>">ubah</a><br><br>
                    <a class="tombol-merah" href="?page=hapus_barang&id=<?php echo $value['id_barang']; ?>">hapus</a>
                </td>
            </tr>
            <?php
            $nomor++;
        endforeach;
        ?>
    </table>

    <br>
    <?php
    if ($count == 0) {
        echo "<center>-- Belum ada data barang --</center>";
    }

    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM tbl_barang");
    $stmt->execute();
    $result = $stmt->fetch();
    $jmldata = $result['total'];
    $jmlhal = ceil($jmldata / $batas);
    $stmt->closeCursor();

    echo "<div class='paging'>";
    if ($hal > 1) {
        echo "<span><a href='?page=barang&hal=1'><<</a></span>";
        echo "<span><a href='?page=barang&hal=" . ($hal - 1) . "'>Previous</a></span>";
    } else {
        echo "<span><<</span>";
        echo "<span>Previous</span>";
    }
    if ($hal < $jmlhal) {
        echo "<span><a href='?page=barang&hal=" . ($hal + 1) . "'>Next</a></span>";
        echo "<span><a href='?page=barang&hal=$jmlhal'>>></a></span>";
    } else {
        echo "<span>Next</span>";
        echo "<span>>></span>";
    }
    echo "</div>";
    ?>







<!-- =============================================================================================================================== -->
<!-- VIEW 4 MENAMPILKAM BARANG YANG BELUM PERNAH DI BELI-->

<?php
// Membuat koneksi ke database
include 'lib/koneksi.php';

$hal_belum_dibeli = isset($_GET['hal_belum_dibeli']) ? $_GET['hal_belum_dibeli'] : 1;
$batas_belum_dibeli = 3;
$posisi_belum_dibeli = ($hal_belum_dibeli - 1) * $batas_belum_dibeli;

// Mengambil data barang yang belum dibeli
$stmt_belum_dibeli = $conn->prepare("SELECT id_barang, deskripsi FROM vw_barang_belum_dibeli LIMIT :posisi, :batas");
$stmt_belum_dibeli->bindParam(':posisi', $posisi_belum_dibeli, PDO::PARAM_INT);
$stmt_belum_dibeli->bindParam(':batas', $batas_belum_dibeli, PDO::PARAM_INT);
$stmt_belum_dibeli->execute();

$data_belum_dibeli = $stmt_belum_dibeli->fetchAll(PDO::FETCH_ASSOC);
$count_belum_dibeli = $stmt_belum_dibeli->rowCount();
$stmt_belum_dibeli->closeCursor();
?>

<h2>Barang Belum Dibeli</h2>
<table class="news">
    <tr>
        <th>No</th>
        <th style="display: none;">Id Barang</th>
        <th>Deskripsi</th>
    </tr>

    <?php
    $nomor_belum_dibeli = ($hal_belum_dibeli - 1) * $batas_belum_dibeli + 1;
    foreach ($data_belum_dibeli as $barang_belum_dibeli):
        ?>
        <tr>
            <td><?php echo $nomor_belum_dibeli; ?></td>
            <td style="display: none;"><?php echo $barang_belum_dibeli['id_barang']; ?></td>
            <td><?php echo $barang_belum_dibeli['deskripsi']; ?></td>
        </tr>
        <?php
        $nomor_belum_dibeli++;
    endforeach;
    ?>
</table>

<br>
<?php
if ($count_belum_dibeli == 0) {
    echo "<center>-- Tidak ada barang yang belum dibeli --</center>";
}

$stmt_belum_dibeli_total = $conn->prepare("SELECT COUNT(*) as total FROM vw_barang_belum_dibeli");
$stmt_belum_dibeli_total->execute();
$result_belum_dibeli_total = $stmt_belum_dibeli_total->fetch();
$jmldata_belum_dibeli = $result_belum_dibeli_total['total'];
$jmlhal_belum_dibeli = ceil($jmldata_belum_dibeli / $batas_belum_dibeli);
$stmt_belum_dibeli_total->closeCursor();

echo "<div class='paging'>";
if ($hal_belum_dibeli > 1) {
    echo "<span><a href='?page=barang&hal_belum_dibeli=1'><<</a></span>";
    echo "<span><a href='?page=barang&hal_belum_dibeli=" . ($hal_belum_dibeli - 1) . "'>Previous</a></span>";
} else {
    echo "<span><<</span>";
    echo "<span>Previous</span>";
}
if ($hal_belum_dibeli < $jmlhal_belum_dibeli) {
    echo "<span><a href='?page=barang&hal_belum_dibeli=" . ($hal_belum_dibeli + 1) . "'>Next</a></span>";
    echo "<span><a href='?page=barang&hal_belum_dibeli=$jmlhal_belum_dibeli'>>></a></span>";
} else {
    echo "<span>Next</span>";
    echo "<span>>></span>";
}
echo "</div>";
?>







<!-- =========================================================================================================================== -->

<!-- VIEW 2 MENAMPILKAN BARANG DENGAN STOK TERENDAH -->
<?php
include 'lib/koneksi.php';
$query_barang_stok = $conn->prepare("SELECT * FROM view_barang_stok_terendah");
$query_barang_stok->execute();
$data_barang_stok = $query_barang_stok->fetchAll();
$count_barang_stok = $query_barang_stok->rowCount();
?>

<h2>Barang dengan Stok Terendah:</h2>

<table class="news" style="margin-bottom: 20px;">
    <tr>
        <th>No.</th>
        <th>Deskripsi</th>
        <th>Stok</th>
    </tr>
    <?php
    $nomor = 1;
    foreach ($data_barang_stok as $barang):
        ?>
        <tr>
            <td><?php echo $nomor ?></td>
            <td><?php echo $barang['deskripsi'] ?></td>
            <td><?php echo $barang['stok'] ?></td>
        </tr>
        <?php
        $nomor++;
    endforeach;
    ?>
</table>
<?php





// Mengimport file koneksi.php
require_once 'lib/koneksi.php';

// Fungsi untuk menjalankan prosedur update_stock()
function executeUpdateStockProcedure($conn) {
    $conn->exec("CALL update_stock()");
}

// Cek apakah tombol eksekusi dipencet
if (isset($_POST['eksekusi'])) {
    try {
        // Panggil fungsi untuk menjalankan prosedur update_stock()
        executeUpdateStockProcedure($conn);
        echo "Berhasil menambahkan 10 stok di semua barang";
    } catch (PDOException $e) {
        echo "Koneksi atau query bermasalah: " . $e->getMessage();
    }
}
?>

<h1>Tambah 10 Stock untuk Semua Barang</h1>
<div class="form-container">
    <form method="POST">
        <input type="submit" name="eksekusi" value="Tambahkan Stok All">
    </form>
</div>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        padding: 20px;
    }

    .container {
        max-width: 400px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);

    }

    h1 {
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    .form-container {
        text-align: center;
    }

    .form-container input[type="submit"] {
        background-color: #18d848;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        border-radius: 20px;
        font-size: 16px;
        margin-top: 10px;
        margin: 30px;
        cursor: pointer;
    }

    .form-container input[type="submit"]:hover {
        background-color: #a7a7a7;
    }
</style>
