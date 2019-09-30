<?php
    session_start();
    date_default_timezone_set('Asia/Kolkata');

    if(isset($_GET['logout'])){                   //logout
        session_destroy();
        $_SESSION = [];
    }
    define('dbloc', './handlers/abc/d/test', true);

    if(isset($_POST['submitgridbutton'])){
        $db = new MyDB();
        if(!$db) {
            echo $db->lastErrorMsg();
        } else {
            $sql = "SELECT * from questions WHERE questionId = ".$_SESSION['question_nos'][$_SESSION['question']].";";

            $ret = $db->query($sql);
            
            if($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                $specialcol = $row['special'];
                $db->close();
                if($specialcol == NULL){

                }
                else{
                    for($j = 1; $j<=7;$j++ ){
                        if($_POST[''.$j.''] =='' || $_POST[''.$j.''] =='0' || $_POST[''.$j.''] =='8' 
                        || $_POST[''.$j.''] =='9' ){
                            $flag=1;
                        }
                    }
                    for($j = 1; $j<=7;$j++){
                        for($k = $j+1; $k<=7;$k++){
                            if($_POST[''.$j.''] == $_POST[''.$k.'']){
                                $flag = 1;
                            }
                        }
                    }

                    if(!isset($flag)){

                        for($i = 1; $i <= 6; $i++){
                            if(abs($_POST[$i] - $_POST[$i + 1]) == 1){
                                $incorrect = 1;
                            }
                        }

                        if(abs($_POST['2'] - $_POST['4']) == 1 || abs($_POST['2'] - $_POST['6']) == 1 || abs($_POST['5'] - $_POST['7']) == 1 
                            || abs($_POST['7'] - $_POST['4']) == 1 || abs($_POST['2'] - $_POST['5']) == 1){
                                $incorrect = 1;
                        }

                        if(!isset($incorrect)){
                            recordtime();
                            array_splice($_SESSION['question_nos'], $_SESSION['question'],1);
                            $_SESSION["question"] = -1;
                        }
                        
                    }
                }
            }             
                    
           
        }
    }


    if(isset($_POST['submitabutton'])){
        $db = new MyDB();
        if(!$db) {
            echo $db->lastErrorMsg();
        } else {
            $sql = "SELECT * from questions WHERE questionId = ".$_SESSION['question_nos'][$_SESSION['question']].";";

            $ret = $db->query($sql);
            
            if($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                $specialcol = $row['special'];
                $db->close();
                if($specialcol == NULL){

                }

                else {
                    $counter = 0;
                    $stones = array('mind','power','reality', 'soul','space', 'time'); 
                    for($l=1; $l<=6; $l++){
                        $ans = $_POST[$l];
                        $ans = str_replace(' ','', $ans);
                        $ans = str_ireplace('stone','', $ans);
                        $ans = strtolower($ans);
                        
                        if(in_array($ans,$stones)){
                            $index = array_search($ans, $stones);
                            array_splice($stones,$index,1);
                            $counter = $counter + 1;
                        }
                    }
                    if($counter == 6){
                        recordtime();
                        array_splice($_SESSION['question_nos'], $_SESSION['question'],1);
                        $_SESSION["question"] = -1;
                    }
                    else{
                        header("Location: ./meme.php");
                    }
                }
            }


    }

    }

    if(isset($_POST['submitAnswerButton'])){
        //check if corrent answer if correct
        $submittedAnswer = str_replace(' ','', strtolower($_POST['submittedAnswer']));  //convert input to lowercase and trim

        $db = new MyDB();
        if(!$db) {
            echo $db->lastErrorMsg();
        } else {
            // echo "Opened database successfully<br>";
            $sql = "SELECT * from questions WHERE questionId = ".$_SESSION['question_nos'][$_SESSION['question']].";";

            $ret = $db->query($sql);

            
            while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                $correctAns = str_replace(' ','',strtolower($row['answer']));  //convert db answer to lowercase and trim
                $correctAns1 = str_replace(' ','',strtolower($row['answer1'])); 
            }             
            $db->close();
            if($correctAns != NULL){
                if($correctAns1 != NULL){
                    if($submittedAnswer ==  $correctAns || $submittedAnswer == $correctAns1){
                        recordtime();
                        array_splice($_SESSION['question_nos'], $_SESSION['question'],1);
                        $_SESSION["question"] = -1;
                    }
                    else{
                        header("Location: ./meme.php");
                    }
                }
                else{
                    if($submittedAnswer ==  $correctAns){
                        recordtime();
                        array_splice($_SESSION['question_nos'], $_SESSION['question'],1);
                        $_SESSION["question"] = -1;

                    }
                    else{
                        header("Location: ./meme.php");
                    }
                }

            }
        }
    }

    if(((date("H")> $_SESSION['countdown'][0]) || (date("H")== $_SESSION['countdown'][0]  && date('i') >= $_SESSION['countdown'][1])) 
    && isset($_SESSION["user"])){  //check time
        
    }
    else{
        header("Location: ./index.php");
    }

    if(!isset($_SESSION['question_nos'])){          //initialize question_nos array
        $sql =  "SELECT COUNT(*) FROM questions";
        $db = new MyDB();
        if(!$db) {
            echo $db->lastErrorMsg();
        } else {
        $ret = $db->query($sql);
        
        while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
            $_SESSION['totalq'] = $row['COUNT(*)'];
        }             
                
            $db->close();
            
            for ($i = 0; $i<$_SESSION['totalq']; $i++) {
                $_SESSION['question_nos'][$i] = $i;
            }
        }
    }
    $stage1 = 1;
    $stage2= 9;
    $stage3 = 15 - $stage1 - $stage2;

    if($_SESSION["question"] == -1){                //randomize next question
        if(count($_SESSION['question_nos']) == 0 ){
            $_SESSION['win'] = 1;
        }
        // else if(count($_SESSION['question_nos']) > 15 - $stage1){
        //     recordtime();
        //     $_SESSION['question'] = rand(0, $stage1 - 1 - (15 - count($_SESSION['question_nos'])) );
        // }
        // else if(count($_SESSION['question_nos']) > 15 - $stage1 - $stage2){
        //     recordtime();
        //     $_SESSION['question'] = rand(0, $stage2 - 1 - (15- $stage1 - count($_SESSION['question_nos'])));
        // }
        // else if(count($_SESSION['question_nos']) > 0){
        //     recordtime();
        //     $_SESSION['question'] = rand(0, $stage3 - 1 - (15 - $stage1 - $stage2 - count($_SESSION['question_nos'])));
        // }

        else {
            recordtime();
            $_SESSION['question'] = 0;
        }
    
    }

    function recordtime(){
        if(isset($_SESSION['time']) && $_SESSION['question'] != -1){
            $db = new MyDB();
            if(!$db) {
                echo $db->lastErrorMsg();
            } else {
                // echo "Opened database successfully<br>";
                $sql = "INSERT INTO users ('qid','time', 'uid') VALUES (" . $_SESSION['question_nos'][$_SESSION['question']] ."," . (time() - $_SESSION['time']). ",".$_SESSION['userid'] . ");";
                $ret = $db->exec($sql);
                if(!$ret){
                    echo $db->lastErrorMsg();
                } else {
                    
                }
                $db->close();
            }
        }
        else {
            $_SESSION['time'] = time();
        }
    }


        class MyDB extends SQLite3 {
            function __construct() {
                $this->open(dbloc);
                $this->exec('PRAGMA journal_mode = wal;
                pragma temp_store=FILE;');
                $this->busyTimeout(5000);
            }
        }
?>





<!-- html starts -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="app.css" />
  </head>
  <body>

  
<div class="qcontainer">
    <div class='header'>
        <?php
            if(!isset($_SESSION['win'])){
                $a = intval($_SESSION['totalq']) - count($_SESSION['question_nos']) + 1;
                echo "<h1 class='questionNo'>Question : ". $a ."/".$_SESSION['totalq'] ."</h1>";
            }
        ?>
        <h1 class='questionNo timer' id='timer'>00:40:24</h1>

    </div>

    <div class='qbox'>
            <?php 

                if(!isset($_SESSION['win'])){
                                    

                    $db = new MyDB();
                    if(!$db) {
                        echo $db->lastErrorMsg();
                    } else {
                        // echo "Opened database successfully<br>";
                        $sql = "SELECT * from questions WHERE questionId = ".$_SESSION['question_nos'][$_SESSION['question']].";";

                        $ret = $db->query($sql);
                        
                        while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                            echo "<h2 align=center class='question'>";
                            //echo "ID = ". $row['questionId'] . ' ';
                            echo $row['question'];
                            echo "</h2>";  

                            if($row['imageUrl'] != NULL ){
                                echo "<img src=".$row['imageUrl']." style='box-shadow:none' class='questionImg'>";
                            }
                            else if($row['special'] == 'grid'){
                                $special = 1;
                                echo "<br><div class='special'>";
                                echo "<img src='./images/grid.png'>";
                                echo "<form class='gridform' id='gridform' method='post'>
                                        <input type='text' name='1' id='gridtxt1' class='gridtxt' placeholder='1' autofocus>
                                        <input type='text' name='2' id='gridtxt2' class='gridtxt' placeholder='2' autocomplete='off'>
                                        <input type='text' name='3' id='gridtxt3' class='gridtxt' placeholder='3' autocomplete='off'>
                                        <input type='text' name='4' id='gridtxt4' class='gridtxt' placeholder='4' autocomplete='off'>
                                        <input type='text' name='5' id='gridtxt5' class='gridtxt' placeholder='5' autocomplete='off'>
                                        <input type='text' name='6' id='gridtxt6' class='gridtxt' placeholder='6' autocomplete='off'>
                                        <input type='text' name='7' id='gridtxt7' class='gridtxt' placeholder='7' autocomplete='off'>
                                        
                                    </form>
                                ";
                                
                                echo "</div><br>";
                                echo "<input type='submit' name='submitgridbutton' form='gridform' class='submitAnswerButton'/>";
                            }

                            else if($row['special'] == 'avengers'){
                                $special = 1;
                                echo "<form method = 'post'>

                                        <input type='text' name='1' class='avengers' autocomplete='off' autofocus>
                                        <input type='text' name='2' class='avengers' autocomplete='off'>
                                        <input type='text' name='3' class='avengers' autocomplete='off'>
                                        <input type='text' name='4' class='avengers' autocomplete='off'>
                                        <input type='text' name='5' class='avengers' autocomplete='off'>
                                        <input type='text' name='6' class='avengers' autocomplete='off'>";

                                        echo "</div><br>";
                                        echo "<input type='submit' name='submitabutton' class='submitAnswerButton'/>;
                                        
                                    </form>";
                            }


                            else{
                                echo "<br><br>";
                            }
                        }             
                       
                        
                        $db->close();

                    }

                    if(!isset($special)){
                        echo "<form method='POST'>
                        <input type='text' name='submittedAnswer' placeholder='Your Answer' autocomplete='off' autofocus/>
                        <input type='submit' name='submitAnswerButton' class='submitAnswerButton'/>
                        </form>";

                        // echo "<button class='submitAnswerButton skip' onclick='skip()'>Skip <img src='./images/right-arrow.png' class='icon'></button>";
                        
                    }


                } 
                else{
                    // echo"<h1 class='question'>You win</h1>";
                    header("Location: ./end.php");
                }


            ?>
    </div>  
</div>


<!-- js -->
<script src="game.js"></script>

  </body>
</html>