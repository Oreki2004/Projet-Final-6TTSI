<?php
session_start();
// Connexion à la base de données
$mysqli = new mysqli("localhost", "root", "", "urd");

// Vérification de la connexion
if ($mysqli->connect_error) {
    die("La connexion à la base de données a échoué : " . $mysqli->connect_error);
}

// Récupération du score actuel du joueur
$joueur = $_SESSION['pseudo']; // Remplacez "Nom du joueur" par le nom du joueur
$query_select_score = "SELECT score FROM score_quiz WHERE joueur = '$joueur'";
$result_select_score = $mysqli->query($query_select_score);

if ($result_select_score) {
    // Si le joueur existe dans la base de données
    if ($result_select_score->num_rows > 0) {
        $row = $result_select_score->fetch_assoc();
        $score_joueur = $row['score'];

        // Calcul du score actuel
        $score_actuel = 0;
        $reponses_utilisateur = isset($_POST['reponses']) ? $_POST['reponses'] : array();
        foreach ($reponses_utilisateur as $id_question => $reponse_utilisateur) {
            $query = "SELECT est_correcte FROM quiz_reponse WHERE id = $reponse_utilisateur";
            $result = $mysqli->query($query);
            if ($result) {
                $row = $result->fetch_assoc();
                if ($row['est_correcte']) {
                    $score_actuel++;
                }
            }
        }

        // Mise à jour du score si nécessaire
        if ($score_actuel > $score_joueur) {
            $query_update_score = "UPDATE score_quiz SET score = $score_actuel WHERE joueur = '$joueur'";
            $result_update_score = $mysqli->query($query_update_score);
            if ($result_update_score) {
                echo "Ton score actuel est de ".$score_actuel;
            } else {
                echo "Erreur lors de la mise à jour du score : " . $mysqli->error;
            }
        } else {
            echo "Ton score actuel est de ".$score_actuel.", tu peux faire mieux.";
        }
    } else {
        // Si le joueur n'existe pas dans la base de données, on insère son score
        // Calcul du score actuel
        $score_actuel = 0;
        $reponses_utilisateur = isset($_POST['reponses']) ? $_POST['reponses'] : array();
        foreach ($reponses_utilisateur as $id_question => $reponse_utilisateur) {
            $query = "SELECT est_correcte FROM quiz_reponse WHERE id = $reponse_utilisateur";
            $result = $mysqli->query($query);
            if ($result) {
                $row = $result->fetch_assoc();
                if ($row['est_correcte']) {
                    $score_actuel++;
                }
            }
        }

        // Insertion du score
        $query_insert_score = "INSERT INTO score_quiz (joueur, score) VALUES ('$joueur', $score_actuel)";
        $result_insert_score = $mysqli->query($query_insert_score);
        if ($result_insert_score) {
            echo "Score inséré avec succès.";
        } else {
            echo "Erreur lors de l'insertion du score : " . $mysqli->error;
        }
    }
} else {
    echo "Erreur lors de la récupération du score : " . $mysqli->error;
}

// Fermeture de la connexion à la base de données
$mysqli->close();
?>
