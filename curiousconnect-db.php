<?php

// server info
$server = 'localhost';
$user = 'root';
$pass = 'root';
$db = 'goodviewsshop';

// connect to the database
$mysqli = new mysqli($server, $user, $pass, $db, 9000);

// show errors (remove this line if on a live site)
mysqli_report(MYSQLI_REPORT_ERROR);

?>