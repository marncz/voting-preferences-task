<?php

// This small script gets json data from gov. website and saves it as a file.
$url = "http://lda.data.parliament.uk/constituencies.json?exists-endedDate=false&_view=Constituencies&_pageSize=1000&_page=0";
$json = file_get_contents($url);

$file = '../constituencies.json';
$handle = fopen($file, 'w') or die('Cannot open file:  '.$file);
fwrite($handle, $json);
fclose($handle);

print("Newest file downloaded and saved succesfully. \n");
?>
