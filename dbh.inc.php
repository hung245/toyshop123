<?php

$dsn = "mysql:host=rwo5jst0d7dgy0ri.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;port=3306;dbname=njv1izd5eu5qyc3x";
      $username = "a8umgzzuseamn7r2";
      $password = "i0p5v9dpkkdxpync"; 


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
