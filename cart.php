<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
   $message[] = 'cart quantity updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shopping Cart</title>

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

      .shopping-cart {
         padding: 2rem;
      }

      .title {
         color: #333;
         text-align: center;
         font-size: 2rem;
         margin-bottom: 1.5rem;
      }

      .box-container {
         display: flex;
         flex-wrap: wrap;
         justify-content: space-around;
      }

      .box {
         background-color: #333; /* Dark grey background */
         border: 1px solid #ddd;
         padding: 1rem;
         text-align: center;
         margin: 1rem;
         width: 100%;
         position: relative;
      }

      .box a {
         position: absolute;
         top: 10px;
         right: 10px;
         color: #e74c3c; /* Red delete button color */
         cursor: pointer;
      }

      .box img {
         max-width: 100%;
         height: auto;
         margin-bottom: 1rem;
      }

      .name {
         font-weight: bold;
         margin-bottom: 0.5rem;
         color: #00ff00;
      }

      .price {
         color: #27ae60;
         font-weight: bold;
         margin-bottom: 1rem;
      }

      form {
         margin-top: 1rem;
      }

      .sub-total {
         margin-top: 1rem;
         color: #00ff00;
      }

      .delete-btn {
         text-decoration: none;
         background-color: #872341; /* Red delete button background color */
         color: white;
         padding: 0.5rem 1rem;
         border-radius: 5px;
         transition: background-color 0.3s;
         cursor: pointer;
      }

      .delete-btn:hover {
         background-color: #22092C;
      }

      .cart-total {
         margin-top: 2rem;
         text-align: center;
         color: white;
      }

      .cart-total p {
         margin: 0;
      }

      .flex {
         display: flex;
         justify-content: space-between;
         margin-top: 1rem;
      }

      .option-btn {
         text-decoration: none;
         background-color: #2ecc71; /* Green continue shopping button background color */
         color: white;
         padding: 0.5rem 1rem;
         border-radius: 5px;
         transition: background-color 0.3s;
         cursor: pointer;
      }

      .option-btn:hover {
         background-color: #27ae60;
      }

      .btn {
         text-decoration: none;
         background-color: #3498db; /* Blue proceed to checkout button background color */
         color: white;
         padding: 0.5rem 1rem;
         border-radius: 5px;
         transition: background-color 0.3s;
         cursor: pointer;
      }

      .btn:hover {
         background-color: #2980b9;
      }

      .disabled {
         pointer-events: none;
         background-color: #636363; /* Dark grey disabled button background color */
         color: #b1b1b1;
      }
   </style>
</head>

<body style="background-color:#5A5A5A;">

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Shopping Cart</h3>
      <p> <a href="home.php">Home</a> / Cart </p>
   </div>

   <section class="shopping-cart">

      <h1 class="title">Products Added</h1>

      <div class="box-container">
      <?php
         $grand_total = 0;
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
      ?>
      <div class="box">
         <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
         <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_cart['name']; ?></div>
         <div class="price">$<?php echo $fetch_cart['price']; ?>/-</div>
         <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
            <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
            <input type="submit" name="update_cart" value="update" class="option-btn">
         </form>
         <div class="sub-total"> sub total : <span>$<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>/-</span> </div>
      </div>
      <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<p class="empty">your cart is empty</p>';
      }
      ?>
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">delete all</a>
   </div>

   <div class="cart-total">
      <p>grand total : <span>$<?php echo $grand_total; ?>/-</span></p>
      <div class="flex">
         <a href="shop.php" class="option-btn">continue shopping</a>
         <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
         </div>

<div style="margin-top: 2rem; text-align:center;">
   <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('Delete all from cart?');">Delete All</a>
</div>

<div class="cart-total">
   <p>Grand Total: <span>$<?php echo $grand_total; ?>/-</span></p>
   <div class="flex">
   <a href="shop.php" class="option-btn">Continue Shopping</a>
            <a href="checkout.php" class="btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">Proceed to Checkout</a>
         </div>
      </div>

   </section>

   <?php include 'footer.php'; ?>

   <!-- Custom JS file link -->
   <script src="js/script.js"></script>

</body>

</html>