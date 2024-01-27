<?php
$servername = "103.167.35.113";
$username = "delatte";
$password = "Everettt707123";

try {
    $conn = new PDO("mysql:host=$servername;dbname=webpro", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>