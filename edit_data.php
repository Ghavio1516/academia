<?php
include("connection.php");
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM kelas WHERE id_kelas = :id";
    $statement = $conn->prepare($query);
    $statement->execute(['id' => $id]);
    $data = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo "Data not found.";
        exit;
    }
} else {
    echo "ID not provided.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newNamaKelas = $_POST["kelas"];
    $newKapasitas = $_POST["kapasitas"];
    $newStatus = $_POST["statuspeminjaman"];

    $updateQuery = "UPDATE kelas SET nama_kelas = :nama_kelas, kapasitas_kelas = :kapasitas_kelas, status_peminjaman = :status_peminjaman WHERE id_kelas = :id";
    $updateStatement = $conn->prepare($updateQuery);
    $updateStatement->execute([
        'id' => $id,
        'nama_kelas' => $newNamaKelas,
        'kapasitas_kelas' => $newKapasitas,
        'status_peminjaman' => $newStatus
    ]);

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <div class=" page-holder bg-cover">
        <nav class="  navbar navbar-expand-xl navbar-light bg-light">
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
    </div>
    <div class="container mt-5">
        <h2>Edit Data</h2>
        <form action="<?php echo ($_SERVER["PHP_SELF"] . "?id=" . $id); ?>" method="post">
            <div class="mb-3">
                <label for="kelas" class="form-label">Nama Kelas:</label>
                <input type="text" class="form-control" name="kelas" value="<?php echo isset($data['nama_kelas']) ? $data['nama_kelas'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="kapasitas" class="form-label">Kapasitas:</label>
                <input type="text" class="form-control" name="kapasitas" value="<?php echo isset($data['kapasitas_kelas']) ? $data['kapasitas_kelas'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="statuspeminjaman" class="form-label">Status Peminjaman:</label>
                <input type="text" class="form-control" name="statuspeminjaman" value="<?php echo isset($data['status_peminjaman']) ? $data['status_peminjaman'] : ''; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>