<!DOCTYPE html>
<?php session_start() ?>
<html>
<head>
    <title>URD - QUIZ</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
        body {
            background-image: linear-gradient(109.6deg, rgba(102, 51, 153, 1) 11.2%, rgba(2, 0, 4, 1) 91.1%);
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif; 
        }
        a {
            text-decoration: none;
            color: white; 
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
        li a,
        .dropbtn {
        display: inline-block;
        color: white;
        text-align: center;
        padding: 14px 16px;
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
        padding: 12px 16px;
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
    </style>
</head>
<body>
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
                                      <a href="user.php">Compte</a>
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
            <?php 
                $mysqli = mysqli_connect("localhost", "root", "", "urd") or die("La connexion à la base de données a échoué : " . mysqli_connect_error());
                $query = "SELECT * FROM quiz";
                $resultat = $mysqli->query($query);
                $question_num = 1;
                while ($ligne = $resultat->fetch_assoc()) {
                    echo "<div class='question'>";
                    echo "<p><strong>Question $question_num:</strong> " . $ligne['question'] . "</p>";
                    echo "<ul>";
                    $query_reponses = "SELECT * FROM quiz_option WHERE id = " . $ligne['id'];
                    $resultat_reponses = $mysqli->query($query_reponses);
                    while ($ligne_reponse = $resultat_reponses->fetch_assoc()) {
                        echo "<li><input type='radio' name='question_$question_num' value='" . $ligne_reponse['id'] . "' required>" . $ligne_reponse['reponse'] . "</li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                    $question_num++;
                }
            ?>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
