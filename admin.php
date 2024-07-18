<?php
// Koneksi ke database (ganti dengan konfigurasi koneksi Anda)
$koneksi = mysqli_connect("localhost", "root", "", "data");

// Fungsi Tambah Barang dan Penjualan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tambah barang
    if (isset($_POST['tambah_barang'])) {
        $kode_barang = $_POST['kode_barang'];
        $harga_beli = $_POST['harga_beli'];
        $harga_jual = $_POST['harga_jual'];
        $stok = $_POST['stok'];
        $satuan = $_POST['satuan'];

        $query = "INSERT INTO barang (kode_barang, harga_beli, harga_jual, stok, satuan) 
                  VALUES ('$kode_barang', '$harga_beli', '$harga_jual', '$stok', '$satuan')";
        mysqli_query($koneksi, $query);
        header("Location: admin.php");
        exit;
    }
    // Tambah detail penjualan
    elseif (isset($_POST['tambah_penjualan'])) {
        $no_penjualan = $_POST['no_penjualan'];
        $nama_barang = $_POST['nama_barang'];
        $harga_barang = $_POST['harga_barang'];
        $jumlah_barang = $_POST['jumlah_barang'];
        $satuan_detail = $_POST['satuan_detail'];
        $sub_total = $harga_barang * $jumlah_barang;

        $query = "INSERT INTO detail_penjualan (no_penjualan, nama_barang, harga_barang, jumlah_barang, satuan, sub_total) 
                  VALUES ('$no_penjualan', '$nama_barang', '$harga_barang', '$jumlah_barang', '$satuan_detail', '$sub_total')";
        mysqli_query($koneksi, $query);
        header("Location: admin.php");
        exit;
    }
}

// Fungsi Delete Barang
if (isset($_GET['action']) && $_GET['action'] == 'delete_barang' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM barang WHERE id = '$id'";
    mysqli_query($koneksi, $query);
    header("Location: admin.php");
    exit;
}

// Fungsi Delete Detail Penjualan
if (isset($_GET['action']) && $_GET['action'] == 'delete_penjualan' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM detail_penjualan WHERE id = '$id'";
    mysqli_query($koneksi, $query);
    header("Location: admin.php");
    exit;
}

// Query untuk mengambil semua data barang
$query_barang = "SELECT * FROM barang";
$result_barang = mysqli_query($koneksi, $query_barang);

// Query untuk mengambil semua data detail penjualan
$query_penjualan = "SELECT * FROM detail_penjualan";
$result_penjualan = mysqli_query($koneksi, $query_penjualan);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pengolahan Data</title>
</head>
<body>
<a href="index.php">Home</a> | <a href="penjualan.php">Penjualan</a> | <a href="laporan.php">Laporan</a>
    <h1>Admin - Pengolahan Data Barang</h1>

    <!-- Tabel untuk menampilkan data barang -->
    <h2>Data Barang</h2>
    <table border="1">
        <tr>
            <th>Kode Barang</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Satuan</th>
            <th>Action</th>
        </tr>
        <?php
        // Loop untuk menampilkan data barang dari database
        while ($row = mysqli_fetch_assoc($result_barang)) {
            echo "<tr>";
            echo "<td>" . $row['kode_barang'] . "</td>";
            echo "<td>" . $row['harga_beli'] . "</td>";
            echo "<td>" . $row['harga_jual'] . "</td>";
            echo "<td>" . $row['stok'] . "</td>";
            echo "<td>" . $row['satuan'] . "</td>";
            echo "<td>
                    <a href='edit_barang.php?id=" . $row['id'] . "&return_url=admin.php'>Edit</a> | 
                    <a href='admin.php?action=delete_barang&id=" . $row['id'] . "'>Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>

    <!-- Form untuk tambah barang baru -->
    <h2>Form Tambah Barang Baru</h2>
    <form action="admin.php" method="POST">
        <label for="kode_barang">Kode Barang:</label>
        <input type="text" id="kode_barang" name="kode_barang" required><br><br>
        <label for="harga_beli">Harga Beli:</label>
        <input type="text" id="harga_beli" name="harga_beli" required><br><br>
        <label for="harga_jual">Harga Jual:</label>
        <input type="text" id="harga_jual" name="harga_jual" required><br><br>
        <label for="stok">Stok:</label>
        <input type="text" id="stok" name="stok" required><br><br>
        <label for="satuan">Satuan:</label>
        <input type="text" id="satuan" name="satuan" required><br><br>
        <button type="submit" name="tambah_barang">Tambah Barang</button>
    </form>

    <!-- Tabel untuk menampilkan data detail penjualan -->
    <h2>Data Detail Penjualan</h2>
    <table border="1">
        <tr>
            <th>No. Penjualan</th>
            <th>Nama Barang</th>
            <th>Harga Barang</th>
            <th>Jumlah Barang</th>
            <th>Satuan</th>
            <th>Sub Total</th>
            <th>Action</th>
        </tr>
        <?php
        // Loop untuk menampilkan data detail penjualan dari database
        while ($row = mysqli_fetch_assoc($result_penjualan)) {
            echo "<tr>";
            echo "<td>" . $row['no_penjualan'] . "</td>";
            echo "<td>" . $row['nama_barang'] . "</td>";
            echo "<td>" . $row['harga_barang'] . "</td>";
            echo "<td>" . $row['jumlah_barang'] . "</td>";
            echo "<td>" . $row['satuan'] . "</td>";
            echo "<td>" . $row['sub_total'] . "</td>";
            echo "<td>
                    <a href='edit_penjualan.php?id=" . $row['id'] . "&return_url=admin.php'>Edit</a> | 
                    <a href='admin.php?action=delete_penjualan&id=" . $row['id'] . "'>Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>

    <!-- Form untuk tambah detail penjualan baru -->
    <h2>Form Tambah Detail Penjualan</h2>
    <form action="admin.php" method="POST">
        <label for="no_penjualan">No. Penjualan:</label>
        <input type="text" id="no_penjualan" name="no_penjualan" required><br><br>
        <label for="nama_barang">Nama Barang:</label>
        <input type="text" id="nama_barang" name="nama_barang" required><br><br>
        <label for="harga_barang">Harga Barang:</label>
        <input type="text" id="harga_barang" name="harga_barang" required><br><br>
        <label for="jumlah_barang">Jumlah Barang:</label>
        <input type="text" id="jumlah_barang" name="jumlah_barang" required><br><br>
        <label for="satuan_detail">Satuan:</label>
        <input type="text" id="satuan_detail" name="satuan_detail" required><br><br>
        <button type="submit" name="tambah_penjualan">Tambah Detail Penjualan</button>
    </form>

</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>
