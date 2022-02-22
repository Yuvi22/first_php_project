<?php include('include/header.php');?>

<div class="container" style="padding-top:10%; padding-bottom:10%;">
            <div id="login-row" class="row justify-content-center align-items-center">
            <div class="col-lg-4 col-md-6 ">

          	<form action="include/loginl.php" method="post" class="request-form ftco-animate">
				  <h2>Login</h2>
				  <?php 
                        if(@$_GET['Empty']==true)
                        {
                    ?>
                        <div class="alert-light text-danger text-center py-3"><?php echo $_GET['Empty'] ?></div>                                
                    <?php
                        }
                    ?>
 
 
                    <?php 
                        if(@$_GET['Invalid']==true)
                        {
                    ?>
                        <div class="alert-light text-danger text-center py-3"><?php echo $_GET['Invalid'] ?></div>                                
                    <?php
                        }
                    ?>
                     <?php 
                        if(@$_GET['sucess']==true)
                        {
                    ?>
                        <div class="bg-success text-white text-center py-3"><?php echo $_GET['sucess'] ?></div>                                
                    <?php
                        }
                    ?>
	    				<div class="form-group" >
                                <label for="email" class="label">Email:</label><br>
                                <input type="text" name="email"class="form-control" >
	    				</div>
	    				<div class="form-group">
                                <label for="password" class="label">Password:</label><br>
                                <input type="password" name="password" class="form-control" >
	    				</div>

	            <div class="form-group">
                                <button class="btn btn-primary py-3 px-4" type="submit" name="login_user"><i class="fa fa-sign-in"></i> Sign in</button>
                                <a href="register.php" class="text-info flex-right">Register here</a>
                                <br>
                                <a href="reset.php" class="text-info flex-center">Forgot Password</a>
	            </div>
	    			</form>
          </div>
        
            </div>
        </div>
    </div>  
<?php include('include/footer.php');?>