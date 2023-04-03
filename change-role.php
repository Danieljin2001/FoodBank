<?php
    include 'connect.php';
    session_start();
    $username = $_SESSION['username'];
    $sql0 = $sql="Select *
    from `employee`
    where username ='$username'";
    $result0=mysqli_query($con, $sql0);
    $row0=mysqli_fetch_assoc($result0);
    $fname = $row0['Fname'];
    $lname = $row0['Lname'];
    $role0 = $row0['role'];
    if(isset($_GET['emp'])){
        $id = $_GET['emp'];
        $success = 0;
        $sql="Select *
        from `employee`
        where Emp_id='$id'";
        $result=mysqli_query($con, $sql);
        if($result){
            $row=mysqli_fetch_assoc($result);
            $role=$row['role'];
            $fname1 = $row['Fname'];
            $lname1 = $row['Lname'];
        } else {
            die(mysqli_error($con));
        }
    }
?>
<?php
    if(isset($_POST['change'])){
        $role1 = $_POST['change-role']; 
        $sql1 = "update `employee` set role='$role1' where Emp_id='$id'";
        $result1 = mysqli_query($con, $sql1);
        $success = 1;
    }

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Change Role</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  </head>
  <body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
    <?php
      if($success){
        echo '<div class="alert alert-success" role="alert">
        <strong>'.$fname1.' '.$lname1.'</strong> was successfully set to '.$role1.'!
      </div>';
      }
    ?>
    <div class="d-flex justify-content-between">
      <a href="employees.php" class="btn btn-primary m-2">Back</a>  
        <div class="dropdown m-2">
          <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
          <?php echo $fname . " " . $lname;?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <li><span class="dropdown-item-text"><strong><?php echo $role0;?></strong></span></li>
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><a class="dropdown-item" style = "color: red;" href="logout.php">Logout</a></li>
          </ul>
        </div>  
    </div>
    <h1 class="text-center mt-5">Calgary Food Bank</h1> 
    <div class="container mt-5">
        <?php
            echo '<h5>Change role for <strong>'.$fname1.' '.$lname1.'</strong></h5>';
        ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label mt-4">Select a role</label>
                <select name="change-role" class="form-select" multiple aria-label="multiple select example">
                <option>Front</option>
                <option>Back</option>
                <option>Supervisor</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="change">Change role</button>
        </form>
    </div>
  </body>
</html>