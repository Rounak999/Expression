<?php
session_start();
include 'db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query to fetch hashed password
    $sql = "SELECT password FROM users WHERE userid = $1";
    $result = pg_query_params($conn, $sql, array($username));

    if ($result && pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);
        
        // Verify the hashed password
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            
            if ($username === 'admin') {
                header("Location: index.php");
            } else {
                header("Location: user.php");
            }
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🔐 Login - Math Solver CTF</title>
    <style>
        body {
            background: #0f172a;
            color: #f8fafc;
            font-family: 'Arial', sans-serif;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .container {
            background: #1e293b;
            border: 3px solid #3b82f6;
            border-radius: 15px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.8);
        }
        h1 {
            color: #3b82f6;
            margin-bottom: 10px;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 2px solid #3b82f6;
            border-radius: 5px;
            background: #0f172a;
            color: #f8fafc;
        }
        button {
            margin-top: 15px;
            background-color: #3b82f6;
            color: #f8fafc;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        button:hover {
            background-color: #1e40af;
        }
        .error {
            color: #f87171;
            margin-top: 10px;
        }
        .link {
            margin-top: 10px;
            font-size: 14px;
            color: #94a3b8;
        }
        .link a {
            color: #3b82f6;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Login</h1>
        <?php if ($error): ?>
            <p class="error"><?= $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit">Login</button>
        </form>
        <p class="link">New user? <a href="signup.php">Sign up</a></p>
        <p class="link">Change Password? <a href="forgot_password.php">Forgot Password</a></p>
    </div>
</body>
</html>
