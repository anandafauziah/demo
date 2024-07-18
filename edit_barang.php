<?php
// Koneksi ke database (ganti dengan konfigurasi koneksi Anda)
$koneksi = mysqli_connect("localhost", "root", "", "data");

$update_message = ''; // Inisialisasi pesan update

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    // Query ambil data barang berdasarkan ID
    $query = "SELECT * FROM barang WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);
    $barang = mysqli_fetch_assoc($result);
} else {
    // Jika tidak ada ID, redirect ke halaman admin.php
    header("Location: admin.php");
    exit;
}

// Fungsi Update Barang
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $kode_barang = $_POST['kode_barang'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];

    $query = "UPDATE barang SET kode_barang='$kode_barang', harga_beli='$harga_beli', harga_jual='$harga_jual', stok='$stok', satuan='$satuan' WHERE id='$id'";
    if (mysqli_query($koneksi, $query)) {
        $update_message = "Barang berhasil diupdate!";
    } else {
        $update_message = "Gagal mengupdate barang: " . mysqli_error($koneksi);
    }
    
    // Ambil return_url jika ada, default kembali ke admin.php jika tidak ada
    $update_message = "data tidak ditemukan";
    $return_url = isset($_POST['return_url']) ? $_POST['return_url'] : 'admin.php';
    header("Location: " . $return_url);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
</head>
<body>
    <h1>Edit Barang</h1>

    <?php if (!empty($update_message)): ?>
        <p style="color: green;"><?php echo $update_message; ?></p>
    <?php endif; ?>

    <form action="edit_barang.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $barang['id']; ?>">
        <input type="hidden" name="return_url" value="<?php echo $_GET['return_url'] ?? 'admin.php'; ?>">
        
        <label for="kode_barang">Kode Barang:</label>
        <input type="text" id="kode_barang" name="kode_barang" value="<?php echo $barang['kode_barang']; ?>" required><br><br>
        <label for="harga_beli">Harga Beli:</label>
        <input type="text" id="harga_beli" name="harga_beli" value="<?php echo $barang['harga_beli']; ?>" required><br><br>
        <label for="harga_jual">Harga Jual:</label>
        <input type="text" id="harga_jual" name="harga_jual" value="<?php echo $barang['harga_jual']; ?>" required><br><br>
        <label for="stok">Stok:</label>
        <input type="text" id="stok" name="stok" value="<?php echo $barang['stok']; ?>" required><br><br>
        <label for="satuan">Satuan:</label>
        <input type="text" id="satuan" name="satuan" value="<?php echo $barang['satuan']; ?>" required><br><br>
        <button type="submit">Update Barang</button>
    </form>

</body>
</html>

<?php
// Tutup koneksi database
// mysqli_close($koneksi);
?>
