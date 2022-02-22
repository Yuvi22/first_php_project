
<?php include('include/header.php');?>

<div class="container" style="padding-top:10%; padding-bottom:10%;">
	<div id="register-row" class="row justify-content-center align-items-center">
		<div class="col-lg-5 col-md-7">
            <?php 
            $selector = $_GET["selector"];
            $validator = $_GET["validator"];
			$currentDate = date("U");
			include('include/database.php');
        if (empty($selector) || empty($validator)){
            echo '<div class="alert alert-danger" role="alert" style="text-align:center; text-transform: uppercase;"><strong>could not perform request</strong></div>';
        }else{
            if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ){
				$sql ="SELECT * FROM resets WHERE passwordselector = ?  and expire >= ?";
				$stmt = mysqli_stmt_init($db);
				if(!mysqli_stmt_prepare($stmt, $sql)){
					echo '<div class="alert alert-danger" role="alert" style="text-align:center; text-transform: uppercase;"><strong>error</strong></div>';
				exit();
				}
				else 
				{
					// $hashtoken = password_hash($token, PASSWORD_DEFAULT);
					mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
					mysqli_stmt_execute($stmt);
			
					$result = mysqli_stmt_get_result($stmt);
					if (!$row = mysqli_fetch_assoc($result)){
			
						echo '<div class="alert alert-danger" role="alert" style="text-align:center; text-transform: uppercase;"><strong>link expired</strong></div>';
			
						exit();
					}else{
                ?>
    
           <form  action="include/resetl.php" method="POST">
               <input type="hidden" name = "selector" value="<?php echo $selector; ?>"/>
               <input type="hidden" name = "validator" value="<?php echo $validator; ?>"/>
					<div class="container">
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<label class="label-control">Password:</label>
								<input type="password" class="form-control" name="pwd" id="pwd" value="">
							</div>
							<div class="col-lg-12 col-md-12">
							   <label class="label-control"> Confirm Password:</label>
								<input type="password" class="form-control" name="cnfpwd" id="cnfpwd" value="">
							</div>
                     
							<div class="col-lg-12 col-md-12" style="padding-top:3%;">
								<input id="submit" name="rsubmit" class="btn btn-primary btn-block" type="submit" value="Reset password">
							</div>
						</div>
					</div>
				</form>
    <?php
				
				}
			  }
            }
        }

 
            ?>
			

			</div>
		</div>
	</div>
</div>

<?php include('include/footer.php');?>