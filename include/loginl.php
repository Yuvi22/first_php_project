<?php
use PHPMailer\PHPMailer\PHPMailer;
if (isset($_POST['login_user'])) {
    include ('database.php');
    $email = $_POST['email'];
    $pass = $_POST['password'];
    if (empty($_POST['email']) || empty($_POST['password'])) {
        header("location:../login.php?Empty= Please Fill in the Blanks");
        exit();
    } else {
        $t = (date("Y-m-d h:m:s", time()));
        $sql = "SELECT * from user where email = ?";
        $stmt = mysqli_stmt_init($db);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location:../login.php?Empty= Empty fields");
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $passcheck = password_verify($pass, $row['password']);
                if ($passcheck == false) {
                    //$attempt = $attempt + 1;
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
                    $mail->setFrom($email, "activate");
                    $mail->AddAddress($email);
                    $mail->IsHTML(true);
                    $mail->Subject = "Warning";
                    $mail->Body = ' 
                            Wrong email entered at' . $t . '!
                            ';
                    if ($mail->send()) {
                        echo "success";
                        echo "Email is sent!";
                    } else {
                        echo "failed";
                        echo "Something is wrong: contact admin <br><br>";
                    }
                    $uname = $row['fname'] . ' ' . $row['lname'];
                    $action = "wrong email entered";
                    $query = "INSERT INTO log (name, action) values (?, ?)";
                    $stmt = mysqli_stmt_init($db);
                    if (!mysqli_stmt_prepare($stmt, $query)) {
                        header("location:../login.php?error= error");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "ss", $uname, $action);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                    }
                    $attempt++;
                    header("location:../login.php?Invalid=  Wrong Email Or Password");
                } elseif ($passcheck == true) {
                    if ($row['isactive'] == "no") {
                        header("location:../login.php?Invalid=  Please activate your account(check your mail)");
                        exit();
                    } elseif ($row['isactive'] == "yes") {
                        if ($row['isadmin'] == "admin") {
                            if ($row['islogin'] == "yes") {
                                $uname = $row['fname'] . ' ' . $row['lname'];
                                $action = "login attemt when already login";
                                $query = "INSERT INTO log (name, action) values (?, ?)";
                                $stmt = mysqli_stmt_init($db);
                                if (!mysqli_stmt_prepare($stmt, $query)) {
                                    header("location:../login.php?error= error");
                                    exit();
                                }
                                header("location:../login.php?Invalid= already log in");
                                exit();
                            } elseif ($row['islogin'] == "no") {
                                session_start();
                                $_SESSION['email'] = $_POST['email'];
                                $_SESSION['fname'] = $row['fname'];
                                $_SESSION['user'] = $row['isadmin'];
                                $uname = $row['fname'] . ' ' . $row['lname'];
                                $action = "admin login";
                                $query = "INSERT INTO log (name, action) values (?, ?)";
                                $stmt = mysqli_stmt_init($db);
                                if (!mysqli_stmt_prepare($stmt, $query)) {
                                    header("location:../login.php?error= error");
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "ss", $uname, $action);
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_store_result($stmt);
                                }
                                $query = "UPDATE user set islogin = ? where email = ?";
                                $stmt = mysqli_stmt_init($db);
                                if (!mysqli_stmt_prepare($stmt, $query)) {
                                    header("location:../login.php?error= error");
                                    exit();
                                } else {
                                    $islogin = "yes";
                                    mysqli_stmt_bind_param($stmt, "ss", $islogin, $email);
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_store_result($stmt);
                                }
                                // $attempt = 0;
                                header("location:../index.php?login=success");
                            }
                        } elseif ($row['isadmin'] == "user") {
                            if ($row['islogin'] == "yes") {
                                $uname = $row['fname'] . ' ' . $row['lname'];
                                $action = "login attemt when already login";
                                $query = "INSERT INTO log (name, action) values (?, ?)";
                                $stmt = mysqli_stmt_init($db);
                                if (!mysqli_stmt_prepare($stmt, $query)) {
                                    header("location:../login.php?error= error");
                                    exit();
                                }
                                header("location:../login.php?Invalid= already log in");
                                exit();
                            } elseif ($row['islogin'] == "no") {
                                session_start();
                                $_SESSION['email'] = $_POST['email'];
                                $_SESSION['fname'] = $row['fname'];
                                $_SESSION['user'] = $row['isadmin'];
                                $uname = $row['fname'] . ' ' . $row['lname'];
                                $action = "user login";
                                $query = "INSERT INTO log (name, action) values (?, ?)";
                                $stmt = mysqli_stmt_init($db);
                                if (!mysqli_stmt_prepare($stmt, $query)) {
                                    header("location:../login.php?error= error");
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "ss", $uname, $action);
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_store_result($stmt);
                                }
                                $query = "UPDATE user set islogin = ? where email = ?";
                                $stmt = mysqli_stmt_init($db);
                                if (!mysqli_stmt_prepare($stmt, $query)) {
                                    header("location:../login.php?error= error");
                                    exit();
                                } else {
                                    $islogin = "yes";
                                    mysqli_stmt_bind_param($stmt, "ss", $islogin, $email);
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_store_result($stmt);
                                }
                                // $attempt = 0;
                                header("location:../index.php?login=success");
                            }
                        }
                    }
                }
            } else {
                header("location:../login.php?Invalid= Please Enter Correct User Name and Password ");
            }
        }
    }
    // }
    //     }
    //    }
    //}
    
} else {
    header("location:../login.php");
    exit();
}
?>