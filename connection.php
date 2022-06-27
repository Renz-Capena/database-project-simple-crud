<?php
    // Enable error reporting for mysqli
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $host = "localhost";
    $user = "rooet";
    $pass = "";
    $db   = "database_student";


    $con = new mysqli("localhost","root","","database_student");
