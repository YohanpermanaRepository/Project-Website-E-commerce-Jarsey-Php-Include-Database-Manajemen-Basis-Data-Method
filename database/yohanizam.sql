create database yohanizam;
use yohanizam;

CREATE TABLE `tbl_barang` (
  `id_barang` int(100) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `harga` int(20) NOT NULL,
  `stok` int(5) NOT NULL,
  `created` date NOT NULL,
  `nama_image` varchar(50) NOT NULL,
  `type_image` varchar(50) NOT NULL,
  `size_image` bigint(20) NOT NULL
);

CREATE TABLE `tbl_keranjang` (
  `id` int(100) NOT NULL,
  `id_user` int(100) NOT NULL,
  `id_barang` int(100) NOT NULL,
  `ukuran` varchar(5) NOT NULL,
  `qty` int(50) NOT NULL,
  `kurir` varchar(15) NOT NULL,
  `date_in` date NOT NULL,
  `total` int(100) NOT NULL
);


CREATE TABLE `tbl_pesanan` (
  `id_pesanan` int(100) NOT NULL,
  `id_user` int(100) NOT NULL,
  `id_barang` int(100) NOT NULL,
  `ukuran` varchar(5) NOT NULL,
  `qty` int(50) NOT NULL,
  `kurir` varchar(15) NOT NULL,
  `date_in` date NOT NULL,
  `total` int(100) NOT NULL
);

CREATE TABLE `tbl_users` (
  `id_user` int(100) NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `username` varchar(6) NOT NULL,
  `password` varchar(6) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `no_hp` text NOT NULL,
  `title` varchar(10) NOT NULL
);

ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id_barang`);

ALTER TABLE `tbl_keranjang`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id_user`);

ALTER TABLE `tbl_barang`
  MODIFY `id_barang` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `tbl_keranjang`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

ALTER TABLE `tbl_pesanan`
  MODIFY `id_pesanan` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

ALTER TABLE `tbl_users`
  MODIFY `id_user` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;



