<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom admin CSS file link -->
   <link rel="stylesheet" href="css/admin_style.css">
</head>

<body style="background-color: gray;">

   <?php include 'admin_header.php'; ?>

   <section class="users">

      <h1 class="title"> User Accounts </h1>

      <div class="box-container">
         <?php
         $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
         while ($fetch_users = mysqli_fetch_assoc($select_users)) {
         ?>
            <div class="box">
               <p> User ID : <span><?php echo $fetch_users['id']; ?></span> </p>
               <p> Username : <span><?php echo $fetch_users['name']; ?></span> </p>
               <p> Email : <span><?php echo $fetch_users['email']; ?></span> </p>
               <p> User Type : <span style="color:<?php echo ($fetch_users['user_type'] == 'admin') ? 'var(--orange)' : 'var(--green)'; ?>"><?php echo $fetch_users['user_type']; ?></span> </p>
               <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Delete this user?');" class="delete-btn">Delete User</a>
               <p></p>
               <?php if ($fetch_users['user_type'] == 'user') { ?>
   <a href="edit_customer.php?edit=<?php echo $fetch_users['id']; ?>" class="delete-btn edit-btn" onclick="return confirm('Edit this customer?')">Edit Customer</a>
<?php } ?>



            </div>
         <?php
         };
         ?>
      </div>

      <div class="add-customer-btn">
         <a href="add_customer.php" class="btn">Add Customer</a>
      </div>

   </section>

   <!-- Custom admin JS file link -->
   <script src="js/admin_script.js"></script>

</body>

</html>
