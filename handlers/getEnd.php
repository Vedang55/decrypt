<?php
    session_start();
    $hour = $_SESSION['end'][0];
    $min = $_SESSION['end'][1];
    $sec = $_SESSION['end'][2];
    echo $hour.":".$min.":".$sec;
?>