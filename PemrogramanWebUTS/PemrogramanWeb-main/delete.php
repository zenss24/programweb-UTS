<?php
require './config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $deleteQuery = "DELETE FROM products WHERE id = $id";
    $deleteResult = mysqli_query($db_connect, $deleteQuery);

    if ($deleteResult) {
        header('Location: show.php'); // Redirect kembali ke halaman utama setelah menghapus
        exit();
    } else {
        echo "Gagal menghapus produk.";
    }
} else {
    echo "ID produk tidak valid.";
    exit();
}
?>
