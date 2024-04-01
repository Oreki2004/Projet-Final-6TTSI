<!DOCTYPE html>
<?php session_start() ?>
<html>
<head>
	<title>TorrentGames - Inscription</title>
	<style>
		body{	
			background-image: url(IMG/Twilight\ Gap\,\ Last\ City\ Perimeter\ 0.png);
			background-repeat: no-repeat;
			background-size: cover;

		}
		h2{
			text-align: center;
			font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
		}
		input,a{
				margin: 10px;
		}

		.button{
			border: none;
			padding: 10px;
			margin: 5px;
			border-radius: 4px;
		}
		.button:hover{
			transition-duration: .5s;
			transform: scale(1.1);
			color: white;
			background-color: black;
		}
		
		p{
			text-align:center;
			color:red;
		}
		
		#reussi{
			color:lime;
		}
		.content{
			max-width: 20em;
			max-height: fit-content ;
			margin: 2em auto;
			border: 0px solid;
			padding: 10px;
			box-shadow: 0em 0em 3em #000000;
			background-color: white;
			opacity: 75%;
		}
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');

        a {
            text-decoration: none;
            color: black; 
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
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['admin'] == 0) {
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
	<div class=content>
		<h2>Inscription</h2>

	<?php
	if (isset($_POST['submit'])) {

		$connexion = mysqli_connect("localhost", "root", "", "urd") or die("La connexion à la base de données a échoué : " . mysqli_connect_error());

		$query = "SELECT MAX(id) FROM joueur";
		$result = mysqli_query($connexion, $query);
		$row = mysqli_fetch_array($result);
		$max_id = $row[0];

		$new_id = $max_id + 1;

		$email = mysqli_real_escape_string($connexion, $_POST['email']);
		$mdp = mysqli_real_escape_string($connexion, $_POST['mdp']);
		$pseudo = mysqli_real_escape_string($connexion, $_POST['pseudo']);

		
		$query = "SELECT * FROM joueur WHERE email='$email'";
		$result = mysqli_query($connexion, $query);

		if (mysqli_num_rows($result) > 0) {
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
