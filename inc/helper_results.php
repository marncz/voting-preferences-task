<?php

// Load the current list of avaiable constituencies.
$json = json_decode(file_get_contents("constituencies.json"), true);
$constituencies = $json['result']['items'];

// Initialize variables.
$total_will_vote = 0;
$total_wont_vote = 0;
$top_candidates = array();

$constituencies_array = array();
$constituencies_with_votes = array();
$constituencies_without_votes = array();

// Get top candidates nationally.
$sth = $conn->prepare("SELECT candidate, COUNT(*) AS count FROM votes WHERE candidate != '' GROUP BY candidate ORDER BY COUNT(*) DESC LIMIT 5");
$sth->execute();
$top_voted_for = $sth->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

// A bit of format cleanup.
foreach ($top_voted_for as $name => $votes) {
  $top_candidates[$name] = $votes[0]['count'];
}

foreach ($constituencies as $item) {
  // Create an array of details about a constituency with its gss_code as the key.
  $constituencies_array[$item['gssCode']]['name'] = $item['label']['_value'];

  // Call the database and retrieve all votes with candidates.
  $sth = $conn->prepare("SELECT * FROM votes WHERE gss_code = :gss_code AND candidate != ''");
  $sth->execute(array(':gss_code' => $item['gssCode']));
  $constituencies_array[$item['gssCode']]['will_vote'] = $sth->rowCount();
  $total_will_vote += $sth->rowCount();

  // Call the database and retrieve all votes without a candidates.
  $sth = $conn->prepare("SELECT * FROM votes WHERE gss_code = :gss_code AND candidate = ''");
  $sth->execute(array(':gss_code' => $item['gssCode']));
  $constituencies_array[$item['gssCode']]['wont_vote'] = $sth->rowCount();
  $total_wont_vote += $sth->rowCount();

  // Get top candidates for this constituency.
  $sth = $conn->prepare("SELECT candidate, COUNT(*) AS count FROM votes WHERE candidate != '' AND gss_code = :gss_code GROUP BY candidate ORDER BY COUNT(*) DESC LIMIT 3");
  $sth->execute(array(':gss_code' => $item['gssCode']));
  $top_voted_for = $sth->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

  // A bit of format cleanup.
  foreach ($top_voted_for as $name => $votes) {
    $constituencies_array[$item['gssCode']]['top_candidates'][$name] = $votes[0]['count'];
  }

  // Check if there are any votes casted for this constituency.
  if ($top_voted_for) {
     array_push($constituencies_with_votes, $item['gssCode']);
  } else {
     array_push($constituencies_without_votes, $item['gssCode']);
  }
}


// Function for calculating turnout.
function calculate_turnout ($will_vote, $wont_vote) {
  if (($will_vote + $wont_vote) == 0)
    return 0;
  return round(($will_vote * 100 / ($wont_vote + $will_vote)), 2);
}

?>
