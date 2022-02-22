<?php include('include/header.php');?>
<div class="container">
                            <h5 class="text-center">
                                <span class="post-color">Account Activation</span>
                            </h5>
                            <br/>
                            <h4 class="post my-3"></h4>
                            <p><?php
                                require('include/database.php');

                                if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
                                    // Verify data
                                    $email = $_GET['email']; // Set email variable
                                    $hashs = $_GET['hash']; // Set hash variable
                                    $sql = "SELECT * FROM user WHERE email = ? AND token = ?";
                                        $stmt = mysqli_stmt_init($db);
                                        if(!mysqli_stmt_prepare($stmt, $sql)){
                                       echo "error";
                                        exit();
                                        }else{
                                            mysqli_stmt_bind_param($stmt, "ss", $email, $hashs);
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);
                                            if (!$row = mysqli_fetch_assoc($result)){
            
                                                echo "error";
                                    
                                                exit();
                                            }else{
                                                
                                                    $sql = "UPDATE user SET isactive = ? WHERE email = ?";
                                                    $stmt = mysqli_stmt_init($db);
                                                    if(!mysqli_stmt_prepare($stmt, $sql)){
                                                    echo "error";
                                                    exit();
                                                    }else{
                                                        $active = "yes";
                                                        mysqli_stmt_bind_param($stmt, "ss", $active, $email);
                                                        mysqli_stmt_execute($stmt); 
                                                        echo '<div class="bg-success text-white text-center py-3">Account activated</div>';
                                                        echo '<br>';
                                                        echo '<a href="../login.php" class="btn btn-primary">Login</a>';
                                                    }
                                                
                                            
                                            }

                                        }
 
                                }else{
                                    // Invalid approach
                                    echo '<div class="alert alert-danger" role="alert"><strong>Invalid approach</strong> Please use the link that has been send to your email.</div>';
                                }
?></p>
                        </div>
<?php include('include/footer.php');?>