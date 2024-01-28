<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

include("connection.php");
$isAdmin = $_SESSION['status_user'] == 'Administrator';

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
    <nav style="background-color: #064e3b;" class="navbar navbar-expand-xl navbar-light">
      <div class="container-fluid">
        <div class="d-flex flex-row">
          <img src="./Meta/logoooo0.png" style="width: 40px; height: 40px;" alt="logo">
          <div class="p-1">
            <a class="navbar-brand text-white" href="index.php">PNJ Borrow</a>
          </div>
        </div>
        <div class="btn-group">
          <button type="button" class="btn btn-success text-white"><?= $_SESSION["username"] ?></button>
          <button type="button" class="btn dropdown-toggle dropdown-toggle-split btn-success" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-5" style="font-family: Arial, sans-serif;">
      <div class="">
        <h2>Detail Informasi Kelas</h2>
        <form action="<?php if ($classDetails) : ?>" method="post">
          <div class="mb-3 row">
            <label for="idkelas" class="form-label col-sm-2">Id Kelas:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="idkelas" value="<?php echo $classDetails['id_kelas']; ?>" required>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="namakelas" class="form-label col-sm-2">Nama Kelas:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="namakelas" value="<?php echo $classDetails['nama_kelas']; ?>" required>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="Kapasitas" class="form-label col-sm-2">Kapasitas:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="kapasitas" value="<?php echo $classDetails['kapasitas_kelas']; ?>" required>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="statuspeminjaman" class="form-label col-sm-2">Status Peminjaman:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="statuspeminjaman" value="<?php echo $classDetails['status_peminjaman']; ?>" required>
            </div>
          </div>
        </form>
      </div>

      <?php if ($isAdmin) : ?>
        <div style="margin-top: 5px;">
          <button style="background-color: #064e3b;" type="button" class="btn mb-1 text-white" data-bs-toggle="modal" data-bs-target="#adminActionsModal">
            Pesan Kelas
          </button>
        </div>
      <?php endif; ?>

      <div class="modal fade" id="adminActionsModal" tabindex="-1" aria-labelledby="adminActionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="adminActionsModalLabel">Pesan Kelas</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="add_jadwal.php" method="post">
                <input type="hidden" name="idkelas" value="<?php echo $kelasId; ?>">

                <div class="row g-3">
                  <div class="col-md-6">
                    <label for="hari" class="form-label">Hari:</label>
                    <select name="hari" class="form-select" required>
                      <option value="senin">Senin</option>
                      <option value="selasa">Selasa</option>
                      <option value="rabu">Rabu</option>
                      <option value="kamis">Kamis</option>
                      <option value="jumat">Jumat</option>
                      <option value="sabtu">Sabtu</option>
                      <option value="minggu">Minggu</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="jam" class="form-label">Jam:</label>
                    <input type="time" name="jam" class="form-control" required>
                  </div>
                  <div class="col-md-6">
                    <label for="durasi" class="form-label">Durasi:</label>
                    <select name="durasi" class="form-select" required>
                      <option value="50 Menit">1 Pelajaran</option>
                      <option value="100 Menit">2 Pelajaran</option>
                      <option value="150 Menit">3 Pelajaran</option>
                      <option value="200 Menit">4 Pelajaran</option>
                      <option value="250 Menit">5 Pelajaran</option>
                      <option value="300 Menit">6 Pelajaran</option>
                    </select>
                  </div>
                </div>
                <button style="background-color: #064e3b;" type="submit" class="btn btn-primary mt-3">Pesan</button>
              </form>
            </div>
          </div>
        </div>
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