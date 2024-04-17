<!DOCTYPE html>
<?php session_start() ?>
<html>
<head>
	<title>TorrentGames - Inscription</title>
    <link rel="stylesheet" href="./CSS/connexion.css">
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
	<div class=content>
		<h2>Inscription</h2>

	<?php
	if (isset($_POST['submit'])) {

		$connexion = mysqli_connect("localhost", "root", "", "urd") or die("La connexion à la base de données a échoué : " . mysqli_connect_error());

		$query = "SELECT MAX(id) FROM joueur";
		$resultat = mysqli_query($connexion, $query);
		$ligne = mysqli_fetch_array($resultat);
		$max_id = $ligne[0];

		$new_id = $max_id + 1;

		$email = mysqli_real_escape_string($connexion, $_POST['email']);
		$mdp = mysqli_real_escape_string($connexion, $_POST['mdp']);
		$pseudo = mysqli_real_escape_string($connexion, $_POST['pseudo']);

		
		$query = "SELECT * FROM joueur WHERE email='$email'";
		$resultat = mysqli_query($connexion, $query);

		if (mysqli_num_rows($resultat) > 0) {
			echo "<p>Cet email est déjà utilisé.</p>";
		}
		
		else {

			$query = "INSERT INTO joueur (id, email, mdp, pseudo) VALUES ('$new_id', '$email', '$mdp', '$pseudo')";
			if (mysqli_query($connexion, $query)) {
				echo "<p id=reussi>Inscription réussie.</p>";
				header( "refresh:3;url=connexion.php" );

			} else {
				echo "<p>Une erreur s'est produite lors de l'inscription.<p>";
			}
			
			$query2 = "INSERT INTO niveau (id, id_joueur, niveau, joueur) VALUES ('','$new_id', '1', '$pseudo')";
			if (mysqli_query($connexion, $query2)) {
				header( "refresh:3;url=connexion.php" );

			} else {
				echo "<p>Une erreur s'est produite lors de l'inscription.<p>";
			}
		}
		mysqli_close($connexion);
	}
	?>

		<form align=center method="post" action="">
			<label for="email">Email :</label><br>
			<input type="email" name="email" placeholder="Example@gmail.com" required><br>

			<label for="mdp">Mot de passe :</label><br>
			<input type="password" name="mdp" placeholder="Example1234" required><br>

			<label for="pseudo">Pseudonyme :</label><br>
			<input type="text" name="pseudo" placeholder="Example" required><br>

			<input class=button type="submit" name="submit" value="S'inscrire"><br><a href="connexion.php">déjà un compte?</a>
		</form>
	</div>
</body>
</html>
