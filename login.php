<?php
session_start();

$users = [
    'admin' => ['password' => 'admin', 'role' => 'admin'],
    'siswa'=> ['password'=> 'siswa','role'=> 'siswa'],
    'dosen'=> ['password'=> 'dosen','role'=> 'dosen'],
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($users[$username]) && $users[$username]['password'] == $password) {
        $_SESSION['role'] = $users[$username]['role'];
        header('Location: schedule.php');
        exit();
    } else {
        $message = 'Invalid credentials';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spirit Academia by Ghavio</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #34eb5b;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 300px;
            margin: auto;
        }

        label {
            font-weight: bold;
        }

        input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            color: red;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Spirit Academia V2 by Ghavio</h1>
        <h2>Login</h2>
        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>
