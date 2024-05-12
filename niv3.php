<!DOCTYPE html>
<?php 
session_start();

$connexion = mysqli_connect("localhost", "root", "", "urd") or die("La connexion à la base de données a échoué : " . mysqli_connect_error());

$pseudo = $_SESSION['pseudo'];
$_SESSION['pseudo'] = $pseudo;

$query = "SELECT * FROM niveau WHERE joueur='$pseudo'";
	$result = mysqli_query($connexion, $query);
	$ligne = ($result->fetch_assoc());
	
	if ($ligne > 0) {
		
		$niveau= $ligne['niveau'];
        $_SESSION['niveau'] = $niveau;

	}
    else{
        echo "impossible de récupérer le niveau".$pseudo;
    }


if (!$connexion) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

if(isset($_POST['temps'])){
    $temps = $_POST['temps'];
    // Insérer le temps dans la base de données ou le mettre à jour s'il existe déjà un temps pour cet utilisateur
    $pseudo = $_SESSION['pseudo'];
    $niveauActuel = $_SESSION['niveau'];
    $requeteTemps = "SELECT * FROM `jeu_paires` WHERE pseudo='$pseudo'";
    $resultatTemps = mysqli_query($connexion, $requeteTemps);
    if(mysqli_num_rows($resultatTemps) > 0) {
        $row = mysqli_fetch_assoc($resultatTemps);
        if($temps < $row['temps']){
            $requeteUpdateTemps = "UPDATE `jeu_paires` SET temps='$temps' WHERE pseudo='$pseudo'";
            mysqli_query($connexion, $requeteUpdateTemps);
        }
    } else {
        $requeteInsertTemps = "INSERT INTO `jeu_paires` (id,pseudo, temps) VALUES ('','$pseudo', '$temps')";
        mysqli_query($connexion, $requeteInsertTemps);
    }

    if($niveauActuel == 3 && $temps < 180){ 
        $nouveauNiveau = 4;
        $requeteniveau = "UPDATE niveau SET niveau='$nouveauNiveau' WHERE joueur='$pseudo'";
        mysqli_query($connexion, $requeteniveau);
        $_SESSION['niveau'] = $nouveauNiveau;
    }
}
?>
<html>
<head>
    <title>URD - JEU DES PAIRES</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
        body {
            background-image: url(IMG/Lost\ Oasis\,\ Io\ 0.png);
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
        img{
		cursor:pointer;
        max-width: 100px;
        height: 80px;
	    }
        table{
            margin: 10em auto;
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
        <table id="tapis">
    <tr>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
    </tr>
    <tr>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
    </tr>
    <tr>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
    </tr>
    <tr>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
        <td><img src="./cartes/fondcarte.png"/></td>
    </tr>
    </table>
    <form id="jeuForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" id="tempsInput" name="temps" value="">
    <button type="button" id="finJeuBtn" onclick="fin()">Suivant</button>
</form>
    <script>
    var debutJeu;

function fin(){
    var tempsJeu = Math.round((new Date().getTime() - debutJeu) / 1000);
    document.getElementById("tempsInput").value = tempsJeu;
    document.getElementById("jeuForm").submit(); 
}

    var motifsCartes=[1,1,2,2,3,3,4,4,5,5,6,6,7,7,8,8,9,9,10,10];
    var etatsCartes=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
    var cartesRetournees=[];
    var nbPairesTrouvees=0;
    var imgCartes=document.getElementById("tapis").getElementsByTagName("img");		
    for(var i=0;i<imgCartes.length;i++){
        imgCartes[i].noCarte=i; 
        imgCartes[i].onclick=function(){
            controleJeu(this.noCarte);
        }                      
    }
    initialiseJeu();
    function majAffichage(noCarte){
        switch(etatsCartes[noCarte]){
            case 0:
                imgCartes[noCarte].src="./cartes/fondcarte.png";
                break;
            case 1:
                imgCartes[noCarte].src="./cartes/carte"+motifsCartes[noCarte]+".png";
                break;
            case -1:
                imgCartes[noCarte].style.visibility="hidden";
                break;
        }
    }
    function fin() {
        var debutJeu = new Date().getTime();

        var tempsJeu = new Date().getTime() - debutJeu;
        document.getElementById("tempsInput").value = tempsJeu;

        document.getElementById("jeuForm").submit();
    }
    function initialiseJeu(){
        for(var position=motifsCartes.length-1; position>=1; position--){
            var hasard=Math.floor(Math.random()*(position+1));
            var sauve=motifsCartes[position];
            motifsCartes[position]=motifsCartes[hasard];
            motifsCartes[hasard]=sauve;
        }
        debutJeu = new Date().getTime(); // Enregistre le moment où le jeu commence
    }
    function controleJeu(noCarte){
        if(cartesRetournees.length<2){
            if(etatsCartes[noCarte]==0){
                etatsCartes[noCarte]=1;
                cartesRetournees.push(noCarte);
                majAffichage(noCarte);
            }
            if(cartesRetournees.length==2){
                var nouveauEtat=0;
                if(motifsCartes[cartesRetournees[0]]==motifsCartes[cartesRetournees[1]]){
                    nouveauEtat=-1;
                    nbPairesTrouvees++;
                }

                etatsCartes[cartesRetournees[0]]=nouveauEtat;
                etatsCartes[cartesRetournees[1]]=nouveauEtat;
                setTimeout(function(){
                    majAffichage(cartesRetournees[0]);
                    majAffichage(cartesRetournees[1]);
                    cartesRetournees=[];
                    if(nbPairesTrouvees==10){
                        fin();
                    }
                },750);
            }
        }
    }
    </script>
</body>
</html>