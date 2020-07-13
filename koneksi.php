<?php 
 $host = "localhost";
 $dbname = "db_latihan";
 $username = "root";
 $password = "";
 $db = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>