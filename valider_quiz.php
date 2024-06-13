<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head>
    <title>URD - ACCUEIL</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
        
        * {
            color: white;
        }
        body {
            background-image: linear-gradient(109.6deg, rgba(102, 51, 153, 1) 11.2%, rgba(2, 0, 4, 1) 91.1%);
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif; 
            height: 65em;
        }
        h1 {
            position: absolute;
            translate: 0 -40px;
            height: 5%;
            background-color: rgba(0, 0, 0, 0.61);
            backdrop-filter: 10%;
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
            color: white;
            transition-duration: 0.6s;
            cursor: pointer;
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
                              <li class="dropdown"><a class="dropbtn">' . ($_SESSION["pseudo"]) . '</a>
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
    <?php
    $mysqli = new mysqli("localhost", "root", "", "urd");
    if ($mysqli->connect_error) {
        die("La connexion à la base de données a échoué : " . $mysqli->connect_error);
    }
    $joueur = $_SESSION['pseudo'];
    if (isset($_POST['reponses'])) {
        $query_niv = "UPDATE niveau SET niveau ='2' WHERE joueur = '$joueur'";
        $resultat_niv = $mysqli->query($query_niv);
        if ($resultat_niv) {
            echo "Vous avez maintenant accès au Niveau 2.";
        } else {
            echo "Erreur lors de la mise à jour du niveau : " . $mysqli->error;
        }

        $score_query = "SELECT score FROM score_quiz WHERE joueur = '$joueur'";
        $score_resultat = $mysqli->query($score_query);
        
        if ($score_resultat) {
            if ($score_resultat->num_rows > 0) {
                $row = $score_resultat->fetch_assoc();
                $score_joueur = $row['score'];

                $score_actuel = 0;
                $reponses_utilisateur = $_POST['reponses'];
                foreach ($reponses_utilisateur as $id_question => $reponse_utilisateur) {
                    $query = "SELECT est_correcte FROM quiz_reponse WHERE id = $reponse_utilisateur";
                    $result = $mysqli->query($query);
                    if ($result) {
                        $row = $result->fetch_assoc();
                        if ($row['est_correcte']) {
                            $score_actuel++;
                        }
                    }
                }

                if ($score_actuel > $score_joueur) {
                    $majscore = "UPDATE score_quiz SET score = $score_actuel WHERE joueur = '$joueur'";
                    $resultatmajscore = $mysqli->query($majscore);
                    if ($resultatmajscore) {
                        echo "Ton score actuel est de " . $score_actuel;
                    } else {
                        echo "Erreur lors de la mise à jour du score : " . $mysqli->error;
                    }
                } else {
                    echo "Ton score actuel est de " . $score_actuel . ", tu peux faire mieux.";
                }
            } else {
                $score_actuel = 0;
                foreach ($reponse_utilisateur as $id_question => $reponse_utilisateur) {
                    $query = "SELECT est_correcte FROM quiz_reponse WHERE id = $reponse_utilisateur";
                    $result = $mysqli->query($query);
                    if ($result) {
                        $row = $result->fetch_assoc();
                        if ($row['est_correcte']) {
                            $score_actuel++;
                        }
                    }
                }
                $query_score = "INSERT INTO score_quiz (joueur, score) VALUES ('$joueur', $score_actuel)";
                $resultat_score = $mysqli->query($query_score);
                if ($resultat_score) {
                    echo "Score inséré avec succès.";
                } else {
                    echo "Erreur lors de l'insertion du score : " . $mysqli->error;
                }
            }
        } else {
            echo "Erreur lors de la récupération du score : " . $mysqli->error;
        }
    }
    $mysqli->close();
    ?>
    <div class="button"><a href="map.php">Suivant</a></div>
</body>
</html>
