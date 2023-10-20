<?php
  $dsn = "mysql:host=s29oj5odr85rij2o.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;port=3306;dbname=lm0ft0r9qtusvm42";
  $username = "dolspoxwgf3anvkc";
  $password = "vvvlinl8ngt5rjnp"; 


$imageDir = "images/"; 

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["search"])) {
    $searchKeyword = $_GET["search"];

    $sql = "SELECT ToyID, Toy_Name, description, Original_price, Selling_price, Quantity, Product_import_date, Product_import_staff, Shop_ID, Supplier_ID, image
            FROM toy
            WHERE Toy_Name LIKE :searchKeyword
            OR description LIKE :searchKeyword";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":searchKeyword", "%$searchKeyword%", PDO::PARAM_STR);
    $stmt->execute();
    $toys = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = "SELECT ToyID, Toy_Name, description, Original_price, Selling_price, Quantity, Product_import_date, Product_import_staff, Shop_ID, Supplier_ID, image FROM toy";
    $stmt = $conn->query($sql);
    $toys = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    header {
      background-color: #333;
      color: #fff;
      text-align: center;
      padding: 20px 0;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      position: relative;
    }

    h1 {
      font-size: 36px;
      margin: 0;
    }

    h2 {
      font-size: 24px;
      margin: 20px 0;
    }

    .product {
      border: 1px solid #ddd;
      margin: 10px 0;
      padding: 10px;
      border-radius: 5px;
    }

    .product-details {
      font-size: 16px;
    }

    .product-name {
      font-size: 24px;
      font-weight: bold;
    }

    .product-description {
      margin-top: 10px;
    }

    .product-price {
      margin: 5px 0;
    }

    .login-buttons {
      position: absolute;
      top: 20px;
      right: 20px;
    }

    .login-button {
      background-color: #333;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      margin-left: 10px;
    }

    .search-form {
      text-align: center;
      margin-top: 20px;
    }

    .search-input {
      width: 300px;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }
    .product-image {
  max-width: 300px; 
  height: auto; 
}

  </style>
</head>
<body>
  <header>
    <h1>Toy Shop</h1>
  </header>
  <div class="container">
    <h2>Product List</h2>
   
    <form class="search-form" method="GET" action="index.php">
      <input class="search-input" type="text" name="search" placeholder="Search products">
      <button type="submit">Search</button>
    </form>
    
    <?php if (!empty($toys)): ?>
      <?php foreach ($toys as $toy): ?>
        <div class="product">
          <div class="product-details">
          <img src="<?= $toy['image'] ?>" alt="<?= $toy['Toy_Name'] ?>" class="product-image">
            <h3 class="product-name"><?= $toy['Toy_Name'] ?></h3>
            <p class="product-description"><?= $toy['description'] ?></p>
            <p class="product-price">Selling Price: $<?= $toy['Selling_price'] ?></p>
            <p class="product-price">Quantity: <?= $toy['Quantity'] ?></p>
            <p class="product-price">Shop ID: <?= $toy['Shop_ID'] ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No products found.</p>
    <?php endif; ?>
    <div class="login-buttons">
      <a href="staff-login.php" class="login-button">Login as Staff</a>
      <a href="customer-login.php" class="login-button">Login as Customer</a>
    </div>
  </div>
</body>
</html>
