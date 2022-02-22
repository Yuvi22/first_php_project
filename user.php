<?php include('include/header.php') ?>
<?php include('include/database.php');?>
<?php 
                        if(@$_GET['error']==true)
                        {
							$fname =	@$_GET['firstName'];
							$lname =	@$_GET['lastName'];
							$email =	@$_GET['emailId'];
							
                    ?>
                        <div class="bg-danger text-white text-center py-3"><?php echo $_GET['error'] ?></div>        
						<br>                        
                    <?php
                        }
                    ?>
 
 
                    <?php 
                        if(@$_GET['success']==true)
                        {
                    ?>
                        <div class="bg-success text-white text-center py-3"><?php echo $_GET['success'] ?></div>
						<br>                                
                    <?php
                        }
                    ?>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                
                  <h4 class="card-title ">User Table</h4>
                  <p class="card-category"></p>
                </div>
                <?php 
                $sql="SELECT * FROM user";
                $stmt = mysqli_stmt_init($db);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "error";
                }else{
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);


                if ($result)
                {
                  echo '<div class = "card-body" ><div class="table-wrapper-scroll-y"><div class="table-responsive"><table class="table table-hover"><thead class = "text-primary"><th>First Name</th><th>Last Name</th><th>Email</th><th>User role</th><th>User active</th></thead>';
                  while($row = mysqli_fetch_assoc($result))  
                  {
                    echo "<tr>";
                    echo '<td style="display:none;">' . $row['u_id'] . '</td>';

                    echo '<td>' . $row['fname'] . '</td>';

                    echo '<td>' . $row['lname'] . '</td>';
                    
                    echo '<td>' . $row['email'] . '</td>';

                    echo '<td>' . $row['isadmin'] . '</td>';

                    echo '<td>' . $row['isactive'] . '</td>';
                    
                   // echo '<td><a href="edituser.php?id=' . $row['u_id'] . '" class="btn btn-info">Edit</a></td>';
                    
                   // echo '<td><a href="deleteuser.php?id=' . $row['u_id'] . '" class = "btn btn-danger" >Delete</a></td>';
                    
                    echo "</tr>";

                  }
                  echo "</table></div><p class='float-right'><a href='newuser.php' class= 'btn btn-primary'>Add a new record</a></p></div></div>";

                }
                else
                {
                  echo "no result";
     
                }
            }
                ?>
                
                </div> 
              </div>
              
            </div>
          </div>
        </div>
      </div>
<?php include('include/footer.php') ?>