<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

};

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Page</title>

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

      .search-form {
         text-align: center;
         margin: 1rem 0;
      }

      .box {
         margin: 0.5rem 0;
         padding: 0.5rem;
         border: none;
         border-radius: 3px;
         background-color: #333; /* Dark grey for input box */
         color: #00ff00;
      }

      .btn {
         background-color: #3498db;
         color: white;
         border: none;
         padding: 0.5rem;
         cursor: pointer;
         transition: background-color 0.3s;
      }

      .btn:hover {
         background-color: #2980b9;
      }

      .products {
         padding-top: 0;
      }

      .box-container {
         display: flex;
         flex-wrap: wrap;
         justify-content: space-around;
      }

      .box {
         background-color: white;
         border: 1px solid #ddd;
         padding: 1rem;
         text-align: center;
         margin: 1rem;
         width: 100%;
      }

      .image {
         max-width: 100%;
         height: auto;
         margin-bottom: 1rem;
      }

      .name {
         font-weight: bold;
         margin-bottom: 0.5rem;
      }

      .price {
         color: #27ae60;
         font-weight: bold;
         margin-bottom: 1rem;
      }

      .qty {
         width: 50px;
         margin-right: 0.5rem;
      }

      .btn {
         background-color: #3498db;
         color: white;
         border: none;
         padding: 0.5rem 1rem;
         cursor: pointer;
         transition: background-color 0.3s;
      }

      .btn:hover {
         background-color: #2980b9;
      }

      .empty {
         text-align: center;
         color: #e74c3c;
         font-size: 1.5rem;
      }
   </style>
</head>

<body style="background-color:#5A5A5A;">

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Search Page</h3>
      <p> <a href="home.php">Home</a> / Search </p>
   </div>

   <section class="search-form">
      <form action="" method="post">
         <input type="text" name="search" placeholder="Search products..." class="box">
         <input type="submit" name="submit" value="Search" class="btn">
      </form>
   </section>

   <section class="products">

      <div class="box-container">
   <?php
      if(isset($_POST['submit'])){
         $search_item = $_POST['search'];
         $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%{$search_item}%'") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
   ?>
   <form action="" method="post" class="box">
      <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="" class="image">
      <div class="name"><?php echo $fetch_product['name']; ?></div>
      <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
      <input type="number"  class="qty" name="product_quantity" min="1" value="1">
      <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
      <input type="submit" class="btn" value="add to cart" name="add_to_cart">
   </form>
   <?php
            }
         }else{
            echo '<p class="empty">no result found!</p>';
         }
      }else{
         echo '<p class="empty">search something!</p>';
      }
   ?>
   </div>

</section>

<?php include 'footer.php'; ?>

<!-- Custom JS file link -->
<script src="js/script.js"></script>

</body>

</html>