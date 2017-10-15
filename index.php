<?php
session_start();
include("lib/simple-php-captcha/simple-php-captcha.php");
include("inc/form_handler.php");
$_SESSION['captcha'] = simple_php_captcha();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>General Election 2018</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/narrow-jumbotron.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills float-right">
            <li class="nav-item">
              <a class="nav-link active" href="">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="results.php">Results</a>
            </li>
          </ul>
        </nav>
        <h3 class="text-muted">Voting preferences</h3>
      </div>

      <div class="jumbotron">
        <h1 class="display-4">General Election 2018</h1>
        <p class="lead">Please provide your preferences for upcoming General Election. <br> All data collected through this website is annonymous.</p>
        <br>
        <?php if ($form_errors) {
          echo "<b style='color:red;'>There were errors with your form:</b><br>";
          foreach ($form_errors as $error) {
            echo "- ". $error ."<br>";
          }

        } ?>

        <form method="POST" action="">
          <p><div class="row">
          <div class="col-lg-6">
            Your constituency
          </div>

          <div class="col-lg-6">
            <select class="form-control" name="constituency">
            <?php

            $json = json_decode(file_get_contents("constituencies.json"), true);
            $constituencies = $json['result']['items'];

            foreach ($constituencies as $item) {
              echo "<option value=\"{$item['gssCode']}\">{$item['label']['_value']}</option>";
            }
            ?>
            </select>
          </div>
        </div>
        </p>
        <p>
        <div class="row">
          <div class="col-lg-6">
            Are you going to vote?
          </div>

          <div class="col-lg-6">
            <label class="radio-inline"><input type="radio" class="radio" name="is_going_to_vote" value="yes" checked> Yes</label>
            <label class="radio-inline"><input type="radio" class="radio" name="is_going_to_vote" value="no"> No</label>
          </div>
        </div>
        </p>

        <p>
        <div class="row" id="vote_for_block">
          <div class="col-lg-6">
            Who are you going to vote for?
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <input type="text" class="form-control" name="vote_for">
            </div>
          </div>
        </div>
        </p>

        <div class="row">
          <div class="col-lg-6">
            <?php echo "<img src='".$_SESSION['captcha']['image_src']."'>'"; ?>
          </div>

          <div class="col-lg-6">
            <div class="row form-group">
              <div class="col-lg-3"></div>
              <div class="col-lg-6">
                <input type="text" class="form-control" name="captcha">
              </div>
            </div>
          </div>
        </div>
        </p>

        <p><button class="btn btn-lg btn-success">Submit your preference</button></p>
      </form>
      </div>

      <footer class="footer">
        <p>&copy; Marcin Czarnecki</p>
      </footer>

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script
  src="https://code.jquery.com/jquery-3.2.1.js"></script>
  <script src="js/helpers.js"></script>
  </body>
</html>
