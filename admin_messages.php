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
    <title>Pesan Masuk - Admin</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8dc3d;
            padding: 40px;
            color: #4c2013;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fffaf0;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 8px 8px 0 #4c2013;
        }

        th, td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #4c2013;
            color: #f8dc3d;
        }

        tr:hover {
            background: #fff3b0;
        }

        .btn-back {
            display: inline-block;
            margin-bottom: 20px;
            background: #4c2013;
            color: #f8dc3d;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
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