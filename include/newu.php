
<?php
if(isset($_POST['submitButton']))
{
    include( 'database.php' );
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $emailId = trim($_POST['emailId']);
    $password = trim($_POST['pwd']);
    $confirmpassword = trim($_POST['cnfpwd']);
    $isadmin = trim($_POST['isadmin']);
    if ((empty($firstName)) || (empty($lastName)) || (empty($emailId)) || (empty($password))|| (empty($confirmpassword))) 
    {
        header("location:../newuser.php?error= Empty field&firstName=".$firstName."&lastName".$lastName."&emailId".$emailId);
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z]*$/", $firstName))
    {
        header("location:../newuser.php?error= Invalid First Name&lastName".$lastName."&emailId".$emailId);
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z]*$/", $lastName))
    {
        header("location:../newuser.php?error= Invalid Last Name&firstName=".$firstName."&emailId=".$emailId);
        exit();
    }
    elseif(!filter_var($emailId, FILTER_VALIDATE_EMAIL))
    {
        header("location:../newuser.php?error= Invalid Email&firstName=".$firstName."&lastName=".$lastName);
        exit();
    }
    elseif($password !== $confirmpassword)
    {
        header("location:../newuser.php?error= Password does not match&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
        exit();
    }else if (strlen($password) <= '8') 
    {
        header("location:../newuser.php?error= Password must be more than 8 characters&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
        exit();
    }
    elseif(!preg_match("#[0-9]+#",$password)) 
    {
        header("location:../newuser.php?error= Password must contain number&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
        exit();
    }
    elseif(!preg_match("#[A-Z]+#",$password))
    {
        header("location:../newuser.php?error= Password must contain capital letter&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
        exit();
    }
    elseif(!preg_match("#[a-z]+#",$password)) 
    {
        header("location:../newuser.php?error= Password must contain small letters&firstName=".$firstName."&lastName".$lastName."&emailId=".$emailId);
        exit();
    }
    elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,.|=_+¬-]/', $password)) {
        header("location:../newuser.php?error= Password must contain Special Character&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
        exit();
    }
    else 
    {
        $sql = "SELECT * FROM user WHERE email=?";
        $stmt = mysqli_stmt_init($db);
        if(!mysqli_stmt_prepare($stmt, $sql))
        {
            header("location:../newuser.php?error= error");
            exit();  

        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $emailId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $results = mysqli_stmt_num_rows($stmt);
            if($results > 0)
            {
                header("location:../newuser.php?error= Email taken&firstName=".$firstName."&lastName=".$lastName."&emailId=".$emailId);
                exit();
            }
            else
            {
                $query = "INSERT INTO user (fname, lname, email, password, isadmin, isactive) values (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($db);
                if(!mysqli_stmt_prepare($stmt, $query))
                {
                    header("location:../newuser.php?error= error");
                    exit();  
                }
                else
                {
                    //$hashs = md5(rand(0,1000));
                    $isactive = "yes";
                    $hashed = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "ssssss", $firstName, $lastName, $emailId, $hashed, $isadmin, $isactive);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    header("location:../newuser.php?success= Registered ");
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
    header("location:../newuser.php");
    exit();  
}

?>