<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idkelas = $_POST["idkelas"];
    $hari = $_POST["hari"];
    $jam = $_POST["jam"];
    $durasi = $_POST["durasi"];

    $jam_durasi = "$jam - $durasi";

    $checkQuery = "SELECT $hari FROM jadwal_kelas WHERE id_kelas = :idkelas";
    $checkStatement = $conn->prepare($checkQuery);
    $checkStatement->execute(['idkelas' => $idkelas]);
    $existingData = $checkStatement->fetch(PDO::FETCH_ASSOC);

    if ($existingData[$hari]) {
        $updateQuery = "UPDATE jadwal_kelas SET $hari = :jam_durasi WHERE id_kelas = :idkelas";
        $updateStatement = $conn->prepare($updateQuery);
        $updateStatement->execute(['jam_durasi' => $jam_durasi, 'idkelas' => $idkelas]);
    } else {
        $insertQuery = "INSERT INTO jadwal_kelas (id_kelas, $hari) VALUES (:idkelas, :jam_durasi)";
        $insertStatement = $conn->prepare($insertQuery);
        $insertStatement->execute(['idkelas' => $idkelas, 'jam_durasi' => $jam_durasi]);
    }

    header("Location: detail_kelas.php?id=$idkelas");
    exit;
}
?>
