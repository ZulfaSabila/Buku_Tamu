<?php
session_start();
include 'koneksi.php';

if (empty($_GET['id'])) die("ID tidak valid.");

$id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM tamu WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$tamu = $stmt->get_result()->fetch_assoc();
if (!$tamu) die("Data tidak ditemukan.");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $pesan = $conn->real_escape_string($_POST['pesan']);

    $stmt = $conn->prepare("UPDATE tamu SET nama=?, email=?, pesan=? WHERE id=?");
    $stmt->bind_param("sssi", $nama, $email, $pesan, $id);

    if ($stmt->execute()) header("Location: buku_tamu.php");
    else echo "Error: " . $stmt->error;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Tamu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h2>Edit Tamu</h2>
  <form method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($tamu['id']) ?>">
    <input class="form-control mb-3" type="text" name="nama" value="<?= htmlspecialchars($tamu['nama']) ?>" required>
    <input class="form-control mb-3" type="email" name="email" value="<?= htmlspecialchars($tamu['email']) ?>">
    <textarea class="form-control mb-3" name="pesan" rows="3" required><?= htmlspecialchars($tamu['pesan']) ?></textarea>
    <button class="btn btn-primary" type="submit">Update</button>
    <a href="buku_tamu.php" class="btn btn-secondary">Batal</a>
  </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
