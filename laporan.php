<?php
// Koneksi ke database (ganti dengan konfigurasi koneksi Anda)
$koneksi = mysqli_connect("localhost", "root", "", "data");

// Query untuk mengambil data penjualan dari tabel detail_penjualan saja
$query = "SELECT dp.no_penjualan, dp.nama_barang, dp.harga_barang, dp.jumlah_barang, dp.satuan, dp.sub_total,
                 p.nama_kasir, p.tgl_penjualan, p.jam_penjualan
          FROM detail_penjualan dp
          INNER JOIN penjualan p ON dp.no_penjualan = p.no_penjualan";
$result = mysqli_query($koneksi, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
</head>
<body>
<a href="index.php">Home</a> | <a href="admin.php">Admin</a>
<h1>Laporan Penjualan Toko Toserba</h1>

    <table border="1">
        <tr>
            <th>No. Penjualan</th>
            <th>Nama Kasir</th>
            <th>Tanggal Penjualan</th>
            <th>Jam Penjualan</th>
            <th>Nama Barang</th>
            <th>Harga Barang</th>
            <th>Jumlah Barang</th>
            <th>Satuan</th>
            <th>Sub Total</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['no_penjualan'] . "</td>";
            echo "<td>" . $row['nama_kasir'] . "</td>";
            echo "<td>" . $row['tgl_penjualan'] . "</td>";
            echo "<td>" . $row['jam_penjualan'] . "</td>";
            echo "<td>" . $row['nama_barang'] . "</td>";
            echo "<td>" . $row['harga_barang'] . "</td>";
            echo "<td>" . $row['jumlah_barang'] . "</td>";
            echo "<td>" . $row['satuan'] . "</td>";
            echo "<td>" . $row['sub_total'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>
