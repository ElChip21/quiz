<?php


require_once 'model/questions.php';
require_once 'model/quiz.php';
require_once 'controller/questionsController.php';
require_once 'controller/quizController.php';


$type = $_GET['type'] ?? '';


$questionsController = new QuestionsController();
$quizController = new QuizController();
$allQuestions = $questionsController->getAllQuestions();
$allQuizzes = $quizController->getAllQuizzes();


switch ($type) {
    case 'questions':
       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         
            switch ($_POST['action']) {
                case 'add':
                    $id = $_POST['id'];
                    $questionText = $_POST['question_texte'] ?? '';
                    $questionType = $_POST['question_type'] ?? '';
                    $questionsController->add_edit_question($questionTexte, $questionType, 'add');
                    break;

                case 'edit':
                    $id = $_POST['id'];
                    $questionText = $_POST['question_texte'] ?? '';
                    $questionType = $_POST['question_type'] ?? '';
                    $questionsController->add_edit_question($questionTexte, $questionType, $action);
                    break;

                case 'delete':
                 
                    $id = $_POST['id'];
                    $questionsController->deleteQuestion($id);
                    break;

                default:
                    
                    break;
            }

         
        
            exit();
        } else {
           
            $allQuestions = $questionsController->getAllQuestions();
        }
        break;

    case 'quiz':
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
          
            $allQuizzes = $quizController->getAllQuizzes();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         
            switch ($_POST['action']) {
                case 'add':
                 
                    $titre_quiz = $_POST['titre_quiz'] ?? '';
                    $description_quiz = $_POST['description_quiz'] ?? '';
                    $quizController->add_edit_question($titre_quiz, $description_quiz, 'add');
                    break;

                case 'edit':
                    
                    $titre_quiz = $_POST['titre_quiz'] ?? '';
                    $description_quiz = $_POST['description_quiz'] ?? '';
                    $quizController->add_edit_question($titre_quiz, $description_quiz, 'edit');
                    break;

                case 'delete':
                 
                    $id = $_POST['id_quiz'];
                    $questionsController->deleteQuestion($id);
                    break;

                default:
                    
                    break;
            }

         
        
            exit();
        }
        break;

    default:
      
        break;
}
?>
<?php require_once 'view/header.php'; ?> 
<!DOCTYPE html>
<html>

<body>
  
        <h2>List des questions</h2>        
        <h2> <a class='btn btn-primary' href='view/addQuestionToQuiz.php' role='button'>Ajouter une question</a> </h2>

        <table>
            <tr>
            
                <th>ID</th>
                <th>Question</th>
                <th>Type</th>
            </tr>
            <?php foreach ($allQuestions as $question): ?>
                <tr>
         <td><?= $question['id'] ?></td>
         <td><?= htmlentities($question['question_texte']) ?></td>
         <td><?= htmlentities($question['question_type']) ?></td>

                </tr>
            <?php endforeach; ?>
        </table>
   

    
        <h2>Liste de tous les quizs!</h2>
        <h2> <a class='btn btn-primary' href='view/addQuiz.php' role='button'>Ajouter un Quiz</a> </h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Description</th>
            </tr>
            <?php foreach ($allQuizzes as $quiz): ?>
                <tr>
                <td><?= $quiz['id_quiz'] ?></td>
         <td><?= htmlentities($quiz['titre_quiz']) ?></td>
         <td><?= htmlentities($quiz['description_quiz']) ?></td>
                  
                </tr>
            <?php endforeach; ?>
        </table>
</body>
</html>
