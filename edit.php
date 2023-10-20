<?php
session_start();

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

if (!isset($_SESSION['user_id'])) {
    header("Location: process-staff-login.php");
    exit;
}

if (isset($_GET['ToyID'])) {
    $ToyID = $_GET['ToyID'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newToyName = $_POST['new_toy_name'];
        $newDescription = $_POST['new_description'];
        $newOriginalPrice = $_POST['new_original_price'];
        $newSellingPrice = $_POST['new_selling_price'];
        $newQuantity = $_POST['new_quantity'];
        $newProductImportDate = $_POST['new_product_import_date'];
        $newProductImportStaff = $_POST['new_product_import_staff'];
        $newShopID = $_POST['new_shop_id'];

        $img = '';
        if (isset($_FILES['new_image']['name'])) {
            $imgdir = '';
            $img = $imgdir . str_replace(' ', '-', $_FILES['new_image']['name']);
            move_uploaded_file($_FILES['new_image']['tmp_name'], $img);
        }

        $sql = "UPDATE toy SET
            Toy_Name = :newToyName,
            Description = :newDescription,
            Original_price = :newOriginalPrice,
            Selling_price = :newSellingPrice,
            Quantity = :newQuantity,
            Product_import_date = :newProductImportDate,
            Product_import_staff = :newProductImportStaff,
            Shop_ID = :newShopID,
            image = :newimage
            WHERE ToyID = :ToyID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':newToyName', $newToyName);
        $stmt->bindParam(':newDescription', $newDescription);
        $stmt->bindParam(':newOriginalPrice', $newOriginalPrice);
        $stmt->bindParam(':newSellingPrice', $newSellingPrice);
        $stmt->bindParam(':newQuantity', $newQuantity);
        $stmt->bindParam(':newProductImportDate', $newProductImportDate);
        $stmt->bindParam(':newProductImportStaff', $newProductImportStaff);
        $stmt->bindParam(':newShopID', $newShopID);
        $stmt->bindParam(':newimage', $img);
        $stmt->bindParam(':ToyID', $ToyID);

        if ($stmt->execute()) {
            header("Location: clientforstaff.php");
            exit;
        } else {
            echo "An error occurred while updating product information.";
        }
    }

    $sql = "SELECT * FROM toy WHERE ToyID = :ToyID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ToyID', $ToyID);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            margin: 0;
            padding: 10px;
        }

        .edit-form {
            margin: 20px 0;
        }

        .form-group {
            margin: 10px 0;
        }

        label {
            display: block;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .update-button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Product</h2>
        <form class="edit-form" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="new_toy_name">Toy Name:</label>
                <input type="text" name="new_toy_name" id="new_toy_name" value="<?php echo $product['Toy_Name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_description">Description:</label>
                <input type="text" name="new_description" id="new_description" value="<?php echo $product['Description']; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_original_price">Original Price:</label>
                <input type="text" name="new_original_price" id="new_original_price" value="<?php echo $product['Original_price']; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_selling_price">Selling Price:</label>
                <input type="text" name="new_selling_price" id="new_selling_price" value="<?php echo $product['Selling_price']; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_quantity">Quantity:</label>
                <input type="text" name="new_quantity" id="new_quantity" value="<?php echo $product['Quantity']; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_product_import_date">Product Import Date:</label>
                <input type="text" name="new_product_import_date" id="new_product_import_date" value="<?php echo $product['Product_import_date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_product_import_staff">Product Import Staff:</label>
                <input type="text" name="new_product_import_staff" id="new_product_import_staff" value="<?php echo $product['Product_import_staff']; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_shop_id">Shop ID:</label>
                <input type="text" name="new_shop_id" id="new_shop_id" value="<?php echo $product['Shop_ID']; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_image">Image:</label>
                <input type="file" name="new_image" id="new_image" accept="image/*" required>
                </div>

            <button type="submit" class="update-button">Update</button>
        </form>
        <a href="index.php">Back to Product List</a>
    </div>
</body>
</html>
