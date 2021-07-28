<?php 
session_start();

// connect to database
$db = mysqli_connect("localhost", "root", "admin");
mysqli_select_db($db,"game_review");

// variable declaration
$fname = $lname = $user_type = $username = $email = $password = "";
$errors   = array(); 

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}

if (isset($_POST['login_btn'])) {
	login();
}

if (isset($_POST['add_account'])) {
	add_account();
}

if (isset($_POST['post'])) {
	post_comment();
}


// log user out if logout button clicked
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: Login.php");
}

// REGISTER USER
function register() {
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $fname, $lname, $user_type, $username, $email, $password;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
    $user_type = e($_POST['user_type']);
    $fname = e($_POST['fname']);
    $lname = e($_POST['lname']);
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	$sql_u = "SELECT * FROM users WHERE username='$username'";
  	$sql_e = "SELECT * FROM users WHERE email='$email'";
  	$res_u = mysqli_query($db, $sql_u);
  	$res_e = mysqli_query($db, $sql_e);

	if (mysqli_num_rows($res_u) > 0) {
  	  array_push($errors, "Username already taken");  	
  	}
  	if(mysqli_num_rows($res_e) > 0){
  	  array_push($errors, "Email already taken");  	
  	}

	// form validation: ensure that the form is correctly filled
	if (empty($user_type)) { 
		array_push($errors, "User type is required"); 
	}
	if (empty($fname)) { 
		array_push($errors, "First Name is required"); 
	}
	if (empty($lname)) { 
		array_push($errors, "Last Name is required"); 
	}
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register users if there are no errors in the form
	if (count($errors) == 0) {
		
		if (isset($_POST['user_type'])) {
			$user_type = e($_POST['user_type']);

			if ($user_type == 'employee') {
				$query = "INSERT INTO users (first_name, last_name, username, email, user_type, password) 
			  			  VALUES('$fname', '$lname', '$username', '$email', '$user_type', '$password_1')";
				mysqli_query($db, $query);

				// get id of the created employee
				$logged_in_user_id = mysqli_insert_id($db);

				$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in employee in session
				$_SESSION['success']  = "New user successfully created and now logged in!";
				header('location: EmployeeDash.php');
			
			}
			else {
				$query = "INSERT INTO users (first_name, last_name, username, email, user_type, password) 
						  VALUES('$fname', '$lname', '$username', '$email', '$user_type', '$password_1')";
				mysqli_query($db, $query);

				// get id of the created user
				$logged_in_user_id = mysqli_insert_id($db);

				$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
				$_SESSION['success']  = "New user successfully created and now logged in!";
				header('location: UserDash.php');
							
			}
			
		}
	}
}

// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}

// LOGIN USER
function login(){
	global $db, $email_username, $errors;

	// grab form values
	$email_username = e($_POST['email_username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($email_username)) {
		array_push($errors, "Username or email is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {

		$query = "SELECT * FROM users WHERE (username='$email_username' OR email = '$email_username') AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['user_type'] == 'employee') {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: EmployeeDash.php');		  
			}else if($logged_in_user['user_type'] == 'user'){
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: UserDash.php');
			}else if($logged_in_user['user_type'] == 'admin'){
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: AdminDash.php');
			}
		}else {
			array_push($errors, "Wrong username/email/password combination");
		}
	}
}

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}

// ADD ACCOUNT
function add_account() {
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $fname, $lname, $user_type, $username, $email, $password;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
    $user_type = e($_POST['user_type']);
    $fname = e($_POST['fname']);
    $lname = e($_POST['lname']);
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	$sql_u = "SELECT * FROM users WHERE username='$username'";
  	$sql_e = "SELECT * FROM users WHERE email='$email'";
  	$res_u = mysqli_query($db, $sql_u);
  	$res_e = mysqli_query($db, $sql_e);

	if (mysqli_num_rows($res_u) > 0) {
  	  array_push($errors, "Username already taken");  	
  	}
  	if(mysqli_num_rows($res_e) > 0){
  	  array_push($errors, "Email already taken");  	
  	}

	// form validation: ensure that the form is correctly filled
	if (empty($user_type)) { 
		array_push($errors, "Account type is required"); 
	}
	if (empty($fname)) { 
		array_push($errors, "First Name is required"); 
	}
	if (empty($lname)) { 
		array_push($errors, "Last Name is required"); 
	}
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register users if there are no errors in the form
	if (count($errors) == 0) {
		
		if (isset($_POST['user_type'])) {
			$user_type = e($_POST['user_type']);

			if ($user_type == 'employee') {
				$query = "INSERT INTO users (first_name, last_name, username, email, user_type, password) 
			  			  VALUES('$fname', '$lname', '$username', '$email', '$user_type', '$password_1')";
				mysqli_query($db, $query);
				

			
			}
			else if ($user_type == 'admin'){
				$query = "INSERT INTO users (first_name, last_name, username, email, user_type, password) 
						  VALUES('$fname', '$lname', '$username', '$email', '$user_type', '$password_1')";
				mysqli_query($db, $query);
				
							
			}

			else {
				$query = "INSERT INTO users (first_name, last_name, username, email, user_type, password) 
						  VALUES('$fname', '$lname', '$username', '$email', '$user_type', '$password_1')";
				mysqli_query($db, $query);

							
			}
			
		}
	}
	
}

function post_comment() {
	global $message, $db, $errors;

    $message = e($_POST['message']);
    if (empty($message)) { 
		array_push($errors, "User type is required"); 
	}
	else {
		$user_id = $_SESSION['user']['id'];
    	$review_id = $_GET['id'];
		$query = "INSERT INTO user_comments (users_id, review_id, content) 
						  VALUES('$user_id', '$review_id', '$message')";
	mysqli_query($db, $query);
	header('location: ReviewDescription.php?id='. $review_id);
	}
	
	
}








