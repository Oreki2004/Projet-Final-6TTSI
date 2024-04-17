
<?php session_start() ?>
<html>
<head>
	<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>URD - CONNEXION</title>
    <link rel="stylesheet" href="css/connexion.css">
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
<div class="content">
<h2>Connexion</h2>

<?php
		

if (isset($_POST['submit'])) {

	$connexion = mysqli_connect("localhost", "root", "", "urd") or die("La connexion à la base de données a échoué : " . mysqli_connect_error());


	$email = mysqli_real_escape_string($connexion, $_POST['email']);
	$mdp = mysqli_real_escape_string($connexion, $_POST['mdp']);

	$query = "SELECT * FROM joueur WHERE email='$email' AND mdp='$mdp'";
	$result = mysqli_query($connexion, $query);
	$ligne = ($result->fetch_assoc());
	
	if ($ligne > 0) {
		
		$pseudo = $ligne['pseudo'];
		$id = $ligne['id'];



		$_SESSION['loggedin'] = true;
		$_SESSION['pseudo'] = $pseudo;

		$_SESSION['id'] = $id;


		echo "<p id=reussi>Connecté.</p>";
		header( "refresh:2;url=index.php" );
	} else {
		echo "<p>Email ou mot de passe incorrect.</p>";
	}
	mysqli_close($connexion);
}
?>


		<center><form method="post" action="">
		<label for="email">Email :</label>
		<br><input type="email" name="email" placeholder="example@gmail.com" required><br>

		<label for="mdp">Mot de passe :</label>
		<br><input type="password" name="mdp" placeholder="Example1234" required><br><br>

		<input class="button" type="submit" name="submit" value="Se connecter"><br>
		 pas encore membre?<a href="inscription.php">Inscrivez-vous</a>
	</form></center>
	</div>
</body>
</html>
