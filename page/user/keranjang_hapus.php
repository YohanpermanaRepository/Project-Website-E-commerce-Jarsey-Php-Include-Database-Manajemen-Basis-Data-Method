<?php
include('lib/koneksi.php');

$id = $_GET['id'];

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo = $conn->prepare("SELECT id_barang, qty FROM tbl_keranjang WHERE id = :id");
    $pdo->bindParam(':id', $id);
    $pdo->execute();

    $row = $pdo->fetch(PDO::FETCH_ASSOC);
    $id_barang = $row['id_barang'];
    $qty = $row['qty'];

    $pdo = $conn->prepare("DELETE FROM tbl_keranjang WHERE id = :id");
    $pdo->bindParam(':id', $id);
    $pdo->execute();

    $pdo = $conn->prepare("CALL update_stok_setelah_hapus_keranjang(:id_barang, :qty)");
    $pdo->bindParam(':id_barang', $id_barang);
    $pdo->bindParam(':qty', $qty);
    $pdo->execute();

    echo "<script>alert('Barang dalam keranjang berhasil dihapus');window.location='?page=beranda'</script>";
} catch (PDOexception $e) {
    print "hapus berita gagal: " . $e->getMessage() . "<br/>";
    die();
}
?>
