<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion</title>
    <style>
        body{
            background-color: black;
        }


        @keyframes spinner {
            to {
                transform: rotate(540deg);
            }
        }
        
        .spinner:before {
            content: '';
            box-sizing: border-box;
            position: absolute;
            top: 40%;
            left: 45%;
            width: 10em;
            height: 10em;
            margin-top: -10px;
            margin-left: -10px;
            border-radius: 50%;
            border: 2px solid transparent;
            border-top-color: #0000ff;
            border-bottom-color:#aa21e4;
            animation: spinner 1s ease infinite;
        }
    </style>
</head>
    <body>
        <?php 
            session_start();
            session_destroy();

            echo "<div class=spinner></div>";
           header("refresh:3;url=index.php");

        ?>
    </body>
</html>


