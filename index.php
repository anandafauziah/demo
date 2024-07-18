<?php
// Koneksi ke database (ganti dengan konfigurasi koneksi Anda)
$koneksi = mysqli_connect("localhost", "root", "", "data");

// Proses pencarian jika ada parameter search yang dikirimkan
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
    $query = "SELECT * FROM barang WHERE kode_barang LIKE '%$search%' OR satuan LIKE '%$search%'";
} else {
    // Query untuk mengambil semua data barang jika tidak ada pencarian
    $query = "SELECT * FROM barang";
}

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Toko Toserba</title>
</head>
<body>
    <h1>Daftar Barang</h1>

    <!-- Form pencarian -->
    <form action="index.php" method="GET">
        <label for="search">Cari Barang:</label>
        <input type="text" id="search" name="search">
        <button type="submit">Cari</button>
    </form>

    <!-- Tabel daftar barang -->
    <table border="1">
        <tr>
            <th>Kode Barang</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Satuan</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['kode_barang'] . "</td>";
            echo "<td>" . $row['harga_jual'] . "</td>";
            echo "<td>" . $row['stok'] . "</td>";
            echo "<td>" . $row['satuan'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <br>

    <a href="admin.php">Admin</a> | <a href="penjualan.php">Penjualan</a> | <a href="laporan.php">Laporan</a>

</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>
