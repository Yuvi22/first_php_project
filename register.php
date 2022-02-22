
<?php include('include/header.php');?>

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
			<form id="registrationForm" action="include/registerl.php" method="POST">
				<div class="container">
					<div class="row">
						   <div class="col-lg-6 col-md-12">
							   <label class="label-control">First Name:</label>
							   <input type="text" class="form-control" name="firstName" id="firstName" value="<?php $fname ?>">
							</div>
						   <div class="col-lg-6 col-md-12">
								<label class="label-control">Last Name:</label>
								<input type="text" class="form-control" name="lastName" id="lastName" value="<?php $lname ?>">
						   </div>
					   </div>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<label class="label-control">Email:</label>
								<input type="text"  class="form-control" name="emailId" id="emailId" value="<?php $email ?>">
							</div>
							<div class="col-lg-12 col-md-12">
								<label class="label-control">Password:</label>
								<input type="password" class="form-control" name="pwd" id="pwd" value="">
							</div>
							<div class="col-lg-12 col-md-12">
							   <label class="label-control"> Confirm Password:</label>
								<input type="password" class="form-control" name="cnfpwd" id="cnfpwd" value="">
							</div>
                     
							<div class="col-lg-12 col-md-12" style="padding-top:3%;">
								<input id="submitButton" name="submitButton" class="btn btn-primary btn-block" type="submit" value="Submit">
							</div>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>

<?php include('include/footer.php');?>