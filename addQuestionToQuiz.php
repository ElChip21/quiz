
<?php

// Import des fonctions
require_once 'database/connect.php';
require_once 'controller/questionsController.php';
require_once 'index.php';

// Pour éviter de dupliquer le code, ce formulaire sera utiliser pour créer ou modifier un membre. Si l'url est appelée avec id= alors nous l'utiliserons pour éditer le membre avec l'id spécifié. 
if (isset($_GET['id'])) {
    // récupérer $id dans les paramètres d'URL
    $id_categorie = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Charger les informations du membre depuis la BDD pour remplir le formulaire
    try {
        // Se connecter à la BDD avec la fonction connect() définie dans functions.php
        $db = connect();

        // Préparer $categorieQuery pour récupérer les informations du membre
        $questionQuery = $db->prepare('SELECT * FROM questions WHERE id= :id');
        // Exécuter la requête
        $questionQuery->execute(['id' => $id]);
        // Récupérer les données et les assigner à $member
        $questions = $questionQuery->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Afficher le message s'il y a une exception
        echo $e->getMessage();
    }
    // Fermer la connection à la BDD
    $questionQuery=null;
    $db=null;
}

?>

<?php require_once 'view/header.php';?>
<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='categories.php' class='btn btn-secondary m-2 active' role='button'>Questions</a>

<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Ajout d'une question</h1>
</div>
<div class='row'>
    <form method='post' action='controller/questionsController.php'>
        <!--  Ajouter the ID to the form if it exists but make the field hidden -->
        <input type='hidden' name='id' value='<?= $questions['id'] ?? '' ?>'>
        <div class='form-group my-3'>
            <label for='question_texte'>Votre question : </label>
            <input type='text' name='question_texte' class='form-control' id='question_texte' placeholder='Votre question : ' required autofocus value='<?= isset($questions['question_texte']) ? htmlentities($questions['question_texte']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='description_categorie'>Type de la question</label>
            <input type='text' name='question_type' class='form-control' id='question_type' placeholder='Type de la question' required value='<?= isset($questions['question_type']) ? htmlentities($questions['question_type'])  : '' ?>'>
        </div>
            </select>
        </div>
        <div class='form-group my-3'>
    <button type='submit' class='btn btn-primary my-3' name='action' value='add'>Ajouter</button>
    
</div>
  
    </form>
</div>