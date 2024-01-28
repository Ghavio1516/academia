<?php
session_start();
include("connection.php");

if (isset($_POST["login"])) {
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        $message = '<label>All fields are required</label>';
    } else {
        $query = "SELECT * FROM user WHERE nama_user = :username AND password_user = :password";
        $statement = $conn->prepare($query);
        $statement->execute(
            array(
                'username' => $_POST["username"],
                'password' => $_POST["password"]
            )
        );
        $count = $statement->rowCount();
        if ($count > 0) {
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            $_SESSION["username"] = $_POST["username"];
            $_SESSION["status_user"] = $user["status_user"];
            header("location: index.php");
        } else {
            $message = '<label>Wrong Username or Password</label>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spirit Academia</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-container">
        <div class="login2">
            <img src="./Meta/logoooo0.png" alt="logo">
            <h1>PNJ Academia</h1>
        </div>
        <div class="login">
            <h3>Sign In</h3>
            <?php
            if (isset($message)) {
                echo '<label class="text-danger">' . $message . '</label>';
            }
            ?>
            <form method="post">
                <input type="text" placeholder="Username" name="username" class="form-control">
                <input type="password" placeholder="Password" name="password" class="form-control">
                <button type="submit" name="login" class="btn btn-info" value="Login">Login</button>
            </form>
        </div>
    </div>
</body>

</html>