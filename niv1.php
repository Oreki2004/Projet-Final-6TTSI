<!DOCTYPE html>
<?php session_start() ?>
<html>
<head>
    <title>URD - QUIZ</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
        body {
            background-image: url('IMG/Courtyard\,\ Tower\ 19.png');
            background-repeat: no-repeat;
            background-size: cover;
            font-family: Arial, sans-serif;
            
        }
        .body{
            background-color: rgba(0, 0, 0, 0.5);

        }
        a {
            text-decoration: none;
            color: black; 
        }
        header nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            
        }
        .logo {
            width: 100px;
        }
        nav ul {
            display: flex;
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            margin-right: 20px;
        }
        /* Responsive Styles */
        @media screen and (max-width: 768px) {
            nav ul {
                flex-direction: column;
                padding-left: 0;
            }
            nav ul li {
                margin-right: 0; 
                margin-bottom: 10px; 
            }
        }
        li a {
        color: #fff;
        line-height: 2;
        position: relative;
        font-family: cursive;
        }

        li a::before {
        content: '';
        width: 0;
        height: 2px;
        border-radius: 2px;
        background-color: #fff;
        position: absolute;
        bottom: -.25rem;
        left: 50%;
        transition: width .4s, left .4s;
        }

        li a:hover::before {
        width: 100%;
        left: 0;
        }
        li a,
        .dropbtn {
        display: inline-block;
        color: white;
        text-align: center;
        padding: 0 16px;
        text-decoration: none;
        }

        .dropdown li a:hover,
        .dropdown:hover .dropbtn {
        background-color: rgba(0, 0, 0, 0.5);
        color: red;
        transition-duration: 0.6s;
        }

        li.dropdown {
        display: inline-block;
        }

        .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        
        }

        .dropdown-content a {
        color: black;
        padding: 10px 14px;
        text-decoration: none;
        display: block;
        text-align: left;
        }

        .dropdown-content a:hover {
        background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
        display: block;
        
        }
        .quiz-container, li{
            color: white;
            list-style-type: none;
            
        }

        .form{
            display: flex;
            margin: 10px;
            justify-content: space-around;
        }

        .question{
            margin: 1em;
            font-weight: bold;
        }
        #option{
            margin: 1em;
        }
        div.button{
            display: flex;
            margin: 0 auto;
            justify-content: center;
            padding: 1em;
        }
        .button input{
            padding: 1em;
        }
        h2{
            margin-left: 1em;
        }
    </style>
</head>
<body>
    <div class="body">
    <header class="main-head">
        <nav>
        <a href="index.php"><img class="logo" align="left" alt="URD" src="LOGO/téléchargement (2).svg"></a>
            <ul>
                <li><a href="index.php">ACCUEIL</a></li>
                <li><a href="leaderboard.php">LEADERBOARD</a></li>
                <li><a href="contactez-nous.php">CONTACT</a></li>
                <?php 
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                        echo '<li><a href="map.php">MAP</a></li>
                              <li class=dropdown><a class=dropbtn>' . ($_SESSION["pseudo"]) . '</a>
                                  <div class="dropdown-content">
                                      <a href="deco.php">Déconnecter</a>
                                  </div>
                              </li>';
                    } else {
                        echo '<li><a href="connexion.php">CONNEXION</a></li>';
                    }
                ?>
            </ul>
        </nav>
    </header>
    <div class="quiz-container">
        <h2>Quiz</h2>
        <form method="post" action="valider_quiz.php">
            <div class="form">
                <?php
        // Connexion à la base de données
        $mysqli = new mysqli("localhost", "root", "", "urd");

        // Vérification de la connexion
        if ($mysqli->connect_error) {
            die("La connexion à la base de données a échoué : " . $mysqli->connect_error);
        }

        // Récupération des questions aléatoires
        $query_questions = "SELECT * FROM quiz ORDER BY RAND() LIMIT 4";
        $result_questions = $mysqli->query($query_questions);

        // Affichage des questions
        while ($ligne = $result_questions->fetch_assoc()) {
            // Récupération des réponses pour cette question
            $query_answers = "SELECT * FROM quiz_reponse WHERE id_question = " . $ligne['id'] . " ORDER BY RAND()";
            $result_answers = $mysqli->query($query_answers);
            
            // Affichage de la question
            echo "<div>";
            echo "<div class='question'><strong>Question:</strong> ".$ligne['question']."</div>";
            
            // Affichage des réponses
            while ($answer = $result_answers->fetch_assoc()) {
                echo "<input id='option' type='radio' name='reponses[" . $ligne['id'] . "]' value='" . $answer['id'] . "' required>";
                echo $answer['reponse'] . "<br>";
            }
            
            echo "</div>";


        }

        // Fermeture de la connexion à la base de données
        $mysqli->close();
        ?>

            </div><br>
            <div class="button"><input type="submit" value="Submit"></div>
            
        </form>
    </div></div>
</body>
</html>
