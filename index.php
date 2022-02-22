<?php include('include/header.php');?>
<?php include('include/database.php');?>
<!-- Main Content -->
<?php
$sql="SELECT * FROM anime";
            $stmt = mysqli_stmt_init($db);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo "error";
            }else{
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
        
            while($row = mysqli_fetch_assoc($result)){ ?>

         <div class="card" style="border:none;">
            
            <div class="card-body">
            <div class="container"><div class="row"><div class="col-lg-3"><img class="card-img-top" src="<?php echo $row['images']; ?>" alt="Card image" style="width:200px; padding-left:3px;"></div><div class="col-lg-9"> <strong>Name:</strong> <?php echo $row['name']; ?>  <br><strong>Genre:</strong> <?php echo $row['genre']; ?>   <br><strong>Type:</strong> <?php echo $row['type']; ?>  <br><strong>Episode:</strong> <?php echo $row['episodes']; ?></div> </div></div>
               <!-- <a href="#" class="btn btn-primary" style="text-decoration:none;">Read more...</a> -->
               
            </div>
         </div>
         <hr>

 
            <?php } 
            }?> 
<?php include('include/footer.php');?>
