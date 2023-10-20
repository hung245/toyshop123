<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $staffID = $_POST["staffID"];
  $staffName = $_POST["staffName"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $phone = $_POST["phone"];
  $shopID = $_POST["shopID"];

  $dsn = "mysql:host=s29oj5odr85rij2o.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;port=3306;dbname=erf4p42dq0r2dxvv";
  $username = "h9h1633x6ek8iw6v";
  $password = "fjyr5bd0t2ypluj6";
  

  try {
    $conn = new PDO($dsn, $username, $Password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
  }

  $checkSql = "SELECT COUNT(*) FROM staff WHERE StaffID = :staffID";
  $checkStmt = $conn->prepare($checkSql);
  $checkStmt->bindParam(":staffID", $staffID);
  $checkStmt->execute();
  $count = $checkStmt->fetchColumn();

  if ($count > 0) {
    $errorMessage = "Staff member with this StaffID already exists. Please choose a different StaffID.";
  } else {
    try {
      $sql = "INSERT INTO staff (StaffID, StaffName, Email, Password, Phone, ShopID) 
              VALUES (:staffID, :staffName, :email, :password, :phone, :shopID)";

      $stmt = $conn->prepare($sql);

      $stmt->bindParam(":staffID", $staffID);
      $stmt->bindParam(":staffName", $staffName);
      $stmt->bindParam(":email", $email);
      $stmt->bindParam(":password", $password);
      $stmt->bindParam(":phone", $phone);
      $stmt->bindParam(":shopID", $shopID);

      $stmt->execute();

      $successMessage = "Staff member added successfully.";
    } catch (PDOException $e) {
      $errorMessage = "Unable to add the staff member: " . $e->getMessage();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
  <div class="container">
    <h1 class="heading">Add New Staff</h1>
    <form action="add_staff.php" method="POST">
      <div class="form-group">
        <label for="staffID">Staff ID:</label>
        <input type="text" id="staffID" name="staffID" required>
      </div>
      <div class="form-group">
        <label for="staffName">Staff Name:</label>
        <input type="text" id="staffName" name="staffName" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
      </div>
      <div class="form-group">
        <label for="shopID">Shop ID:</label>
        <input type="text" id="shopID" name="shopID" required>
      </div>
      <div class="form-group">
        <input type="submit" value="Add Staff" class="submit-button">
      </div>
    </form>
    <?php if (isset($successMessage)) : ?>
      <p class="success-message"><?php echo $successMessage; ?></p>
    <?php elseif (isset($errorMessage)) : ?>
      <p class="error-message"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
  </div>
</body>
</html>
