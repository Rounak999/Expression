<?php
$servername = "expression_db";
$username = "rounakadmin";
$password = "rounakadmin";
$dbname = "expression";

// Create connection
$conn = pg_connect("host=$servername dbname=$dbname user=$username password=$password");

// Check connection
if (!$conn) {
    die("Database Connection Failed: " . pg_last_error());
}
?>
