<?php
$conn = new PDO("mysql:host=$servername;dbname=task3", $username, $password);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>