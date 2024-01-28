<?php
// detail_kelas.php

include("connection.php");

if (isset($_GET['id'])) {
  $kelasId = $_GET['id'];

  // Fetch class details from the database (replace with your actual table and column names)
  $query = "SELECT * FROM kelas WHERE id_kelas = :kelasId";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':kelasId', $kelasId, PDO::PARAM_STR);
  $stmt->execute();

  $classDetails = $stmt->fetch(PDO::FETCH_ASSOC);

  // Fetch schedule from the jadwal_kelas table (replace with your actual table and column names)
  $scheduleQuery = "SELECT * FROM jadwal_kelas WHERE id_kelas = :kelasId";
  $scheduleStmt = $conn->prepare($scheduleQuery);
  $scheduleStmt->bindParam(':kelasId', $kelasId, PDO::PARAM_STR);
  $scheduleStmt->execute();

  $classSchedule = $scheduleStmt->fetchAll(PDO::FETCH_ASSOC);

  // Close the database connection
  $conn = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Kelas</title>
  <!-- Add your CSS styling if needed -->
</head>

<body>
  <h1>Detail Kelas</h1>

  <?php if ($classDetails) : ?>
    <h2>Informasi Kelas</h2>
    <ul>
      <li><strong>ID Kelas:</strong> <?php echo $classDetails['id_kelas']; ?></li>
      <li><strong>Nama Kelas:</strong> <?php echo $classDetails['nama_kelas']; ?></li>
      <li><strong>Kapasitas:</strong> <?php echo $classDetails['kapasitas_kelas']; ?></li>
      <li><strong>Status Peminjaman:</strong> <?php echo $classDetails['status_peminjaman']; ?></li>
    </ul>

    <?php if ($classSchedule) : ?>
      <h2>Jadwal Kelas</h2>
      <table border="1">
        <thead>
          <tr>
            <th>Senin</th>
            <th>Selasa</th>
            <th>Rabu</th>
            <th>Kamis</th>
            <th>Jumat</th>
            <th>Sabtu</th>
            <th>Minggu</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($classSchedule as $row) : ?>
            <tr>
              <td><?php echo $row['senin']; ?></td>
              <td><?php echo $row['selasa']; ?></td>
              <td><?php echo $row['rabu']; ?></td>
              <td><?php echo $row['kamis']; ?></td>
              <td><?php echo $row['jumat']; ?></td>
              <td><?php echo $row['sabtu']; ?></td>
              <td><?php echo $row['minggu']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else : ?>
      <p>Jadwal kelas tidak ditemukan.</p>
    <?php endif; ?>

  <?php else : ?>
    <p>Data kelas tidak ditemukan.</p>
  <?php endif; ?>

  <!-- Add your additional details or styling here -->

</body>

</html>
