<?php
    include 'connect.php';
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['role'] == "Front"){
        header('location:signin.php');
    }
?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complete Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  </head>
  <body>
    <div class="d-flex justify-content-between">
        <a href="back-home.php" class="btn btn-primary m-2">Back</a>
        <a href="logout.php" class="btn btn-primary m-2">Logout</a>
    </div>

    <h1 class="text-center mt-5">Complete Orders</h1> 
    <div class="container mt-5">
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">Order_no</th>
                <th scope="col">Picked_up</th>
                <th scope="col">Bemp_id</th>
                <th scope="col">Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $user = $_SESSION['Emp_id'];
                    $sql = "Select O.order_no, O.picked_up, O.Bemp_id, O.Type
                            From `Order` as O
                            WHERE O.picked_up = 1";
                    $result=mysqli_query($con, $sql);

                    if($result){
                        while($row=mysqli_fetch_assoc($result)){
                            $orderNo = $row['order_no'];
                            $pickedUp = $row['picked_up'];
                            $bempId = $row['Bemp_id'];
                            $type = $row['Type'];
                            echo '<tr>
                                <th scope="row">'.$orderNo.'</th>
                                <td>'.$pickedUp.'</td>
                                <td>'.$bempId.'</td>
                                <td>'.$type.'</td>
                                <td> <a href="backemp-preview-forder.php?ordNo='.$orderNo.'&page=complete"" class="btn btn-secondary">Preview Order</a>
                                </td>
                            </tr>
                            ';
                        }
                    }
                ?>
            </tbody>
        </table>
        
    </div>
  </body>
</html>