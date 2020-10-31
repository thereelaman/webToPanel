<?php

session_start();
include('./lib/db.php');

// initializing variables
$username = "";
$name     = "";
$email    = "";
$address  = "";
$phone    = "";
$hash     = "";

$errors = array(); 

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $name       = mysqli_real_escape_string($mysqli, $_POST['name']);
  $username   = mysqli_real_escape_string($mysqli, $_POST['username']);
  $email      = mysqli_real_escape_string($mysqli, $_POST['email']);
  $address    = mysqli_real_escape_string($mysqli, $_POST['address']);
  $phone      = mysqli_real_escape_string($mysqli, $_POST['phone']);
  $password_1 = mysqli_real_escape_string($mysqli, password_hash($_POST['password_1'], PASSWORD_BCRYPT) );
  $password_2 = mysqli_real_escape_string($mysqli, password_hash($_POST['password_2'], PASSWORD_BCRYPT) );
  $hash       = bin2hex(random_bytes(40));

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($name)) { array_push($errors, "Name is required."); }
  if (empty($username)) { array_push($errors, "username is required.");}
  if (empty($email)) { array_push($errors, "Email is required.");}
  if (empty($address)) { array_push($errors, "Address is required.");} 
  if (empty($phone)) { array_push($errors, "Phone number is required."); }
  if (empty($password_1)) { array_push($errors, "Password is required."); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match.");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($mysqli, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "username already exists. Please choose a new one.");
    }

    if ($user['email'] === $email) {
      array_push($errors, "This email is already associated with another account. Please enter another email address.");
    }

    if ($user['phone'] === $phone) {
        array_push($errors, "This phone number is already associated with another account.");
      }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database
    array_push($errors, "Error Count is Zero");
  	$query = "INSERT INTO `users` (`username`, `name`, `email`, `phone`, `address`, `password`, `hash`) VALUES ('$username', '$name', '$email', '$phone', '$address', '$password', '$hash')"; 
    mysqli_query($mysqli, $query);
    header('location: ../../../dashboard.php');
      
    $_SESSION['username'] = $username;
  	$_SESSION['active'] = 0; //0 until user activates their account with verify.php
    $_SESSION['logged_in'] = true; // So we know the user has logged in
    $_SESSION['message'] =
               
            "Confirmation link has been sent to $email, please verify
            your account by clicking on the link in the message!";

    // Send registration confirmation link (verify.php)
    $to      = $email;
    $subject = 'Account Verification ( thedisplay.studio )';
    $message_body = '
    Hello '.$username.',

    Thank you for signing up!

    Please click this link to activate your account:

    http://thedisplay.studio/lib/verify.php?email='.$email.'&hash='.$hash;  

    mail( $to, $subject, $message_body );
    header("location: ./dashboard.php");
  }
}

if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($mysqli, $_POST['username']);
  $password = mysqli_real_escape_string($mysqli, $_POST['password']);
  array_push($errors, "username = $username");
  array_push($errors, "password = $password");

  if (empty($username)) {
  	array_push($errors, "Username is required.");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required.");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($mysqli, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['logged_in'] = true;
  	  header('location: ../../../dashboard.php');
  	}else {
  		array_push($errors, "The username/password combination appears to be incorrect. Plase try again.");
  	}
  }
}

include('error.php');

?>