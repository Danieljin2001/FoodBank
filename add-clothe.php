<?php
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['role'] != "Supervisor"){
        header('location:signin.php');
    }
?>

<?php
    include 'connect.php';
    $invalid = 0;
    $dup = 0;
    $success = 0;
    if(isset($_POST['add'])){
        $type = $_POST['type'];
        $size = $_POST['size'];
        $gender = $_POST['gender'];
        $desc = $_POST['desc'];
        $qty = $_POST['quantity'];
        $id = $_SESSION['Emp_id']; //supervisor is who ever is making the clothe
        
        if(empty($type) || empty($size) || empty($gender) || empty($desc)|| empty($qty)){
            $invalid = 1;
        } else {
            $sql = "Select * from `clothing_inventory` where type='$type' and size='$size' and gender='$gender'";
            $result = mysqli_query($con, $sql);
            if($result){ //check if clothing exists
                $num=mysqli_num_rows($result);
                if($num > 0) {
                    $dup = 1;
                } else {
                    $sql ="insert into `clothing_inventory` (type, size, gender, qty)
                    values ('$type', '$size', '$gender', '$qty')";
                    $result =mysqli_query($con, $sql); //insert into clothing_inventory first
                    
                    $sql1 ="insert into `replenish_c` (Semp_id, type, size, gender)
                    values ('$id', '$type', '$size', '$gender')";
                    $result1 =mysqli_query($con, $sql1); //insert into replenish_c second

                    $sql2 ="insert into `clothe` (type, size, gender, description)
                    values ('$type', '$size', '$gender', '$desc')";
                    $result2 =mysqli_query($con, $sql2); //insert into clothe third
                    

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
    <title>Add Clothing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  </head>
  <body>
    <?php
      if($success){
        echo '<div class="alert alert-success" role="alert">
        The clothing <strong>'.$type.'</strong> was successfully created!.
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
        <strong>Error </strong> This clothing already exists (same type, size, gender).
      </div>';
      }
    ?>
    <div class="d-flex justify-content-between">
        <a href="replenishC.php" class="btn btn-primary m-2">Back</a>
        <a href="logout.php" class="btn btn-primary m-2">Logout</a>
    </div>

    <h1 class="text-center mt-5">Calgary Food Bank</h1> 
    <div class="container mt-5">
        <form action="add-clothe.php" method="post">
            <div class="mb-3">
                <label class="form-label">Clothing type (e.g. Hoodie, T-shirt, etc)</label>
                <input type="text" class="form-control" placeholder="Enter clothing type" name="type">

                <label class="form-label mt-4">Select the size</label>
                <select name="size" class="form-select" multiple aria-label="multiple select example">
                <option selected value="XXS">XXS</option>
                <option value="XS">XS</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
                </select>

                <label class="form-label mt-4">Select the gender</label>
                <select name="gender" class="form-select" multiple aria-label="multiple select example">
                <option selected value="M">Male</option>
                <option value="F">Female</option>
                <option value="U">Unisex</option>
                </select>

                <label class="form-label mt-4">Clothing description</label>
                <input type="text" class="form-control" placeholder="Enter a short description" name="desc">

                <label class="form-label mt-4">Quantity</label>
                <input type="number" class="form-control" placeholder="Enter the quantity" name="quantity">

                <div class="form-text mt-4">You will be supervising this item.</div>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="add">Add clothing</button>
        </form>
    </div>
    
  </body>
</html>