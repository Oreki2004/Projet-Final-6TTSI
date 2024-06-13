<?php session_start();
       if(!isset($_SESSION['pseudo'])){
        header('Location:index.php');
        exit();}
?>
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
$connexion = mysqli_connect("localhost", "root", "", "urd");

if (!$connexion) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}

class Personnage
{
    protected $nom;
    protected $force;
    protected $vie;
    protected $img;

    public function __construct($nom, $force, $vie, $img)
    {
        $this->nom = $nom;
        $this->force = $force;
        $this->vie = $vie;
        $this->img = $img;
    }

    public function estVivant()
    {
        return $this->vie > 0;
    }

    public function attaquer(Personnage $ennemi)
    {
        $degats = $this->force;
        $ennemi->recevoirDegats($degats);
        return $degats;
    }

    public function recevoirDegats($degats)
    {
        $this->vie = max(0, $this->vie - $degats);
    }

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
    public function attaquer(Personnage $ennemi)
    {
        $degats = rand(15, 25); 
        $ennemi->recevoirDegats($degats);
        return $degats;
    }
}

class Arcaniste extends Personnage
{
    public function attaquer(Personnage $ennemi)
    {
        $degats = rand(20, 25); 
        $ennemi->recevoirDegats($degats);
        return $degats;
    }
}

class Chasseur extends Personnage
{
    public function attaquer(Personnage $ennemi)
    {
        $degats = rand(22, 30);
        $ennemi->recevoirDegats($degats);
        return $degats;
    }
}

$requeteJoueur = "SELECT nom, `force`, vie, img, nom FROM perso_joueur"; 
$resultatJoueur = mysqli_query($connexion, $requeteJoueur);

if (!$resultatJoueur) {
    die("Erreur lors de la récupération des personnages du joueur : " . mysqli_error($connexion));
}

$personnagesJoueur = [];
while ($row = mysqli_fetch_assoc($resultatJoueur)) {
    switch ($row['nom']) {
        case 'Titan':
            $personnagesJoueur[] = new Titan($row['nom'], $row['force'], $row['vie'], $row['img']);
            break;
        case 'Arcaniste':
            $personnagesJoueur[] = new Arcaniste($row['nom'], $row['force'], $row['vie'], $row['img']);
            break;
        case 'Chasseur':
            $personnagesJoueur[] = new Chasseur($row['nom'], $row['force'], $row['vie'], $row['img']);
            break;
        default:
            break;
    }
}
?>

<div class="container">
    <h1>Choisissez votre personnage</h1>
    <div class="select-character">
        <form method="POST">
            <select name="perso_choisi">
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
    $nom_perso_choisi = $_POST['perso_choisi'];
    $perso_choisi = null;
    foreach ($personnagesJoueur as $personnage) {
        if ($personnage->getNom() === $nom_perso_choisi) {
            $perso_choisi = $personnage;
            break;
        }
    }

    if ($perso_choisi) {
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
            echo "<div class='combatant'><img src='img_combat/" . $perso_choisi->getImg() . "' alt=''></div>";
            echo "<div class='versus'><img src='img_combat/VS.png'></div>";
            echo "<div class='combatant'><img src='img_combat/" . $ennemi->getImg() . "' alt=''></div>";
            echo "</div><div class='log'>";

            while ($perso_choisi->estVivant() && $ennemi->estVivant()) {
                $degatsInfliges = $perso_choisi->attaquer($ennemi);
                echo "<p>" . htmlspecialchars($perso_choisi->getNom()) . " inflige $degatsInfliges dégâts à " . htmlspecialchars($ennemi->getNom()) . "</p>";
                if ($ennemi->estVivant()) {
                    $degatsInfliges = $ennemi->attaquer($perso_choisi);
                    echo "<p>" . htmlspecialchars($ennemi->getNom()) . " inflige $degatsInfliges dégâts à " . htmlspecialchars($perso_choisi->getNom()) . "</p>";
                }
                $nombreDeManches++; 
            }

            if (!$perso_choisi->estVivant()) {
                echo "<p>" . htmlspecialchars($perso_choisi->getNom()) . " a été vaincu par " . htmlspecialchars($ennemi->getNom()) . "!</p>";
            } else {
                echo "<p>" . htmlspecialchars($ennemi->getNom()) . " a été vaincu par " . htmlspecialchars($perso_choisi->getNom()) . "!</p>";

                $score = 100 - ($nombreDeManches * 10);
                if ($score < 0) {
                    $score = 0;
                }
                echo "<p>Votre score est : $score</p>";

                $nouveauNiveau = 3; 
                // Vérifier si l'utilisateur existe dans la table niveau
                $pseudo = $_SESSION['pseudo'];
                $requeteNiveau = "SELECT * FROM niveau WHERE joueur = '$pseudo'";
                $resultatNiveau = mysqli_query($connexion, $requeteNiveau);

                if (mysqli_num_rows($resultatNiveau) > 0) {
                    $requeteMajNiveau = "UPDATE niveau SET niveau = $nouveauNiveau WHERE joueur = '$pseudo'";
                } else {
                    $requeteMajNiveau = "INSERT INTO niveau (joueur, niveau) VALUES ('$pseudo', $nouveauNiveau)";
                }
                $resultatMajNiveau = mysqli_query($connexion, $requeteMajNiveau);

                if (!$resultatMajNiveau) {
                    die("Erreur lors de la mise à jour du niveau du joueur : " . mysqli_error($connexion));
                }

                // Vérifier si l'utilisateur existe dans la table score_combat
                $requeteScore = "SELECT * FROM score_combat WHERE joueur = '$pseudo'";
                $resultatScore = mysqli_query($connexion, $requeteScore);

                if (mysqli_num_rows($resultatScore) > 0) {
                    $requeteMajScore = "UPDATE score_combat SET score = $score WHERE joueur = '$pseudo'";
                } else {
                    $requeteMajScore = "INSERT INTO score_combat (joueur, score) VALUES ('$pseudo', $score)";
                }
                $resultatMajScore = mysqli_query($connexion, $requeteMajScore);

                if (!$resultatMajScore) {
                    die("Erreur lors de la mise à jour du score du joueur : " . mysqli_error($connexion));
                }

                header("refresh:10;url=map.php");
                echo "<p><strong>Redirection vers la page de la carte dans 10 secondes...</strong></p>";
                exit();
            }
        } else {
            echo "Personnage sélectionné non trouvé.";
        }
    }
}
echo "</div>";
mysqli_close($connexion);
?>
    </div>
</body>
</html>
