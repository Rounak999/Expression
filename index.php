<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['username'] !== 'admin') {
    header("Location: user.php");
    exit();
}
$target = rand(1000, 9999); // Random target number for the challenge
$_SESSION['target'] = $target;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🏁 Math Challenge: Crack the Code! 🏆</title>
    <style>
        body {
            background: #0f172a; /* Dark sporty background */
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
            border: 3px solid #3b82f6; /* Sporty blue outline */
            border-radius: 15px;
            padding: 30px;
            width: 100%;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.8);
        }
        h1 {
            color: #3b82f6;
            margin-bottom: 10px;
        }
        .highlight {
            color: #facc15;
            font-weight: bold;
            font-size: 24px;
        }
        input[type='text'] {
            width: 90%;
            padding: 10px;
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
        .hint {
            margin-top: 15px;
            font-size: 14px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏆 Math Challenge: Crack the Code! 🏁</h1>
        <p>Your target number is: <span class="highlight"><?= $target; ?></span></p>
        <form method="POST" action="process.php">
            <input type="text" name="expression" placeholder="Enter your expression..." required>
            <br>
            <button type="submit">🔢 Submit Answer</button>
        </form>
        <p class="hint">💡 Hint: Use numbers and math operators like `+`, `-`, `*`, `/`. Can you find a creative way? 😉</p>
    </div>
</body>
</html>
