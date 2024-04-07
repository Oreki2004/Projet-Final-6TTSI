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
    </style>
</head>
    <body>
        <?php 
            session_start();
            session_destroy();

           header("refresh:1;url=index.php");

        ?>
    </body>
</html>


