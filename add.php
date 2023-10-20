<?php
$errorMessage = '';
$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $toyName = $_POST["toy_name"];
    $description = $_POST["description"];
    $originalPrice = $_POST["original_price"];
    $sellingPrice = $_POST["selling_price"];
    $quantity = $_POST["quantity"];
    $productImportDate = $_POST["Product_import_date"];
    $productImportStaff = $_POST["Product_import_staff"];
    $shopID = $_POST["shop_id"];
    $supplierID = $_POST["supplier_id"];

    $imgdir = '';
    $img = $imgdir . str_replace(' ', '-', $_FILES['image']['name']); 

    if (move_uploaded_file($_FILES['image']['tmp_name'], $img)) {
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

        $shopCheckSql = "SELECT COUNT(*) FROM shop WHERE ShopID = :shopID";
        $shopCheckStmt = $conn->prepare($shopCheckSql);
        $shopCheckStmt->bindParam(":shopID", $shopID);
        $shopCheckStmt->execute();
        $shopCount = $shopCheckStmt->fetchColumn();

        $supplierCheckSql = "SELECT COUNT(*) FROM supplier WHERE SupplierID = :supplierID";
        $supplierCheckStmt = $conn->prepare($supplierCheckSql);
        $supplierCheckStmt->bindParam(":supplierID", $supplierID);
        $supplierCheckStmt->execute();
        $supplierCount = $supplierCheckStmt->fetchColumn();

        $staffCheckSql = "SELECT COUNT(*) FROM staff WHERE StaffID = :productImportStaff";
        $staffCheckStmt = $conn->prepare($staffCheckSql);
        $staffCheckStmt->bindParam(":productImportStaff", $productImportStaff);
        $staffCheckStmt->execute();
        $staffCount = $staffCheckStmt->fetchColumn();

        if ($shopCount > 0 && $supplierCount > 0 && $staffCount > 0) {
            try {
                $sql = "INSERT INTO toy (Toy_Name, Description, Original_Price, Selling_Price, Quantity, Product_Import_Date, Product_Import_Staff, Shop_ID, Supplier_ID, image)
                        VALUES (:toyName, :description, :originalPrice, :sellingPrice, :quantity, :productImportDate, :productImportStaff, :shopID, :supplierID, :image)";

                $stmt = $conn->prepare($sql);

                $stmt->bindParam(":toyName", $toyName);
                $stmt->bindParam(":description", $description);
                $stmt->bindParam(":originalPrice", $originalPrice);
                $stmt->bindParam(":sellingPrice", $sellingPrice);
                $stmt->bindParam(":quantity", $quantity);
                $stmt->bindParam(":productImportDate", $productImportDate);
                $stmt->bindParam(":productImportStaff", $productImportStaff);
                $stmt->bindParam(":shopID", $shopID);
                $stmt->bindParam(":supplierID", $supplierID);
                $stmt->bindParam(":image", $img);

                if ($stmt->execute()) {
                    $successMessage = "Product added successfully.";
                    // Optionally, you can also clear the form input fields here.
                } else {
                    $errorMessage = "An error occurred while adding product information.";
                }
            } catch (PDOException $e) {
                $errorMessage = "Unable to add the product: " . $e->getMessage();
            }
        } else {
            $errorMessage = "Shop ID, Supplier ID, or Product Import Staff does not exist. Please enter valid information.";
        }
    } else {
        $errorMessage = "Error moving the uploaded image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toy Shop</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
    }
    .container {
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
    }
    .heading {
      text-align: center;
      color: #333;
    }
    .form-group {
      margin: 10px 0;
    }
    label {
      display: block;
      margin-bottom: 5px;
      color: #333;
    }
    input[type="text"],
    input[type="number"],
    textarea,
    input[type="date"],
    input[type="file"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }
    input[type="submit"] {
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 3px;
      padding: 10px 20px;
      cursor: pointer;
    }
    input[type="submit"]:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="heading">Add a New Product</h1>
    <form action="add.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="toy_name">Toy Name:</label>
        <input type="text" id="toy_name" name="toy_name" required>
      </div>
      <div class "form-group">
        <label for "description">Description:</label>
        <textarea id="description" name="description" required></textarea>
      </div>
      <div class="form-group">
        <label for="original_price">Original Price:</label>
        <input type="number" id="original_price" name="original_price" step="0.01" required>
      </div>
      <div class="form-group">
        <label for="selling_price">Selling Price:</label>
        <input type="number" id="selling_price" name="selling_price" step="0.01" required>
      </div>
      <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>
      </div>
      <div class="form-group">
        <label for="Product_import_date">Product Import Date:</label>
        <input type="date" id="Product_import_date" name="Product_import_date" required>
      </div>
      <div class="form-group">
        <label for="Product_import_staff">Product Import Staff:</label>
        <input type="text" id="Product_import_staff" name="Product_import_staff" required>
      </div>
      <div class="form-group">
        <label for="shop_id">Shop ID:</label>
        <input type="number" id="shop_id" name="shop_id" required>
      </div>
      <div class="form-group">
        <label for="supplier_id">Supplier ID:</label>
        <input type="number" id="supplier_id" name="supplier_id" required>
      </div>
      <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" name="image" id="image" accept="image/*" required>
      </div>
      <div class="form-group">
        <input type="submit" value="Add Product" class="submit-button">
      </div>
      <div class="form-group">
  <a href="clientforstaff.php" class="back-button">Back to Product List</a>
</div>

      
      <?php if (!empty($errorMessage)) : ?>
        <p class="error-message"><?php echo $errorMessage; ?></p>
      <?php elseif (!empty($successMessage)) : ?>
        <p class="success-message"><?php echo $successMessage; ?></p>
      <?php endif; ?>
    </form>
  </div>
  
</body>
</html>
