<?php
require_once __DIR__ . '/../database/connect.php';
require_once '../controller/quizController.php';
require_once '../model/questions.php';

$quizController = new QuizController();

// Pour éviter de dupliquer le code, ce formulaire sera utilisé pour créer ou modifier un quiz. Si l'URL est appelée avec id= alors nous l'utiliserons pour éditer la question avec l'id spécifié. 
if (isset($_GET['id'])) {
    // Récupérer $id dans les paramètres d'URL
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Charger les informations de la question depuis la BDD pour remplir le formulaire
    try {
        $quiz = $quizController->getQuizById($id_quiz);
    } catch (Exception $e) {
        // Afficher le message s'il y a une exception
        echo $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $titre_quiz = $_POST['titre_quiz'] ?? '';
        $description_quiz = $_POST['description_quiz'] ?? '';

        try {
            $quizController->add_edit_question($titre_quiz, $description_quiz, 'add');
        } catch (Exception $e) {
            // Gérer l'exception si nécessaire
            echo $e->getMessage();
        }
    }
}
?>

<?php require_once 'header.php'; ?>
<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='view/view_quiz.php' class='btn btn-secondary m-2 active' role='button'>Quizs</a>

<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Ajout d'un quiz</h1>
</div>
<div class='row'>
    <form method='post' action='addQuiz.php'>
        <!-- Ajouter l'ID à formulaire s'il existe, mais le champ doit rester caché -->
        <input type='hidden' name='id' value='<?= $question['id'] ?? '' ?>'>
        <div class='form-group my-3'>
            <label for='question_texte'>Votre nouveau quiz :</label>
            <input type='text' name='titre_quiz' class='form-control' id='titre_quiz' placeholder='Votre Nouveau quiz : ' required autofocus value='<?= isset($quiz['titre_quiz']) ? htmlentities($quiz['titre_quiz']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='question_type'>Description de votre quiz :</label>
            <input type='text' name='description_quiz' class='form-control' id='description_quiz' placeholder='Description de votre quiz :' required value='<?= isset($quiz['description_quiz']) ? htmlentities($quiz['description_quiz'])  : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <button type='submit' class='btn btn-primary my-3' name='action' value='add'>Ajouter</button>
        </div>
    </form>
</div>
