<?php
    session_start();
    $hour = $_SESSION['countdown'][0];
    $min = $_SESSION['countdown'][1];
    $sec = $_SESSION['countdown'][2];
    echo $hour.":".$min.":".$sec;
?>