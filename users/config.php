<?php
   session_start();
    $siteurl ='http://localhost/training/quiz/';

    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "quiz";

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    if($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } ?>