<?php
session_start();
require_once '../controller/quizController.php';
require_once __DIR__ . '/../database/connect.php';


$quizController = new QuizController();

$quiz = $quizController->getAllQuizzes();

?>

<?php require_once 'header.php' ?>

<a href='home.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='view_quiz.php' class='btn btn-secondary m-2 active' role='button'>Quiz</a>
<a href='view_questions.php' class='btn btn-secondary m-2 active' role='button'>Questions</a>
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
    <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>Quizs</h1>
</div>
<div class='row'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>titre</th>
                <th scope='col'>description</th>
      
            </tr>
        </thead>
        <tbody>
        <?php foreach ($quiz as $quizs) : ?>
           
                <td><?= $quizs['id_quiz'] ?></td>
                <td><?= htmlentities($quizs['titre_quiz']) ?></td>
                <td><?= htmlentities($quizs['description_quiz']) ?></td>
           
                <td>
                   
                <a class='btn btn-primary' href='controller/quizController.php?id=<?= add_edit_quiz() ?>' role='button'>Modifier</a>
                <a class='btn btn-primary' href='controller/quizController.php?id=<?=  deleteQuiz() ?>' role='button'>Supprimer</a>
                   
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class='row'>
    <div class='col'>
        
            <a class='btn btn-success'  href='addQuiz.php' role='button'>Ajouter un quiz</a>
      
    </div>
</div>

<?php require_once 'footer.php'; ?>
