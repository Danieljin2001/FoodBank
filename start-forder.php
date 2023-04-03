<?php
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['role'] == "Back"){
        header('location:signin.php');
    }
?>

<?php
    include 'connect.php';
    //calories needed:
    $MALE_CAL = 2500;
    $FEMALE_CAL = 2000;
    $CHILD_CAL = 1600;

    //number of family members
    $adult_m = 1;
    $adult_f = 1;
    $child = 1;

    if(isset($_POST['update-fam'])){
        $adult_m = $_POST['males-num'];
        $adult_f = $_POST['females-num'];
        $child = $_POST['child-num'];

    }
?>

<!-- create temp table for adding food -->
<?php
    $home = $_GET['home'];
    if($home){
        $sql = "DROP TABLE IF EXISTS ordertemp";
        $result =mysqli_query($con, $sql); 
        if($result){
            $sql1 = "create table `ordertemp` (
                `name` varchar(100) NOT NULL REFERENCES `food_inventory`(`name`),
                `qty` int(10) unsigned NOT NULL,
                PRIMARY KEY (`name`));";
            $result1 =mysqli_query($con, $sql1);
            if(!$result1){
                die(mysqli_error($con));
            }  
        } else {
            die(mysqli_error($con));
        }
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create food order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>  
    <div class="d-flex justify-content-between">
        <a href="front-home.php" class="btn btn-primary m-2">Back</a>
        <a href="logout.php" class="btn btn-primary m-2">Logout</a>
    </div>

    <h1 class="text-center mt-5">Calgary Food Bank</h1> 
    <div class="container mt-5">
        <form method="post">
            <div class="mb-3">
                <h5 class="mt-3">Family members</h5> 
                <label>Adult males <small>(2500 calories per male)</small></label>
                <select name="males-num" class="form-control">
                    <?php
                        $x = 1;
                        while($x < 6){
                            if($x == $adult_m)
                                echo "<option selected value='$x'>$x</option>";
                            else
                                echo "<option value='$x'>$x</option>";
                            $x += 1;
                        }
                    ?>
                </select>
                <label class="mt-2">Adult females <small>(2000 calories per female)</small></label>
                <select name="females-num" class="form-control">
                    <?php
                        $x = 1;
                        while($x < 6){
                            if($x == $adult_f)
                                echo "<option selected value='$x'>$x</option>";
                            else
                                echo "<option value='$x'>$x</option>";
                            $x += 1;
                        }
                    ?>
                </select>
                <label class="mt-2">Children <small>(1600 calories per child)</small></label>
                <select name="child-num" class="form-control">
                    <?php
                        $x = 1;
                        while($x < 11){
                            if($x == $child)
                                echo "<option selected value='$x'>$x</option>";
                            else
                                echo "<option value='$x'>$x</option>";
                            $x += 1;
                        }
                    ?>
                </select>
                <label class="mt-4">Total calories for family: <strong>
                    <?php echo ($adult_m * $MALE_CAL) + ($child * $CHILD_CAL)+ ($adult_f * $FEMALE_CAL); ?>
                </strong></label>
                <button type="submit" class="btn btn-primary w-100 mt-3 mb-3" name="update-fam">Update family</button>
                
                <h5 class="mt-5">Select foods</h5>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" aria-haspopup="true"  data-bs-toggle="dropdown" aria-expanded="false">
                        Type of food
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php
                            $sql = "Select distinct type from `food`";
                            $result=mysqli_query($con, $sql);
                            if($result){
                                while($row=mysqli_fetch_assoc($result)){
                                    $type = $row['type'];
                                    $adr = "list-food.php?type=$type";
                                    if($type == 'FV') {
                                        $type = "Fruit and Vegetables";
                                    }
                                    echo '<a class="dropdown-item" href="'.$adr.'">'.$type.'</a>';
                                }
                            }
                        ?>
                    </div>
                </div>

                <h5 class="mt-5">Order</h5>
                   

                       
            </div>
            <button type="submit" class="btn btn-primary w-100" name="create">Create order</button>
        </form>
                  
    </div>

    
  </body>
</html>