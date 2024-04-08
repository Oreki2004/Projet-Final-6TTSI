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
		.button {
			border: none;
			outline: none;
			background-color: #6c5ce7;
			padding: 10px 20px;
			font-size: 12px;
			font-weight: 700;
			color: #fff;
			border-radius: 5px;
			transition: all ease 0.1s;
			box-shadow: 0px 5px 0px 0px #a29bfe;
		}

		.button:active {
			transform: translateY(5px);
			box-shadow: 0px 0px 0px 0px #a29bfe;
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
				input {
		color: #8707ff;
		border: 2px solid #8707ff;
		border-radius: 10px;
		padding: 10px 25px;
		background: transparent;
		max-width: 190px;
		}

		input:active {
		box-shadow: 2px 2px 15px #8707ff inset;
		}

		.content a:hover {
			text-decoration: underline;
		}
		      li a,
        .dropbtn {
        display: inline-block;
        color: black;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        }

        .dropdown li a:hover,
        .dropdown:hover .dropbtn {
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
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
        margin: 5px;
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
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['admin'] == 0) {
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
