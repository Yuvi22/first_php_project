
<?php include('include/header.php');?>
<?php include('include/database.php');?>
<?php 

if(isset($_GET['id'])){
$id=$_GET['id'];
}
$sql="SELECT * from user where u_id = ?";
$stmt = mysqli_stmt_init($db);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location:../login.php?Empty= error");
}else{
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($result))
        {
?>
<div class="container" style="padding-top:10%; padding-bottom:10%;">
	<div id="register-row" class="row justify-content-center align-items-center">
		<div class="col-lg-5 col-md-7">
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
			<form id="registrationForm" action="include/edit.php" method="POST">
				<div class="container">
					<div class="row">
                    <input type="hidden" class="form-control" name="u_id" id="u_id" value="<?php $row['u_id'] ?>">
						   <div class="col-lg-6 col-md-12">
							   <label class="label-control">First Name:</label>
							   <input type="text" class="form-control" name="firstName" id="firstName" value="<?php echo $row['fname'] ?>">
							</div>
						   <div class="col-lg-6 col-md-12">
								<label class="label-control">Last Name:</label>
								<input type="text" class="form-control" name="lastName" id="lastName" value="<?php echo $row['lname'] ?>">
						   </div>
					   </div>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<label class="label-control">Email:</label>
								<input type="text"  class="form-control" name="emailId" id="emailId" value="<?php echo $row['email'] ?>" disabled>
							</div>
							<div class="col-lg-12 col-md-12">
								<label class="label-control">Password:</label>
								<input type="text" class="form-control" name="pwd" id="pwd" value="<?php echo $row['password'] ?>">
							</div>
                            
                            <div class="col-lg-12 col-md-12">
                            
                            <label  class="label-control">Role
                                          </label>
                              <input type="text" class="form-control" name="isadmin" id="isadmin" value="<?php echo $row['isadmin'] ?>">
                             <!-- ?php if ($row['isadmin'] =="user") {?>
                            <select name="isadmin"  class="form-control">
                                <option value="user" selected>User</option>
                                <option value="admin">Admin</option>
                            </select>
                            ?php }else{ ?>
                            <select name="isadmin"  class="form-control">
                                <option value="user">User</option>
                                <option value="admin" selected>Admin</option>
                            </select>
                            ?php } ?> -->
                            </div>

                            <div class="col-lg-12 col-md-12">
                            
                            <label  class="label-control">Active
                                          </label>
                                          <input type="text" class="form-control" name="isactive" id="isactive" value="<?php echo $row['isactive'] ?>">
                             <!-- ?php if ($row['isactive'] =="yes") {?>
                            <select name="isactive"  class="form-control">
                                <option value="yes" selected>Yes</option>
                                <option value="no">No</option>
                            </select>
                            ?php }else{ ?>
                            <select name="isactive"  class="form-control">
                                <option value="yes">Yes</option>
                                <option value="no" selected>No</option>
                            </select>
                            ?php } ?> -->
                            </div>
                     
							<div class="col-lg-12 col-md-12" style="padding-top:3%;">
								<input id="submitButton" name="submitButton" class="btn btn-primary btn-block" type="submit" value="Submit">
							</div>
						</div>
					</div>
				</form>
                            <?php } 
                            }?>
			</div>
		</div>
	</div>
</div>

<?php include('include/footer.php');?>