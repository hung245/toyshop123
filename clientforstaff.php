<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: process-staff-login.php");
    exit;
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_product"])) {
    header("Location: add.php");
    exit;
}

$stmt = $conn->query("SELECT * FROM toy");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toy Shop - Staff Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-top: 0;
            color: #333;
        }

        h2 {
            color: #007bff;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 5px 10px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<header>
        <h1>Welcome, Staff Member! <a href="index.php" style="float: left;">Home</a></h1>
    </header>

    <div class="container">
        <h2>Product List</h2>
        <button><a href="add.php">Add Product</a></button>
        <button><a href="add_staff.php">Add Staff</a></button>
        <button><a href="indexshop.php">Add Shop</a></button>
        <table>
            <thead>
                <tr>
                    <th>Toy Name</th>
                    <th>Description</th>
                    <th>Original Price</th>
                    <th>Selling Price</th>
                    <th>Quantity</th>
                    <th>Import Date</th>
                    <th>Import Staff</th>
                    <th>Shop ID</th>
                    <th>Supplier ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?= $product['Toy_Name'] ?></td>
                        <td><?= $product['Description'] ?></td>
                        <td><?= $product['Original_price'] ?></td>
                        <td><?= $product['Selling_price'] ?></td>
                        <td><?= $product['Quantity'] ?></td>
                        <td><?= $product['Product_import_date'] ?></td>
                        <td><?= $product['Product_import_staff'] ?></td>
                        <td><?= $product['Shop_ID'] ?></td>
                        <td><?= $product['Supplier_ID'] ?></td>
                        <td>
                            <button><a href="edit.php?ToyID=<?= $product['ToyID']?>">Edit</a></button>
                            <button><a href="remove.php?ToyID=<?= $product['ToyID']?>">Remove</a></button>
                            <button><a href="product_details.php?ToyID=<?= $product['ToyID']?>">Details</a></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
