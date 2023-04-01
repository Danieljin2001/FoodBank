<?php
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['role'] != "Supervisor"){
        header('location:signin.php');
    }
?>



<?php
    include 'connect.php';
    $success = 0;
    $invalid = 0;
    $superuser;

    $id;
    $fname;
    $lname;
    if(isset($_GET['emp'])){
        $id = $_GET['emp'];
        $sql="Select *
        from `employee`
        where Emp_id='$id'";
        $result=mysqli_query($con, $sql);
        if($result){
            $row=mysqli_fetch_assoc($result);
            $fname=$row['Fname'];
            $lname=$row['Lname'];
        } else {
            die(mysqli_error($con));
        }

    }
    
    if(isset($_POST['change'])){
        $super = $_POST['super']; 
        
        if(empty($super)){
            $invalid = 1;
        } else {
            $sql="update `employee` set Semp_id='$super' where Emp_id='$id'";
            $result = mysqli_query($con, $sql);
            if($result){ //check if food name exists
                $sql1="Select *
                from `employee`
                where Emp_id='$super'";
                $result1=mysqli_query($con, $sql1);
                if($result1){
                    $row=mysqli_fetch_assoc($result1);
                    $superuser=$row['username'];
                    $success = 1;
                } else {
                    die(mysqli_error($con));
                }              
            } else {
                die(mysqli_error($con));
            }
        }

    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Change Supervisor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  </head>
  <body>
    <?php
      if($success){
        echo '<div class="alert alert-success" role="alert">
        The supervisor for <strong>'.$fname.' '.$lname.'</strong> was successfully set to '.$superuser.'!
      </div>';
      }
    ?>
    <?php
      if($invalid){
        echo '<div class="alert alert-danger" role="alert">
        <strong>Error </strong> Please select a supervisor.
      </div>';
      }
    ?>
    <div class="d-flex justify-content-between">
        <a href="employees.php" class="btn btn-primary m-2">Back</a>
        <a href="logout.php" class="btn btn-primary m-2">Logout</a>
    </div>

    <h1 class="text-center mt-5">Calgary Food Bank</h1> 
    <div class="container mt-5">
        <?php
            echo '<h5>Change the supervisor for <strong>'.$fname.' '.$lname.'</strong></h5>';
        ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label mt-4">Select a supervisor</label>
                <select name="super" class="form-select" multiple aria-label="multiple select example">
                <?php
                    $sql ="Select * 
                    from `employee`
                    where role='Supervisor'";
                    $result =mysqli_query($con, $sql); 
                    if($result){
                        while($row=mysqli_fetch_assoc($result)){
                            $s_id=$row['Emp_id']; //super id
                            $s_user=$row['username']; //super username
                            if($_SESSION['Emp_id'] == $s_id) {
                                echo '<option selected value='.$s_id.'>'.$s_user.'</option>';
                           } else {
                                echo '<option value='.$s_id.'>'.$s_user.'</option>';
                           }
                        }
                    } else {
                        die(mysqli_error($con));
                    }
                    
                ?>
                
                
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="change">Change supervisor</button>
        </form>
    </div>
    
  </body>
</html>