<?php include('include/header.php') ?>
<?php include('include/database.php');?>
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
                $sql="SELECT * FROM log";
                $stmt = mysqli_stmt_init($db);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "error";
                }else{
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);


                if ($result)
                {
                  echo '<div class = "card-body" ><div class="table-wrapper-scroll-y"><div class="table-responsive"><table class="table table-hover"><thead class = "text-primary"><th>Name</th><th>Action</th><th>Date</th></thead>';
                  while($row = mysqli_fetch_assoc($result))  
                  {
                    echo "<tr>";
                    echo '<td style="display:none;">' . $row['id'] . '</td>';

                    echo '<td>' . $row['name'] . '</td>';

                    echo '<td>' . $row['action'] . '</td>';

                    echo '<td>' . $row['date'] . '</td>';
                    
                    echo "</tr>";

                  }
                  echo "</table></div></div></div>";

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