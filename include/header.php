<?php include('database.php');?>
<?php if((isset($_SESSION['email'])) && (isset($_SESSION['user'])) );
	session_start();
if ( isset( $_GET[ 'logout' ] ) ) {
   $email = $_SESSION['email'];
   $query = "UPDATE user set islogin = ? where email = ?";
   $stmt = mysqli_stmt_init($db);
   if(!mysqli_stmt_prepare($stmt, $query))
   {
       header("location:../index.php?error= error");
       exit();  
   }
   else
   {
      
       $islogin = "no";
       mysqli_stmt_bind_param($stmt, "ss", $islogin, $email);
       mysqli_stmt_execute($stmt);
       mysqli_stmt_store_result($stmt);
   }
	session_destroy();
	unset( $_SESSION[ 'email' ] );
	header( "location: index.php" );
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>The Anime Blog </title>
      <!-- Bootstrap core CSS -->
      <!-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <!-- Custom fonts for this template -->
      <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
      <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
      <style>
      body{
         /* background-image: url("../img/35252wide.jpg");
         opacity: 5.5;
         height: 100%;
         background-repeat: repeat; */
         
      }
         /* Make the image fully responsive */
         .carousel-inner img {
         width: 100%;
         height: 100%;
         }
        
.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 8rem;
    padding: .5rem 0;
    margin: .125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: .50rem;
}
      </style>
      <script>
      $('.carousel').carousel({
        interval: 2000
      })
      </script>
      <!-- Custom styles for this template -->
      <link href="css/clean-blog.min.css" rel="stylesheet">
   </head>
   <body>
      <!-- Navigation -->
      <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
         <div class="container">
            <a class="navbar-brand" href="index.php">Start Anime</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
               <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                     <a class="nav-link" href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="about.php">About</a>
                  </li>
                  <?php if( isset($_SESSION['email']) && !empty($_SESSION['email']) ){?>
                  <li class="nav-item">
                     <a class="nav-link" href="post.php">Post</a>
                  </li>
                  <?php }else{ ?>
                     <?php }?>
                  <li class="nav-item">
                     <a class="nav-link" href="contact.php">Contact</a>
                  </li>
                  <?php if( isset($_SESSION['email']) && !empty($_SESSION['email']) ){?>	
                  <?php if($_SESSION['user'] == "admin" ){?>
                     <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Admin </a>
                     <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
                        <ul style="list-style: none; padding:0%; text-align:center;">
                           	
                           <li><a data-placement="bottom" href="user.php">Users</a>
                           </li>
                           <hr class="divider">
                           <li><a href="log.php" data-placement="bottom"> Log</a></li>
                           </ul>
                     </div>
                  </li>
                  <?php } } ?>

                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i> Profile </a>
                     <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
                        <ul style="list-style: none; padding:0%; text-align:center;">
                           <?php if( isset($_SESSION['email']) && !empty($_SESSION['email']) ){?>	
                           <li><a data-placement="bottom" href="#">
                              <?php echo $_SESSION['fname']; ?> <b class="caret"></b>
                              </a>
                           </li>
                           <hr class="divider">
                           <li><a href="index.php?logout='1'" data-placement="bottom"><i class="fa fa-power-off"></i> Logout</a></li>
                           <?php }else{ ?>
                           <li><a data-placement="bottom" href="register.php"><i class="fa fa-user"></i>Sign Up </a></li>
                           <hr class="divider">
                           <li><a data-placement="bottom" href="login.php#login"><i class="fa fa-sign-in"></i> Login</a></li>
                           <?php }?>
                        </ul>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <!-- Page Header style="background-image: url('img/home-bg.jpg')"-->
      <header class="masthead" >
         <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel" style="height: 40rem;">
            <div class="carousel-inner" style="height: 40rem;">
               <?php
                  $thumbs = glob("images/*.jpg");
                  
                  if(count($thumbs)) {
                    foreach($thumbs as $thumb) {
                  	?>
               <div class="carousel-item active">
                  <img class="d-block w-100" src="<?php echo $thumb ?>" style="height: 40rem;">
               </div>
               <?php
                  }
                  }
                  ?>
            </div>
         </div>
         <!-- <div class="overlay"></div>
            <div class="container">
              <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                  <div class="site-heading">
                    <h1>Clean Blog</h1>
                    <span class="subheading">A Blog Theme by Start Bootstrap</span>
                  </div>
                </div>
              </div>
            </div> -->
      </header>