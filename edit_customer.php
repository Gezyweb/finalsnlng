<?php
include 'config.php';

if (isset($_GET['edit'])) {
   $edit_id = $_GET['edit'];
   $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$edit_id'") or die('query failed');
   $fetch_user = mysqli_fetch_assoc($select_user);
}

if (isset($_POST['update'])) {
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $user_type = $_POST['user_type'];

   // Check if a new password is provided
   $password = (!empty($_POST['password'])) ? mysqli_real_escape_string($conn, md5($_POST['password'])) : $fetch_user['password'];

   mysqli_query($conn, "UPDATE `users` SET name='$name', email='$email', password='$password', user_type='$user_type' WHERE id='$edit_id'") or die('query failed');

   header('location: admin_users.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Edit Customer</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom admin CSS file link -->
   <link rel="stylesheet" href="css/admin_style.css">
   <style>
      body {
         background-color: #121212; /* Darker black background */
         color: #00ff00; /* Green text */
         margin: 0;
         padding: 0;
         font-family: 'Arial', sans-serif;
      }

      .edit-customer {
         background-color: #111; /* Dark black for form container */
         color: #00ff00;
         padding: 3rem; /* Increased padding */
         border-radius: 5px;
         width: 80%; /* Increased width */
         margin: auto;
      }

      form {
         display: flex;
         flex-direction: column;
      }

      label {
         margin-top: 1.5rem; /* Increased margin */
         font-size: 1.2rem; /* Increased font size */
      }

      .box {
         margin: 0.7rem 0; /* Increased margin */
         padding: 1.5rem; /* Increased padding */
         border: none;
         border-radius: 5px; /* Increased border radius */
         background-color: #333; /* Dark grey for input box */
         color: #00ff00;
         font-size: 1rem; /* Increased font size */
         height: 2.5rem; /* Increased height */
      }

      .btn {
         background-color: #3498db;
         color: white;
         border: none;
         padding: 1.5rem; /* Increased padding */
         cursor: pointer;
         transition: background-color 0.3s;
         font-size: 1.2rem; /* Increased font size */
      }

      .btn:hover {
         background-color: #2980b9;
      }

      select {
         /* Add this style for the select box */
         margin: 0.7rem 0;
         padding: 0.5rem;
         border-radius: 5px;
         background-color: #333;
         color: #00ff00;
         font-size: 1rem;
         height: 2.5rem;
      }
   </style>
</head>

<body style="background-color: #5A5A5A;">

   <?php include 'admin_header.php'; ?>

   <section class="edit-customer">

      <h1 class="title"> Edit Customer </h1>

      <div class="form-container">
         <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $fetch_user['name']; ?>" required class="box">

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $fetch_user['email']; ?>" required class="box">

            <label for="password">Password (leave blank to keep current password):</label>
            <input type="password" name="password" placeholder="Enter new password" class="box">

            <label for="user_type">User Type:</label>
            <select name="user_type" class="box">
               <option value="user" <?php echo ($fetch_user['user_type'] == 'user') ? 'selected' : ''; ?>>User</option>
               <option value="admin" <?php echo ($fetch_user['user_type'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
            </select>

            <input type="submit" name="update" value="Update" class="btn">
         </form>
      </div>

   </section>

   <!-- Custom admin JS file link -->
   <script src="js/admin_script.js"></script>

</body>

</html>
