<?php include('function.php'); 
  if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: Login.php');
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Review - GRA</title>
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

      $user_id = $_SESSION['user']['id'];
      
      $query = "SELECT * from users where id = '$user_id'";
      $result = mysqli_query($conn, $query);
      if (!$result)
        die('Invalid querry:' .mysqli_error($conn));
      $myrow=mysqli_fetch_array($result);


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
            <?php if(!empty($myrow['user_photo'])) {
                          echo "<img class = 'rounded-circle' style = 'width: 30px; height: 30px; position:relative; right: 5px' src = 'profile/".$myrow['user_photo']."'>";
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
        <h1>Add Review</h1>
    </div>
  </div>
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
                      <p class="text-muted">Add Image Poster</p>
                    </div>
                  </div>
                </div>
              </div>
              <form class="form" method="POST">
              <div class="mt-2">
                        <input type="file" name="file" id="file"/>
                          <br><br> 
                     
              </div>
              <ul class="nav nav-tabs">
              </ul>
              <div class="tab-content pt-3">
                <div class="tab-pane active">
                    <div class="row">
                      <div class="col">
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Review Title Name</label>
                              <input class="form-control" required type="text" name="review_title" placeholder="Title Name">
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label>Review Description</label>
                              <input class="form-control" required type="text" name="review_description" placeholder="Short Descritpion...">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                              <label>Add trailer link</label>
                               <div class="mt-2 form-group">
                                    <input class="form-control" type="text" name="trailer" id="trailer"/>
                                      <br><br> 
                              </div>
                            </div>
                        </div>
                        <br>

                         <div class="row">
                          <div class="col">
                           <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                              <th class="text-center">Add Game details:</th>
                            </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>
                                  <select name="platform" class="custom-select" required>
                                <option value>Platform</option>
                                <option disabled="disabled">---------</option>
                                <option value="All platforms">All platforms</option>
                                <option value="PC">PC</option>
                                <option value="PlayStation 4">PlayStation 4</option>
                                <option value="Xbox One">Xbox One</option>
                                <option value="Nintendo Wii">Nintendo Wii</option>
                              </select>
                                </td>
                              </tr>
                              <tr>
                                  <td>
                                  <select name="genre" class="custom-select">
                                <option value>Genre</option>
                                <option disabled="disabled">------</option>
                                <option value="All genres">All genres</option>
                                <option value="FPS">FPS</option>
                                <option value="RPG">RPG</option>
                                <option value="MMO">MMO</option>
                                <option value="RTS">RTS</option>
                                <option value="MOBA">MOBA</option>
                              </select>
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                  <select name="region" class="custom-select">
                                <option value>Region</option>
                                <option disabled="disabled">--------</option>
                                <option value="All regions">All regions</option>
                                <option value="Europe">Europe</option>
                                <option value="North America">North America</option>
                                <option value="South America">South America</option>
                                <option value="Australia">Australia</option>
                                <option value="Asia">Asia</option>
                              </select>
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                <div class="form-group">
                                  <select name="pg_rating" class="custom-select form-control">
                                <option value>PG-Rating</option>
                                <option disabled="disabled">------</option>
                                <option value="All ratings">All ratings</option>
                                <option value="PG-3">PG-3</option>
                                <option value="3">PG-7</option>
                                <option value="PG-7">PG-12</option>
                                <option value="PG-16">PG-16</option>
                                <option value="PG-18">PG-18</option>
                              </select>
                              </div>
                                  </td>
                              </tr>
                              <tr>
                                <td>
                                  <button type="submit" class="btn btn-danger btn-block">Reset Fields</button>
                                </td>
                              </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                          <br>
                        <div class="row">
                          <div class="col mb-3">
                            <div class="form-group">
                              <label>Review Content</label>
                              <textarea name="review_content" class="form-control" rows="5" required placeholder="Review Content..."></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col d-flex justify-content-end">
                        <div class="form-group">
                         <input type="submit" name="submit" class="btn btn-danger " value="Add Review">
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
      if(isset($_POST['submit'])){
     
      $file = $_FILES["file"];
      $file_name = $_FILES["file"]['name'];
      $file_tmp = $_FILES["file"]['tmp_name'];
      $file_size = $_FILES["file"]['size'];
      $file_type = $_FILES["file"]['type'];
      $file_error = $_FILES["file"]['error'];
      $file_ext = explode('.', $file_name);
      $file_actual_ext = strtolower(end($file_ext));
      $file_destination = 'GameReviewImgs/'.$file_name;
      move_uploaded_file($file_name, $file_destination);
     

        $trailer = $_POST['trailer'];
        $review_title = $_POST['review_title'];
        $review_description = $_POST['review_description'];
        $review_content = $_POST['review_content'];
        $pg_rating = $_POST['pg_rating'];
        $region = $_POST['region'];
        $genre = $_POST['genre'];
        $platform = $_POST['platform'];
        $id = $_SESSION['user']['id'];

        $query = "INSERT INTO reviews (review_title, review_description, review_content, users_id, pg_rating, region, genre, platform, review_image, review_trailer) VALUES ('$review_title', '$review_description', '$review_content', '$id', '$pg_rating', '$region', '$genre', '$platform', '$file_name', '$trailer')";
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

        

                    ?>
        <script type="text/javascript">
            alert("Update Successfull.");
            window.location = "AddReview.php";
        </script>
        <?php
      }              
?>