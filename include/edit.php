
<?php
if(isset($_POST['submitButton']))
{
    include( 'database.php' );
    $u_id = trim($_POST['u_id']);
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $emailId = trim($_POST['emailId']);
    $password = trim($_POST['pwd']);
    $isadmin = trim($_POST['isadmin']);
    $isactive = trim($_POST['isactive']);

   if(!preg_match("/^[a-zA-Z]*$/", $firstName))
    {
        header("location:../user.php?error= Invalid First Name&lastName".$lastName."&emailId".$emailId);
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z]*$/", $lastName))
    {
        header("location:../user.php?error= Invalid Last Name&firstName=".$firstName."&emailId=".$emailId);
        exit();
    }
    else if (strlen($password) <= '8') 
    {
        header("location:../user.php?error= Password must be more than 8 characters&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
        exit();
    }
    elseif(!preg_match("#[0-9]+#",$password)) 
    {
        header("location:../user.php?error= Password must contain number&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
        exit();
    }
    elseif(!preg_match("#[A-Z]+#",$password))
    {
        header("location:../user.php?error= Password must contain capital letter&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
        exit();
    }
    elseif(!preg_match("#[a-z]+#",$password)) 
    {
        header("location:../user.php?error= Password must contain small letters&firstName=".$firstName."&lastName".$lastName."&emailId=".$emailId);
        exit();
    }
    elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,.|=_+¬-]/', $password)) {
        header("location:../user.php?error= Password must contain Special Character&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
        exit();
    }
    else 
    {

                $query = "UPDATE user SET fname = ?, lname = ?, password = ?, isadmin = ?, isactive = ? WHERE email = ?";
                $stmt = mysqli_stmt_init($db);
                if(!mysqli_stmt_prepare($stmt, $query))
                {
                    
                    header("location:../user.php?error= error");
                    exit();  
                }
                else
                {
                    //$hashs = md5(rand(0,1000));
                    $hashed = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "ssssss", $firstName, $lastName, $hashed, $isadmin, $isactive, $emailId);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    header("location:../user.php?success= sucess.$x.");
                    exit();  
                }

            }


    
mysqli_stmt_close($stmt);
mysqli_close($db);
}
else
{
    header("location:../user.php");
    exit();  
}

?>