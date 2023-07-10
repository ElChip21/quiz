

<?php
require_once 'model/quiz.php';
require_once 'database/connect.php';

class QuizController {
    private $db;

    public function setDB($db) {
        $this->db = $db;
    }

    public function getAllQuizzes() {
        try {
            // Requête pour récupérer tous les quiz
            $quizQuery = $this->db->query('SELECT * FROM quiz LIMIT 10');
    
            // Renvoie toutes les lignes
            return $quizQuery->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // En cas d'erreur, lancer une exception pour être gérée plus tard
            throw new Exception('Erreur lors de la récupération des quiz: ' . $e->getMessage());
        }
    }

    public function getQuizById($id_quiz) {
        try {
            // Requête pour récupérer le quiz par son ID
            $quizIdQuery = $this->db->prepare('SELECT * FROM quiz WHERE id_quiz = :id_quiz');
            $quizIdQuery->execute(['id_quiz' => $id_quiz]);
    
            // Renvoie la première ligne trouvée
            return $quizIdQuery->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // En cas d'erreur, lancer une exception pour être gérée plus tard
            throw new Exception('Erreur lors de la récupération du quiz: ' . $e->getMessage());
        }
    }

    public function addEditQuiz($titre_quiz, $description_quiz) {
        if (!empty($_POST)) {
            $type = '';
            $message = '';

            // Un quiz n'a un ID que si ses infos sont déjà enregistrées en BDD, donc on vérifie s'il le quiz a un ID.
            if (empty($_POST['id_quiz'])) {
                // S'il n'y a pas d'ID, le quiz n'existe pas dans la BDD donc on l'ajoute.
                try {
                    // Préparation de la requête d'insertion.
                    $createQuizStmt = $this->db->prepare('INSERT INTO quiz (titre_quiz, description_quiz) VALUES (:titre_quiz, :description_quiz)');
                    // Exécution de la requête
                    $createQuizStmt->execute(['titre_quiz' => $titre_quiz, 'description_quiz' => $description_quiz]);
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
                    // Le quiz n'a pas été ajouté, lancer une exception pour être gérée plus tard
                    throw new Exception('Erreur lors de l\'ajout du quiz: ' . $e->getMessage());
                } 
            } else {
                // Le quiz existe, on met à jour ses informations

                // Récupération de l'ID du quiz
                $id = filter_input(INPUT_POST, 'id_quiz', FILTER_SANITIZE_NUMBER_INT);

                // Mise à jour des informations du quiz
                try {
                    // Préparation de la requête de mise à jour
                    $updateQuizStmt = $this->db->prepare('UPDATE quiz SET titre_quiz=:titre_quiz, description_quiz=:description_quiz WHERE id_quiz=:id_quiz');
                    // Exécution de la requête
                    $updateQuizStmt->execute(['titre_quiz' => $titre_quiz, 'description_quiz' => $description_quiz, 'id_quiz' => $id]);
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
                    // Une exception a été lancée, lancer une exception pour être gérée plus tard
                    throw new Exception('Erreur lors de la mise à jour du quiz: ' . $e->getMessage());
                }
            }

            // Fermeture de la connexion à la BDD (facultatif dans le contexte actuel car vous n'avez pas ouvert la connexion ici)
            $createQuizStmt = null;
            $updateQuizStmt = null;
        }
    }

    public function deleteQuiz($id_quiz) {
        // L'ID est-il dans les paramètres d'URL ?
        if (isset($_GET['id_quiz'])) {
            // Récupérer $id_quiz depuis l'URL
            $id_quiz = filter_input(INPUT_GET, 'id_quiz', FILTER_SANITIZE_NUMBER_INT);

            try {
                // Préparation de la requête pour supprimer le quiz correspondant à l'id
                $deleteQuizStmt = $this->db->prepare('DELETE FROM quiz WHERE id_quiz=:id_quiz');
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
