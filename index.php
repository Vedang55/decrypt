<?php
session_start();
define('dbloc', './handlers/abc/d/test', true);

class MyDB extends SQLite3 {
  function __construct() {
    $this->open(dbloc);
    $this->exec('PRAGMA journal_mode = wal;
    pragma temp_store=FILE;');
    $this->busyTimeout(10000);
  }
}


if (isset($_SESSION["user"])){
  header("Location: ./game.php");
}
date_default_timezone_set('Asia/Kolkata');
$_SESSION['countdown'] = array(13,50,0);
$_SESSION['end'] = array(3,15,0);

if(isset($_POST['submit'])){
    if((date("H")> $_SESSION['countdown'][0]) || (date("H")== $_SESSION['countdown'][0]  && date('i') >= $_SESSION['countdown'][1])){
        $submitbutton= $_POST['submit'];
        if ($submitbutton){
            
            $_SESSION["user"] = str_replace(' ','',$_POST['username']);
            $_SESSION["question"] = -1;
            $db = new MyDB();
            if(!$db) {
                echo $db->lastErrorMsg();
            } else {
                
                // echo "Opened database successfully<br>";
                $sql = "INSERT INTO usernames ('username') VALUES ('" . $_SESSION['user'] . "')";
                $ret = $db->exec($sql);
                if(!$ret){
                    echo $db->lastErrorMsg();
                    
                } else {
                    $_SESSION['userid'] = $db->lastInsertRowID();
                }
                $db->close();
            }

            header("Location: ./game.php");
        }
    }

}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Quick Quiz</title>
    <link rel="stylesheet" href="app.css" />
  </head>
  <body>
  <p style='display:none;' id='countdown'>
    <?php
      echo $_SESSION['countdown'][0].":". $_SESSION['countdown'][1] .":". $_SESSION['countdown'][2] ;
    ?>
  </p>

    <div class="container">
        <img class='timg' src="./images/logo1.png">
        <div id="home" class="flex-center flex-column">
            <h1 class="decrypt">Decrypt</h1>
            <p style="font-size:4rem; font-family:cursive;color:yellow;" id='si'>Starts in</p>
            <h1 id='time'>
            <?php
              $info = getdate();
              $hour = date('h');
              $min = $info['minutes'];
              $sec = $info['seconds'];
              echo $hour.":".$min.":".$sec;
            ?>
            </h1>
            <form method="POST" class='homeform' style='display:none' id='homeform'>
              <input type='text' placeholder='Name' id='usernameField' name='username' required pattern="[a-zA-Z]+[ a-zA-Z]*" maxlength="20" autocomplete='off' autofocus>
              <br>
              <input type="submit" class="btn" value="Play" name='submit' id='play'>
            </form>
        </div>
    </div>

    <script src="index.js"></script>

  </body>
</html>
