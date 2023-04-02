<?php
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['role'] != "Supervisor"){
        header('location:signin.php');
    }
?>
<?php
    include 'connect.php';
    $name = $_GET['updatename'];
    if(isset($_POST['update'])){
      $qty = $_POST['qty'];
      $sql="update `food_inventory` set qty='$qty' where name='$name'";
      $result = mysqli_query($con, $sql);
      if($result){
        header('location:replenishF.php');
      } else {
        die(mysqli_error($conn));
      }
    }
    include 'connect.php';
    $id = $_SESSION['Emp_id'];
    $sql = "Select * from `employee` where Emp_id = '$id'";
    $result = mysqli_query($con, $sql);
    $row=mysqli_fetch_assoc($result);
    if($result){
      $fname = $row['Fname'];
      $lname = $row['Lname'];
      $role = $row['role'];
    }
    else{
      die(mysqli_error($con));
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Food Quantity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  </head>
  <body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
    <div class="d-flex justify-content-between">
      <a href="replenishF.php" class="btn btn-primary m-2">Back</a>  
        <div class="dropdown m-2">
          <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
          <?php echo $fname . " " . $lname;?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <li><span class="dropdown-item-text"><strong><?php echo $role;?></strong></span></li>
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><a class="dropdown-item" style = "color: red;" href="logout.php">Logout</a></li>
          </ul>
        </div>  
    </div>
    <h1 class="text-center mt-5">Calgary Food Bank</h1> 
    <div class="container mt-5">
        <form method="post">
            <div class="mb-3">
                <?php
                  $sql = "Select * 
                  from `food_inventory`
                  where name = '$name'";
                  $result=mysqli_query($con, $sql);
                  if($result){
                    $row=mysqli_fetch_assoc($result);
                    $qty1 = $row['qty'];
                    echo '<label class="form-label">Current <strong>'.$name.'</strong> quantity: '.$qty1.'</label>';
                  }
                ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Set new quantity</label>
                <input type="number" class="form-control" placeholder="Enter new quantity" name="qty">
            </div>
            <button type="submit" class="btn btn-primary w-100" name="update">Update Quantity</button>
        </form>
    </div>
  </body>
</html>