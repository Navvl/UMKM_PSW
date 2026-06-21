<?php
session_start();
include 'Config/koneksi.php';


$query = "SELECT * FROM messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Banana Go</title>
    <link rel="icon" type="image/jpeg" href="assets/img/icon.png">
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/home.css" />
    <link rel="stylesheet" href="assets/css/admin_messages.css" />
    
</head>
<body>

<a href="index.php" class="btn-back">← Back Home</a>

<h1>Pesan Masuk</h1>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Pesan</th>
            <th>Tanggal</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['pesan']); ?></td>
                <td><?= $row['created_at']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</body>
</html>