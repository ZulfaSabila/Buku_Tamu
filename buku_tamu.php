<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $n = $conn->real_escape_string($_POST["nama"]);
  $e = $conn->real_escape_string($_POST["email"]);
  $p = $conn->real_escape_string($_POST["pesan"]);

  if ($conn->query("INSERT INTO tamu (nama,email,pesan) VALUES('$n','$e','$p')")) {
    $_SESSION['msg'] = "Terima kasih!";
  } else {
    $_SESSION['msg'] = "Error: " . $conn->error;
  }
  header("Location: " . $_SERVER['PHP_SELF']);
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Buku Tamu</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="container-custom">
  <h2>Buku Tamu</h2>

  <?php
  if (!empty($_SESSION['msg'])) {
    $color = strpos($_SESSION['msg'], 'Error') === false ? 'green' : 'red';
    echo "<p class='msg' style='color:$color;'>".$_SESSION['msg']."</p>";
    unset($_SESSION['msg']);
  }
  ?>

  <form method="post">
    <input type="text" name="nama" placeholder="Nama" required class="form-input">
    <input type="email" name="email" placeholder="Email" class="form-input">
    <textarea name="pesan" rows="3" placeholder="Pesan" required class="form-input"></textarea>
    <button type="submit" class="btn-submit">Kirim</button>
  </form>
  
  <hr>
  <h2>Daftar Tamu</h2>

  <?php
  $r = $conn->query("SELECT * FROM tamu ORDER BY tanggal DESC");
  if ($r->num_rows > 0) {
    echo "<table>";
    echo "<thead><tr><th>Nama</th><th>Email</th><th>Pesan</th><th>Tanggal</th><th>Aksi</th></tr></thead><tbody>";
    while ($d = $r->fetch_assoc()) {
      echo "<tr><td>{$d['nama']}</td><td>{$d['email']}</td><td>{$d['pesan']}</td><td>{$d['tanggal']}</td>
            <td>
              <a href='edit_tamu.php?id={$d['id']}' class='btn-sm btn-warning'>Edit</a>
              <a href='hapus_tamu.php?id={$d['id']}' class='btn-sm btn-danger' onclick='return confirm(\"Yakin?\")'>Hapus</a>
            </td></tr>";
    }
    echo "</tbody></table>";
  } else {
    echo "<p class='msg'>Belum ada pesan.</p>";
  }
  ?>
</div>
</body>
</html>
