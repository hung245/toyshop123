<?php

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


$sql = "SELECT * FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();

$results = $stmt->fetchAll();

foreach ($results as $result) {
  echo $result['name'] . " " . $result['email'] . "\n";
}

$conn = null;
