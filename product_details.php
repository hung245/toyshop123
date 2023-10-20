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


if (isset($_GET['ToyID'])) {
    $ToyID = $_GET['ToyID'];


    $stmt = $conn->prepare("SELECT * FROM toy WHERE ToyID = :ToyID");
    $stmt->bindParam(':ToyID', $ToyID);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "No products found.";
        exit;
    }
} else {
    echo "Missing product information.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
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
    </style>
</head>
<body>
    <header>
        <h1>Product Details</h1>
    </header>

    <div class="container">
        <h2>Product Information</h2>
        <table>
            <tr>
                <th>Toy Name</th>
                <td><?= $product['Toy_Name'] ?></td>
            </tr>
            <tr>
                <th>Description</th>
                <td><?= $product['Description'] ?></td>
            </tr>
            <tr>
                <th>Original Price</th>
                <td><?= $product['Original_price'] ?></td>
            </tr>
            <tr>
                <th>Selling Price</th>
                <td><?= $product['Selling_price'] ?></td>
            </tr>
            <tr>
                <th>Quantity</th>
                <td><?= $product['Quantity'] ?></td>
            </tr>
            <tr>
                <th>Import Date</th>
                <td><?= $product['Product_import_date'] ?></td>
            </tr>
            <tr>
                <th>Import Staff</th>
                <td><?= $product['Product_import_staff'] ?></td>
            </tr>
            <tr>
                <th>Shop ID</th>
                <td><?= $product['Shop_ID'] ?></td>
            </tr>
            <tr>
                <th>Supplier ID</th>
                <td><?= $product['Supplier_ID'] ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
