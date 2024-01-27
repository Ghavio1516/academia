<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idkelas = $_POST["idkelas"];
    $kelas = $_POST["kelas"];
    $kapasitas = $_POST["kapasitas"];
    $statuspeminjaman = $_POST["statuspeminjaman"];

    $query = "INSERT INTO kelas (id_kelas, nama_kelas, kapasitas_kelas, status_peminjaman) 
              VALUES (:idkelas, :kelas, :kapasitas, :statuspeminjaman)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idkelas', $idkelas);
    $stmt->bindParam(':kelas', $kelas);
    $stmt->bindParam(':kapasitas', $kapasitas);
    $stmt->bindParam(':statuspeminjaman', $statuspeminjaman);

    if ($stmt->execute()) {
        header("location: index.php");
    } else {
        alertWindow("Error: " . $stmt->errorInfo()[2]);   
    }
}

function alertWindow($msg) {       
    echo "<script type ='text/JavaScript'>";  
    echo "alert('$msg')";  
    echo "</script>";   
}
?>
