<?php
session_start();
include("lib/simple-php-captcha/simple-php-captcha.php");
include("inc/form_handler.php");
include("inc/helper_results.php");
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
              <a class="nav-link" href="/">Home </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="/results.php">Results <span class="sr-only">(current)</span></a>
            </li>
          </ul>
        </nav>
        <h3 class="text-muted">Voting preferences</h3>
      </div>

      <div class="jumbotron">
        <h1 class="display-4">Top candidates</h1>
        <p>
        <?php
        $i = 0;
        foreach($top_candidates as $name => $votes) {
          $i++;
          echo "{$i}. <b>{$name}</b> - {$votes} votes <br>";
        } ?>
        </p>
        <h3>Statistics</h3>
        <p>
        People willing to vote: <b><?php echo $total_will_vote; ?></b> <br>
        People not willing to vote: <b><?php echo $total_wont_vote; ?></b> <br>
        Possible turnout: <b><?php echo calculate_turnout($total_will_vote, $total_wont_vote). "%"; ?></b>
        </p>
        <hr>
        <h1 class="display-5">Voting results</h1>
        <p class="lead">Below is a list of constituencies along with votes.</p>
        <?php
        foreach ($constituencies_with_votes as $gss_code) {
          $details = $constituencies_array[$gss_code];
          echo "<br><h2> {$details['name']} </h2>";
          echo "Will and won't vote: <b> {$details['will_vote']} / {$details['wont_vote']} </b><br>";
          echo "Turnout: <b> ". calculate_turnout($details['will_vote'], $details['wont_vote']). "% </b><br><br>";

          $i = 0;
          foreach($details['top_candidates'] as $name => $votes) {
              $i++;
              echo "{$i}. <b>{$name}</b> -  {$votes} ";
              echo (($votes == 1) ? "vote" : "votes") . "<br>";
          }
          echo "<hr>";
        } ?>
        <hr>
        <h1 class="display-6">Constituencies without votes</h1>
        <p class="lead">This is a list of constituencies without any votes.</p>

          <?php
          echo "<ul class='list-group row'>";
          foreach ($constituencies_without_votes as $gss_code) {
            echo "<li class='list-group-item'>". $constituencies_array[$gss_code]['name'] ."</li>";
          }
          echo "</ul>";
          ?>

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
