<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
    <title>URD - COMBAT</title>
    <link rel="stylesheet" href="css/niv2.css">
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
    <?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "urd");

if (!$connexion) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}

// Définition des classes de personnages
class Personnage
{
    protected $nom;
    protected $force;
    protected $vie;
    protected $img;

    // Constructeur
    public function __construct($nom, $force, $vie, $img)
    {
        $this->nom = $nom;
        $this->force = $force;
        $this->vie = $vie;
        $this->img = $img;
    }

    // Méthode pour vérifier si le personnage est vivant
    public function estVivant()
    {
        return $this->vie > 0;
    }

    // Méthode pour infliger des dégâts à un autre personnage
    public function attaquer(Personnage $ennemi)
    {
        $degats = $this->force;
        $ennemi->recevoirDegats($degats);
        return $degats;
    }

    // Méthode pour recevoir des dégâts
    public function recevoirDegats($degats)
    {
        $this->vie = max(0, $this->vie - $degats);
    }

    // Méthodes pour récupérer les informations du personnage
    public function getNom()
    {
        return $this->nom;
    }

    public function getForce()
    {
        return $this->force;
    }

    public function getVie()
    {
        return $this->vie;
    }

    public function getImg()
    {
        return $this->img;
    }
}

class Titan extends Personnage
{
    // Marteau
}

class Arcaniste extends Personnage
{
    // Bombe Nova
}

class Chasseur extends Personnage
{
    // Lames
}

$requeteJoueur = "SELECT *, 'Chasseur' AS classe FROM perso_joueur"; 
$resultatJoueur = mysqli_query($connexion, $requeteJoueur);

if (!$resultatJoueur) {
    die("Erreur lors de la récupération des personnages du joueur : " . mysqli_error($connexion));
}


$personnagesJoueur = [];
while ($row = mysqli_fetch_assoc($resultatJoueur
)) {
    $personnagesJoueur[] = new $row['classe']($row['nom'], $row['force'], $row['vie'], $row['img']);
}
?>

<div class="container">
    <h1>Choisissez votre personnage</h1>
    <div class="select-character">
        <form method="POST">
            <select name="selected_character">
                <?php
                foreach ($personnagesJoueur as $personnage) {
                    echo "<option value='" . $personnage->getNom() . "'>" . $personnage->getNom() . "</option>";
                }
                ?>
            </select>
            <input type="submit" name="submit" value="Commencer le combat">
        </form>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $selectedCharacterName = $_POST['selected_character'];
    $selectedCharacter = null;
    foreach ($personnagesJoueur as $personnage) {
        if ($personnage->getNom() === $selectedCharacterName) {
            $selectedCharacter = $personnage;
            break;
        }
    }

    if ($selectedCharacter) {
        $requeteEnnemis = "SELECT * FROM perso_combat ORDER BY RAND() LIMIT 1"; 
        $resultatEnnemis = mysqli_query($connexion, $requeteEnnemis);

        if (!$resultatEnnemis) {
            die("Erreur lors de la récupération des ennemis : " . mysqli_error($connexion));
        }

        $ennemi = mysqli_fetch_assoc($resultatEnnemis);
        $ennemi = new Personnage($ennemi['nom'], $ennemi['force'], $ennemi['vie'], $ennemi['img']);
        $nombreDeManches = 0;
        if ($ennemi) {
            echo "<div class='combat-container'>";
            echo "<div class='combatant'><img src='img_combat/" . $selectedCharacter->getImg() . "' alt=''></div>";
            echo "<div class='versus'><img src=img_combat/VS></div>";
            echo "<div class='combatant'><img src='img_combat/" . $ennemi->getImg() . "' alt=''></div>";
            echo "</div><div class='log'>";

            // Déroulement du combat
            while ($selectedCharacter->estVivant() && $ennemi->estVivant()) {
                $degatsInfliges = $selectedCharacter->attaquer($ennemi);
                echo "<p>" . $selectedCharacter->getNom() . " inflige $degatsInfliges dégâts à " . $ennemi->getNom() . "</p>";
                if ($ennemi->estVivant()) {
                    $degatsInfliges = $ennemi->attaquer($selectedCharacter);
                    echo "<p>" . $ennemi->getNom() . " inflige $degatsInfliges dégâts à " . $selectedCharacter->getNom() . "</p>";
                }
                $nombreDeManches++; // Incrémenter le nombre de manches
            }

            // Affichage du résultat du combat
            if (!$selectedCharacter->estVivant()) {
                echo "<p>" . $selectedCharacter->getNom() . " a été vaincu par " . $ennemi->getNom() . "!</p>";
            } else {
                echo "<p>" . $ennemi->getNom() . " a été vaincu par " . $selectedCharacter->getNom() . "!</p>";

                $score = 100 - ($nombreDeManches * 10);
                if ($score < 0) {
                    $score = 0;
                }
                echo "<p>Votre score est : $score</p>";
                
                // Mettre à jour le niveau du joueur dans la base de données
                $nouveauNiveau = 3; // Augmentation du niveau
                $requeteMajNiveau = "UPDATE niveau SET niveau = $nouveauNiveau WHERE joueur = '" . $_SESSION['pseudo'] . "'";
                $resultatMajNiveau = mysqli_query($connexion, $requeteMajNiveau);
                
                if (!$resultatMajNiveau) {
                    die("Erreur lors de la mise à jour du niveau du joueur : " . mysqli_error($connexion));
                }
                
                // Optionnel : Mettre à jour le score du joueur dans la base de données
                $requeteMajScore = "UPDATE score_combat SET score = $score WHERE joueur = '" . $_SESSION['pseudo'] . "'";
                $resultatMajScore = mysqli_query($connexion, $requeteMajScore);
                
                if (!$resultatMajScore) {
                    die("Erreur lors de la mise à jour du score du joueur : " . mysqli_error($connexion));
                }
                
                header("refresh:10;url=map.php");
                echo "<p><strong>Redirection vers la page de la carte dans 10 secondes...<strong></p>";
                exit();
        }
    } else {
        echo "Personnage sélectionné non trouvé.";
    }
}}
echo "</div>";
mysqli_close($connexion);
?>
    </div>
</body>
</html>

