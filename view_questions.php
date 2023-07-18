<?php
session_start();
require_once 'controller/questionsController.php';
require_once "/database/connect.php";

$question = getAllQuestions();

?>

<?php require_once 'header.php' ?>

<a href='home.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
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
    <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>Questions</h1>
</div>
<div class='row'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>question_texte</th>
                <th scope='col'>question_type</th>
      
            </tr>
        </thead>
        <tbody>
        <?php foreach ($question as $questions) : ?>
           
                <td><?= $questions['id_question'] ?></td>
                <td><?= htmlentities($questions['question_texte']) ?></td>
                <td><?= htmlentities($questions['question_type']) ?></td>
           
                <td>
                   
                <a class='btn btn-primary' href='controller/questionsController.php?id=<?= add_edit_question() ?>' role='button'>Modifier</a>
                <a class='btn btn-primary' href='controller/questionsController.php?id=<?= deleteQuestion() ?>' role='button'>Supprimer</a>
                   
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class='row'>
    <div class='col'>
        
            <a class='btn btn-success'  href='controller/questionsController.php?id=<?= add_edit_question() ?> ' role='button'>Ajouter une question</a>
      
    </div>
</div>

<?php require_once 'footer.php'; ?>
