

    

    <?php

require_once 'database/connect.php';
require_once 'model/questions.php';
require_once 'model/quiz.php';
require_once 'controller/questionsController.php';
require_once 'controller/quizController.php';

// Get the type of request
$type = $_GET['type'] ?? '';

// Initialize the controllers
$questionsController = new QuestionsController();
$quizController = new QuizController();

// Handle the request
switch ($type) {
    case 'questions':
        // Handle questions requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check the action
            switch ($_POST['action']) {
                case 'add':
                    // Add a question
                    $questionText = $_POST['question_texte'] ?? '';
                    $questionType = $_POST['question_type'] ?? '';
                    $questionsController->addQuestion($questionText, $questionType);
                    break;

                case 'edit':
                    // Edit a question
                    $questionText = $_POST['question_texte'] ?? '';
                    $questionType = $_POST['question_type'] ?? '';
                    $questionsController->editQuestion($questionText, $questionType);
                    break;

                case 'delete':
                    // Delete a question
                    $id = $_POST['id'];
                    $questionsController->deleteQuestion($id);
                    break;

                default:
                    // Invalid action
                    break;
            }

            // Redirect to the questions page
            header('Location: index.php?type=questions');
            exit();
        } else {
            // Get all questions
            $allQuestions = $questionsController->getAllQuestions();
        }
        break;

    case 'quiz':
        // Handle quiz requests
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Get all quizzes
            $allQuizzes = $quizController->getAllQuizzes();
        }
        break;

    default:
        // No matching type
        break;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Application</title>
</head>
<body>
    <?php if ($type === 'questions'): ?>
        <h2>List of questions</h2>
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
        <h2>List of quizzes</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
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
