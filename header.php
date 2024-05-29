<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">
            <img src="images/oglogo_alter3.png" alt="TheGlitch Logo" style="height: 50px;"> <!-- Set the path to your image and adjust the height if needed -->
         </a>

         <nav class="navbar">
            <a href="home.php">HOME</a>
            <a href="shop.php">SHOP</a>
            <a href="orders.php">ORDERS</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number); 
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span style="color: #00ff00;">(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>

         <div class="user-box">
            <p>username: <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>email: <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">Logout</a>
         </div>
      </div>
   </div>
   <style>
      /* Add your existing styles here */

      .header-2 {
         background-color: #121212; /* Darker black for header */
         color: #00ff00;
         padding: 1rem;
         text-align: center;
      }

      .logo {
         color: #00ff00;
         text-decoration: none;
         font-size: 1.5rem;
         font-weight: bold;
      }

      .navbar a {
         color: #00ff00;
         text-decoration: none;
         margin: 0 15px;
         font-weight: bold;
         transition: color 0.3s;
      }

      .navbar a:hover {
         color: #009900;
      }

      .icons {
         display: flex;
         align-items: center;
      }

      .icons i {
         margin-right: 5px;
      }

      .user-box {
         display: none;
         position: absolute;
         top: 60px;
         right: 10px;
         background-color: #121212; /* Darker black for user-box */
         color: #00ff00;
         padding: 10px;
         border: 1px solid #00ff00;
         z-index: 1;
      }

      .user-box p,
      .user-box a {
         margin: 5px 0;
         font-size: 14px;
      }

      .user-box span {
         font-weight: bold;
      }

      .delete-btn {
         color: #e74c3c;
         cursor: pointer;
      }
   </style>
</header>
