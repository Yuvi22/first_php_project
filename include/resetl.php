<?php
if(isset($_POST['rsubmit'])){
    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $password = trim($_POST['pwd']);
    $confirmpassword = trim($_POST['cnfpwd']);
    if (empty($password) || empty($confirmpassword)){
        
        header("location:../resetpass.php?error= Empty");
        exit();
    }elseif ($password !== $confirmpassword){
        header("location:../resetpass.php?error= Password do not match");
        exit();
    }

    $currentDate = date("U");

    include('database.php');

    $sql ="SELECT * FROM resets WHERE passwordselector = ?  and expire >= ?";
    $stmt = mysqli_stmt_init($db);
    if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location:../resetpass.php?error=error");
    exit();
    }
    else 
    {
        // $hashtoken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if (!$row = mysqli_fetch_assoc($result)){

            echo "link expired";

            exit();
        }else{
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row["token"]);

            if($tokenCheck === false){
            echo "re-submit reset request";

            exit();
            }elseif($tokenCheck === true){
                $tokenemail = $row["resetemail"];

                $sql = "SELECT * FROM user WHERE email = ? ";
                $stmt = mysqli_stmt_init($db);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                header("location:../resetpass.php?error=error");
                exit();
                }else{
                    mysqli_stmt_bind_param($stmt, "s", $tokenemail);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if (!$row = mysqli_fetch_assoc($result)){
            
                        echo "error";
            
                        exit();
                    }else{
                        $passcheck = password_verify($password, $row['password']);
                        if($passcheck == true){
                            header("location:../reset.php?Invalid= You  cannot add the same password as the previous one resend a mail");
                            exit();
                        }else{

                        $sql = "UPDATE user set password = ? WHERE email = ?";
                        $stmt = mysqli_stmt_init($db);
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("location:../resetpass.php?error=error");
                        exit();
                        }else{
                            $pass = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $pass, $tokenemail);
                            mysqli_stmt_execute($stmt); 

                            $sql = "DELETE FROM resets WHERE resetemail=?";
                            $stmt = mysqli_stmt_init($db);
                            if(!mysqli_stmt_prepare($stmt, $sql)){

                            }
                            else 
                            {
                                mysqli_stmt_bind_param($stmt, "s", $email);
                                mysqli_stmt_execute($stmt);
                                header("location: ../login.php?sucess=password reset");
                                exit();
                            }

                        }
                    }

                    
                    }
                }

            }
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($db);

}else{
    header("location:../index.php");

}
?>