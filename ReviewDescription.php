<?php include('function.php'); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Review Description Page - GRA</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="http://localhost/GameReviewApp/custom.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Cuprum:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

  <?php 
      $conn = mysqli_connect("localhost", "root", "admin");
      mysqli_select_db($conn,"game_review");
       $id = $_GET["id"];

          $query = "SELECT * from reviews where id = '$id'";
          $result = mysqli_query($conn, $query);
          if (!$result)
            die('Invalid querry:' .mysqli_error($conn));
          $myrow=mysqli_fetch_array($result);

          $query2 = "SELECT * from user_comments where review_id = '$id'";
          $result2 = mysqli_query($conn, $query2);
          if (!$result2)
            die('Invalid querry:' .mysqli_error($conn));
          $myrow2 = mysqli_fetch_array($result2);

          $query4 = "SELECT users.*, user_comments.* FROM user_comments JOIN users ON user_comments.users_id = users.id and review_id = '$id'";
          $result4 = mysqli_query($conn, $query4);
          if (!$result4)
            die('Invalid querry:' .mysqli_error($conn));
          $myrow4 = mysqli_fetch_array($result4);
          



          if (isLoggedIn()) {
          $user_id = $_SESSION['user']['id'];

          $query3 = "SELECT * from users where id = '$user_id'";
          $result3 = mysqli_query($conn, $query3);
          if (!$result3)
            die('Invalid querry:' .mysqli_error($conn));
          $myrow3=mysqli_fetch_array($result3);
     }


  ?>
	
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="http://localhost/GameReviewApp/HomePage.php"><i class="fas fa-gamepad"></i> GRA</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-nav-demo" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="bs-nav-demo">
      <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="http://localhost/GameReviewApp/Reviews.php">Reviews</a>
          </li>
           <?php if (isLoggedIn() && $_SESSION['user']['user_type'] == 'admin'):  ?>
             <li class="nav-item">
              <a class="nav-link" href="http://localhost/GameReviewApp/AdminDash.php">Dashboard</a>
              </li>
              <?php endif ?>
          <?php if (isLoggedIn() && $_SESSION['user']['user_type'] == 'employee'):  ?>
            <li class="nav-item">
            <a class="nav-link" href="http://localhost/GameReviewApp/EmployeeDash.php">Dashboard</a>
            </li>
             <?php endif ?>
        <?php if (isLoggedIn() && $_SESSION['user']['user_type'] == 'user'):  ?>
          <li class="nav-item">
          <a class="nav-link" href="http://localhost/GameReviewApp/UserDash.php">Dashboard</a>
          </li>
           <?php endif; ?>
      </ul>
      <ul class="navbar-nav">
      <?php if (isLoggedIn() && $_SESSION['user']['user_type'] == 'admin'):  ?>
               <li>
               <a href="http://localhost/GameReviewApp/AdminEdit.php">
            <?php if(!empty($myrow3['user_photo'])) {
                          echo "<img class = 'rounded-circle' style = 'width: 30px; height: 30px; position:relative; right: 5px' src = 'profile/".$myrow3['user_photo']."'>";
                        } else {
                          echo "<i class='fas fa-user-circle fa-2x text-secondary'></i>";
                        }

                       ?>
          </a>
            </li>
              <?php endif ?>
               <?php if (isLoggedIn() && $_SESSION['user']['user_type'] == 'employee'):  ?>
               <li>
                <a href="http://localhost/GameReviewApp/EmployeeEditPage.php">
            <?php if(!empty($myrow3['user_photo'])) {
                          echo "<img class = 'rounded-circle' style = 'width: 30px; height: 30px; position:relative; right: 5px' src = 'profile/".$myrow3['user_photo']."'>";
                        } else {
                          echo "<i class='fas fa-user-circle fa-2x text-secondary'></i>";
                        }

                       ?>
          </a>
            </li>
              <?php endif ?>
               <?php if (isLoggedIn() && $_SESSION['user']['user_type'] == 'user'):  ?>
               <li>
                    <a href="http://localhost/GameReviewApp/UserEditPage.php">
            <?php if(!empty($myrow3['user_photo'])) {
                          echo "<img class = 'rounded-circle' style = 'width: 30px; height: 30px; position:relative; right: 5px' src = 'profile/".$myrow3['user_photo']."'>";
                        } else {
                          echo "<i class='fas fa-user-circle fa-2x text-secondary'></i>";
                        }

                       ?>
          </a>
            </li>
              <?php endif ?>
        <?php  if (isset($_SESSION['user'])) : ?>
          <div>
              <strong class="text-danger"><?php echo $_SESSION['user']['username']; ?></strong>
              <a href="EmployeeDash.php?logout='1'" button type="submit" class="btn btn-danger" name="logout">Log out</a>
          </div>
        </li>
        <?php else: ?>
          <li>
          <a class="nav-link" href="http://localhost/GameReviewApp/Register.php">Sign Up</a>
        </li>
        <li>
          <a class="nav-link" href="http://localhost/GameReviewApp/Login.php">Sign in</a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>



  <?php echo  "<img src='imgreviews/".$myrow['review_image']."' class='img-fluid'>"; ?>
  <br><br><br>
  <h1 class="my-text-font text-center"><?php echo $myrow['review_title']; ?></h1>

<br><br>

<div class="container content">

<!-- 16:9 aspect ratio -->
<div class="embed-responsive embed-responsive-16by9">
    <?php echo "<iframe width='560' height='31' src='".$myrow['review_trailer']."' class='img-fluid' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>"; ?>
