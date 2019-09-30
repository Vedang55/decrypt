<?php
    session_start();
    define('dbloc', './handlers/abc/d/test', true);
    date_default_timezone_set('Asia/Kolkata');

    class MyDB extends SQLite3 {
        function __construct() {
            $this->open(dbloc);
            $this->exec('PRAGMA journal_mode = wal;');
            $this->exec('pragma temp_store=FILE;');
            $this->busyTimeout(5000);
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>The End</title>

    <style>
        body {
            background: url('./images/bckg.jpg');
            font-family: "Trebuchet MS", Helvetica, sans-serif;
        }

        .container {
            max-width:40rem;
            margin :0 auto 0 auto;
            display:flex;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            min-height:100vh;
        }

        table {
            font-size : 2rem;
            border : 2px solid white;
            background-color:rgba(255,255,255,0.5);
        }
        th{
            border : 2px solid white; 
            padding:0.2rem 1rem 0.2rem 1rem;

        }
        
        td {
            border : 2px solid white; 
            text-align:center;
            padding:0.2rem 1rem 0.2rem 1rem;
            
        }


    </style>
    
  </head>
  <body>
    <div class='container'>

    
        <?php
            if(isset($_SESSION['win'])){
                echo "<h1 class='win'>Winner winner chicken dinner</h1>";
                echo "Total Time : ";
                // $db = new MyDB();
                // if(!$db) {
                //     echo $db->lastErrorMsg();
                // } else {
                // // echo "Opened database successfully<br>";
                // $sql = "SELECT sum(time) from users WHERE uid = ".$_SESSION['userid'].";";
    
                // $ret = $db->query($sql);
    
                
                // while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                //     echo "<h2>";
                //     echo gmdate("H:i:s", $row['sum(time)']) ;
                //     echo "</h2>";
                // }             
                
                // $db->close();
                // }
                
            $datetime1 = strtotime("2011-10-10 2:15:00");
            $datetime2 = strtotime("2011-10-10 ".date('h').':'.getdate()['minutes'].':'.getdate()['seconds']);
            $interval  = abs($datetime2 - $datetime1);
            $minutes   = round($interval / 60);
            echo '<h2>minutes : '.$minutes . '</h2><br>'; 



            }
            else {

            }


            $datetime1 = strtotime("2011-10-10 2:15:00");
            $datetime2 = strtotime("2011-10-10 ".date('h').':'.getdate()['minutes'].':'.getdate()['seconds']);
            $interval  = abs($datetime2 - $datetime1);
            $minutes   = round($interval / 60);
            echo '<h2>minutes : '.$minutes . '</h2><br>'; 


            $db = new MyDB();
            if(!$db) {
                echo $db->lastErrorMsg();
            } else {
                // echo "Opened database successfully<br>";
                $sql = "SELECT * from users WHERE uid = ".$_SESSION['userid'].";";
    
                $ret = $db->query($sql);
    
                echo "<table align='center'>
                        <tr>
                            <th>question id</th>
                            <th>time</th>
                        </tr>";
                while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                    

                    echo "<tr>
                            <td>".$row['qid'] . "</td>
                            <td>".$row['time'] . " seconds " ."</td>
                            </tr>";
                }             
                echo "</table>";

                $db->close();
            }

        ?>

    </div>



       
  </body>

  </html>
  