INSERT INTO `tbl_users` (`id_user`, `nama_lengkap`, `email`, `username`, `password`, `alamat`, `no_hp`, `title`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin', 'admin', 'Trunojoyo University student S.I', '082237172172', 'admin');

INSERT INTO `tbl_barang` (`id_barang`, `deskripsi`, `harga`, `stok`, `created`, `nama_image`, `type_image`, `size_image`) VALUES
(1, 'Barcelona Home', 320000, 31, '2023-05-22', 'BARCELONA.png', 'image/png', 1042644),
(2, 'AC Milan Home Kit', 210000, 25, '2023-05-19', 'AC MILAN.png', 'image/png', 901722),
(3, 'Atletico Madrid Home Kit', 270000, 34, '2023-05-19', 'ATLETICO.png', 'image/png', 753425),
(4, 'Chelsea Home Kit', 200000, 32, '2023-05-19', 'CHELSEA.png', 'image/png', 1050462),
(5, 'Manchaster United', 190000, 40, '2023-05-19', 'MANCASTER.png', 'image/png', 1363031),
(6, 'Inter Milan', 270000, 18, '2023-05-19', 'INTER.png', 'image/png', 857450),
(7, 'Juventus', 310000, 55, '2023-05-19', 'JUVE.png', 'image/png', 389184),
(8, 'King City Home Kit', 240000, 50, '2023-05-19', 'MAN CITY.png', 'image/png', 738876),
(9, 'Paris Saint German Home Kit', 200000, 38, '2023-05-19', 'PSG.png', 'image/png', 531468),
(10, 'Real Madrid', 190000, 44, '2023-05-19', 'REAL MADRID.png', 'image/png', 794108),
(11, 'Arsenal Home Away', 260000, 39, '2023-05-19', 'ARSENAL.png', 'image/png', 320034),
(12, 'Newcastle United Home Away', 210000, 23, '2023-05-19', 'NEWCASTLE.png', 'image/png', 92869),
(13, 'Leicester City Home Away ', 220000, 67, '2023-05-19', 'LEICESTER.png', 'image/png', 282698),
(14, 'tottenham hotspur Home Away', 250000, 36, '2023-05-19', 'TOTENHAM.png', 'image/png', 304703),
(15, 'Westham Home Away', 247000, 26, '2023-05-19', 'WESTHAM.png', 'image/png', 1665133);


# Menerapkan Modul Stored Procedure
#1. Procedure 1 delete barang

INSERT INTO `tbl_users` (`id_user`, `nama_lengkap`, `email`, `username`, `password`, `alamat`, `no_hp`, `title`) VALUES ('1', 'admin', 'admin@gmail.com', 'admin', 'admin', 'Trunojoyo University student S.I', '082237172172', 'admin');

DELIMITER //
CREATE PROCEDURE insert_barang(
    IN p_deskripsi varchar(100),
    IN p_harga int,
    IN p_stok int,
    IN p_created date,
    IN p_nama_image varchar(50),
    IN p_type_image varchar(50),
    IN p_size_image bigint
)
BEGIN
    INSERT INTO tbl_barang (deskripsi, harga, stok, created, nama_image, type_image, size_image)
    VALUES (p_deskripsi, p_harga, p_stok, p_created, p_nama_image, p_type_image, p_size_image);
END //
DELIMITER ;


#2. Procedure 2 delete_barang
DELIMITER //
CREATE PROCEDURE delete_barang(
    IN p_id_barang INT
)
BEGIN
    DELETE FROM tbl_barang WHERE id_barang = p_id_barang;
END //
DELIMITER ;

CALL delete_barang(16);


#3. Procedure 3 update barang
DELIMITER //
CREATE PROCEDURE update_barang(
    IN p_id_barang INT,
    IN p_deskripsi VARCHAR(100),
    IN p_harga INT,
    IN p_stok INT,
    IN p_created DATE,
    IN p_nama_image VARCHAR(50),
    IN p_type_image VARCHAR(50),
    IN p_size_image BIGINT
)
BEGIN
    UPDATE tbl_barang
    SET deskripsi = p_deskripsi,
        harga = p_harga,
        stok = p_stok,
        created = p_created,
        nama_image = p_nama_image,
        type_image = p_type_image,
        size_image = p_size_image
    WHERE id_barang = p_id_barang;
END //
DELIMITER ;


#4. Procedure 4 menampilkan data barang
DELIMITER //
CREATE PROCEDURE GetBarang(
    IN p_posisi INT,
    IN p_batas INT
)
BEGIN
    SELECT *
    FROM tbl_barang
    LIMIT p_posisi, p_batas;
END //
DELIMITER ;

# 5
DELIMITER //
CREATE PROCEDURE sp_insert_keranjang(
IN `p_id_user` INT,
IN `p_id_barang` INT,
IN `p_ukuran` VARCHAR(50),
IN `p_qty` INT,
IN `p_kurir` VARCHAR(50),
IN `p_date_in` VARCHAR(8),
IN `p_total` INT
)
BEGIN
  DECLARE stock INT;
  
  -- Mengambil stok barang dari tabel tbl_barang
  SELECT stok INTO stock FROM tbl_barang WHERE id_barang = p_id_barang;
  
  -- Mengurangi stok barang sesuai dengan jumlah yang dimasukkan ke keranjang
  UPDATE tbl_barang SET stok = stock - p_qty WHERE id_barang = p_id_barang;
  
  -- Memasukkan data ke tabel tbl_keranjang
  INSERT INTO tbl_keranjang (id_user, id_barang, ukuran, qty, kurir, date_in, total)
  VALUES (p_id_user, p_id_barang, p_ukuran, p_qty, p_kurir, p_date_in, p_total);

END //
DELIMITER ;



#6 menerapkan looping procedure
DELIMITER $$
CREATE PROCEDURE update_stock()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE current_id INT;
    DECLARE current_stock INT;
    DECLARE cur CURSOR FOR SELECT id_barang, stok FROM tbl_barang;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    -- Membuka cursor
    OPEN cur;
    
    -- Mengambil data pertama dari cursor
    FETCH cur INTO current_id, current_stock;
    
    -- Memulai loop
    WHILE NOT done DO
        SET current_stock = current_stock + 10;
        UPDATE tbl_barang SET stok = current_stock WHERE id_barang = current_id;   
        FETCH cur INTO current_id, current_stock;
    END WHILE;
    
    -- Menutup cursor
    CLOSE cur;
END$$
DELIMITER ;


### Menerapkan CreateView
#1
CREATE VIEW view_user_purchases AS
SELECT u.id_user, u.nama_lengkap, 
SUM(p.qty) AS total_qty
FROM tbl_users u
JOIN tbl_pesanan p ON u.id_user = p.id_user
GROUP BY u.id_user, u.nama_lengkap
ORDER BY SUM(p.qty) DESC;


#2
CREATE VIEW view_barang_stok_terendah AS
SELECT id_barang, deskripsi, stok
FROM tbl_barang
WHERE stok = (SELECT MIN(stok) FROM tbl_barang);



#3
CREATE VIEW v_pendapatan_per_tanggal AS
SELECT
    p.date_in AS tanggal,
    SUM(p.total) AS total_pendapatan
FROM
    tbl_pesanan p
GROUP BY
    p.date_in;
    
    
#4 
CREATE VIEW vw_barang_belum_dibeli AS
SELECT id_barang, deskripsi
FROM tbl_barang
WHERE id_barang NOT IN (SELECT id_barang FROM tbl_pesanan);

#5
CREATE VIEW view_pengguna_belum_pesanan AS
SELECT tu.id_user, tu.nama_lengkap, tu.email, tu.username, tu.alamat, tu.no_hp
FROM tbl_users tu
LEFT JOIN tbl_pesanan tp ON tu.id_user = tp.id_user
WHERE tp.id_pesanan IS NULL;


# MenerapkanTriger

#1. Trigger untuk menghapus data keranjang saat barang yang terkait dihapus dari tabel 
DELIMITER $$
CREATE TRIGGER tr_delete_keranjang
AFTER DELETE ON tbl_barang
FOR EACH ROW
BEGIN
  DELETE FROM tbl_keranjang WHERE id_barang = OLD.id_barang;
END$$
DELIMITER ;

#2. Trigger untuk memastikan bahwa jumlah stok tidak negatif dalam tabel tbl_barang:

DELIMITER $$
CREATE TRIGGER tr_check_stock
BEFORE UPDATE ON tbl_barang
FOR EACH ROW
BEGIN
  IF NEW.stok < 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Jumlah stok tidak boleh negatif';
  END IF;
END$$
DELIMITER ;

#3. Trigger untuk menghapus barang dari keranjang saat stoknya habis:
DELIMITER //
CREATE TRIGGER hapus_dari_keranjang AFTER UPDATE ON tbl_barang
FOR EACH ROW
BEGIN
    IF NEW.stok <= 0 THEN
        DELETE FROM tbl_keranjang WHERE id_barang = NEW.id_barang;
    END IF;
END //
DELIMITER ;

#4. Trigger untuk memastikan tidak ada dua user dengan email atau username yang sama:
DELIMITER //
CREATE TRIGGER check_duplicate_user BEFORE INSERT ON tbl_users
FOR EACH ROW
BEGIN
    IF EXISTS (SELECT 1 FROM tbl_users WHERE email = NEW.email OR username = NEW.username) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Email atau username sudah digunakan.';
    END IF;
END //
DELIMITER ;

#5. Trigger untuk menghapus pesanan terkait saat penghapusan barang dari tabel barang:
DELIMITER //
CREATE TRIGGER hapus_pesanan_barang AFTER DELETE ON tbl_barang
FOR EACH ROW
BEGIN
    DELETE FROM tbl_pesanan WHERE id_barang = OLD.id_barang;
END //
DELIMITER ;









