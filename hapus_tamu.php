<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM tamu WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: buku_tamu.php"); 
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "ID tidak valid.";
    exit;
}
?>