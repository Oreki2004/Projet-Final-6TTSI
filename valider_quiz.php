<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "urd");

if($mysqli === false){
    die("ERREUR : Impossible de se connecter. " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = 0;
    foreach ($_POST as $question_number => $answer_id) {
        $question_number = str_replace('question_', '', $question_number); // Retirer le préfixe 'question_' pour obtenir le numéro de question
        $query = "SELECT id FROM quiz_option WHERE id = $answer_id AND id_question = $question_number";
        $sqli = $mysqli->prepare($query);
        $sqli->bind_param("ii", $answer_id, $question_number);
        $sqli->execute();
        $resultat = $sqli->get_result();
        if ($resultat->num_rows > 0) {
            $score++;
        }
    }

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        $user_id = $_SESSION['id']; 
        $insert_query = "INSERT INTO score (user_id, score) VALUES (?, ?)";
        $sqli = $mysqli->prepare($insert_query);
        $sqli->bind_param("ii", $user_id, $score);
        if ($sqli->execute()) {
            echo "Quiz soumis avec succès ! Votre score : $score";
        } else {
            echo "Erreur lors de la soumission du quiz.";
        }
    } else {
        echo "Veuillez vous connecter pour soumettre le quiz.";
    }
}
?>
