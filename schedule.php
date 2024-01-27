
<?php
session_start();

if (!isset($_SESSION['role'])) {
    header('Location: login.php');
    exit();
}

include("data.php");
$isAdmin = $_SESSION['role'] == 'admin';

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
  <title>Spirit Academia V2 by Ghavio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script>
  function filterTable() {
    var filterMatkul = $("#filterMatkul").val().toLowerCase();
    var filterJam = $("#filterJam").val().toLowerCase();
    var filterLokasi = $("#filterLokasi").val().toLowerCase();
    var filterNama = $("#filterNama").val().toLowerCase();

    $("#TableJadwal tr").each(function () {
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
    <div class="container py-5">
      <header class="text-center text-white py-5">
        <div class="row">
          <div class="col-sm-12 mb-3 mb-sm-0 center mx-auto">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-success fw-bolder">Spirit Academia V2</h1>
                <p class="card-title text-success">UTS WEBPRO</p>
                <p class="card-text text-success">Ghavio Rizky Ananda - 2207411034</p>
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

          <?php if ($isAdmin): ?>
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
</body>
</html>
