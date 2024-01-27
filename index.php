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

// Menyusun data ke dalam array $jadwalmatkul
$jadwalmatkul = array();
if ($result !== false) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $jadwalmatkul[] = array(
            'matkul' => $row['nama_kelas'],
            'hari' =>  $row['hari'], 
            'jam' =>  $row['jam'], 
            'kapasitas' => $row['kapasitas_kelas'],
            'statuspeminjaman' => $row['status_peminjaman']
        );
    }
} else {
    // Handle the query error if needed
    echo "Error executing query: " . $conn->errorInfo()[2];
}

$matkulOptions = array_unique(array_column($jadwalmatkul, 'matkul'));
$hariOptions = array_unique(array_column($jadwalmatkul, 'hari'));
$jamOptions = array_unique(array_column($jadwalmatkul, 'jam'));
$kapasitasOptions = array_unique(array_column($jadwalmatkul, 'kapasitas'));
$statuspeminjamanOptions = array_unique(array_column($jadwalmatkul, 'statuspeminjaman'));
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
  <div style="background: url(https://cdn.discordapp.com/attachments/932451666081513552/1176136804810891284/pnj.jpg?ex=656dc5c1&is=655b50c1&hm=25cb8e9a374babdd0f16ec4f14bc066daee2b2d94ae5df681c3d27940f613b85&)" class="page-holder bg-cover">
    <nav class="navbar navbar-expand-xl navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
          <ul class="navbar-nav me-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <a class="nav-link active" href="#" aria-current="page">Home
                <span class="visually-hidden">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
              <div class="dropdown-menu" aria-labelledby="dropdownId">
                <a class="dropdown-item" href="#">Action 1</a>
                <a class="dropdown-item" href="#">Action 2</a>
              </div>
            </li>
          </ul>
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
      </div>
    </nav>

    <div class="container py-5">
      <header class="text-center text-white py-5">
        <div class="row">
          <div class="col-sm-12 mb-3 mb-sm-0 center mx-auto">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-success fw-bolder">Peminjaman Kelas</h5>
                <p class="card-title text-success">UAS WEBPRO</p>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Anggota">
                  <p class="card-text text-light">Kelompok 6</p>
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

      <div class='container'>
        <div style="padding-top: 20px;">
          <div class="button" style="padding-bottom: 20px;">
            <form>
              <label for="filterkelas">Nama Kelas:</label>
              <select id="filterkelas">
                <option value="">-- All --</option>
                <?php foreach ($matkulOptions as $option) : ?>
                  <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                <?php endforeach; ?>
              </select>

              <label for="filterJam">Jam/Durasi:</label>
              <select id="filterJam">
                <option value="">-- All --</option>
                <?php foreach ($jamOptions as $option) : ?>
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

          <?php if ($isAdmin) : ?>
            <div style="margin-top: 20px;">
                <h2>Admin Actions</h2>
                <form action="add_data.php" method="post">
                    <label for="idkelas">ID Kelas:</label>
                    <input type="text" name="idkelas" required>

                    <label for="kelas">Nama Kelas:</label>
                    <input type="text" name="kelas" required>
                    
                    <label for="hari">Hari:</label>
                    <input type="text" name="hari" required>

                    <label for="jam">Jam/Durasi:</label>
                    <input type="text" name="jam" required>

                    <label for="kapasitas">Kapasitas:</label>
                    <input type="text" name="kapasitas" required>

                    <label for="statuspeminjaman">Status Peminjaman:</label>
                    <input type="text" name="statuspeminjaman" required>

                    <button type="submit">Tambah Data</button>
                </form>
            </div>
        <?php endif; ?>


          <table class='table table-hover table-bordered '>
            <thead class='table-success'>
              <tr>
                <th class="text-info">NAMA KELAS</th>
                <th class="text-info">HARI</th>
                <th class="text-info">JAM/DURASI</th>
                <th class="text-info">KAPASITAS</th>
                <th class="text-info">STATUS</th>
              </tr>
            </thead>

            <tbody id="TableJadwal">
              <?php foreach ($jadwalmatkul as $key => $jadwal) : ?>
                  <tr class="<?php echo $key % 2 == 0 ? 'table-primary' : 'table-info'; ?>">
                      <td><?php echo $jadwal['matkul']; ?></td>
                      <td><?php echo $jadwal['hari']; ?></td>
                      <td><?php echo $jadwal['jam']; ?></td>
                      <td><?php echo $jadwal['kapasitas']; ?></td>
                      <td><?php echo $jadwal['statuspeminjaman']; ?></td>
                  </tr>
              <?php endforeach; ?>
          </tbody>

          </table>
        </div>
      </div>
    </div>
  </div>
  <script>
    function filterTable() {
      var filterkelas = $("#filterkelas").val().toLowerCase();
      var filterJam = $("#filterJam").val().toLowerCase();
      var filterkapasitas = $("#filterkapasitas").val().toLowerCase();
      var filterstatus = $("#filterstatus").val().toLowerCase();

      $("#TableJadwal tr").each(function() {
        var matkulText = $(this).find("td:nth-child(1)").text().toLowerCase();
        var jamText = $(this).find("td:nth-child(3)").text().toLowerCase();
        var kapasitasText = $(this).find("td:nth-child(4)").text().toLowerCase();
        var namaText = $(this).find("td:nth-child(5)").text().toLowerCase();

        var matkulMatch = filterkelas === '' || matkulText.includes(filterkelas);
        var jamMatch = filterJam === '' || jamText.includes(filterJam);
        var kapasitasMatch = filterkapasitas === '' || kapasitasText.includes(filterkapasitas);
        var namaMatch = filterstatus === '' || namaText.includes(filterstatus);

        $(this).toggle(matkulMatch && jamMatch && kapasitasMatch && namaMatch);
      });
    }
  </script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>