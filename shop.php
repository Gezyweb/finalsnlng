<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

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

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Delicious Shop</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      body {
         font-family: 'Arial', sans-serif;
         background-color: #121212; /* Black background */
         color: #00ff00; /* Green text */
         margin: 0;
         padding: 0;
      }

      header {
         background-color: #111; /* Darker black for header */
         color: #00ff00;
         padding: 1rem;
         text-align: center;
      }

      .heading {
         background-color: #333; /* Dark grey background for heading */
         color: #00ff00;
         padding: 1rem;
         text-align: center;
      }

      a {
         color: #00ff00;
      }

      section {
         padding: 2rem;
      }

      .title {
         color: #00ff00;
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
         background-color: #111; /* Dark black for product box */
         border: 1px solid #00ff00;
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
         color: #00ff00;
      }

      .price {
         color: #00ff00;
         font-weight: bold;
         margin-bottom: 1rem;
      }

      .qty {
         width: 50px;
         margin-right: 0.5rem;
      }

      .btn {
         background-color: #00ff00;
         color: #121212;
         border: none;
         padding: 0.5rem 1rem;
         cursor: pointer;
         transition: background-color 0.3s;
      }

      .btn:hover {
         background-color: #009900;
      }

      .empty {
         text-align: center;
         color: #e74c3c;
         font-size: 1.5rem;
      }

      footer {
         background-color: #111; /* Darker black for footer */
         color: #00ff00;
         padding: 1rem;
         text-align: center;
         position: fixed;
         bottom: 0;
         width: 100%;
      }
   </style>
</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Delicious Cake & Bakery</h3>
      <p><a href="home.php">Home</a> / Shop</p>
   </div>

   <section class="products">

      <h1 class="title">Latest Products</h1>

      <div class="box-container">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="price">₱<?php echo $fetch_products['price']; ?></div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>

<?php include 'footer.php'; ?>
<!-- Custom JS file link -->
<script src="js/script.js"></script>

</body>

</html>
