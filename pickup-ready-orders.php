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
    <title>Orders Ready for Pick up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  </head>
  <body>
    <div class="d-flex justify-content-between">
        <a href="back-home.php" class="btn btn-primary m-2">Back</a>
        <a href="logout.php" class="btn btn-primary m-2">Logout</a>
    </div>

    <h1 class="text-center mt-5">Orders Ready for Pick up</h1> 
    <div class="container mt-5">
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">Order no</th>
                <th scope="col">Family id</th>
                <th scope="col">Date</th>
                <th scope="col">Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $user = $_SESSION['Emp_id'];
                    $sql = "Select *
                            From `Order` as o, `Orders` as os
                            WHERE o.picked_up = 0 and o.Bemp_id='$user' and o.Ready_for_pick_up = 1 and os.order_no = o.order_no";
                    $result=mysqli_query($con, $sql);

                    if($result){
                        while($row=mysqli_fetch_assoc($result)){
                            $orderNo = $row['Order_no'];
                            $Fam_id = $row['Fam_id'];
                            $date = $row['date'];
                            $time = $row['time'];
                            $type = $row['type'];
                            if ($type == "Food") {
                                echo '<tr>
                                    <th scope="row">'.$orderNo.'</th>
                                    <td>'.$Fam_id.'</td>
                                    <td>'.$date.' '.$time.'</td>
                                    <td>'.$type.'</td>
                                    <td> <a href="backemp-preview-forder.php?ordNo='.$orderNo.'&page=pickup-ready"" class="btn btn-secondary">Preview Order</a>
                                    <a href="backemp-complete-pickedup-order.php?ordNo='.$orderNo.'" class="btn btn-primary">Picked up</a>
                                    </td>
                                </tr>
                                ';
                            } else {
                                echo '<tr>
                                    <th scope="row">'.$orderNo.'</th>
                                    <td>'.$Fam_id.'</td>
                                    <td>'.$date.' '.$time.'</td>
                                    <td>'.$type.'</td>
                                    <td> <a href="backemp-preview-corder.php?ordNo='.$orderNo.'&page=pickup-ready"" class="btn btn-secondary">Preview Order</a>
                                        <a href="backemp-complete-pickedup-order.php?ordNo='.$orderNo.'" class="btn btn-primary">Picked up</a>   
                                    </td>
                                </tr>
                                ';
                            }
                        }
                    }
                ?>
            </tbody>
        </table>
        
    </div>
  </body>
</html>