<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){

      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');

      }

   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   
   <link rel="stylesheet" href="css/style.css">
   <style>
      body {
         font-family: 'Arial', sans-serif;
         background: url('images/pattern_background.png') no-repeat center center fixed; /* Set the path to your background image */
         background-size: cover; /* Cover the entire background */
         color: #00ff00; /* Green text */
         margin: 0;
         padding: 0;
         height: 100vh; /* Ensure the body takes the full viewport height */
      }

      .form-container {
         background-color: rgba(0, 0, 0, 0.8); /* Semi-transparent dark background */
         color: #00ff00;
         padding: 2rem;
         border-radius: 5px;
          /* Set a max-width for the form container */
         margin: 100px auto; /* Center the form container */
      }

      form {
         display: flex;
         flex-direction: column;
      }

      h3 {
         text-align: center;
         margin-bottom: 1rem;
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

      p {
         margin-top: 1rem;
         text-align: center;
         color: #00ff00;
      }

      a {
         color: #3498db;
      }

      .message {
         background-color: rgba(255, 0, 0, 0.8); /* Semi-transparent red for error messages */
         color: white;
         padding: 1rem;
         border-radius: 5px;
         margin: 1rem 0;
         position: relative;
      }

      .message i {
         position: absolute;
         top: 10px;
         right: 10px;
         cursor: pointer;
      }
   </style>
</head>

<body>

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
   
<div class="form-container">

<form action="" method="post">
   <h3>Login Now</h3>
   <input type="email" name="email" placeholder="Enter your email" required class="box">
   <input type="password" name="password" placeholder="Enter your password" required class="box">
   <input type="submit" name="submit" value="Login Now" class="btn">
   <p>Don't have an account? <a href="register.php">Register Now</a></p>
</form>

</div>

</body>

</html>
