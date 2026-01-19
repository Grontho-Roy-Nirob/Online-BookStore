<?php
include("../../../USER/MVC/Db/dbregister.php");

$categories = [];
$sql = "SELECT id, name FROM categories ORDER BY name ASC";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

$title = $author = $price = $discount = $final_price = $quantity = $description = $category = $status = "";
$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $title       = trim($_POST['title']);
    $author      = trim($_POST['author']);
    $price       = trim($_POST['price']);
    $discount    = trim($_POST['discount']);
    $final_price = trim($_POST['final_price']);
    $quantity    = trim($_POST['quantity']);
    $description = trim($_POST['description']);
    $category    = $_POST['category'] ?? '';
    $status      = $_POST['status'] ?? 'Available';


    if ($title === '') 
        $error = "Title cannot be empty";
    else if ($author === '') 
        $error = "Author cannot be empty";
    else if ($price === '' || !is_numeric($price) || floatval($price) <= 0) 
        $error = "Enter a valid price";
    else if ($discount === '' || !is_numeric($discount) || floatval($discount) < 0 || floatval($discount) > 100) 
        $error = "Discount must be between 0 and 100";
    else if ($final_price === '' || !is_numeric($final_price) || floatval($final_price) < 0) 
        $error = "Invalid final price";
    else if ($quantity === '' || !is_numeric($quantity) || intval($quantity) < 1) 
        $error = "Quantity must be at least 1";
    else if ($description === '') 
        $error = "Description cannot be empty";
    else if ($category === '') 
        $error = "Please select a category";

 if ($error === "") {
        $imageName = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../../../USER/MVC/Picture/" . $imageName);

        $sql = "INSERT INTO books (title, author, price, discount, final_price, quantity, description, image, status, category_id)
                VALUES ('$title','$author','$price','$discount','$final_price','$quantity','$description','$imageName','$status','$category')";

        if ($conn->query($sql)) {
            $title = $author = $price = $discount = $final_price = $quantity = $description = $category = $status = "";
            header("Location: viewbooks.php");
            exit(); 
        } 
        else 
        {
            $error = "Failed to add book!";
            $title = $author = $price = $discount = $final_price = $quantity = $description = $category = $status = "";
        }

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <link rel="stylesheet" href="../Css/bookmodification.css">
</head>
<body>

    <h2>Add New Book</h2>
    <a href="admindashboard.php" class="back-dashboard">Back to Dashboard</a><br><br>

    <?php if ($error !== ""): ?>
        <script>alert('<?php echo $error; ?>');</script>
    <?php endif; ?>

    <?php if ($success !== ""): ?>
        <script>alert('<?php echo $success; ?>');</script>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

    <input type="text" name="title" placeholder="Book Title" value="<?php echo $title; ?>" required><br><br>
    <input type="text" name="author" placeholder="Author Name" value="<?php echo $author; ?>" required><br><br>
    <input type="text" id="price" name="price" placeholder="Original Price" value="<?php echo $price; ?>" oninput="calcFinalAdd()" required><br><br>
    <input type="text" id="discount" name="discount" placeholder="Discount" value="<?php echo $discount; ?>" oninput="calcFinalAdd()" required><br><br>
    <input type="text" id="final_price" name="final_price" placeholder="Final Price" value="<?php echo $final_price; ?>" readonly required><br><br>
    <input type="text" name="quantity" placeholder="Quantity" value="<?php echo $quantity; ?>" required><br><br>
    <textarea name="description" placeholder="Book Description" required><?php echo $description; ?></textarea><br><br>
