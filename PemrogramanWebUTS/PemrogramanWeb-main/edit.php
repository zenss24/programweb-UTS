<?php
require './config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($db_connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Produk tidak ditemukan.";
        exit();
    }
} else {
    echo "ID produk tidak valid.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = $_POST['new_nama'];
    $newPrice = $_POST['new_price'];

    // Gunakan prepared statement untuk menghindari SQL injection
    $updateQuery = "UPDATE products SET nama = ?, price = ? WHERE id = ?";
    $stmt = mysqli_prepare($db_connect, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ssi", $newName, $newPrice, $id);
    $updateResult = mysqli_stmt_execute($stmt);

    if ($updateResult) {
        header('Location: show.php?id=' . $id); // Redirect kembali ke halaman produk setelah mengedit
        exit();
    } else {
        echo "Gagal mengedit produk.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
</head>
<body>
    <h1>Edit Produk</h1>
    <form method="POST">
        <label for="new_nama">Nama Produk Baru:</label>
        <input type="text" name="new_nama" value="<?= $product['nama']; ?>" required>

        <label for="new_price">Harga Produk Baru:</label>
        <input type="text" name="new_price" value="<?= $product['price']; ?>" required>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>
