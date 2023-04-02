<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:signin.php');
    }
?>

<?php
    include 'connect.php';
    $invalid = 0;
    $dup = 0;
    $success = 0;
    if(isset($_POST['change'])){
        $new_pw = $_POST['new_pw'];
        $id = $_SESSION['Emp_id']; //supervisor is who ever is making the emp
        $sql = "Select * from `employee` where Emp_id = '$id'";
        $result = mysqli_query($con, $sql);
        $row=mysqli_fetch_assoc($result);
        $old_pw;
        if($result){
          $old_pw = $row['password'];
        }
        else {
            die(mysqli_error($con));
        }
        if(empty($new_pw) || !$result){
            $invalid = 1;
        } else {
            if ($new_pw != $old_pw){
                $sql1 = "update `employee` set password='$new_pw' where Emp_id = '$id'";
                $result1 = mysqli_query($con, $sql1);
                if ($result1){
                    $success = 1;
                }
                else{
                    die(mysqli_error($con));
                }
            }
            else {
                $dup = 1;
            }
        }

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
  <?php
      if($success){
        echo '<div class="alert alert-success" role="alert">
        <strong>Success </strong> the password was successfully changed!.
      </div>';
      }
    ?>
    <?php
      if($invalid){
        echo '<div class="alert alert-danger" role="alert">
        <strong>Error </strong> cannot have an empty password.
      </div>';
      }
    ?>
    <?php
      if($dup){
        echo '<div class="alert alert-danger" role="alert">
        <strong>Error </strong> cannot use old password as new password.
      </div>';
      }
    ?>
    <div class="d-flex justify-content-between">
        <a href="profile.php" class="btn btn-primary m-2">Back</a>
        <a href="logout.php" class="btn btn-primary m-2">Logout</a>
    </div>
    <form method = "post">
        <div class="input-group mb-5">
            <input type="text" class="form-control" placeholder="Enter New password" name="new_pw">
            <button class="btn btn-outline-primary" type="submit" name="change">Change Password</button>
        </div>
    </form>
  </body>
</html>