<?php include('include/header.php')?>

<?php include('include/database.php');?>
<?php $email = $_SESSION['email'];?>
<div class="container" style="padding-top:10%; padding-bottom:10%;">
	<div id="register-row" class="row justify-content-center align-items-center">
		<div class="col-lg-5 col-md-7">
		<?php 
                        if(@$_GET['error']==true)
                        {
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
			<form id="registrationForm" action="include/postl.php" method="POST"  enctype="multipart/form-data">
				<div class="container">
					<div class="row">
					<input type="hidden" class="form-control" name="email" id="email" value="<?php echo $email ?>">
						   <div class="col-lg-12 col-md-12">
							   <label class="label-control">Name:</label>
							   <input type="text" class="form-control" name="name" id="name">
							</div>
						   <div class="col-lg-12 col-md-12">
								<label class="label-control">Genre:</label>
								<input type="text" class="form-control" name="genre" id="genre">
						   </div>
							<div class="col-lg-12 col-md-12">
								<label class="label-control">Type:</label>
								<input type="text"  class="form-control" name="type" id="type">
							</div>
							<div class="col-lg-12 col-md-12">
								<label class="label-control">Episode:</label>
								<input type="text" class="form-control" name="episode" id="episode" value="">
							</div>
              <div class="form-group"  style = " margin-left: 14px;margin-top: 29px;">
                            <label for="file" class="sr-only">File</label>
                            <div class="input-group">
                              <input type="text" name="filename" class="form-control" placeholder="No file selected" readonly>
                              <span class="input-group-btn">
                                <div class="btn btn-default  custom-file-uploader">
                                  <input type="file" name="myfile" onchange="this.form.filename.value = this.files.length ? this.files[0].name : ''" style="display: block; position: absolute; top: 0; right: 0; bottom: 0; left: 0; z-index: 5; width: 100%; height: 100%; opacity: 0; cursor: default;" />
                                  <strong> Select a file</strong>
                                </div>
                              </span>
                            </div>
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
  <?php include('include/footer.php')?>
