<?php include('function.php'); 
  if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: Login.php');
  }

  if (isLoggedIn() && $_SESSION['user']['user_type'] != 'admin') {
    if ($_SESSION['user']['user_type'] == 'employee') {
      $_SESSION['msg'] = "You do not have permission";
    header('location: EmployeeDash.php');
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
  <title>Add account - GRA</title>
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
            <a class="nav-link" href="http://localhost/GameReviewApp/AdminDash.php">Dashboard</a>
          </li>
      </ul>
      <ul class="navbar-nav">
      <li>
         <a href="http://localhost/GameReviewApp/AdminEdit.php">
            <?php if(!empty($myrow['user_photo'])) {
                          echo "<img class = 'rounded-circle' style = 'width: 30px; height: 30px; position:relative; right: 5px' src = 'profile/".$myrow['user_photo']."'>";
                        } else {
                          echo "<i class='fas fa-user-circle fa-2x text-secondary'></i>";
                        }

                       ?>
          </a>
         <div>
          <li>
             <?php  if (isset($_SESSION['user'])) : ?>
              <strong class="text-danger"><?php echo $_SESSION['user']['username']; ?></strong>
              <a href="EmployeeDash.php?logout='1'" button type="submit" class="btn btn-danger" name="logout">Log out</a>
            <?php endif ?>
          </li>
          </div>
          </li>
      </ul>
    </div>
  </div>
</nav>

<br><br>

<div class="container content">
  <form method="post" action="AddAccount.php">
    <h2 class="text-center">Add a new account</h2>
    <br>
     <div class="row justify-content-center mb-4">
    <div class="col-6">
  
    <div class="alert-danger text-center">
      <?php echo display_error(); ?>
    </div>
    </div>
  
    </div>
    <div class="row justify-content-center mb-4">
    <div class="col-6">
      <select name="user_type" class="custom-select" >
        <option value>Choose account type</option>
        <option disabled="disabled">-----------------------</option>
        <option value="admin">Admin</option>
        <option value="employee">Employee</option>
        <option value="user">User</option>
      </select>
    </div>
  </div>
    
  <div class="row justify-content-center mb-4">
    <div class="col-6">
      <div class="form-outline">
        <label class="form-label" for="fname">First name</label>
        <input type="text" name="fname" class="form-control"/>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-6">
      <div class="form-outline">
        <label class="form-label" for="lname">Last name</label>
        <input type="text" name="lname" class="form-control"/>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-6">
      <div class="form-outline">
        <div>
          <label class="form-label" for="username">Username</label>
          <input type="text" name="username" class="form-control"/>
        </div>
      </div>
    </div>
  </div>

<div class="row justify-content-center mb-4">
  <div class="col-6">
     <!-- Email input -->
    <div class="form-outline">
      <div>
        <label class="form-label" for="email">Email address</label>
        <input type="email" name="email" class="form-control"/>
      </div>
    </div>
  </div>
</div>

<div class="row justify-content-center mb-4">
  <div class="col-6">
    <!-- Password input -->
    <div class="form-outline">
      <label class="form-label" for="password_1">Password</label>
      <input type="password" name="password_1" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
      title="Must contain at least one number(0-9) and one uppercase(A-Z) and lowercase letter(a-z), and at least 8 or more characters"/>
    </div>
  </div>
</div>

<div class="row justify-content-center mb-4">
  <div class="col-6">
    <!-- Password input -->
    <div class="form-outline">
      <label class="form-label" for="password_2">Confirm Password</label>
      <input type="password" name="password_2" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
      title="Must contain at least one number(0-9) and one uppercase(A-Z) and lowercase letter(a-z), and at least 8 or more characters"/>
    </div>
  </div>
</div>

  <!-- Submit button -->
  <div class="row justify-content-center mb-2">
    <div class="col-6">
      <button type="submit" class="btn btn-danger btn-block mb-4" name="add_account">Add Account</button>
    </div>
  </div>
</form>
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