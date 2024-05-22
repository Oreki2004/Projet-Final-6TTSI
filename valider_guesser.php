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

    <?php
    // Connexion à la base de données
    $conn = new mysqli("localhost", "root", "", "urd");

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connexion échouée: " . $conn->connect_error);
    }

    // Récupérer l'identifiant du joueur depuis la session
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        $id = $_SESSION['id'];
        $pseudo = $_SESSION['pseudo'];

        // Vérifier si une réponse a été soumise
        if (isset($_POST['guess'])) {
            $guess = strtolower(trim($_POST['guess']));  // Nettoyer l'entrée de l'utilisateur

            // Récupérer le nom de l'image depuis la base de données
            $sql = "SELECT nom FROM guesser ORDER BY RAND() LIMIT 1";  // Sélectionne un chemin d'image aléatoire
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $image_name = strtolower($row['nom']);

                // Comparer la réponse soumise avec le nom de l'image
                if ($guess == $image_name) {
                    // Le joueur a deviné correctement
                    echo "Félicitations ! Vous avez deviné correctement.";

                    // Mettre à jour le niveau du joueur dans la table niveaux
                    $level = 1; // Nouveau niveau du joueur
                    $sql_update = "UPDATE niveau SET niveau = '$level' WHERE id_joueur = '$id'";
                    if ($conn->query($sql_update) === TRUE) {
                        echo " Niveau mis à jour avec succès.";
                    } else {
                        echo " Erreur lors de la mise à jour du niveau: " . $conn->error;
                    }

                    // Ajouter le score du joueur dans la table guesser_score
                    $score = 10; // Exemple de score, vous pouvez adapter cette valeur
                    $sql_score = "INSERT INTO guesser_score (id,joueur, score) VALUES ('','$pseudo', '$score')";
                    if ($conn->query($sql_score) === TRUE) {
                        echo " Score ajouté avec succès.";
                    } else {
                        echo " Erreur lors de l'ajout du score: " . $conn->error;
                    }
                } else {
                    // Le joueur a deviné incorrectement
                    echo "Désolé, votre réponse est incorrecte. Veuillez réessayer.";
                }
            } else {
                echo "Aucune image trouvée dans la base de données.";
            }
        } else {
            echo "Veuillez soumettre une réponse.";
        }
    } else {
        echo "Vous devez être connecté pour jouer.";
    }

    // Fermer la connexion
    $conn->close();
    ?>

    <div class="button"><a href="map">Suivant</a></div>
</body>
</html>
