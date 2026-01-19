<?php
session_start();
include("../../../USER/MVC/Db/dbregister.php");

if (!isset($_SESSION["username"]) || !str_starts_with($_SESSION["username"], "@admin")) {
    header("Location: ../../../USER/MVC/php/login.php");
    exit();
}

$orders = $conn->query("SELECT * FROM orders ORDER BY order_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Customer Orders</title>
    <link rel="stylesheet" href="../Css/order.css">
</head>
<body>
    
<div class="container">
    <h2 class="page-title" >Customer Orders</h2>

     <?php if ($orders->num_rows == 0) { ?>
        <p class="empty">No orders found.</p>
    <?php } else { ?>

        <?php while($orderid = $orders->fetch_assoc()) { 
            $oid = (int)$orderid['order_id'];

            $items = $conn->query("SELECT * FROM order_items WHERE order_id='$oid'");
        ?>

        <div class="order-card">
                <div class="order-head">
                    <div>
                        <h3>Order #<?php echo $oid; ?></h3>
                        <p><b>User:</b> <?php echo $orderid['username']; ?></p>
                        <p><b>Name:</b> <?php echo $orderid['name']; ?></p>
                        <p><b>Payment:</b> <?php echo $orderid['payment_method']; ?>
                            <?php if (!empty($orderid['payment_number'])) { ?>
                                (<?php echo $orderid['payment_number']; ?>)
                            <?php } ?>
                        </p>
                        <p><b>Date:</b> <?php echo $orderid['order_date']; ?></p>
                        <p><b>Address:</b> <?php echo $orderid['address']; ?></p>
                    </div>
                
             <div class="right">
                        <p class="total">৳<?php echo number_format((float)$orderid['total_amount'], 2); ?></p>
                        <button class="toggle-btn" onclick="toggleItems(<?php echo $oid; ?>)">View Items</button>
                    </div>
                </div>
          
             <div class="items-box" id="items-<?php echo $oid; ?>" style="display:none;">
                    <table class="items-table">
                        <tr>
                            <th>Book</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>

              <?php 
                        $grand = 0;
                        while($item = $items->fetch_assoc()) { 
                            $p = (float)$item['price'];
                            $q = (int)$item['quantity'];
                            $mul = $p * $q;
                            $grand += $mul;
                        ?>


</body>
</html>