<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Access Restricted</title>
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
            color: #f87171;
        }
        p {
            font-size: 16px;
            color: #94a3b8;
        }
        a {
            color: #3b82f6;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚫 Access Denied</h1>
        <p>Login as admin to get the math challenge.</p>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
