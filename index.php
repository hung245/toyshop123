<?php
$dsn = "mysql:host=s465z7sj4pwhp7fn.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;port=3306;dbname=d4h3mjkjk80n2yrp";
$username = "cxyr1qdeadhw1stb";
$password = "bd5sul6vxf3c5fo2";

$imageDir = "images/"; 

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["search"])) {
    $searchKeyword = $_GET["search"];
    $sql = "SELECT ToyID, Toy_Name, description, Original_price, Selling_price, Quantity, Product_import_date, Product_import_staff, Shop_ID, Supplier_ID, image FROM toy WHERE Toy_Name LIKE :searchKeyword OR description LIKE :searchKeyword";
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
      background-color: #007BFF;
      color: #fff;
      text-align: center;
      padding: 20px 0;
    }
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      position: relative;
    }
    h1 {
      font-size: 2.5em;
      margin: 0;
    }
    h2 {
      font-size: 24px;
      margin: 20px 0;
    }
    .product {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border: 1px solid #ddd;
      margin: 10px 0;
      padding: 10px;
      border-radius: 5px;
    }
    .product-details {
      max-width: 70%;
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
      text-align: center;
      margin-top: 20px;
    }
    .login-button {
      background-color: #007BFF;
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
    .search-input, button {
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      background-color: #007BFF;
      color: #fff;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
    .product-image {
      max-width: 200px; 
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
    <form class="search-form" method="GET" action="shop.php">
      <input class="search-input" type="text" name="search" placeholder="Search toys...">
      <button type="submit">Search</button>
    </form>
    <div class="login-buttons">
      <a class="login-button" href="login.html">Log In</a>
      <a class="login-button" href="register.html">Register</a>
    </div>
    <?php foreach ($toys as $toy): ?>
      <div class="product">
        <div class="product-details">
          <h3 class="product-name"><?= htmlspecialchars($toy['Toy_Name']) ?></h3>
          <p class="product-description"><?= htmlspecialchars($toy['description']) ?></p>
          <p class="product-price">Original Price: <?= number_format($toy['Original_price'], 2) ?></p>
          <p class="product-price">Selling Price: <?= number_format($toy['Selling_price'], 2) ?></p>
          <p class="product-price">Quantity: <?= $toy['Quantity'] ?></p>
        </div>
        <div class="product-image">
          <img src="<?= $imageDir . htmlspecialchars($toy['image']) ?>" alt="<?= htmlspecialchars($toy['Toy_Name']) ?>">
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</body>
</html>
