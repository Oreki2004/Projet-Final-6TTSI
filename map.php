<?php 
       session_start();
       
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URD - MAP</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');
        body {
            background-color: black;
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
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
            display: block;
            margin: 0 auto;
        }

    </style>
</head>
<body color="black" id="map" link="white" vlink="white" alink="purple">
        <header class="main-head">
            <nav>
                <a  href="index.php"><img class="logo"align="left" alt="URD" src="LOGO/téléchargement (2).svg"></a>
                <a href="index.php"><h1></h1></a>
                <ul>
                    <li><a href="index.php">ACCUEIL</a></li>
                    <li><a href="leaderboard.php">LEADERBOARD</a></li>
                    <li><a href="contactez-nous.php">CONTACT</a></li>
                    <?php 
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                        echo '<li><a href="map.php">MAP</a></li><li class=dropdown><a class=dropbtn>'.($_SESSION["pseudo"]).'</a>
                        <div class="dropdown-content">
                            <a href="deco.php">Déconnecter</a>
                        </div>
                        </li>';
                        }
                        else{
                            echo '<li><a href="connexion.php">CONNEXION</a></li>' ;
                        }
                    ?>
                </ul>
            </nav>

        </header>

        <div style="position: relative;margin-top:5%;">
        <img src="img/destiny2_maps_director_s4.png" usemap="#image-map">
    </div>
<!-- Image Map généré par http://www.image-map.net/ -->

<map name="image-map">
    
    <?php 
    $mysqli = new mysqli("localhost", "root", "", "urd");

    if ($mysqli->connect_error) {
        die("La connexion à la base de données a échoué : " . $mysqli->connect_error);
    }
    $id=$_SESSION["id"];

    $query_niveau = "SELECT * FROM niveau where id_joueur='$id' ";
    $result_niveau = $mysqli->query($query_niveau);
    while ($ligne = $result_niveau->fetch_assoc()) {
        if($ligne['niveau']==1){
            echo'<area id="terre" target="_blank" alt="terre" title="terre" href="niv1.php" coords="615,343,77" shape="circle">';
        }
        
    elseif($ligne['niveau']==2){
        echo'<area id="titan" target="_blank" alt="titan" title="titan" href="niv2.php" coords="333,451,37" shape="circle">';
    }
    elseif($ligne['niveau']==3){
        echo '<area id="io" target="_blank" alt="io" title="io" href="niv3.php" coords="241,200,43" shape="circle">';
    }
    elseif($ligne['niveau']==4){
        echo '<area id="nessos" target="_blank" alt="nessos" title="nessos" href="niv4.php" coords="815,143,33" shape="circle">';
    }
        else{
            echo "vos données sont corrompus";
        }
    
    
    }?></map>

</body>
</html>