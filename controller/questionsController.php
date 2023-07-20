<?php
require_once __DIR__ . '/../database/connect.php';
class QuestionsController {
    private $db;

    public function __construct() {
        $this->db = new DatabaseConnection();
    }

    public function getAllQuestions() {
        try {
            $pdo = $this->db->getPDO();
            $questionsQuery = $pdo->query('SELECT * FROM questions LIMIT 10');
            return $questionsQuery->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la récupération des questions: ' . $e->getMessage());
        }
    }

    public function getQuestionById($id) {
        try {
            $pdo = $this->db->getPDO();
            $questionIdQuery = $pdo->prepare('SELECT * FROM questions WHERE id = :id');
            $questionIdQuery->execute(['id' => $id]);
            return $questionIdQuery->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la récupération de la question: ' . $e->getMessage());
        }
    }

    public function add_edit_question($questionTexte, $questionType) {
        // Code pour ajouter ou mettre à jour une question
        if (!empty($_POST)) {
            $pdo = $this->db->getPDO();

            // Vérifier l'action demandée
            if (empty($_POST['id'])){ 
            
                    // Code pour ajouter une nouvelle question
                    try {
                        // Préparation de la requête d'insertion.
                        $createQuestionStmt = $pdo->prepare('INSERT INTO questions (question_texte, question_type) VALUES (:question_texte, :question_type)');
                        // Exécution de la requête
                        $createQuestionStmt->execute(['question_texte' => $questionTexte, 'question_type' => $questionType]);
                        // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
                        if ($createQuestionStmt->rowCount()) {
                            // Une ligne a été insérée => message de succès
                            $type = 'success';
                            $message = 'Question ajoutée';
                            return true;
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
                   

            }else{ 
                    // Code pour modifier une question existante
                    
                        // Récupération de l'ID de la question
                        $id = $_POST['id'];

                        try {
                            // Préparation de la requête de mise à jour
                            $updateQuestionStmt = $pdo->prepare('UPDATE questions SET question_texte=:question_texte, question_type=:question_type WHERE id=:id');
                            // Exécution de la requête
                            $updateQuestionStmt->execute(['question_texte' => $questionTexte, 'question_type' => $questionType, 'id' => $id]);
                            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
                            if ($updateQuestionStmt->rowCount()) {
                                // Une ligne a été mise à jour => message de succès
                                $type = 'success';
                                $message = 'Question mise à jour'; 
                                return true;
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
                    

             
                   
            }else{ 
                 // Action non valide
            
                 $type = 'error';
                 $message = 'Les champs ne sont remplis';
            }
        }
    

    public function deleteQuestion($id) {
        // Code pour supprimer une question existante de la base de données ou tout autre moyen
        // L'ID est-il dans les paramètres d'URL?
        if (isset($_GET['id'])) {
            // Récupérer $id depuis l'URL
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

            try {
                $pdo = $this->db->getPDO();
                // Préparation de la requête pour supprimer la catégorie correspondant à l'id
                $deleteQuestionStmt = $pdo->prepare('DELETE FROM questions WHERE id=:id');
                // Execution de la requête
                $deleteQuestionStmt->execute(['id' => $id]);

                // Vérification qu'une ligne a été impactée avec rowCount()
                if ($deleteQuestionStmt->rowCount()) {
                    // La ligne a été détruite, on envoie un message de succès
                    $type = 'success';
                    $message = 'Question supprimée';
                } else {
                    // Aucune ligne n'a été impactée, on envoie un message d'erreur
                    $type = 'error';
                    $message = 'Question non supprimée';
                }
            } catch (Exception $e) {
                // Une exception a été levée, on affiche le message d'erreur
                $type = 'error';
                $message = 'Exception message: ' . $e->getMessage();
            }
        }
    }
}
?>
