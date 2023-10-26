<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: process-staff-login.php");
    exit;
}
$dsn = "mysql:host=s465z7sj4pwhp7fn.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;port=3306;dbname=d4h3mjkjk80n2yrp";
$username = "cxyr1qdeadhw1stb";
$password = "bd5sul6vxf3c5fo2";


try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}


if (isset($_GET['ToyID'])) {
    $ToyID = $_GET['ToyID'];

 
    $stmt = $conn->prepare("DELETE FROM toy WHERE ToyID = :ToyID");
    $stmt->bindParam(':ToyID', $ToyID);
    $stmt->execute();

    header("Location: clientforstaff.php");
    exit;
} else {
    echo "Invalid infomation product.";
    exit;
}
