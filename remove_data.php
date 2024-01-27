<?php
include("connection.php");

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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remove"])) {
    $deleteQuery = "DELETE FROM kelas WHERE id_kelas = :id";
    $deleteStatement = $conn->prepare($deleteQuery);
    $deleteStatement->execute(['id' => $id]);

    header("Location: index.php");
    exit;
}
?>