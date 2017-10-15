<?php
include('db_connection.php');

// Create an empty array for errors, even when POST is not send - to avoid warnings.
$form_errors = array();

// Only trigger when a POST request is received.
if ($_POST) {

  // Check whether field for planning to vote is set.
  if (!$_POST['is_going_to_vote']) {
    array_push($form_errors, "Please specify whether you are planning to vote.");
  } else {
    // Check whether candidate is going to vote.
    if($_POST['is_going_to_vote'] == "yes") {
      // Check whether field for candidate was filled.
      if (!$_POST['vote_for']) {
        array_push($form_errors, "Please specify who you are vote for.");
      }
    }
  }
  // Check whether captcha was provided
  if (!$_POST['captcha']) {
    array_push($form_errors, "Please fill out captcha code.");
  } else {
    if($_POST['captcha'] != $_SESSION['captcha']['code']){
      array_push($form_errors, "Captcha code submitted by you was not correct.");
    }
  }

  // Check whether there are no errors.
  if(count($form_errors) == 0) {
    // Add entries to the database.
    $stmt = $conn->prepare("INSERT INTO votes (gss_code, candidate) VALUES (:gss_code, :candidate)");
    $stmt->bindParam(':gss_code', $_POST['constituency']);
    $stmt->bindParam(':candidate', $_POST['vote_for']);
    $stmt->execute();

    // Redirect to a thank you page.
    header("Location: thankyou.php");
  }

} else {
  // Placeholder...
}



?>
