<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

include("connection.php");

if (isset($_GET['id'])) {
  $kelasId = $_GET['id'];

  $query = "SELECT * FROM kelas WHERE id_kelas = :kelasId";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':kelasId', $kelasId, PDO::PARAM_STR);
  $stmt->execute();

  $classDetails = $stmt->fetch(PDO::FETCH_ASSOC);

  $scheduleQuery = "SELECT * FROM jadwal_kelas WHERE id_kelas = :kelasId";
  $scheduleStmt = $conn->prepare($scheduleQuery);
  $scheduleStmt->bindParam(':kelasId', $kelasId, PDO::PARAM_STR);
  $scheduleStmt->execute();

  $classSchedule = $scheduleStmt->fetchAll(PDO::FETCH_ASSOC);

  $conn = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Kelas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
  <div class=" page-holder bg-cover">
    <nav style="background-color: #D9D9D9;" class="  navbar navbar-expand-xl navbar-light ">
      <div class="container-fluid ">
        <a class="navbar-brand" href="#">PNJ Borrow</a>
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="btn-group">
          <button type="button" class="btn btn-outline-success"><?= $_SESSION["username"] ?></button>
          <button type="button" class="btn dropdown-toggle dropdown-toggle-split btn-outline-success" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-5" style="font-family: Arial, sans-serif;">

      <h2>Detail Informasi Kelas</h2>
      <form action="<?php if ($classDetails) : ?>" method="post"></form>
      <div class="mb-3">
        <label for="idkelas" class="form-label">Id Kelas:</label>
        <input type="text" class="form-control" name="idkelas" value="<?php echo $classDetails['id_kelas']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="namakelas" class="form-label">Nama Kelas:</label>
        <input type="text" class="form-control" name="namakelas" value="<?php echo $classDetails['nama_kelas']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="Kapasitas" class="form-label">Kapasitas:</label>
        <input type="text" class="form-control" name="kapasitas" value="<?php echo $classDetails['kapasitas_kelas']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="statuspeminjaman" class="form-label">Status Peminjaman:</label>
        <input type="text" class="form-control" name="statuspeminjaman" value="<?php echo $classDetails['status_peminjaman']; ?>" required>
      </div>

      <?php if ($classSchedule) : ?>
        <h2 style="color: #333;">Jadwal Kelas</h2>
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
          <thead style="background-color: #007bff; color: #fff;">
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
        <p style="color: #333;">Jadwal kelas tidak ditemukan.</p>
      <?php endif; ?>

    <?php else : ?>
      <p style="color: #333;">Data kelas tidak ditemukan.</p>
    <?php endif; ?>
    </div>

    <!-- Add your additional details or styling here -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>