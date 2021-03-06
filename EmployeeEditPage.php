<?php include('function.php'); 
  if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: Login.php');
  }

  if (isLoggedIn() && $_SESSION['user']['user_type'] != 'employee') {
    if ($_SESSION['user']['user_type'] == 'admin') {
      $_SESSION['msg'] = "You do not have permission";
    header('location: AdminDash.php');
    }
    
    else {
       $_SESSION['msg'] = "You do not have permission";
        header('location: UserDash.php');
    }
  }
  

?>

<!DOCTYPE html>
<html>
<head>
  <title>My Settings - GRA</title>
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

<?php 

if (isset($_POST['add_photo'])) {

  $sql_img = "SELECT user_photo from users where id = '$user_id'";
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
        $file_name_new = "profile" .$user_id. ".". $file_actual_ext;
        $file_destination = 'profile/'.$file_name_new;
        move_uploaded_file($file_tmp, $file_destination);
        $sql_stm = "UPDATE users SET user_photo = '$file_name_new' Where id = '$user_id'";
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
            <?php if(!empty($myrow['user_photo'])) {
                          echo "<img class = 'rounded-circle' style = 'width: 30px; height: 30px; position:relative; right: 5px' src = 'profile/".$myrow['user_photo']."'>";
                        } else {
                          echo "<i class='fas fa-user-circle fa-2x text-secondary'></i>";
                        }

                       ?>
          </a>
        </li>
        <li>
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

<div class="container content w-50 p-3">
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
                      <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;"><?php if(!empty($myrow['user_photo'])) {
                          echo "<img style = 'width: 150px; height: 170px;' src = 'profile/".$myrow['user_photo']."'>";
                        } else {
                          echo "<img style = 'width: 150px; height: 170px;' src = 'profile/profile.png'>";
                        }

                       ?></span>
                    </div>
                  </div>
                </div>
                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                  <div class="text-center text-sm-left mb-2 mb-sm-0">
                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php echo $myrow['first_name']; echo " ". $myrow['last_name'];?></h4>
                    <p name = "username" class="mb-0"><?php echo $myrow['username']; ?></p>
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
                  </div>
                  <div class="text-center text-sm-right">
                    <span class="badge badge-danger"><?php echo $myrow['user_type']; ?></span>
                    <div class="text-muted"><small>Joined <?php echo $myrow['created']; ?></small></div>
                  </div>
                </div>
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
                              <label>First Name</label>
                              <input class="form-control" type="text" name="first_name" value="<?php echo $myrow['first_name']; ?>">
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label>Last Name</label>
                              <input class="form-control" type="text" name="last_name" value="<?php echo $myrow['last_name']; ?>">
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label>Username</label>
                              <input class="form-control" type="text" name="username" value="<?php echo $myrow['username']; ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Email</label>
                              <input name="email" class="form-control" type="text" value="<?php echo $myrow['email']; ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col mb-3">
                            <div class="form-group">
                              <label>About</label>
                              <textarea name="about" class="form-control" rows="5"><?php echo $myrow['about']; ?></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-sm-6 mb-3">
                        <div class="mb-2"><b>Change Password</b></div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Current Password</label>
                              <input class="form-control" type="password" name="current_pass">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>New Password</label>
                              <input class="form-control" type="password" name="new_pass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
      title="Must contain at least one number(0-9) and one uppercase(A-Z) and lowercase letter(a-z), and at least 8 or more characters">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Confirm <span class="d-none d-xl-inline">Password</span></label>
                              <input class="form-control" type="password" name="conf_pass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
      title="Must contain at least one number(0-9) and one uppercase(A-Z) and lowercase letter(a-z), and at least 8 or more characters"></div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-5 offset-sm-1 mb-3">
                        <div class="mb-2"><b>Keeping in Touch</b></div>
                        <div class="row">
                          <div class="col">
                            <label>Email Notifications</label>
                            <div class="custom-controls-stacked px-2">
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="notifications-blog" checked="">
                                <label class="custom-control-label" for="notifications-blog">Blog posts</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="notifications-news" checked="">
                                <label class="custom-control-label" for="notifications-news">Newsletter</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="notifications-offers" checked="">
                                <label class="custom-control-label" for="notifications-offers">Personal Offers</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col d-flex justify-content-end">
                        <div class="form-group">
                        <input type="submit" class="btn btn-danger" name="submit" value="Save Changes">
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
    <p class="text-light">?? 2021 Copyright: <i class="fas fa-gamepad"></i> GRA</p>
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

<script src="https://kit.fontawesome.com/9b37347340.js" crossorigin="anonymous"></script>



</body>
</htmlphp
 