<?php 
include_once('config.php');


    session_start();
    $usernameOld = $_SESSION['username'];

    
    $name_New = $_POST['full-name'];
    $website_New = $_POST['website'];
    $bio_New = $_POST['bio'];
    $email_New = $_POST['email'];
    $phoneNumber_New = $_POST['phoneNumber'];
    $gender_New = $_POST['gender'];

    mysqli_query($link, "UPDATE profile SET name = '$name_New', website = '$website_New', bio = '$bio_New', email = '$email_New', phoneNumber = '$phone_NumberNew', gender = '$gender_New' WHERE USERNAME = '$usernameOld'");

    
  header('location: profile.php');




 ?>