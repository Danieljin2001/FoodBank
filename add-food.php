<?php
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['role'] != "Supervisor"){
        header('location:signin.php');
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

<?php
    include 'connect.php';
    $invalid = 0;
    $dup = 0;
    $success = 0;
    if(isset($_POST['add'])){
        $name = $_POST['name'];
        $type = $_POST['type'];
        $calories = $_POST['calories'];
        $qty = $_POST['quantity'];
        $id = $_SESSION['Emp_id']; //supervisor is who ever is making the food
        
        if(empty($name) || empty($type) || empty($calories) || empty($qty)){
            $invalid = 1;
        } else {
            $sql = "Select * from `food_inventory` where name='$name'";
            $result = mysqli_query($con, $sql);
            if($result){ //check if food name exists
                $num=mysqli_num_rows($result);
                if($num > 0) {
                    $dup = 1;
                } else {
                    $sql ="insert into `food_inventory` (name, qty)
                    values ('$name', '$qty')";
                    $result =mysqli_query($con, $sql); //insert into food_inventory first
                    
                    $sql1 ="insert into `replenish_f` (Semp_id, name)
                    values ('$id', '$name')";
                    $result1 =mysqli_query($con, $sql1); //insert into replenish_f second

                    $sql2 ="insert into `food` (name, type, calories)
                    values ('$name', '$type', '$calories')";
                    $result2 =mysqli_query($con, $sql2); //insert into food third
                    

                    if($result && $result1 && $result2){
                        $success = 1;
                    } else {
                        die(mysqli_error($con));
                    }
                }
            }
        }

    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Food</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  </head>
  <body>
    <?php
      if($success){
        echo '<div class="alert alert-success" role="alert">
        The food <strong>'.$name.'</strong> was successfully created!.
      </div>';
      }
    ?>
    <?php
      if($invalid){
        echo '<div class="alert alert-danger" role="alert">
        <strong>Error </strong> Please fill in the information for all the fields.
      </div>';
      }
    ?>
    <?php
      if($dup){
        echo '<div class="alert alert-danger" role="alert">
        <strong>Error </strong> This food already exists.
      </div>';
      }
    ?>
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
        <form action="add-food.php" method="post">
            <div class="mb-3">
                <label class="form-label">Food name</label>
                <input type="text" class="form-control" placeholder="Enter food name" name="name">

                <label class="form-label mt-4">Select the food type</label>
                <select name="type" class="form-select" multiple aria-label="multiple select example">
                <option selected value="FV">Fruit and Vegetable</option>
                <option value="Grain">Grain</option>
                <option value="Meat">Meat</option>
                <option value="Dairy">Dairy</option>
                <option value="Other">Other</option>
                </select>

                <label class="form-label mt-4">Calories (per 1 item or 100g)</label>
                <input type="number" class="form-control" placeholder="Enter the amount of calories" name="calories">

                <label class="form-label mt-4">Quantity</label>
                <input type="number" class="form-control" placeholder="Enter the quantity" name="quantity">

                <div class="form-text mt-4">You will be supervising this item.</div>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="add">Add food</button>
        </form>
    </div>
    
  </body>
</html>