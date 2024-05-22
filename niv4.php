<!DOCTYPE html>
<?php session_start(); 

$conn = new mysqli("localhost", "root","" , "urd");

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupérer le chemin de l'image depuis la base de données
$sql = "SELECT img FROM guesser ORDER BY RAND() LIMIT 1"; // Sélectionne un chemin d'image aléatoire
$result = $conn->query($sql);

// Vérifier s'il y a des erreurs dans la requête SQL
if (!$result) {
    printf("Erreur : %s\n", $conn->error);
    exit();
}

// Vérifier si des résultats ont été retournés
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $image = $row['img'];
} else {
    $image = ""; // Chemin par défaut si aucune image n'est trouvée
}

?>
?>
<html>
<head>
<title>URD - NIVEAU 4</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
        body {
            background-image: url('./IMG/The\ Tor\,\ Nessus\ 2.png');
            background-repeat: no-repeat;
            background-size: cover;
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
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true ) {
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
    <section class="game-section">
        <h2>Devinez l'endroit</h2>
        <img src="./guess_img/<?php echo $image; ?>" alt="Image à deviner">

        <form action="valider_guesser.php" method="post">
            <label for="guess">Votre devinette:</label>
            <input type="text" id="guess" name="guess">
            <button type="submit">Valider</button>
        </form>
    </section>
</body>
</html>
