<?php
require_once '../database/connect.php';
require_once '../controller/questionsController.php';
require_once '../model/questions.php';

$questionController = new QuestionsController();

// Pour éviter de dupliquer le code, ce formulaire sera utilisé pour créer ou modifier une question. Si l'URL est appelée avec id= alors nous l'utiliserons pour éditer la question avec l'id spécifié. 
if (isset($_GET['id'])) {
    // Récupérer $id dans les paramètres d'URL
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Charger les informations de la question depuis la BDD pour remplir le formulaire
    try {
        $question = $questionController->getQuestionById($id);
    } catch (Exception $e) {
        // Afficher le message s'il y a une exception
        echo $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $question_texte = $_POST['question_texte'] ?? '';
        $question_type = $_POST['question_type'] ?? '';

        try {
            $questionController->addEditQuestion($question_texte, $question_type, 'add');
        } catch (Exception $e) {
            // Gérer l'exception si nécessaire
            echo $e->getMessage();
        }
    }
}
?>

<?php require_once 'header.php'; ?>
<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='../view_questions.php' class='btn btn-secondary m-2 active' role='button'>Questions</a>

<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Ajout d'une question</h1>
</div>
<div class='row'>
    <form method='post' action='addQuestionToQuiz.php'>
        <!-- Ajouter l'ID à formulaire s'il existe, mais le champ doit rester caché -->
        <input type='hidden' name='id' value='<?= $question['id'] ?? '' ?>'>
        <div class='form-group my-3'>
            <label for='question_texte'>Votre question :</label>
            <input type='text' name='question_texte' class='form-control' id='question_texte' placeholder='Votre question : ' required autofocus value='<?= isset($question['question_texte']) ? htmlentities($question['question_texte']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='question_type'>Type de la question</label>
            <input type='text' name='question_type' class='form-control' id='question_type' placeholder='Type de la question' required value='<?= isset($question['question_type']) ? htmlentities($question['question_type'])  : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <button type='submit' class='btn btn-primary my-3' name='action' value='add'>Ajouter</button>
        </div>
    </form>
</div>
