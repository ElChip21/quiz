<?php
require_once 'database/connect.php';
require_once 'model/questions.php';
require_once 'model/quiz.php';
require_once 'controller/questionsController.php';
require_once 'controller/quizController.php';

// On vérifie si la clé 'type' existe dans le tableau $_GET
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Instancier les contrôleurs
$questionsController = new QuestionsController();
$quizController = new QuizController();

// Gérer les requêtes en fonction du type demandé
switch ($type) {
    case 'questions':
        // Ajouter ou modifier une question
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id'])) {
                $questionId = $_POST['id'];

                // Vérifier l'action demandée
                switch ($_POST['action']) {
                    case 'add':
                        // Récupérer les données du formulaire
                        $questionTexte = $_POST['question_texte'] ?? '';
                        $questionType = $_POST['question_type'] ?? '';

                        // Ajouter la question dans la base de données
                        $questionsController->add_edit_question($questionTexte, $questionType, 'add');
                        break;

                    case 'edit':
                        // Récupérer les données du formulaire
                        $questionTexte = $_POST['question_texte'] ?? '';
                        $questionType = $_POST['question_type'] ?? '';

                        // Modifier la question dans la base de données
                        $questionsController->add_edit_question($questionTexte, $questionType, 'edit');
                        break;

                    case 'delete':
                        // Supprimer la question de la base de données
                        $questionsController->deleteQuestion($id);
                        break;

                    default:
                        // Action invalide
                        break;
                }

                header('Location: index.php?type=questions');
                exit();
            }
        }

        // Afficher toutes les questions
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $allQuestions = $questionsController->getAllQuestions();
        }
        break;

    case 'quiz':
        // Afficher tous les quiz
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $allQuizzes = $quizController->getAllQuizzes();
        }
        break;

    default:
        break;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mon Application</title>
  
</head>
<body>
    <?php if ($type === 'questions'): ?>
        <h2>Liste des questions :</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Type</th>
            </tr>
            <?php foreach ($allQuestions as $question): ?>
                <tr>
                    <td><?= $question['id'] ?></td>
                    <td><?= $question['question_texte'] ?></td>
                    <td><?= $question['question_type'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <?php if ($type === 'quiz'): ?>
        <h2>Liste des quiz :</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Description</th>
            </tr>
            <?php foreach ($allQuizzes as $quiz): ?>
                <tr>
                    <td><?= $quiz['id_quiz'] ?></td>
                    <td><?= $quiz['titre_quiz'] ?></td>
                    <td><?= $quiz['description_quiz'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    