</div>

 <br><br>

 <h3>Rate this review</h3>
 <div class="justify-content-center">
                <h5 class="my-text-font">Star Rating</h5>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star"></span>
            <span class="fa fa-star"></span>
</div>
  <br>
  <div class="row">
    <div class="col-4">
      <table class="table table-hover table-bordered">
        <tbody>
          <tr>
            <td>
              <h5>Available Platforms:</h5>
             <p><?php echo $myrow['platform']; ?></p>
            </td>
          </tr>
          <tr>
            <td>
              <h5>Genre:</h5>
             <p><?php echo $myrow['genre']; ?></p>
            </td>
          </tr>
          <tr>
             <td>
              <h5>Available Regions:</h5>
             <p><?php echo $myrow['region']; ?></p>
            </td>
          </tr>
          <tr>
             <td>
              <h5>PG-Rating:</h5>
             <p><?php echo $myrow['pg_rating']; ?></p>
            </td>
          </tr>
      </tbody>
    </table>
    </div>
  </div>
  

<br><br>
  <p>
    <?php echo $myrow['review_content']; ?>
  </p>



<br><br>

<?php 
 if (isLoggedIn()):  ?>

<form method="POST" action="ReviewDescription.php?id=<?php echo $id ?>">
  <h2 class="my-text-font">Comment Section</h2>
<?php 
  if (!$result4)
            die('Invalid querry:' .mysqli_error($conn));
          else {
            while ($myrow4=mysqli_fetch_array($result4,MYSQLI_ASSOC)) {
              ?>

                <div class="d-flex justify-content-left row">
        <div class="col-md-8">
            <div class="d-flex flex-column comment-section">
                <div class="bg-white p-2">
                    <div class="d-flex flex-row user-info"><?php echo"<img class = 'rounded-circle' src = 'profile/".$myrow4['user_photo']."' width='40'>"; ?>
                        <div class="d-flex flex-column justify-content-start ml-2"><span class="d-block font-weight-bold name text-danger"><?php echo $myrow4['username']. " "; ?></span><span class="date text-black-50">Shared publicly -  <?php echo $myrow4['created']; ?></span></div>
                    </div>
                    <div class="mt-2">
                        <p class="comment-text"> <?php echo $myrow4['content']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <?php 

            }
          }
          ?>
    <div class="d-flex justify-content-left row">
        <div class="col-md-8">
            <div class="d-flex flex-column comment-section">
                <div class="bg-white">
                    <div class="d-flex flex-row fs-12">
                        <div class="like p-2 cursora"><i class="fa fa-thumbs-o-up"></i><span class="ml-1">Like</span></div>
                        <div class="like p-2 cursor"><i class="fa fa-commenting-o"></i><span class="ml-1">Comment</span></div>
                        <div class="like p-2 cursor"><i class="fa fa-share"></i><span class="ml-1">Share</span></div>
                    </div>
                </div>
                <div class="bg-light p-2">
                    <div class="d-flex flex-row align-items-start"><?php echo"<img class = 'rounded-circle' src = 'profile/".$myrow3['user_photo']."' width='40' height = '40'>"; ?><textarea class="form-control ml-1 shadow-none textarea" name="message"></textarea></div>
                    <div class="mt-2 text-right"><button class="btn btn-danger btn-sm shadow-none" type="submit" name="post">Post comment</button>
                </div>           
                </div>
            </div>
        </div>
    </div>
</form>
<?php endif; ?>
</div>


<br><br>

<!-- Footer -->
<footer class="bg-secondary text-center text-lg-start">
  <!-- Grid container -->
  <div class="container p-4">
    <!--Grid row-->
    <div class="row justify-content-center">
      <!--Grid column-->
      <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
        <h5 class="text-uppercase">About</h5>

        <p class="text-light">
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iste atque ea quis
          molestias. Fugiat pariatur maxime quis culpa corporis vitae repudiandae aliquam
          voluptatem veniam, est atque cumque eum delectus sint!
        </p>
      </div>
      <!--Grid column-->

      <!--Grid column-->
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase">More sites</h5>

        <ul class="list-unstyled mb-0">
          <li>
            <a href="https://www.metacritic.com/" class="text-light">metacritic.com</a>
          </li>
          <li>
            <a href="https://www.gamespot.com" class="text-light">gamespot.com</a>
          </li>
          <li>
            <a href="https://www.gamesradar.com/uk/" class="text-light">gamesradar.com</a>
          </li>
        </ul>
      </div>
      <!--Grid column-->

      <!--Grid column-->
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase mb-0">Usefull Links</h5>

        <ul class="list-unstyled">
          <li>
            <a href="http://localhost/GameReviewApp/Contact.html" class="text-light">Contact</a>
          </li>
          <li>
            <a href="http://localhost/GameReviewApp/Privacypolicy.html" class="text-light">Privacy Policy</a>
          </li>
          <li>
            <a href="http://localhost/GameReviewApp/TermsOfUse.html" class="text-light">Terms of Use</a>
          </li>
        </ul>
      </div>
      <!--Grid column-->
    </div>
    <!--Grid row-->
  </div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3 bg-dark">
   	<p class="text-light">© 2021 Copyright: <i class="fas fa-gamepad"></i> GRA</p>
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

<script src="https://kit.fontawesome.com/9b37347340.js" crossorigin="anonymous"></script>

</body>
</html>