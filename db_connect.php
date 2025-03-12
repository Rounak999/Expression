<?php
$servername = "172.31.160.1";
$username = "rounak";
$password = "rounak";
$dbname = "expression";

// Create connection
$conn = pg_connect("host=$servername dbname=$dbname user=$username password=$password");

// Check connection
if (!$conn) {
    die("Database Connection Failed: " . pg_last_error());
}
?>
