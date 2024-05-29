<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ',$cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }else{
      if(mysqli_num_rows($order_query) > 0){
         $message[] = 'order already placed!'; 
      }else{
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $message[] = 'order placed successfully!';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      }
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">
   <style>
      body {
         font-family: 'Arial', sans-serif;
         background-color: #121212; /* Darker black background */
         color: #00ff00; /* Green text */
         margin: 0;
         padding: 0;
      }

      .heading {
         background-color: #333; /* Dark grey heading background */
         color: #00ff00;
         padding: 1rem;
         text-align: center;
      }

      .heading h3 {
         margin: 0;
      }

      .heading p {
         margin: 0.5rem 0 0;
         font-size: 0.8rem;
      }

      .display-order {
         padding: 2rem;
         color: #00ff00;
      }

      .display-order p {
         margin: 0;
      }

      .grand-total {
         margin-top: 1rem;
         font-size: 1.2rem;
         font-weight: bold;
      }

      .checkout {
         padding: 2rem;
      }

      form {
         background-color: #333; /* Dark grey form background */
         padding: 1.5rem;
         border-radius: 10px;
      }

      h3 {
         color: #00ff00;
         margin-bottom: 1.5rem;
         text-align: center;
      }

      .flex {
         display: flex;
         flex-wrap: wrap;
         justify-content: space-between;
      }

      .inputBox {
         flex: 0 0 48%;
         margin-bottom: 1.5rem;
      }

      span {
         color: #00ff00;
         display: block;
         margin-bottom: 0.5rem;
      }

      input,
      select {
         width: 100%;
         padding: 0.8rem;
         margin-bottom: 1rem;
         border: 1px solid #555; /* Dark grey border */
         border-radius: 5px;
         background-color: #444; /* Dark grey input background */
         color: #ddd; /* Light grey text color */
      }

      .btn {
         background-color: #3498db; /* Blue button background color */
         color: white;
         padding: 0.8rem 1.5rem;
         border: none;
         border-radius: 5px;
         cursor: pointer;
         transition: background-color 0.3s;
      }

      .btn:hover {
         background-color: #2980b9; /* Darker blue on hover */
      }
   </style>
</head>

<body style="background-color:#5A5A5A;">

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Checkout</h3>
      <p> <a href="home.php">Home</a> / Checkout </p>
   </div>

   <section class="display-order">

   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo '$'.$fetch_cart['price'].' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   <div class="grand-total"> Grand Total : <span>$<?php echo $grand_total; ?></span> </div>

</section>

<section class="checkout">

   <form action="" method="post">
      <h3>Place Your Order</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Your Name:</span>
            <input type="text" name="name" required placeholder="Enter your name">
         </div>
         <div class="inputBox">
            <span>Your Number:</span>
            <input type="number" name="number" required placeholder="Enter your number">
         </div>
         <div class="inputBox">
            <span>Your Email:</span>
            <input type="email" name="email" required placeholder="Enter your email">
         </div>
         <div class="inputBox">
            <span>Payment Method:</span>
            <select name="method">
               <option value="cash on delivery">Cash on Delivery</option>
               <option value="credit card">Credit Card</option>
               <option value="paypal">PayPal</option>
               <option value="paytm">Paytm</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Address Line 01:</span>
            <input type="number" min="0" name="flat" required placeholder="e.g. Flat No.">
         </div>
         <div class="inputBox">
            <span>Address Line 01:</span>
            <input type="text" name="street" required placeholder="e.g. Street Name">
         </div>
         <div class="inputBox">
            <span>City:</span>
            <input type="text" name="city" required placeholder="e.g. Cebu">
         </div>
         <div class="inputBox">
            <span>State:</span>
            <input type="text" name="Region" required placeholder="e.g. 7">
         </div>
         <div class="inputBox">
            <span>Country:</span>
            <input type="text" name="country" required placeholder="e.g. Philippines">
         </div>
         <div class="inputBox">
            <span>Pin Code:</span>
            <input type="number" min="0" name="pin_code" required placeholder="e.g. 123456">
         </div>
      </div>
      <input type="submit" value="Order Now" class="btn" name="order_btn">
   </form>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>

</html>