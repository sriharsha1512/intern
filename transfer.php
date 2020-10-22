<?php require 'connect_to_db.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="node_modules/bootstrap-social/bootstrap-social.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Credit Transfer</title>
</head>
<body>

    <nav class="navbar navbar-dark navbar-expand-sm fixed-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#Navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand mr-auto" href="index.php"><img src="img/sparkslogo.png" width="50" height="50"></a>
            <div class="collapse navbar-collapse" id="Navbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php"><span class="fa fa-home fa-sm"></span> Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="aboutme.php"><span class="fa fa-info fa-sm"></span> About</a></li>
                    <li class="nav-item active"><a class="nav-link" href="transfer.php"><span class="fa fa-retweet fa-sm"></span>Transactions</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row row-content">
                <div class="col-12 col-sm-6">
                    <div class="row row-content">
                        <div class="col-12">
                            <h3>Happy Transaction</h3>
                        </div>
                        <div class="col-12">
                            <form action="" method="POST">
                                <div class="form-group row">
                                    <label for="sender" class="col-md-4 col-form-label"><strong>Sender Name</strong></label>
                                    <div class="col-md-8">
                                        <input type="text" name="sender" id="sender" class="form-control" placeholder="Sender Name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="receiver" class="col-md-4 col-form-label"><strong>Receiver Name</strong></label>
                                    <div class="col-md-8">
                                        <input type="text" name="receiver" id="receiver" class="form-control" placeholder="Receiver Name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="amount" class="col-md-4 col-form-label"><strong>Credits</strong></label>
                                    <div class="col-md-8">
                                        <input type="number" name="amount" id="amount" class="form-control" placeholder="Credits" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-6 col-md-4 offset-md-4">
                                        <input type="submit" class="btn btn-primary" name="btntran" value="Transfer">
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <a role="button" class="btn btn-secondary" href="view_users.php">Back</a>
                                    </div>
                                </div>
                            </form>
                            <?php
                                if( isset($_POST['btntran'])){
                                    $sender = $_POST['sender'];
                                    $receiver = $_POST['receiver'];
                                    $amount = $_POST['amount'];
                                    $sqlsearch1 = "SELECT * FROM users WHERE u_name = $sender AND u_name = $receiver";
                                    $result = mysqli_query($conn, $sqlsearch1);
                                    $sqlupdate1 = "UPDATE users SET credits = credits - $amount WHERE u_name = '$sender'";
                                    $sqlupdate2 = "UPDATE users SET credits = credits + $amount WHERE u_name = '$receiver'";
                                    $res1 = mysqli_query($conn, $sqlupdate1);
                                    $res2 = mysqli_query($conn, $sqlupdate2);
                                    if(!$res1){
                                        echo "Failed to Update: " . mysqli_error($res1); 
                                    }
                                    if(!$res2){
                                        echo "Failed to Update: " . mysqli_error($res2); 
                                    }
                                    $sqlinsert = "INSERT INTO historytable (crfrom, crto, creditamt) VALUES ('$sender','$receiver','$amount')";
                                    $res3 = mysqli_query($conn, $sqlinsert);
                                    if($res3){
                                       echo  "<script>alert('Credit Transfered Successfully...')</script>";
                                    }
                                    else{
                                        echo "Failed to Insert:" . mysqli_error($res3);
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                    $sql = "SELECT * FROM historytable";
                    $result = mysqli_query($conn, $sql);
                ?>
                <div class="col-12 col-sm-6">
                    <h3>Transaction History</h3>
                    <div class="table-responsive">
                       <table class="table table-striped" style="margin-bottom:80px">
                            <thead class="thead-dark">
                                <tr>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Credits Transfered</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(mysqli_num_rows($result) > 0){
                                        while($emp = mysqli_fetch_assoc($result)){
                                ?>
                                <tr>
                                    <td><?php echo $emp['crfrom']; ?></td>
                                    <td><?php echo $emp['crto']; ?></td>
                                    <td><?php echo $emp['creditamt']; ?></td>
                                </tr>
                                <?php
                                        }
                                    }
                                    else{
                                        echo "0 results";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="row-footer fixed-bottom">
        <div class="container">
            <div class="row  justify-content-center">             
                <div class="col-auto">
                    <p>© Copyright 2020 <a href="https://www.linkedin.com/in/sri-harsha-357b1219b/" style="color:#85C1E9;">Sri Harsha</a></p>
                </div>
           </div>
        </div>
    </footer>
    <!-- jQuery first, then Popper.js, then Bootstrap JS. -->
    <script src="node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>