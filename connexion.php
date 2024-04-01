
<?php session_start() ?>
<html>
<head>
	<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>URD - CONNEXION</title>
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
		$email = $ligne['email'];
		$mdp = $ligne['mdp'];


		$_SESSION['loggedin'] = true;
		$_SESSION['pseudo'] = $pseudo;
		$_SESSION['email'] = $email;
		$_SESSION['mdp'] = $mdp;
		$_SESSION['id'] = $id;


		echo "<p id=reussi>Connexion réussie.</p>";
		header( "refresh:3;url=index.php" );
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
