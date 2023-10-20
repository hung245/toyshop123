<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $shopID = $_POST["shopID"];
  $shopname = $_POST["shopname"];
  $address = $_POST["address"];
  $manager = $_POST["manager"];
  $phone = $_POST["phone"];


  $dsn = "mysql:host=s29oj5odr85rij2o.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;port=3306;dbname=lm0ft0r9qtusvm42";
  $username = "dolspoxwgf3anvkc";
  $password = "vvvlinl8ngt5rjnp"; 
  
  
  try {
      $conn = new PDO($dsn, $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
      exit;
  }

  try {

    $sql = "INSERT INTO shop (ShopID, ShopName, Address, Manager, Phone)
            VALUES (:shopID, :shopname, :address, :manager, :phone)";


    $stmt = $conn->prepare($sql);

 
    $stmt->bindParam(":shopID", $shopID);
    $stmt->bindParam(":shopname", $shopname);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":manager", $manager);
    $stmt->bindParam(":phone", $phone);


    $stmt->execute();

    echo "<p class='success-message'>The store has been added successfully.</p>";
  } catch (PDOException $e) {
    echo "<p class='error-message'>Store cannot be added: " . $e->getMessage() . "</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <title>Add Shop</title>
</head>
<body>
  <div class="container">
    <h1 class="heading">Add New Shop</h1>
    <form action="indexshop.php" method="POST">
      <div class="form-group">
        <label for="shopID">Shop ID:</label>
        <input type="text" id="shopID" name="shopID" required>
      </div>
      <div class "form-group">
        <label for="shopname">Shop Name:</label>
        <input type="text" id="shopname" name="shopname" required>
      </div>
      <div class="form-group">
        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea>
      </div>
      <div class="form-group">
        <label for="manager">Manager:</label>
        <input type="text" id="manager" name="manager" required>
      </div>
      <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
      </div>
      <div class="form-group">
        <input type="submit" value="Add Shop" class="submit-button">
      </div>
    </form>
  </div>
</body>
</html>
