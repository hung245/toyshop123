<?php

$dsn = "mysql:host=td5l74lo6615qq42.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;port=3306;dbname=pqexjxo57ht2w73i";
$username = "x859u67buqo6v1iq";
$password = "d7vyekdqwidzd3bv";


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
