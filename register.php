<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'user already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
         $message[] = 'registered successfully!';
         header('location:login.php');
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
   <title>Register</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      body {
         font-family: 'Arial', sans-serif;
         background-color: #121212; /* Darker black background */
         color: #00ff00; /* Green text */
         margin: 0;
         padding: 0;
      }

      .form-container {
         background-color: #111; /* Dark black for form container */
         color: #00ff00;
         padding: 2rem;
         border-radius: 5px;
         width: 100%;
         margin: auto;
         
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
   </style>
</head>

<body style="background-color:#5A5A5A;">



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
         <h3>Register Now</h3>
         <input type="text" name="name" placeholder="Enter your name" required class="box">
         <input type="email" name="email" placeholder="Enter your email" required class="box">
         <input type="password" name="password" placeholder="Enter your password" required class="box">
         <input type="password" name="cpassword" placeholder="Confirm your password" required class="box">
         <select name="user_type" class="box">
            <option value="user">User</option>
            
         </select>
         <input type="submit" name="submit" value="Register Now" class="btn">
         <p>Already have an account? <a href="login.php">Login Now</a></p>
      </form>

   </div>

</body>

</html>