<?php
session_start();
require_once '../controller/questionsController.php';
require_once __DIR__ . '/../database/connect.php';




$questionsController = new QuestionsController();
$id= (!empty($_GET['id']))?$_GET['id']:0;
$question = $questionsController->getAllQuestions();
if (!empty($_GET['action']) && ($_GET['action'] === 'delete')) $questionsController->deleteQuestion($id);



?>

<?php require_once 'header.php' ?>

<a href='home.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='view_questions.php' class='btn btn-secondary m-2 active' role='button'>Questions</a>
<a href='view_quiz.php' class='btn btn-secondary m-2 active' role='button'>Quizs</a>

<?php if (!empty($_GET['type']) && ($_GET['type'] === 'success')) : ?>
    <div class='row'>
        <div class='alert alert-success'>             
            Succès! <?= $_GET['message'] ?>
        </div>
    </div>
<?php elseif (!empty($_GET['type']) && ($_GET['type'] === 'error')) : ?>
    <div class='row'>
        <div class='alert alert-danger'>
            Erreur! <?= $_GET['message'] ?>
        </div>
    </div>
<?php endif; ?>
<div class='row'>
    <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>Questions</h1>
</div>
<div class='row'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>question</th>
                <th scope='col'>Type de la question</th>
      
            </tr>
        </thead>
        <tbody>
        <?php foreach ($question as $questions) : ?>
           
                <td><?= $questions['id'] ?></td>
                <td><?= htmlentities($questions['question_texte']) ?></td>
                <td><?= htmlentities($questions['question_type']) ?></td>
           
                <td>
                <a class='btn btn-primary' href='addQuestionToQuiz.php?id=<?= $questions['id'] ?>' role='button'>Modifier</a>
               
                <a class='btn btn-primary' href='view_questions.php?id=<?= $questions['id'] ?>&action=delete' role='button'>Supprimer</a>
                   
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class='row'>
    <div class='col'>
        
            <a class='btn btn-success'  href='addQuestionToQuiz.php' role='button'>Ajouter une question</a>
      
    </div>
</div>

<?php require_once 'footer.php'; ?>
