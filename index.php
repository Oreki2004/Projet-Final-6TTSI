<!DOCTYPE html>
<?php session_start() ?>
<html>
<head>
    <title>URD - ACCUEIL</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
        body {
            background-image: url(IMG/Courtyard\,\ Tower\ 1.png);
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif; 

        }
        h1{
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
        
        .welcome {
            text-align: left;
            color: white;
            margin-top: 50px;
            margin-left: 2em;
            margin-left: 1em;
            max-width: 700px;
            border: solid 0.1em rgb(130, 54, 236);
            border-radius: 10px;
            max-height: 20em;
            background-color: rgba(0, 0, 0,0.61);
            backdrop-filter: blur(1px);
            
        }
        legend{
            font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-size: 1.5em;
        } 
        .welcome h1,.welcome p{
            margin-left: 1em;
            max-width: 700px;
            font-size: 1.2em;
        }

        .welcome p {
            padding: 1.2em 1em;
            margin: 0 0;
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
    <fieldset class="welcome">
        <legend>Bienvenue sur URD</legend>
        <div>
        <p>Découvrez un monde fascinant avec 4 niveaux de jeu inspirés par l'univers de Destiny 2. Préparez-vous à l'action, aux combats épiques et aux défis palpitants qui vous attendent dans notre jeu en ligne.
            Ce Projet est réalisé par Sathiyaseelan Arunmoli élève à Saint-Luc Mons en 6TT SI.
        </p></div>
    </fieldset>
</body>
</html>
