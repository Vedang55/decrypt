<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Wrong!</title>

    <style>
        body {
            background: url('./images/bckg.jpg');
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

        img {
            max-width: 40rem;
            max-height:80vh;
        }

        button {
            margin: 0.5rem;
            text-align: center;
            border-radius: 10rem;
            color: rgb(0, 191, 255);
            background-color: rgba(200, 255, 0,1);
            padding: 1.5rem;
            font-size:2rem;
            
        }
    </style>
    
  </head>
  <body>
    <div class='container'>
    
        
        <img src='<?php
            $dir = './images/memes';
            $files = glob(realpath($dir) . '/*.*');
            $file = array_rand($files);
            $imgd = str_replace('\\','/',$files[$file]);
            $imgd=explode('/',$imgd);
            echo 'images/memes/'.end($imgd);  
        ?>'>
        
        <button onclick='retry()' id='retryButton'>Retry <i class="fa fa-refresh"></i></button>

    </div>


        <script>
            function retry(){
                window.location = './game.php';
            }

            var input = document.documentElement;

            // Execute a function when the user releases a key on the keyboard
            input.addEventListener("keydown", function(event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                document.getElementById("retryButton").click();
            }
            });

        </script>

  </body>

  </html>
  