<?php
include 'lib/koneksi.php';

$iduser = $_POST['id_user'];
$idbarang = $_POST['id_barang'];
$harga = $_POST['harga'];
$date = date('Ymd');
$ukuran = implode(",", $_POST['ukuran']);
$qty = $_POST['qty'];
$kurir = $_POST['kurir'];
$total = $harga * $qty;
$sisa = $_POST['sisa'];

// Cek stok barang sebelum memproses pesanan
$checkStock = $conn->prepare("SELECT stok FROM tbl_barang WHERE id_barang = :id_barang");
$checkStock->bindParam(':id_barang', $idbarang);
$checkStock->execute();
$stockRow = $checkStock->fetch(PDO::FETCH_ASSOC);
$stock = $stockRow['stok'];

if ($qty > $sisa || $qty > $stock || $stock <= 0) {
    echo "<script>alert('Kuantitas pesanan melebihi sisa stok barang atau stok barang habis');window.location='?page=belanja_detail&id=$idbarang&st=$sisa'</script>";
} elseif ($qty <= 0) {
    echo "<script>alert('Keliru dalam menginputkan kuantitas');window.location='?page=belanja_detail&id=$idbarang&st=$sisa'</script>";
} else {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Perbarui stok barang
        $newStock = $stock - $qty;
        $updateStock = $conn->prepare("UPDATE tbl_barang SET stok = :newStock WHERE id_barang = :id_barang");
        $updateStock->bindParam(':newStock', $newStock);
        $updateStock->bindParam(':id_barang', $idbarang);
        $updateStock->execute();

        // Proses pemesanan
        $pdo = $conn->prepare('CALL sp_insert_keranjang(:id_user, :id_barang, :ukuran, :qty, :kurir, :date_in, :total)');
        $pdo->bindParam(':id_user', $iduser, PDO::PARAM_INT);
        $pdo->bindParam(':id_barang', $idbarang, PDO::PARAM_INT);
        $pdo->bindParam(':ukuran', $ukuran, PDO::PARAM_STR);
        $pdo->bindParam(':qty', $qty, PDO::PARAM_INT);
        $pdo->bindParam(':kurir', $kurir, PDO::PARAM_STR);
        $pdo->bindParam(':date_in', $date, PDO::PARAM_STR);
        $pdo->bindParam(':total', $total, PDO::PARAM_INT);
        $pdo->execute();

        echo "<center><b>Barang berhasil ditambahkan ke keranjang</b></center>";
        echo "<meta http-equiv='refresh' content='1; url=?page=beranda'>";
    } catch (PDOException $e) {
        print "Added data failed: " . $e->getMessage() . "<br/>";
        die();
    }
}
?>
