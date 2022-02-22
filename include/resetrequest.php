<?php
use PHPMailer\PHPMailer\PHPMailer;
if(isset($_POST['reset'])){

    $select = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = "http://localhost/resetpass.php?selector=". $select . "&validator=" .bin2hex($token);

    $expires = date("U") + 1800;

    include('database.php');

    $email = $_POST["email"];

    $sql = "DELETE FROM resets WHERE resetemail=?";
    $stmt = mysqli_stmt_init($db);
    if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location:../reset.php?error=error");
    exit();
    }
    else 
    {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO resets (resetemail, passwordselector, token, expire) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($db);
    if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location:../reset.php?error=error");
    exit();
    }
    else 
    {
        $hashtoken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $email, $select, $hashtoken, $expires);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($db);

    $to = $email;

    $subject = "Reset Password";

    $message ='<p>Your password can be reset by clicking the button below. If you did not request a new password, please ignore this email.</p>';
    $message .= '<p>Here is your password reset link:</br>';
    $message .= '<a href="'.$url.'">'.$url.'</a></p>';

    $header = "From:Anime <dissertationreg@gmail.com>\r\n";
    $header .= "Reply-to: dissertationreg@gmail.com\r\n";
    $header .= "Content-type: text/html\r\n";

    // mail($to, $subject, $message, $header);
    
        //send an email
        
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
        $mail->setFrom($email, "reset");
        $mail->addAddress($email);
        $mail->Subject =$subject ;
        $mail->Body =$message  ;
    
        if ($mail->send()) {
            echo "success";
            echo "Email is sent!";
        } else {
            echo "failed";
            echo "Something is wrong: contact admin <br><br>";
        }
    header("location: ../reset.php?reset= success check your mail");

}else{
    header("location:../index.php");

}
?>