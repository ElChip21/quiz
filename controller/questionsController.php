<?php
require_once 'model/questions.php';
require_once 'database/connect.php';
class QuestionsController {
  
  
  
    public function getAllQuestions() {
      try {
          // Récupération de l'objet PDO
          $db = connect();
  
          // Requête pour récupérer tous les abos
          $questionsQuery=$db->query('SELECT * FROM questions LIMIT 10');
  
          // Renvoie tous les lignes
          return $questionsQuery->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
          // En cas d'erreur afficher le message
          echo $e->getMessage();
      }
  }
  public function getQuestionById($id) {
    // Code pour récupérer une question spécifique à partir de son ID depuis la base de données ou tout autre moyen
    // et retourner un objet Question correspondant
      try {
          // Récupération de l'objet PDO
          $db = connect();
  
          // Requête pour récupérer tous les abos
          $QuestionIdQuery=$db->query('SELECT * FROM questions WHERE id = :id');
  
          // Renvoie tous les lignes
          return $QuestionIdQuery->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
          // En cas d'erreur afficher le message
          echo $e->getMessage();
      }
  }
  

  

    


        public function add_edit_question($questionTexte, $questionType, $action) {
            // Code pour créer une nouvelle question dans la base de données ou tout autre moyen
            // et retourner l'objet Question créé
        
            if (!empty($_POST) && $action !== '') {
                $db = connect();
        
                // Vérifier l'action demandée
                switch ($action) {
                    case 'add':
                        // Code pour ajouter une nouvelle question
                        try {
                            // Préparation de la requête d'insertion.
                            $createQuestionStmt = $db->prepare('INSERT INTO questions (question_texte, question_type) VALUES (:question_texte, :question_type)');
                            // Exécution de la requête
                            $createQuestionStmt->execute(['question_texte' => $questionTexte, 'question_type' => $questionType]);
                            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
                            if ($createQuestionStmt->rowCount()) {
                                // Une ligne a été insérée => message de succès
                                $type = 'success';
                                $message = 'Question ajoutée';
                            } else {
                                // Aucune ligne n'a été insérée => message d'erreur
                                $type = 'error';
                                $message = 'Question non ajoutée';
                            }
                        } catch (Exception $e) {
                            // La question n'a pas été ajoutée, récupération du message de l'exception
                            $type = 'error';
                            $message = 'Question non ajoutée: ' . $e->getMessage();
                        }
                        break;
        
                    case 'edit':
                        // Code pour modifier une question existante
                        if (!empty($_POST['id'])) {
                            // Récupération de l'ID de la question
                            $id = $_POST['id'];
        
                            try {
                                // Préparation de la requête de mise à jour
                                $updateQuestionStmt = $db->prepare('UPDATE questions SET question_texte=:question_texte, question_type=:question_type WHERE id=:id');
                                // Exécution de la requête
                                $updateQuestionStmt->execute(['question_texte' => $questionTexte, 'question_type' => $questionType, 'id' => $id]);
                                // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
                                if ($updateQuestionStmt->rowCount()) {
                                    // Une ligne a été mise à jour => message de succès
                                    $type = 'success';
                                    $message = 'Question mise à jour';
                                } else {
                                    // Aucune ligne n'a été mise à jour => message d'erreur
                                    $type = 'error';
                                    $message = 'Question non mise à jour';
                                }
                            } catch (Exception $e) {
                                // Une exception a été lancée, récupération du message de l'exception
                                $type = 'error';
                                $message = 'Question non mise à jour: ' . $e->getMessage();
                            }
                        }
                        break;
        
                    default:
                        // Action non valide
                        $type = 'error';
                        $message = 'Action non valide';
                        break;
                }
                $createQuestionStmt = null;
                $updateQuestionStmt = null;
                $db = null;
            }
        }
        
  public function deleteQuestion($id) {
    // Code pour supprimer une question existante de la base de données ou tout autre moyen

    
    
    // L'ID est-il dans les paramètres d'URL?
    if (isset($_GET['id'])) {
    
        // Récupérer $id depuis l'URL
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
        try {
            // Connection à la BDD avec la fonction connect() dans functions.php
            $db = connect();
    
            // Préparation de la requête pour supprimer la catégorie correspondant à l'id
            $deleteQuestionStmt = $db->prepare('DELETE FROM questions WHERE id=:id');
            // Execution de la requête
            $deleteQuestionStmt->execute(['id' => $id]);
        
            // Vérification qu'une ligne a été impactée avec rowCount()
            if ($deleteQuestionStmt->rowCount()) {
                // La ligne a été détruite, on envoie un message de succès
                $type = 'success';
                $message = 'Question supprimé';
            } else {
                // Aucune ligne n'a été impactée, on envoie un message d'erreur
                $type = 'error';
                $message = 'Question non supprimé';
            }
    
        } catch (Exception $e) {
            // Une exception a été levée, on affiche le message d'erreur
            $type = 'error';
            $message = 'Exception message: ' . $e->getMessage();
        }
        // Fermeture de la connexion à la BDD
        $deleteQuestionStmt = null;
        $db = null;
    

  }

}
}
?>