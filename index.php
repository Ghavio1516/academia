<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

include("connection.php");
include("data.php");

$isAdmin = $_SESSION['status_user'] == 'Administrator';
$query = "SELECT * FROM kelas";
$result = $conn->query($query);

$pinjamruangan = array();
if ($result !== false) {
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $pinjamruangan[] = array(
      'id' => $row['id_kelas'],
      'namakelas' => $row['nama_kelas'],
      'kapasitas' => $row['kapasitas_kelas'],
      'statuspeminjaman' => $row['status_peminjaman']
    );
  }
} else {
  echo "Error executing query: " . $conn->errorInfo()[2];
}

$namakelasOptions = array_unique(array_column($pinjamruangan, 'namakelas'));
$kapasitasOptions = array_unique(array_column($pinjamruangan, 'kapasitas'));
$statuspeminjamanOptions = array_unique(array_column($pinjamruangan, 'statuspeminjaman'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peminjaman Kelas</title>
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

    <div class="filter-box" style="padding-bottom: 10px;  border-radius: 30px; padding: 50px;">
      <header class="  text-center text-white">
        <div class="  row ">
          <div class="  col-sm-12 mb-3 mb-sm-0 center mx-auto">
            <div class="  card  ">
              <div style="border-radius: 5px; background-color: #00796B;" class="card-body">
                <h5 class="card-title text-success fw-bolder text-white">Peminjaman Kelas</h5>
                <p class="card-title text-success text-white">UAS WEBPRO</p>
                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#Anggota">
                  <p class="card-text text-light text-dark">Kelompok 6</p>
                </button>
                <div class="modal fade" id="Anggota" tabindex="-1" aria-labelledby="AnggotaLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="AnggotaLabel">Kelompok 6</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <ul class="list-unstyled">
                          <li>Ghavio Rizky Ananda - 2207411034
                          <li>Putra Fajar Ramadhan - 2207411046
                          <li>Muhammad Adnan Fadilah - 2207411048
                          <li>Naura Mufidah - 2207411052
                          <li>Ahmad Ulul Azmi - 2207411053
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>

      <div style="padding-top: 30px;">
        <div class="card width: 100%; height: 100% mx-auto  ">
          <div style="border-radius: 5px; background-color: #00796B;" class="card-body">
            <div class="button">
              <form class="text-white" style="margin-right: 50px;">
                <label for="filterkelas">Nama Kelas:</label>
                <select id="filterkelas">
                  <option value="">-- All --</option>
                  <?php foreach ($namakelasOptions as $option) : ?>
                    <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                  <?php endforeach; ?>
                </select>

                <label for="filterkapasitas">Kapasitas:</label>
                <select id="filterkapasitas">
                  <option value="">-- All --</option>
                  <?php foreach ($kapasitasOptions as $option) : ?>
                    <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                  <?php endforeach; ?>
                </select>

                <label for="filterstatus">Status:</label>
                <select id="filterstatus">
                  <option value="">-- All --</option>
                  <?php foreach ($statuspeminjamanOptions as $option) : ?>
                    <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                  <?php endforeach; ?>
                </select>
                <button type="button" onclick="filterTable()">Cari</button>
              </form>
            </div>
          </div>
        </div>
      </div>


      <?php if ($isAdmin) : ?>
        <div style="margin-top: 5px;">
          <button type="button" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#adminActionsModal">
            Admin Actions
          </button>
        </div>
      <?php endif; ?>

      <div class="modal fade" id="adminActionsModal" tabindex="-1" aria-labelledby="adminActionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="adminActionsModalLabel">Admin Actions</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="add_data.php" method="post">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label for="idkelas" class="form-label">ID Kelas:</label>
                    <input type="text" name="idkelas" class="form-control" required>
                  </div>
                  <div class="col-md-6">
                    <label for="kelas" class="form-label">Nama Kelas:</label>
                    <input type="text" name="kelas" class="form-control" required>
                  </div>
                  <div class="col-md-6">
                    <label for="kapasitas" class="form-label">Kapasitas:</label>
                    <input type="text" name="kapasitas" class="form-control" required>
                  </div>
                  <div class="col-md-6">
                    <label for="statuspeminjaman" class="form-label">Status Peminjaman:</label>
                    <input type="text" name="statuspeminjaman" class="form-control" required>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Tambah Data</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <table class='table table-hover table-bordered '>
        <thead class='table-success'>
          <tr>
            <th class="text-info">NAMA KELAS</th>
            <th class="text-info">KAPASITAS</th>
            <th class="text-info">STATUS</th>
            <th class="text-info">AKSI</th>
          </tr>
        </thead>
        <tbody id="TableJadwal">
          <?php foreach ($pinjamruangan as $key => $jadwal) : ?>
            <tr class="<?php echo $key % 2 == 0 ? 'table-primary' : 'table-info'; ?>">
              <td><?php echo $jadwal['namakelas']; ?></td>
              <td><?php echo $jadwal['kapasitas']; ?></td>
              <td><?php echo $jadwal['statuspeminjaman']; ?></td>
              <td>
                <a href="edit_data.php?id=<?php echo $jadwal['id']; ?>" class="btn btn-success">Edit</a>
                <a href="remove_data.php?id=<?php echo $jadwal['id']; ?>" class="btn btn-success">Remove</a>
                <a href="detail_kelas.php?id=<?php echo $jadwal['id']; ?>" class="btn btn-info">Detail</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>


    </div>
  </div>
  </div>
  <script src="Script.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>