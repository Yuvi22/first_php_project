<?php include('include/header.php');?>
<div class="container" style="padding-top:10%; padding-bottom:10%;">
            <div id="login-row" class="row justify-content-center align-items-center">
            <div class="col-lg-4 col-md-6 ">
            <?php 
                        if(@$_GET['reset']==true)
                        {
                    ?>
                        <div class="bg-success text-white text-center py-3"><?php echo $_GET['reset'] ?></div>
						<br>                                
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
          	<form action="include/resetrequest.php" method="post" class="request-form ftco-animate">
				  <h2>Reset password</h2>

	    				<div class="form-group" >
                                <label for="email" class="label">Email:</label><br>
                                <input type="text" name="email"class="form-control" required="">
	    				</div>

	            <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit" name="reset">Send mail</button>
	            </div>
	    			</form>
          </div>
        
            </div>
        </div>
    </div>  
<?php include('include/footer.php');?>