<?php include('function.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Log in - GRA</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="http://localhost/GameReviewApp/custom.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Cuprum:wght@500&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	
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
    	</ul>
    	<ul class="navbar-nav">
    		<li>
    			<a class="nav-link" href="http://localhost/GameReviewApp/Register.php">Sign Up</a>
    		</li>
    		<li>
    			<a class="nav-link" href="http://localhost/GameReviewApp/Login.php">Sign in</a>
    		</li>
    	</ul>
  	</div>
  </div>
</nav>

<br><br>

<div class="container content">
<form method="post" action="Login.php">
	<h2 class="text-center">Log in to an existing account</h2>
	<br>
   <div class="row justify-content-center mb-4">
    <div class="col-6">
  
    <div class="alert-danger text-center">
      <?php echo display_error(); ?>
    </div>
    </div>
  
    </div>
  <div class="row justify-content-center mb-2">
  	<div class="col-6">
  	 	<!-- Email input -->
  		<div class="form-outline mb-4">
  			<label class="form-label" for="email_username">Email/Username</label>
    		<input type="text" name="email_username" class="form-control" required />
  		</div>
  	 </div>
  </div>
  
   <div class="row justify-content-center mb-2">
  	<div class="col-6">
  	 	 <!-- Password input -->
	  <div class="form-outline mb-4">
	  	<label class="form-label" for="password">Password</label>
	    <input type="password" name="password" class="form-control" required/>
	  </div>
  	</div>
  </div>  	
  <!-- 2 column grid layout for inline styling -->
  <div class="row justify-content-center mb-4">
    <div class="col-3">
      <!-- Checkbox -->
      <div class="custom-control custom-checkbox">
        <input
          class="custom-control-input"
          type="checkbox"
          value=""
          id="form2Example3"
          checked/>
        <label class="custom-control-label" for="form2Example3">Remember me</label>
      </div>
    </div>

    <div class="col-3">
      <!-- Simple link -->
      <a href="#!" class="text-decoration-none">Forgot password?</a>
    </div>
  </div>

  <div class="row justify-content-center mb-2">
  	<div class="col-6">
  		<!-- Submit button -->
  		<button name="login_btn" type="submit" class="btn btn-danger btn-block mb-4">Log in</button>
  	</div>
  </div>
  
  <!-- Register buttons -->
  <div class="text-center">
    <p>Not a member? <a href="http://localhost/GameReviewApp/Register.php" class="text-decoration-none"> Register</a></p>
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