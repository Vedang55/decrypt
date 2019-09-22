<?php
    date_default_timezone_set('Asia/Kolkata');
    $info = getdate();
    $hour = date('h');
    $min = $info['minutes'];
    $sec = $info['seconds'];
    echo $hour.":".$min.":".$sec;
?>

