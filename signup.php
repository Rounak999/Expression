<?php
session_start();
include 'db_connect.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "⚠️ Username and Password cannot be empty!";
    } else {
        // Check if username exists
        $checkUserQuery = "SELECT COUNT(*) FROM users WHERE userid = $1";
        $result = pg_query_params($conn, $checkUserQuery, array($username));

        if ($result) {
            $row = pg_fetch_row($result);
            if ($row[0] > 0) {
                $error = "⚠️ Username already taken!";
            } else {
                // Get current user count
                $userCountQuery = "SELECT COUNT(*) FROM users";
                $userCountResult = pg_query($conn, $userCountQuery);
                $userCountRow = pg_fetch_row($userCountResult);
                $userIndex = (int)$userCountRow[0] + 1;

                // Generate predictable token
                $baseNum = $userIndex * 1111;
                $tokenValue = "$baseNum-" . ($baseNum + 3232) . "-" . ($baseNum + 42236) . "-" . ($baseNum + 34543);
                $token = base64_encode($tokenValue);

                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert user into the database
                $insertQuery = "INSERT INTO users (userid, password, token) VALUES ($1, $2, $3)";
                $insertResult = pg_query_params($conn, $insertQuery, array($username, $hashedPassword, $token));

                if ($insertResult) {
                    $success = "✅ Signup Successful! Your token: <strong>$token</strong>";
                } else {
                    $error = "❌ Error signing up: " . pg_last_error($conn);
                }
            }
        } else {
            $error = "❌ Database error: " . pg_last_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Math Solver CTF</title>
    <style>
        body {
    background-color: #0d1117;
    font-family: 'Courier New', monospace;
    color: white;
    text-align: center;
}

.ctf-container {
    width: 100%;
    max-width: 500px; /* Keep it wide */
    margin: 50px auto;
    padding: 20px;
}

.ctf-title {
    font-size: 26px;
    font-weight: bold;
    text-shadow: 0 0 10px cyan, 0 0 20px blue;
}

.ctf-box {
    background: #161b22;
    border: 2px solid cyan;
    border-radius: 10px;
    padding: 35px 40px; /* Equal padding */
    box-shadow: 0 0 15px cyan, 0 0 30px blue;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.ctf-input {
    width: 90%; /* Reduce width slightly to create balance */
    padding: 12px;
    margin: 10px 0;
    border: 2px solid cyan;
    border-radius: 5px;
    background: #0d1117;
    color: white;
    font-size: 18px;
    text-shadow: 0 0 10px cyan;
    text-align: center; /* Center input text */
}

.ctf-button {
    width: 95%;
    padding: 12px;
    background: cyan;
    border: none;
    border-radius: 5px;
    color: black;
    font-weight: bold;
    font-size: 18px;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 0 10px cyan, 0 0 20px blue;
}

.ctf-button:hover {
    background: blue;
    color: white;
    box-shadow: 0 0 15px cyan, 0 0 30px blue;
}

.ctf-text {
    margin-top: 15px;
    font-size: 15px;
}

.ctf-link {
    color: cyan;
    text-decoration: none;
    text-shadow: 0 0 5px cyan;
}

.ctf-link:hover {
    text-decoration: underline;
}

.ctf-error {
    color: red;
    font-weight: bold;
    text-shadow: 0 0 5px red;
}

.ctf-success {
    color: limegreen;
    font-weight: bold;
    text-shadow: 0 0 5px lime;
}
    </style>
</head>
<body>
    <div class="ctf-container">
        <h1 class="ctf-title">🚀 Sign Up</h1>

        <div class="ctf-box">
            <?php if (isset($error)) echo "<p class='ctf-error'>$error</p>"; ?>
            <?php if (isset($success)) echo "<p class='ctf-success'>$success</p>"; ?>

            <form action="signup.php" method="POST">
                <input type="text" name="username" class="ctf-input" placeholder="Enter Username" required>
                <input type="password" name="password" class="ctf-input" placeholder="Enter Password" required>
                <button type="submit" class="ctf-button">Register</button>
            </form>
            <p class="ctf-text">Already have an account? <a href="index.php" class="ctf-link">Login</a></p>
            <p class="ctf-text">Forgot Password? <a href="forgot_password.php" class="ctf-link">Forgot password</a></p>
        </div>
    </div>
</body>
</html>
