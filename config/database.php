<?php

$host = '127.0.0.1';
$port = '3306';
$dbname = 'pbl_ti_2025_b_zahir';
$username = 'root';
$password = '';

$db = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->exec("SET time_zone = '+07:00'");
