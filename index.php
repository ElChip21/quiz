<?php


require_once 'model/questions.php';
require_once 'model/quiz.php';
require_once 'controller/questionsController.php';
require_once 'controller/quizController.php';


$type = $_GET['type'] ?? '';


$questionsController = new QuestionsController();
$quizController = new QuizController();


switch ($type) {
    case 'questions':
       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         
            switch ($_POST['action']) {
                case 'add':
                 
                    $questionText = $_POST['question_texte'] ?? '';
                    $questionType = $_POST['question_type'] ?? '';
                    $questionsController->addQuestion($questionText, $questionType);
                    break;

                case 'edit':
                    
                    $questionText = $_POST['question_texte'] ?? '';
                    $questionType = $_POST['question_type'] ?? '';
                    $questionsController->editQuestion($questionText, $questionType);
                    break;

                case 'delete':
                 
                    $id = $_POST['id'];
                    $questionsController->deleteQuestion($id);
                    break;

                default:
                    
                    break;
            }

         
            header('Location: index.php?type=questions');
            exit();
        } else {
           
            $allQuestions = $questionsController->getAllQuestions();
        }
        break;

    case 'quiz':
        
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

<body>
    <?php if ($type === 'questions'): ?>
        <h2>List des questions</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Type</th>
            </tr>
            <?php foreach ($allQuestions as $question): ?>
                <tr>
                    <td><?= $question->id ?></td>
                    <td><?= $question->question_text ?></td>
                    <td><?= $question->question_type ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <?php if ($type === 'quiz'): ?>
        <h2>Liste de tous les quizs!</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Description</th>
            </tr>
            <?php foreach ($allQuizzes as $quiz): ?>
                <tr>
                    <td><?= $quiz->id_quiz ?></td>
                    <td><?= $quiz->titre_quiz ?></td>
                    <td><?= $quiz->description_quiz ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
