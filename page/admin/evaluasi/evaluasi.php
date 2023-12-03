<div>
    <!-- VIEW 3 PENDAPATAN PERTANGGAL -->
    <?php
    include 'lib/koneksi.php';
    $query_pendapatan = $conn->prepare("SELECT tanggal, total_pendapatan FROM v_pendapatan_per_tanggal");
    $query_pendapatan->execute();
    $data_pendapatan = $query_pendapatan->fetchAll();
    $count_pendapatan = $query_pendapatan->rowCount();
    ?>
    <div>
        <h2 class="centered-heading">Pendapatan per Tanggal:</h2>

        <table class="pendapatan-table">
            <tr>
                <th>Tanggal</th>
                <th>Total Pendapatan</th>
            </tr>
            <?php foreach ($data_pendapatan as $pendapatan): ?>
                <tr>
                    <td><?php echo $pendapatan['tanggal']; ?></td>
                    <td><?php echo $pendapatan['total_pendapatan']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>


<!-- VIEW 1 USER PEMBELIAN TERBANYAK -->
<?php
include 'lib/koneksi.php';
$query_user_purchases = $conn->prepare("SELECT nama_lengkap, total_qty,
                                         @rank := @rank + 1 AS ranking FROM view_user_purchases
                                         CROSS JOIN (SELECT @rank := 0) r
                                         ORDER BY total_qty DESC");
$query_user_purchases->execute();
$data_user_purchases = $query_user_purchases->fetchAll();
$count_user_purchases = $query_user_purchases->rowCount();
?>
<h2 class="centered-heading">User dengan Jumlah Pembelian Terbanyak:</h2>

<table class="user-purchases-table">
    <tr>
        <th>Ranking</th>
        <th>Nama Pengguna</th>
        <th>Total Pembelian</th>
    </tr>
    <?php foreach ($data_user_purchases as $user): ?>
        <tr>
            <td><?php echo $user['ranking'] ?></td>
            <td><?php echo $user['nama_lengkap'] ?></td>
            <td><?php echo $user['total_qty'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>


<!-- VIEW PENGGUNA YANG BELUM PERNAH MELAKUKAN PESANAN -->
<h2 class="centered-heading">User yang belum pernah melakukan pesanan</h2>
<?php
include('lib/koneksi.php');
$query = $conn->prepare("SELECT * FROM view_pengguna_belum_pesanan WHERE id_user NOT IN (SELECT id_user FROM tbl_users WHERE title = 'admin')");
$query->execute();
$data = $query->fetchAll();
$count = $query->rowCount();
?>

<table class="user-no-orders-table">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Alamat</th>
        <th>No HP</th>
    </tr>
    <?php
    $no = 1;
    foreach ($data as $value): ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $value['nama_lengkap']; ?></td>
            <td><?php echo $value['email']; ?></td>
            <td><?php echo $value['alamat']; ?></td>
            <td><?php echo $value['no_hp']; ?></td>
        </tr>
    <?php
    $no++;
    endforeach;
    ?>
</table>
<br>
<?php
if ($count == 0) {
    echo "<center>-- Belum ada pengguna yang belum melakukan pesanan --</center>";
    echo "<br>";
}
?>





<style>
    /* Tabel Pendapatan per Tanggal */
    .pendapatan-table {
        width: 70%;
        border-collapse: collapse;
        margin-bottom: 20px;
        margin-left: auto;
        margin-right: auto;
    }

    .pendapatan-table th,
    .pendapatan-table td {
        padding: 8px;
        border: 1px solid #ccc;
    }

    .pendapatan-table th {
        background-color: #f2f2f2;
        text-align: left;
    }

    .pendapatan-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Tabel User Pembelian Terbanyak */
    .user-purchases-table {
        width: 70%;
        border-collapse: collapse;
        margin-bottom: 20px;
        margin-left: auto;
        margin-right: auto;
    }

    .user-purchases-table th,
    .user-purchases-table td {
        padding: 8px;
        border: 1px solid #ccc;
    }

    .user-purchases-table th {
        background-color: #f2f2f2;
        text-align: left;
    }

    .user-purchases-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Tabel User yang Belum Melakukan Pesanan */
    .user-no-orders-table {
        width: 70%;
        border-collapse: collapse;
        margin-left: auto;
        margin-right: auto;
    }

    .user-no-orders-table th,
    .user-no-orders-table td {
        padding: 8px;
        border: 1px solid #ccc;
    }

    .user-no-orders-table th {
        background-color: #f2f2f2;
        text-align: left;
    }

    .user-no-orders-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .centered-heading {
        text-align: center;
        border-radius: 10px 10px 0px 0px;
        background: #b8ff06;
        width: 70%;
        margin-left: auto;
        margin-right: auto;
    }



</style>

