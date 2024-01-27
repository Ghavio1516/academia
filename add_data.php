<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $idkelas = $_POST["idkelas"];
    $kelas = $_POST["kelas"];
    $hari = $_POST["hari"];
    $jam = $_POST["jam"];
    $kapasitas = $_POST["kapasitas"];
    $statuspeminjaman = $_POST["statuspeminjaman"];

    // Lakukan operasi INSERT ke database
    $query = "INSERT INTO kelas (id_kelas, nama_kelas, hari, jam, kapasitas_kelas, status_peminjaman) 
              VALUES (:idkelas, :kelas, :hari, :jam, :kapasitas, :statuspeminjaman)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idkelas', $idkelas);
    $stmt->bindParam(':kelas', $kelas);
    $stmt->bindParam(':hari', $hari);
    $stmt->bindParam(':jam', $jam);
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



$conn = null; // Close the connection
?>
