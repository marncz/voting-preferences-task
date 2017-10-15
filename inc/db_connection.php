<?php
$db_config = include('./config/db_config.php');

try {
    $conn = new PDO('mysql:host='. $db_config['server'] .';dbname='. $db_config['name'], $db_config['user'], $db_config['pass']);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
