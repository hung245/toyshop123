<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: process-staff-login.php");
    exit;
}
$dsn = "mysql:host=rwo5jst0d7dgy0ri.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;port=3306;dbname=oy94weq8rrkmm3im";
$username = "av4keuay3bl923e7";
$password = "shseyj3sc3osbw9z";


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
