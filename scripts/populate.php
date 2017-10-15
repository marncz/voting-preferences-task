<?php
include("inc/db_connection.php");

/*
 *   This is a script for randomly populating the database with votes.
 *   Script also simulates a person choosing not to vote.
 */

// Initialize variables;
$count = ($argv[1]) ? $argv[1] : 100;
$gss_codes = array();


// Taken from https://en.wikipedia.org/wiki/United_Kingdom_general_election,_2017
$candidates = array(
  "Theresa May",
  "Jeremy Corbyn",
  "Nicola Sturgeon",
  "Tim Farron",
  "Arlene Foster",
  "Gerry Adams",
  "Leanne Wood",
  "Jonathan Bartley",
  "Caroline Lucas",
  "John Bercow",
  "Sylvia Hermon",
  "Paul Nuttall",
  "Colum Eastwood",
  "Robin Swann",
  "Naomi Long",
  "Stewart Arnold",
  "Alex Ashman",
  "Sid Cordle",
  "Collective leadership",
  "Adam Walker",
  "Howling Laud Hope",
  "Sophie Walker",
  "Jim Allister",
  "", // An empty value for simulating a person that does not want to vote.
);

$json = json_decode(file_get_contents("constituencies.json"), true);
$constituencies = $json['result']['items'];
foreach ($constituencies as $constituency) {
  array_push($gss_codes, $constituency['gssCode']);
}

print "--- Generating {$count} votes randomly\n\n";

// Generate votes.
for ($i = 0; $i < $count; $i++) {
  $rand_gss_code = $gss_codes[rand(0, count($gss_codes) - 1)];
  $rand_candidate = $candidates[rand(0, count($candidates) - 1)];

  $stmt = $conn->prepare("INSERT INTO votes (gss_code, candidate) VALUES (:gss_code, :candidate)");
  $stmt->bindParam(':gss_code', $rand_gss_code);
  $stmt->bindParam(':candidate', $rand_candidate);
  $stmt->execute();

  if ($rand_candidate == "") {
    print "Not voting in {$rand_gss_code}.\n";
  } else {
    print "Casting a vote for {$rand_candidate} in {$rand_gss_code}.\n";
  }

}

?>
