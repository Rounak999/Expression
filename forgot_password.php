<?php
session_start();
include 'db_connect.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $token = $_POST['token'] ?? '';

    if (!empty($username) && !empty($newPassword) && !empty($token)) {
        // Fetch stored token
        $result = pg_query_params($conn, "SELECT token FROM users WHERE userid = $1", [$username]);
        if ($result && pg_num_rows($result) > 0) {
            $row = pg_fetch_assoc($result);
            $storedToken = $row['token'];

            if ($storedToken === $token) {
                // Hash the new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the password
                $update = pg_query_params($conn, "UPDATE users SET password = $1 WHERE userid = $2", [$hashedPassword, $username]);
                if ($update) {
                    $message = "<div class='success'>✅ Password successfully updated! <a href='login.php'>Go to Login</a></div>";
                } else {
                    $message = "<div class='error'>❌ Failed to update password.</div>";
                }
            } else {
                $message = "<div class='error'>❌ Invalid token provided.</div>";
            }
        } else {
            $message = "<div class='error'>❌ User not found.</div>";
        }
    } else {
        $message = "<div class='error'>⚠️ All fields are required.</div>";
    }
}

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🔐 Reset Your Password</title>
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
            flex-direction: column;
        }
        .container {
            background: #1e293b;
            border: 3px solid #3b82f6;
            border-radius: 15px;
            padding: 30px;
            width: 100%;
            max-width: 450px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.8);
        }
        h1 {
            color: #3b82f6;
            margin-bottom: 10px;
        }
        input[type='text'], input[type='password'] {
            width: 90%;
            padding: 10px;
            border: 2px solid #3b82f6;
            border-radius: 5px;
            background: #0f172a;
            color: #f8fafc;
            margin-bottom: 10px;
        }
        button {
            margin-top: 10px;
            background-color: #3b82f6;
            color: #f8fafc;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease;
            width: 100%;
        }
        button:hover {
            background-color: #1e40af;
        }
        .success, .error {
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            width: 100%;
        }
        .success {
            background: #10b981;
            color: #fff;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.7);
        }
        .error {
            background: #ef4444;
            color: #fff;
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.7);
        }
        .back {
            margin-top: 10px;
            display: block;
            color: #3b82f6;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Reset Your Password</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="text" name="token" placeholder="Enter Your Token" required>
            <button type="submit">Reset Password</button>
        </form>
        <a href="login.php" class="back">Back to Login</a>
    </div>
    <?= $message ?>
</body>
</html>
