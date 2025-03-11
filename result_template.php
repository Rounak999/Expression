<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🏁 Math Challenge Results 🏆</title>
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
            border: 3px solid #3b82f6;
            border-radius: 15px;
            padding: 30px;
            width: 100%;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.8);
        }
        h1 {
            color: <?= $resultType === 'success' ? '#10b981' : '#ef4444' ?>;
            margin-bottom: 10px;
        }
        a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: bold;
            margin-top: 15px;
            display: inline-block;
            border: 2px solid #3b82f6;
            padding: 8px 20px;
            border-radius: 5px;
            background: #1e40af;
            transition: background 0.3s ease;
        }
        a:hover {
            background: #2563eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $message; ?></h1>
        <a href="index.php">🔙 Try Again</a>
    </div>
</body>
</html>
