
<?php
if(isset($_POST['submitButton']))
{
    include( 'database.php' );
    $email = trim($_POST['email']);
    $name = trim($_POST['name']);
    $genre = trim($_POST['genre']);
    $type = trim($_POST['type']);
    $episode = trim($_POST['episode']);
    if ((empty($name)) || (empty($genre)) || (empty($type)) || (empty($episode))) 
    {
        header("location:../post.php?error= Empty field ");
        exit();
    }
    elseif(!preg_match("/^([a-zA-Z' ]+)$/", $name))
    {
        header("location:../post.php?error= Invalid name");
        exit();
    }
    elseif(!preg_match("/^[\w .,!?()' ]+$/", $genre))
    {
        header("location:../post.php?error= Invalid genre");
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z]*$/", $type))
    {
        header("location:../post.php?error= Invalid type");
        exit();
    }elseif(!preg_match("/^[0-9]*$/", $episode))
    {
        header("location:../post.php?error= Invalid episode");
        exit();
    }
 
    else 
    {
        $imgfile=$_FILES["myfile"]["name"];
        $extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));
        $allowed_extensions = array(".jpg",".jpeg",".png",".gif");
            if($_FILES['myfile']['name']== ""){
                header("location:../post.php?error=Please select file");
              exit();

            }elseif(!in_array($extension,$allowed_extensions))
            {  
                header("location:../post.php?error=Invalid format. Only jpg / jpeg/ png /gif format allowed");
                exit();

            }else{
              $path = "../upload/".$_FILES['myfile']['name'];
              move_uploaded_file($_FILES['myfile']['tmp_name'], $path);
                
              
                $query = "INSERT INTO anime (name, genre, type, episodes, images) values (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($db);
                if(!mysqli_stmt_prepare($stmt, $query))
                {
                    
                    header("location:../post.php?error= error");
                    exit();  
                }
                else
                {

                    mysqli_stmt_bind_param($stmt, "sssss", $name, $genre, $type, $episode, $path);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);


                    $sql2="SELECT * from user where email = ?";
                    $stmt2 = mysqli_stmt_init($db);
                    if(!mysqli_stmt_prepare($stmt2, $sql2)){
                        header("location:../login.php?error= error fields");
                    }else{
                        mysqli_stmt_bind_param($stmt2, "s", $email);
                        mysqli_stmt_execute($stmt2);
                        $result = mysqli_stmt_get_result($stmt2);
                
                            if($row = mysqli_fetch_assoc($result))
                            {
                                    $uname = $row['fname'].' '.$row['lname'];
                                    $action = "Anime added: ".$name;
                                    $query2 = "INSERT INTO log (name, action) values (?, ?)";
                                    $stmt3 = mysqli_stmt_init($db);
                                    if(!mysqli_stmt_prepare($stmt3, $query2))
                                    {
                                        header("location:../login.php?error= error");
                                        exit();  
                                    }
                                    else
                                    {
                                       
    
                                        mysqli_stmt_bind_param($stmt3, "ss", $uname, $action);
                                        mysqli_stmt_execute($stmt3);
                                        mysqli_stmt_store_result($stmt3);
                                    }
                                }
                    header("location:../post.php?success= anime added ");
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