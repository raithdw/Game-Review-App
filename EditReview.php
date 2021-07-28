<?php include('function.php'); 
  if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: Login.php');
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Review - GRA</title>
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
          $myrow = mysqli_fetch_array($result);


          $user_id = $_SESSION['user']['id'];
          
          $query2 = "SELECT * from users where id = '$user_id'";
          $result2 = mysqli_query($conn, $query2);
          if (!$result2)
            die('Invalid querry:' .mysqli_error($conn));
          $myrow2 = mysqli_fetch_array($result2);



      if (isset($_POST['add_photo'])) {

      $sql_img = "SELECT review_image from reviews where id = '$id'";
      $result_img = mysqli_query($conn, $sql_img);
      $rowimg = mysqli_fetch_assoc($result_img);
     
      $file = $_FILES["file"];
      $file_name = $_FILES["file"]['name'];
      $file_tmp = $_FILES["file"]['tmp_name'];
      $file_size = $_FILES["file"]['size'];
      $file_type = $_FILES["file"]['type'];
      $file_error = $_FILES["file"]['error'];
      $file_ext = explode('.', $file_name);
      $file_actual_ext = strtolower(end($file_ext));
      $allow = array('jpg', 'jpeg', 'png', 'bmp');

      if (in_array($file_actual_ext, $allow)) {
        if ($file_error === 0) {
            $file_name_new = "imgreviews" .$id. ".". $file_actual_ext;
            $file_destination = 'imgreviews/'.$file_name_new;
            move_uploaded_file($file_tmp, $file_destination);
            $sql_stm = "UPDATE reviews SET review_image = '$file_name_new' Where id = '$id'";
            $this_result = mysqli_query($conn, $sql_stm);
        } else {
          echo "There was an error uploading your file!";
        }
      } else {
        echo "You cannot upload files of this type!";
      }
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
           <li class="nav-item">
            <a class="nav-link" href="http://localhost/GameReviewApp/EmployeeDash.php">Dashboard</a>
          </li>
    	</ul>
    	<ul class="navbar-nav">
        <li>
          <a href="http://localhost/GameReviewApp/EmployeeEditPage.php">
            <?php if(!empty($myrow2['user_photo'])) {
                          echo "<img class = 'rounded-circle' style = 'width: 30px; height: 30px; position:relative; right: 5px' src = 'profile/".$myrow2['user_photo']."'>";
                        } else {
                          echo "<i class='fas fa-user-circle fa-2x text-secondary'></i>";
                        }

                       ?>
          </a>
       </li>
          <div>
            <?php  if (isset($_SESSION['user'])) : ?>
              <strong class="text-danger"><?php echo $_SESSION['user']['username']; ?></strong>
              <a href="EmployeeDash.php?logout='1'" button type="submit" class="btn btn-danger" name="logout">Log out</a>
            <?php endif ?>
          </div>
        </li>
    	</ul>
  	</div>
  </div>
</nav>

<br><br>

<div class="container content">
 <div class="row">
    <div class="col d-flex">
        <h1>Edit Review</h1>
    </div>
     <div class="col d-flex justify-content-end">
      <form method="POST">
        <input name="delete" class="btn btn-danger" type="submit" value="Delete Review">
      </form>
    </div>
  </div>
  <br>
<div class="row flex-lg-nowrap">
  <div class="col">
    <div class="row">
      <div class="col mb-3">
        <div class="card">
          <div class="card-body">
            <div class="e-profile">
              <div class="row">
                <div class="col-12 col-sm-auto mb-3">
                  <div class="mx-auto" style="width: 140px;">
                    <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(255, 255, 255);">
                       <p class="text-muted"><?php if(!empty($myrow['review_image'])) {
                          echo "<img style = 'width: 250px; height: 170px; position:relative; left:50px; top:10px' src = 'imgreviews/".$myrow['review_image']."'>";
                        } else {
                          echo "<img style = 'width: 250px; height: 170px; position:relative; left:50px; top:10px' src = 'GameReviewImgs/poster.png'>";
                        }

                       ?></p>
                    </div>
                  </div>
                </div>
                <div class="col d-flex flex-column flex-sm-row justify-content-center mb-3">
                  <div class="text-center text-sm-left mb-2 mb-sm-0">
                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php echo $myrow['review_title']; ?></h4>
                    <p class="mb-0"><?php echo $myrow['review_description']; ?></p>
  
                  </div>
                </div>
              </div>
              <div class="mt-2">
                     <form method="POST" enctype="multipart/form-data">
                        <input type="file" name="file" id="file"/>
                          <br><br> 
                        <button class="btn btn-danger" type="submit" name="add_photo">
                        <i class="fa fa-fw fa-camera"></i>
                        <span>Change Photo</span>
                      </button>
                      </form>
              </div>
              <ul class="nav nav-tabs">
              </ul>
              <div class="tab-content pt-3">
                <div class="tab-pane active">
                  <form class="form" method="POST">
                    <div class="row">
                      <div class="col">
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Review Title Name</label>
                              <input class="form-control" type="text" name="review_title" placeholder="Title Name" value="<?php echo $myrow['review_title']; ?>">
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label>Review Description</label>
                              <input class="form-control" type="text" name="review_description" placeholder="Short Descritpion..." value="<?php echo $myrow['review_description']; ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                              <label>Change trailer link</label>
                              <div class="mt-2 form-group">
                                    <input class="form-control" type="text" name="trailer" id="trailer" value="<?php echo $myrow['review_trailer']; ?>" />
                              </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col mb-3">
                            <div class="form-group">
                              <label>Review Content</label>
                              <textarea name="review_content" class="form-control" rows="5" placeholder="Review Content..."><?php echo $myrow['review_content']; ?></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col d-flex justify-content-end">
                        <div class="form-group">
                          <input name="submit" class="btn btn-danger " type="submit" value="Save Changes"></button>
                        </div>
                         
                      </div>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
</div>
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


 <?php
      if(isset($_POST['delete'])){
      $query = "DELETE FROM reviews WHERE id = '$id'";
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    ?>
        <script type="text/javascript">
            alert("Update Successfull.");
            window.location = "EmployeeDash.php";
        </script>
        <?php
      }              
?>


 <?php
      if(isset($_POST['submit'])){
        $review_title = $_POST['review_title'];
        $review_description = $_POST['review_description'];
        $review_content = $_POST['review_content'];
        $trailer = $_POST['trailer'];
      $query = "UPDATE reviews SET review_title = '$review_title',
                      review_description = '$review_description', review_content = '$review_content', review_trailer = '$trailer'
                      WHERE id = '$id'";
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    ?>
        <script type="text/javascript">
            alert("Update Successfull.");
            window.location = "EditReview.php?id=<?php echo $myrow['id'] ?>"
        </script>
        <?php
      }              
?>