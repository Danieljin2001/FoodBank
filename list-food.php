<?php
    include 'connect.php';
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['role'] == "Back"){
        header('location:signin.php');
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Replenish Food</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  </head>
  <body>
    <div class="d-flex justify-content-end">
        <a href="logout.php" class="btn btn-primary m-2">Logout</a>
    </div>

    <h1 class="text-center mt-5">Calgary Food Bank</h1> 
    <div class="container mt-5">

        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">Name</th>
                <th scope="col">Calories</th>
                <th scope="col">Quantity</th>
                <th scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>

                <?php
                    $type = $_GET['type'];
                    $sql = "Select distinct fi.name, fi.qty, f.calories 
                    from `food` as f, `food_inventory` as fi
                    where f.name = fi.name and fi.qty > 1 and f.type = '$type'";
                    $result=mysqli_query($con, $sql);
                    if($result){
                        while($row=mysqli_fetch_assoc($result)){
                            $name = $row['name'];
                            $qty = $row['qty'];
                            $cal = $row['calories'];
                            echo '<tr>
                                <th scope="row">'.$name.'</th>
                                <td>'.$cal.'</td>
                                <td>'.$qty.'</td>
                                <td>';
                            $sql1 = "Select * from `ordertemp` where name='$name'";
                            $result1 = mysqli_query($con, $sql1);
                            if($result1){ //check if food exists in order
                                $num=mysqli_num_rows($result1);
                                if($num > 0) {
                                    echo '<a href="food-to-ordertemp.php?name='.$name.'&add=0&type='.$type.'" class="btn btn-danger">remove</a>
                                    </td>
                                    </tr>';
                                } else {
                                    echo '<a href="food-to-ordertemp.php?name='.$name.'&add=1&type='.$type.'" class="btn btn-success">add</a>
                                        </td>
                                        </tr>';
                                }
                            } else {
                                die(mysqli_error($con));
                            }
                        }
                    } else {
                        die(mysqli_error($con));
                    }
                ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <a href="start-forder.php?home=0" class="btn btn-primary m-2">Done</a>
        </div>
        
    </div>
  </body>
</html>