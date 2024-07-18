<?php
// Koneksi ke database (ganti dengan konfigurasi koneksi Anda)
$koneksi = mysqli_connect("localhost", "root", "", "data");

// Mendapatkan id detail penjualan yang akan di-edit dari parameter GET
$id = $_GET['id'];

// Query untuk mengambil data detail penjualan berdasarkan id
$query = "SELECT * FROM detail_penjualan WHERE id = '$id'";
$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);

// Memproses form jika ada data yang di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $no_penjualan = $_POST['no_penjualan'];
    $nama_barang = $_POST['nama_barang'];
    $harga_barang = $_POST['harga_barang'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $satuan_detail = $_POST['satuan_detail'];
    $sub_total = $harga_barang * $jumlah_barang;

    // Query untuk update data detail penjualan
    $update_query = "UPDATE detail_penjualan SET no_penjualan = '$no_penjualan', nama_barang = '$nama_barang', 
                     harga_barang = '$harga_barang', jumlah_barang = '$jumlah_barang', satuan = '$satuan_detail', 
                     sub_total = '$sub_total' WHERE id = '$id'";
    mysqli_query($koneksi, $update_query);

    // Redirect kembali ke halaman admin.php setelah update
    $return_url = $_POST['return_url'] ?? 'admin.php';
    header("Location: $return_url");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Detail Penjualan - Admin</title>
</head>
<body>
    <h1>Edit Detail Penjualan</h1>

    <form action="edit_penjualan.php?id=<?php echo $id; ?>" method="POST">
        <input type="hidden" name="return_url" value="<?php echo $_GET['return_url'] ?? 'admin.php'; ?>">
        <label for="no_penjualan">No. Penjualan:</label>
        <input type="text" id="no_penjualan" name="no_penjualan" value="<?php echo $row['no_penjualan']; ?>" required><br><br>
        <label for="nama_barang">Nama Barang:</label>
        <input type="text" id="nama_barang" name="nama_barang" value="<?php echo $row['nama_barang']; ?>" required><br><br>
        <label for="harga_barang">Harga Barang:</label>
        <input type="text" id="harga_barang" name="harga_barang" value="<?php echo $row['harga_barang']; ?>" required><br><br>
        <label for="jumlah_barang">Jumlah Barang:</label>
        <input type="text" id="jumlah_barang" name="jumlah_barang" value="<?php echo $row['jumlah_barang']; ?>" required><br><br>
        <label for="satuan_detail">Satuan:</label>
        <input type="text" id="satuan_detail" name="satuan_detail" value="<?php echo $row['satuan']; ?>" required><br><br>
        <button type="submit">Simpan</button>
    </form>

</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>
