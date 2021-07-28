<?php include('function.php'); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reviews Page</title>
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
      
      $start = 0;
      $limit = 5;
      $id = 1;
      if(isset($_GET['id'])) {
        $id=$_GET['id'];
        $start=($id-1)*$limit;
      }

      $query = "SELECT * from reviews Order By reviews.id Desc LIMIT $start, $limit ";
      $result = mysqli_query($conn, $query);
      if (!$result)
        die('Invalid querry:' .mysqli_error($conn));

    if (isLoggedIn()) {
    	$user_id = $_SESSION['user']['id'];
    
    
      $query2 = "SELECT * from users where id = '$user_id'";
      $result2 = mysqli_query($conn, $query2);
      if (!$result)
        die('Invalid querry:' .mysqli_error($conn));
      $myrow2=mysqli_fetch_array($result2);
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
            <?php if(!empty($myrow2['user_photo'])) {
                          echo "<img class = 'rounded-circle' style = 'width: 30px; height: 30px; position:relative; right: 5px' src = 'profile/".$myrow2['user_photo']."'>";
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
            <?php if(!empty($myrow2['user_photo'])) {
                          echo "<img class = 'rounded-circle' style = 'width: 30px; height: 30px; position:relative; right: 5px' src = 'profile/".$myrow2['user_photo']."'>";
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
            <?php if(!empty($myrow2['user_photo'])) {
                          echo "<img class = 'rounded-circle' style = 'width: 30px; height: 30px; position:relative; right: 5px' src = 'profile/".$myrow2['user_photo']."'>";
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

<br><br>

<div class="container content">
	<h1 class="my-text-font text-center">GRA Presents</h1>
	<img src="http://localhost/GameReviewApp/GameReviewImgs/Poster.png" class="img-fluid" alt="...">

	<br><br><br><br><br>
<form>
<div class="row mb-4">
    <div class="col-8">
    	<table class="table table-hover">
		  <tbody>
		    <tr>
		    <td>
		    	<select class="custom-select">
		        <option value>Sort review by:</option>
		        <option disabled="disabled">----------------</option>
		        <option value="1">GRA score: High to Low</option>
		        <option value="2">GRA score: Low to High</option>
		     </select>
		    </td>
		    <td>
		    	<div class="input-group">
	    		<input type="text" class="form-control" placeholder="Search for review">
    		<div class="input-group-append">
	      		<button class="btn btn-danger" type="button">
	        		<i class="fa fa-search"></i>
	      		</button>
    		</div>
			</div>
		    </td>
		    </tr>
		  </tbody>
		</table>
      

<?php 
  if (!$result)
            die('Invalid querry:' .mysqli_error($conn));
          else {
            while ($myrow=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            
              ?>
	<div class="col-13">
		<table class="table table-hover fixed">
		  <tbody>
		    	<tr>
		    		<td>
		    			<p class="text-danger">PC</p>
	    				<a href="http://localhost/GameReviewApp/ReviewDescription.php?id=<?php echo $myrow['id']; ?>" class="text-decoration-none mycolor">
			      		<h5 class="text-left my-text-font"><?php echo $myrow["review_title"]; ?></h5>
		      			</a>
			      	</td>
			      	<td class="td-center">
			      		<div class="justify-content-center">
			      			<h5 class="my-text-font">Star Rating</h5>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star"></span>
							<span class="fa fa-star"></span>
			      		</div>
			      	</td>
			      	<td>
		      			<a href="http://localhost/GameReviewApp/ReviewDescription.php?id=<?php echo $myrow['id']; ?>">
			      		<div class="card">
			      			
			      		
			      		<div class="card-image">
				  	 		<?php echo  "<img src='imgreviews/".$myrow['review_image']."' class='img-fluid card-img-top'>"; ?>
				  	 	<div class="image-overlay"></div>
				  		</div>
				  		</div>
		      			</a>
		      		</td> 
		    	</tr>
		   
		  </tbody>
		   <?php 

            }
          }
          ?>
		</table>

	</div>
	</div>
    
  	<div class="col-4">
  		<table class="table table-hover table-bordered">
  			<thead>
		    <tr>
		      <th class="text-center">Filter Reviews by:</th>
		    </tr>
  			</thead>
		  	<tbody>
		     	<tr>
		      	<td>
		      		<select class="custom-select">
					  <option value>Platform</option>
					  <option disabled="disabled">---------</option>
					  <option value="1">All platforms</option>
					  <option value="2">PC</option>
					  <option value="2">PlayStation 4</option>
					  <option value="2">Xbox One</option>
					  <option value="2">Nintendo Wii</option>
					</select>
		      	</td>
		    	</tr>
	    		<tr>
		      		<td>
		      		<select class="custom-select">
					  <option value>Genre</option>
					  <option disabled="disabled">------</option>
					  <option value="1">All genres</option>
					  <option value="2">FPS</option>
					  <option value="2">RPG</option>
					  <option value="2">MMO</option>
					  <option value="2">RTS</option>
					  <option value="2">MOBA</option>
					</select>
		      		</td>
		    	</tr>
	    		<tr>
		      		<td>
		      		<select class="custom-select">
					  <option value>Region</option>
					  <option disabled="disabled">--------</option>
					  <option value="1">All regions</option>
					  <option value="2">Europe</option>
					  <option value="2">North America</option>
					  <option value="2">South America</option>
					  <option value="2">Australia</option>
					  <option value="2">Asia</option>
					</select>
		      		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<button type="submit" class="btn btn-danger btn-block">Apply Filters</button>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<h2 class="my-text-font">GRA NEWS</h2>
		    			<a href="#" class="text-decoration-none mycolor">
							<div class="card border-0" style="width: auto;">
							  <div class="card-image">
							  	 <img src="http://localhost/GameReviewApp/GameReviewImgs/ash-edmonds-0aWZdK8nK2I-unsplash.jpg" class="card-img-top" alt="...">
							  	 <div class="image-overlay"></div>
							  </div>
							  
							  <div class="card-body">
							    <p class="card-text font-weight-bolder h5 my-text-font">Placeholder for card news title!</p>
							  </div>
							</div>
						</a>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<h2 class="my-text-font">GRA POPULAR</h2>
		    			<a href="#" class="text-decoration-none mycolor">
							<div class="card border-0" style="width: auto;">
							  <div class="card-image">
							  	 <img src="http://localhost/GameReviewApp/GameReviewImgs/ash-edmonds-0aWZdK8nK2I-unsplash.jpg" class="card-img-top" alt="...">
							  	 <div class="image-overlay"></div>
							  </div>
							  
							  <div class="card-body">
							    <p class="card-text font-weight-bolder h5 my-text-font">Placeholder for card popular title!</p>
							  </div>
							</div>
						</a>
		    		</td>
		    	</tr>
		 	</tbody>
		</table>
  	</div>
</div>
     			

</form>

<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
    <li class="page-item">
      <a class="page-link text-danger" href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    <li class="page-item"><a class="page-link mycolor" href="#">1</a></li>
    <li class="page-item"><a class="page-link mycolor" href="#">2</a></li>
    <li class="page-item"><a class="page-link mycolor" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link text-danger" href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
</nav>
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