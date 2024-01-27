<?php
session_start();

include("connection.php");

if (!isset($_SESSION['status_user'])) {
  header('Location: login.php');
  exit();
}

include("data.php");
$isAdmin = $_SESSION['status_user'] == 'Administrator';

$matkulOptions = array_unique(array_column($jadwalmatkul, 'matkul'));
$hariOptions = array_unique(array_column($jadwalmatkul, 'hari'));
$jamOptions = array_unique(array_column($jadwalmatkul, 'jam'));
$lokasiOptions = array_unique(array_column($jadwalmatkul, 'lokasi'));
$dosenOptions = array_unique(array_column($jadwalmatkul, 'dosen'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peminjaman Kelas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script>
    function filterTable() {
      var filterMatkul = $("#filterMatkul").val().toLowerCase();
      var filterJam = $("#filterJam").val().toLowerCase();
      var filterLokasi = $("#filterLokasi").val().toLowerCase();
      var filterNama = $("#filterNama").val().toLowerCase();

      $("#TableJadwal tr").each(function() {
        var matkulText = $(this).find("td:nth-child(1)").text().toLowerCase();
        var jamText = $(this).find("td:nth-child(3)").text().toLowerCase();
        var lokasiText = $(this).find("td:nth-child(4)").text().toLowerCase();
        var namaText = $(this).find("td:nth-child(5)").text().toLowerCase();

        var matkulMatch = filterMatkul === '' || matkulText.includes(filterMatkul);
        var jamMatch = filterJam === '' || jamText.includes(filterJam);
        var lokasiMatch = filterLokasi === '' || lokasiText.includes(filterLokasi);
        var namaMatch = filterNama === '' || namaText.includes(filterNama);

        $(this).toggle(matkulMatch && jamMatch && lokasiMatch && namaMatch);
      });
    }
  </script>
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
          <a class="navbar-brand" href="login.php">
            <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            (Ini ambil username bisa ga sih?)
          </a>
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
                        Isi Anggota
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
              <label for="filterMatkul">Mata Kuliah:</label>
              <select id="filterMatkul">
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

              <label for="filterLokasi">Lokasi:</label>
              <select id="filterLokasi">
                <option value="">-- All --</option>
                <?php foreach ($lokasiOptions as $option) : ?>
                  <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                <?php endforeach; ?>
              </select>

              <label for="filterNama">Nama Dosen:</label>
              <select id="filterNama">
                <option value="">-- All --</option>
                <?php foreach ($dosenOptions as $option) : ?>
                  <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                <?php endforeach; ?>
              </select>

              <button type="button" onclick="filterTable()">Cari</button>
            </form>
          </div>

          <?php if ($isAdmin) : ?>
            <div style="margin-top: 20px;">
              <h2>Admin Actions</h2>
              <form enctype="multipart/form-data" action="upload.php" method="post">
                <label for="file">Upload File:</label>
                <input type="file" name="file" id="file" required>
                <button type="submit">Upload</button>
              </form>
            </div>
          <?php endif; ?>

          <table class='table table-hover table-bordered '>
            <thead class='table-success'>
              <tr>
                <th class="text-info">MATA KULIAH</th>
                <th class="text-info">HARI</th>
                <th class="text-info">JAM/DURASI</th>
                <th class="text-info">LOKASI</th>
                <th class="text-info">DOSEN</th>
              </tr>
            </thead>

            <tbody id="TableJadwal">
              <?php foreach ($jadwalmatkul as $key => $jadwal) : ?>
                <tr class="<?php echo $key % 2 == 0 ? 'table-primary' : 'table-info'; ?>">
                  <td><?php echo $jadwal['matkul']; ?></td>
                  <td><?php echo $jadwal['hari']; ?></td>
                  <td><?php echo $jadwal['jam']; ?></td>
                  <td><?php echo $jadwal['lokasi']; ?></td>
                  <td><?php echo $jadwal['dosen']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>