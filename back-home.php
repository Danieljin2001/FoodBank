<?php
    session_start();
    if(!isset($_SESSION['username'])){ //maybe add condition for back employee role and or supervisor role 
        header('location:signin.php');
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  </head>
  <body>
    <div class="d-flex justify-content-end">
        <a href="logout.php" class="btn btn-primary m-2">Logout</a>
    </div>

    <h1 class="text-center mt-5">Calgary Food Bank BACK</h1> 
    <div class="d-flex justify-content-center m-5">
      <a href="./backEmp/incompleteOrders.php" class="btn btn-primary m-2">List of incomplete orders</a>
      <a href="./backEmp/completeOrders.php" class="btn btn-primary m-2">List of complete orders</a>
    </div>

  </body>
</html>