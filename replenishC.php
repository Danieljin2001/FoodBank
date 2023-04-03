<?php
    include 'connect.php';
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['role'] != "Supervisor"){
        header('location:signin.php');
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Replenish Clothing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  </head>
  <body>
    <div class="d-flex justify-content-between">
        <a href="super-home.php" class="btn btn-primary m-2">Back</a>
        <a href="logout.php" class="btn btn-primary m-2">Logout</a>
    </div>

    <h1 class="text-center mt-5">Calgary Food Bank</h1> 
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <a href="add-clothe.php" class="btn btn-primary">Add a clothing</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">Type</th>
                <th scope="col">Size</th>
                <th scope="col">Gender</th>
                <th scope="col">Description</th>
                <th scope="col">Quantity</th>
                <th scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>

                <?php
                    $user = $_SESSION['Emp_id'];
                    $sql = "Select distinct ci.type, ci.size, ci.gender, ci.qty, c.description 
                    from `employee` as e, `clothing_inventory` as ci, `clothe` as c, `replenish_c` as r
                    where e.Emp_id='$user' and e.Emp_id = r.Semp_id and r.type = ci.type and r.size = ci.size and r.gender = ci.gender and ci.type = c.type and ci.size = c.size and ci.gender = c.gender";
                    $result=mysqli_query($con, $sql);
                    if($result){
                        while($row=mysqli_fetch_assoc($result)){
                            $type = $row['type'];
                            $size = $row['size'];
                            $gender = $row['gender'];
                            $qty = $row['qty'];
                            $desc = $row['description'];
                            echo '<tr>
                                <th scope="row">'.$type.'</th>
                                <td>'.$size.'</td>
                                <td>'.$gender.'</td>
                                <td>'.$desc.'</td>
                                <td>'.$qty.'</td>
                                <td>
                                <a href="update-cqty.php?updatetype='.$type.'&updategender='.$gender.'&updatesize='.$size.'" class="btn btn-secondary">update</a>
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