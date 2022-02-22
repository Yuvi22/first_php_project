
<?php
use PHPMailer\PHPMailer\PHPMailer;
if(isset($_POST['submitButton']))
{
    include( 'database.php' );
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $emailId = trim($_POST['emailId']);
    $password = trim($_POST['pwd']);
    $confirmpassword = trim($_POST['cnfpwd']);
    if ((empty($firstName)) || (empty($lastName)) || (empty($emailId)) || (empty($password))|| (empty($confirmpassword))) 
    {
        header("location:../register.php?error= Empty field&firstName=".$firstName."&lastName".$lastName."&emailId".$emailId);
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z]*$/", $firstName))
    {
        header("location:../register.php?error= Invalid First Name&lastName".$lastName."&emailId".$emailId);
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z]*$/", $lastName))
    {
        header("location:../register.php?error= Invalid Last Name&firstName=".$firstName."&emailId=".$emailId);
        exit();
    }
    elseif(!filter_var($emailId, FILTER_VALIDATE_EMAIL))
    {
        header("location:../register.php?error= Invalid Email&firstName=".$firstName."&lastName=".$lastName);
        exit();
    }
    elseif($password !== $confirmpassword)
    {
        header("location:../register.php?error= Password does not match&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
        exit();
    }else if (strlen($password) <= '8') 
    {
        header("location:../register.php?error= Password must be more than 8 characters&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
        exit();
    }
    elseif(!preg_match("#[0-9]+#",$password)) 
    {
        header("location:../register.php?error= Password must contain number&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
        exit();
    }
    elseif(!preg_match("#[A-Z]+#",$password))
    {
        header("location:../register.php?error= Password must contain capital letter&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
        exit();
    }
    elseif(!preg_match("#[a-z]+#",$password)) 
    {
        header("location:../register.php?error= Password must contain small letters&firstName=".$firstName."&lastName".$lastName."&emailId=".$emailId);
        exit();
    }
    elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,.|=_+¬-]/', $password)) {
        header("location:../register.php?error= Password must contain Special Character&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
        exit();
    }
    else 
    {
        $sql = "SELECT * FROM user WHERE email=?";
        $stmt = mysqli_stmt_init($db);
        if(!mysqli_stmt_prepare($stmt, $sql))
        {
            header("location:../register.php?error= error");
            exit();  

        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $emailId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $results = mysqli_stmt_num_rows($stmt);
            if($results > 0)
            {
                header("location:../register.php?error= Email taken&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
                exit();
            }
            else
            {
                $query = "INSERT INTO user (fname, lname, email, password, token) values (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($db);
                if(!mysqli_stmt_prepare($stmt, $query))
                {
                    header("location:../register.php?error= error");
                    exit();  
                }
                else
                {
                    $hashs = md5(rand(0,1000));// token
                    $hashed = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $emailId, $hashed, $hashs);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);

                    require_once "../PHPMailer/PHPMailer.php";
                    require_once "../PHPMailer/SMTP.php";
                    require_once "../PHPMailer/Exception.php";
                
                    $mail = new PHPMailer();
                
                    //SMTP Settings
                    $mail->isSMTP();
                    $mail->Host = "smtp.gmail.com";
                    $mail->SMTPAuth = true;
                    $mail->Username = "dissertationreg@gmail.com";
                    $mail->Password = 'careg123';
                    $mail->Port = 465; //587
                    $mail->SMTPSecure = "ssl"; //tls
                
                    //Email Settings
                    $mail->isHTML(true);
                    $mail->setFrom($emailId, "activate");
                    $mail->AddAddress($emailId);
                    $mail->IsHTML(true);
                    $mail->Subject = "Account Activation";
                    $mail->Body =' 
                    Thanks for signing up!<br/>
                    Your account has been created, you can login with the following credentials<br/><br/>
                    ------------------------------<br/>

                    <br/>
                    Please click this link to activate your account:<br/>
                    http://localhost/verify.php?email='.$emailId.'&hash='.$hashs.'<br/>
        
                    If you can not click on this link, please copy it and paste it into Internet Browser
                    ';
        
                
                    if ($mail->send()) {
                        echo "success";
                        echo "Email is sent!";
                    } else {
                        echo "failed";
                        echo "Something is wrong: contact admin <br><br>";
                    }
                    header("location:../register.php?success= Registered ");
                    exit();  
                }

            }


    }
    }
mysqli_stmt_close($stmt);
mysqli_close($db);
}
else
{
    header("location:../register.php");
    exit();  
}
// $query = "INSERT INTO user (fname, lname, email, password) values (?, ?, ?, ?)";
// $result = mysqli_query($db, $query);
// if (!$result) {
//     $errormessage = mysqli_error($db);
//     echo "Error with query: " . $errormessage;
// } else {
//     echo "User Registration Successfull!!!";
//}
?>