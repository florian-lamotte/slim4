<?php
$host = 'localhost';
$dbname = 'slim3';
$name = 'root';
$pass = '';

$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.'', $name, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);