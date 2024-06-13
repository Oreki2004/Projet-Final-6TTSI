<!DOCTYPE html>
<?php session_start() ?>
<html>
<head>
    <title>URD - LEADERBOARD</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
        body {
            background-image: url(IMG/Courtyard\,\ Tower\ 1.png);
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif; 
            overflow: hidden;

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
        .leaderboard {
            color: white;
            margin: 0 auto;
            width: fit-content;
            background-color: rgba(0, 0, 0, 0.5);
        }
        table {
        border-collapse: collapse;
        }

        tr:nth-child(2n+2) {
            background: white;
            color: black;
            
        }
        td,th{
            padding: 1em;
        }
        h2{
            text-align: center;
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
    <section class="leaderboard">
        <h2>Leaderboard</h2>
        <table border="1">
            <tr>
                <th>Joueur</th><th>Score Quiz</th>
                <th>Score Combat</th>
                <th>Score Jeu de Paires</th>
                <th>Score Guesser</th>
                <th>Score Total</th>
            </tr>
            <?php
            $conn = new mysqli("localhost", "root", "", "urd");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT j.pseudo AS Joueur,
                           COALESCE(gs.score, 0) AS ScoreGuesser,
                           COALESCE(jp.score, 0) AS ScoreJeuPaires,
                           COALESCE(sq.score, 0) AS ScoreQuiz,
                           COALESCE(sc.score, 0) AS ScoreCombat,
                           COALESCE(gs.score, 0) + COALESCE(jp.score, 0) + COALESCE(sq.score, 0) + COALESCE(sc.score, 0) AS ScoreTotal
                    FROM joueur j
                    LEFT JOIN guesser_score gs ON j.pseudo = gs.joueur
                    LEFT JOIN jeu_paires jp ON j.pseudo = jp.pseudo
                    LEFT JOIN score_quiz sq ON j.pseudo = sq.joueur
                    LEFT JOIN score_combat sc ON j.pseudo = sc.joueur
                    GROUP BY j.pseudo
                    ORDER BY ScoreTotal DESC";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Joueur'] . "</td>";
                    echo "<td>" . $row['ScoreQuiz'] . "</td>";
                    echo "<td>" . $row['ScoreCombat'] . "</td>";
                    echo "<td>" . $row['ScoreJeuPaires'] . "</td>";
                    echo "<td>" . $row['ScoreGuesser'] . "</td>";
                    echo "<td>" . $row['ScoreTotal'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Aucun résultat trouvé</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </section>
</body>
</html>
