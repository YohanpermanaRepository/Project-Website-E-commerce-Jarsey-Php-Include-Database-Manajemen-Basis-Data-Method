<!DOCTYPE html>
<html>

<head>
    <title>Daftar Akun</title>
    <link rel="stylesheet" type="text/css" href="../css/loginstyle.css">
 
</head>

<body>
    <div class="login">
        <h2 class="login-header">DAFTAR AKUN</h2>
        <form class="login-container" action="daftar.php" method="post">

        <?php
include "../lib/koneksi.php";
session_start();

if (isset($_POST['submit'])) {
    $namalengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $nohp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $status = 'user';

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check for duplicate user using trigger
        $pdo = $conn->prepare('INSERT INTO tbl_users (nama_lengkap, email, username, password, alamat, no_hp, title)
            VALUES (:nama_lengkap, :email, :username, :password, :alamat, :no_hp, :title)');
        
        $insertdata = array(
            ':nama_lengkap' => $namalengkap,
            ':email' => $email,
            ':username' => $username,
            ':password' => $password,
            ':alamat' => $alamat,
            ':no_hp' => $nohp,
            ':title' => $status
        );

        $pdo->execute($insertdata);

        // Triger untuk nomor 4

        echo "<center><button class='tombol-biru'>pendaftaran berhasil</button></center>";
        echo "<meta http-equiv='refresh' content='1; url=login.php'>";
    } catch (PDOException $e) {
        // Check if the error message indicates duplicate entry
        if ($e->getCode() == '45000' && strpos($e->getMessage(), 'Email atau username sudah digunakan.') !== false) {
            echo "<center><button class='tombol-merah'>Email atau username sudah digunakan.</button></center>";

        } else {
            echo "pendaftaran gagal dilakukan: " . $e->getMessage() . "<br/>";
        }
    }
}
?>


            <p>
                <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required>
            </p>
            <p>
                <input type="email" name="email" placeholder="Email" required>
            </p>
            <p>
                <input type="text" name="no_hp" placeholder="No HP" required>
            </p>
            <p>
                <textarea name="alamat" rows="3" cols="80" placeholder="Alamat" required></textarea>
            </p>
            <hr>
            <p>
                <input type="text" name="username" maxlength="6" placeholder="Username" required>
            </p>
            <p>
                <input type="password" name="password" maxlength="6" placeholder="Password" required>
            </p>
            <p>
                <input type="submit" name="submit" value="DAFTAR">
            </p>
            <p align="center"><a href="login.php">kembali</a></p>
        </form>

    </div>
</body>
</html>
