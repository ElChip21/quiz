<?php
require_once __DIR__ . '/../database/connect.php';

class QuizController {
    private $db;

    public function __construct() {
        $this->db = new DatabaseConnection();
    }

    public function getAllQuizzes() {
        try {
            $pdo = $this->db->getPDO();
            $quizQuery = $pdo->query('SELECT * FROM quiz LIMIT 10');
            return $quizQuery->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la récupération des quiz: ' . $e->getMessage());
        }
    }

    public function getQuizById($id_quiz) {
        try {
            $pdo = $this->db->getPDO();
            $quizIdQuery = $pdo->prepare('SELECT * FROM quiz WHERE id_quiz = :id_quiz');
            $quizIdQuery->execute(['id_quiz' => $id_quiz]);
            return $quizIdQuery->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la récupération du quiz: ' . $e->getMessage());
        }
    }

   

    public function add_edit_question($titre_quiz, $description_quiz) {
        // Code pour ajouter ou mettre à jour une question
        if (!empty($_POST)) {
            $pdo = $this->db->getPDO();

            // Vérifier l'action demandée
            if (empty($_POST['id'])){ 
            // Vérifier l'action demandée
           
                    // Code pour ajouter un nouveau quiz
                    try {
                        // Préparation de la requête d'insertion.
                        $createQuizStmt = $pdo->prepare('INSERT INTO quiz (titre_quiz, description_quiz) VALUES (:titre_quiz, :description_quiz)');
                        // Exécution de la requête
                        $createQuizStmt->execute(['titre_quiz' => $titre_quiz, 'description_quiz' => $description_quiz]);
                        // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
                        if ($createQuizStmt->rowCount()) {
                            // Une ligne a été insérée => message de succès
                            $type = 'success';
                            $message = 'Quiz ajoutée';
                        } else {
                            // Aucune ligne n'a été insérée => message d'erreur
                            $type = 'error';
                            $message = 'Quiz non ajoutée';
                        }
                    } catch (Exception $e) {
                        // La question n'a pas été ajoutée, récupération du message de l'exception
                        $type = 'error';
                        $message = 'Quiz non ajoutée: ' . $e->getMessage();
                    }
                    

                }else{ 
                    // Code pour modifier une question existante
                    
                        // Récupération de l'ID de la question
                        $id = $_POST['id_quiz'];

                        try {
                            // Préparation de la requête de mise à jour
                            $updateQuizStmt = $pdo->prepare('UPDATE quiz SET titre_quiz=:titre_quiz, description_quiz=:description_quiz WHERE id_quiz=:id_quiz');
                            // Exécution de la requête
                            $updateQuizStmt->execute(['titre_quiz' => $titre_quiz, 'description_quiz' => $description_quiz, 'id_quiz' => $id]);
                            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
                            if ($updateQuizStmt->rowCount()) {
                                // Une ligne a été mise à jour => message de succès
                                $type = 'success';
                                $message = 'Quiz mise à jour';
                            } else {
                                // Aucune ligne n'a été mise à jour => message d'erreur
                                $type = 'error';
                                $message = 'Quiz non mise à jour';
                            }
                        } catch (Exception $e) {
                            // Une exception a été lancée, récupération du message de l'exception
                            $type = 'error';
                            $message = 'Quiz non mise à jour: ' . $e->getMessage();
                        }
                    }
                   
                }else{
                
                    // Action non valide
                    $type = 'error';
                    $message = 'Action non valide';
                  
            }
        }
    


    public function deleteQuiz($id_quiz) {
        // L'ID est-il dans les paramètres d'URL ?
        if (isset($_GET['id_quiz'])) {
            // Récupérer $id_quiz depuis l'URL
            $id_quiz = filter_input(INPUT_GET, 'id_quiz', FILTER_SANITIZE_NUMBER_INT);

            try {
                $pdo = $this->db->getPDO();
                // Préparation de la requête pour supprimer le quiz correspondant à l'id
                $deleteQuizStmt = $pdo->prepare('DELETE FROM quiz WHERE id_quiz=:id_quiz');
                // Exécution de la requête
                $deleteQuizStmt->execute(['id_quiz' => $id_quiz]);

                // Vérification qu'une ligne a été impactée avec rowCount()
                if ($deleteQuizStmt->rowCount()) {
                    // La ligne a été supprimée, on envoie un message de succès
                    $type = 'success';
                    $message = 'Quiz supprimé';
                } else {
                    // Aucune ligne n'a été supprimée, on envoie un message d'erreur
                    $type = 'error';
                    $message = 'Quiz non supprimé';
                }
            } catch (Exception $e) {
                // Une exception a été levée, lancer une exception pour être gérée plus tard
                throw new Exception('Erreur lors de la suppression du quiz: ' . $e->getMessage());
            }

            // Fermeture de la connexion à la BDD (facultatif dans le contexte actuel car vous n'avez pas ouvert la connexion ici)
            $deleteQuizStmt = null;
        }
    }
}
?>
