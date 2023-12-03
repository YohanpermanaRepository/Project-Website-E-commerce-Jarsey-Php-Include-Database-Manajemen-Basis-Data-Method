<?php
include 'lib/koneksi.php';

$id = $_POST['id_barang'];
$desk = $_POST['deskripsi'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];

$name_image = $_FILES['gambar']['name'];
$loc_image = $_FILES['gambar']['tmp_name'];
$type_image = $_FILES['gambar']['type'];

$date = date('Y-m-d');
$size_image = $_FILES['gambar']['size'];

$cek = array('png', 'jpg', 'jpeg', 'gif');
$x = explode('.', $name_image);
$extension = strtolower(end($x));

if ($loc_image != "") {
    if (in_array($extension, $cek) === TRUE) {
        if ($size_image < 5044070) {
            $query = $conn->prepare("SELECT * FROM tbl_barang WHERE id_barang = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_OBJ);

            if ($row->nama_image)
                unlink("img/jersey/$row->nama_image");

            move_uploaded_file($loc_image, "img/jersey/$name_image");

            try {
                $stmt = $conn->prepare("CALL update_barang(:id, :deskripsi, :harga, :stok, :created, :nama_image, :type_image, :size_image)");
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':deskripsi', $desk);
                $stmt->bindParam(':harga', $harga);
                $stmt->bindParam(':stok', $stok);
                $stmt->bindParam(':created', $date);
                $stmt->bindParam(':nama_image', $name_image);
                $stmt->bindParam(':type_image', $type_image);
                $stmt->bindParam(':size_image', $size_image);
                $stmt->execute();

                echo "<center><img src='img/icons/ceklist.png' width='60'></center>";
                echo "<center><b>Data barang berhasil diubah</b></center>";
                echo "<meta http-equiv='refresh' content='1; url=?page=barang'>";
            } catch (PDOException $e) {
                echo "<center><img src='img/icons/cancel.png' width='60'></center>";
                echo "<center><b>Ubah barang gagal: " . $e->getMessage() . "</b></center>";
                echo "<center><a href='?page=barang'>Kembali</a></center>";
            }
        } else {
            echo "<center><img src='img/icons/cancel.png' width='60'></center>";
            echo "<center><b>Ukuran file gambar terlalu besar</b></center>";
            echo "<center><a href='?page=barang'>Kembali</a></center>";
        }
    } else {
        echo "<center><img src='img/icons/cancel.png' width='60'></center>";
        echo "<center><b>Ekstensi file tidak sesuai</b></center>";
        echo "<center><a href='?page=barang'>Kembali</a></center>";
    }
} else {
    try {
        $stmt = $conn->prepare("CALL update_barang(:id, :deskripsi, :harga, :stok, :created, '', '', 0)");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':deskripsi', $desk);
		$stmt->bindParam(':harga', $harga);
		$stmt->bindParam(':stok', $stok);
		$stmt->bindParam(':created', $date);
		$stmt->execute();
		echo "<center><img src='img/icons/ceklist.png' width='60'></center>";
		echo "<center><b>Data barang berhasil diubah</b></center>";
		echo "<meta http-equiv='refresh' content='1; url=?page=barang'>";
	} catch (PDOException $e) {
		echo "<center><img src='img/icons/cancel.png' width='60'></center>";
		echo "<center><b>Ubah barang gagal: " . $e->getMessage() . "</b></center>";
		echo "<center><a href='?page=barang'>Kembali</a></center>";
	}

}
?>
	
