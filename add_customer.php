<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Customer</title>

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

      .add-customer {
         background-color: #111; /* Dark black for form container */
         color: #00ff00;
         padding: 2rem;
         border-radius: 5px;
         width: 50%;
         margin: auto;
      }

      form {
         display: flex;
         flex-direction: column;
      }

      label {
         margin-top: 1rem;
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
   </style>
</head>

<body style="background-color: #5A5A5A;">

   <?php include 'admin_header.php'; ?>

   <section class="add-customer">

      <h1 class="title"> Add Customer </h1>

      <div class="form-container">
         <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" required class="box">

            <label for="email">Email:</label>
            <input type="email" name="email" required class="box">

            <label for="password">Password:</label>
            <input type="password" name="password" required class="box">

            <label for="cpassword">Confirm Password:</label>
            <input type="password" name="cpassword" required class="box">

            <label for="user_type">User Type:</label>
            <select name="user_type" class="box">
               <option value="user">User</option>
               <option value="admin">Admin</option>
            </select>

            <input type="submit" name="submit" value="Add Customer" class="btn">
         </form>
      </div>

   </section>

   <!-- Custom admin JS file link -->
   <script src="js/admin_script.js"></script>

</body>

</html>
