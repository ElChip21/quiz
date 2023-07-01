<?php
require_once '../model/quiz.php';

class QuizController {
  public function getAllQuizzes() {
      try {
          // Récupération de l'objet PDO
          $db = connect();
  
          // Requête pour récupérer tous les abos
          $quizQuery=$db->query('SELECT * FROM quiz LIMIT 10');
  
          // Renvoie tous les lignes
          return $quizQuery->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
          // En cas d'erreur afficher le message
          echo $e->getMessage();
      }
  }
  

  public function getQuizById($id_quiz) {
    try {
      // Récupération de l'objet PDO
      $db = connect();

      // Requête pour récupérer tous les abos
      $QuizIdQuery=$db->query('SELECT * FROM quiz WHERE id_quiz = :id_quiz');

      // Renvoie tous les lignes
      return $QuizIdQuery->fetchAll(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
      // En cas d'erreur afficher le message
      echo $e->getMessage();
  }
}
  

  public function add_edit_quiz($titre_quiz, $description_quiz) {
    
      if (!empty($_POST)) {
        $titre_quiz = $_POST['titre_quiz'] ?? '';
        $description_quiz = $_POST['description_quiz'] ?? '';
        
    
        // Connection à la BDD avec la fonction connect() dans functions.php
        $db = connect();
    
        // Une catégorie n'a un ID que si ses infos sont déjà enregistrées en BDD, donc on vérifie s'il  la catégorie a un ID.
        if (empty($_POST['id_quiz'])) {
             // S'il n'y a pas d'ID, la catégorie n'existe pas dans la BDD donc on l'ajoute.
             try {
                // Préparation de la requête d'insertion.
                $createQuizStmt = $db->prepare('INSERT INTO quiz (titre_quiz, description_quiz) VALUES (:titre_quiz, :description_quiz)');
                // Exécution de la requête
                $createQuizStmt->execute(['titre_quiz'=>$titre_quiz, 'description_quiz'=>$description_quiz]);
                // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
                if ($createQuizStmt->rowCount()) {
                    // Une ligne a été insérée => message de succès
                    $type = 'success';
                    $message = 'Quiz ajouté';
                } else {
                    // Aucune ligne n'a été insérée => message d'erreur
                    $type = 'error';
                    $message = 'Quiz non ajouté';
                }
            } catch (Exception $e) {
                // La catégorie n'a pas été ajouté, récupération du message de l'exception
                $type = 'error';
                $message = 'Quiz non ajouté: ' . $e->getMessage();
            } 
          
   
           } else {
      // La catégorie existe, on met à jour ses informations
  
      // Récupération de l'ID de la catégorie
      $id = filter_input(INPUT_POST, 'id_quiz', FILTER_SANITIZE_NUMBER_INT);
  
      // Mise à jour des informations de la catégorie
      try {
          // Préparation de la requête de mis à jour
          $updateQuizStmt = $db->prepare('UPDATE quiz SET titre_quiz=:titre_quiz, description_quiz=:description_quiz WHERE id_quiz=:id_quiz');
          // Exécution de la requête
         $updateQuizStmt->execute(['titre_quiz'=>$titre_quiz, 'description_quiz'=>$description_quiz, 'id_quiz'=>$id]);
          // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
          if ($updateQuizStmt->rowCount()) {
              // Une ligne a été mise à jour => message de succès
              $type = 'success';
              $message = 'Quiz mis à jour';
          } else {
              // Aucune ligne n'a été mise à jour => message d'erreur
              $type = 'error';
              $message = 'Quiz non mis à jour';
          }
      } catch (Exception $e) {
          // Une exception a été lancée, récupération du message de l'exception
          $type = 'error';
          $message = 'Quiz non mis à jour: ' . $e->getMessage();
      }
      // Fermeture des connexions à la BDD
  $createQuizStmt = null;
  $updateQuizStmt = null;
  $db = null;
  }
      } 
          }
  



  public function deleteQuiz($id_quiz) {
   

    // Code pour supprimer une question existante de la base de données ou tout autre moyen

    
    
    // L'ID est-il dans les paramètres d'URL?
    if (isset($_GET['id'])) {
    
        // Récupérer $id depuis l'URL
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
        try {
            // Connection à la BDD avec la fonction connect() dans functions.php
            $db = connect();
    
            // Préparation de la requête pour supprimer la catégorie correspondant à l'id
            $deleteQuizStmt = $db->prepare('DELETE FROM quiz WHERE id_quiz=:id_quiz');
            // Execution de la requête
            $deleteQuizStmt->execute(['id_quiz' => $id]);
        
            // Vérification qu'une ligne a été impactée avec rowCount()
            if ($deleteQuizStmt->rowCount()) {
                // La ligne a été détruite, on envoie un message de succès
                $type = 'success';
                $message = 'Quiz supprimé';
            } else {
                // Aucune ligne n'a été impactée, on envoie un message d'erreur
                $type = 'error';
                $message = 'Quiz non supprimé';
            }
    
        } catch (Exception $e) {
            // Une exception a été levée, on affiche le message d'erreur
            $type = 'error';
            $message = 'Exception message: ' . $e->getMessage();
        }
        // Fermeture de la connexion à la BDD
        $deleteQuizStmt = null;
        $db = null;
    

  }

}
  }

?>