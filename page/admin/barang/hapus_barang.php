<?php
include('lib/koneksi.php');

$id = $_GET['id'];

$query = $conn->prepare("SELECT * FROM tbl_barang WHERE id_barang = :id");
$query->bindParam(':id', $id);
$query->execute();
$row = $query->fetch(PDO::FETCH_OBJ);

unlink("img/jersey/$row->nama_image");

try {
    $stmt = $conn->prepare("CALL delete_barang(:id)");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo "<center><img src='img/icons/ceklist.png' width='60'></center>";
    echo "<center><b>Data barang berhasil dihapus</b></center>";
    echo "</br>";
    echo "<meta http-equiv='refresh' content='1; url=?page=barang'>";
} catch (PDOException $e) {
    echo "<center><img src='img/icons/cancel.png' width='60'></center>";
    echo "<center><b>Hapus barang gagal: " . $e->getMessage() . "</b></center>";
    echo "<center><a href='?page=barang'>Kembali</a></center>";
}
?>

