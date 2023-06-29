<?php
require_once '../model/quiz.php';

class QuizController {
  public function getAllQuizzes() {
    // Code pour récupérer tous les quizzes depuis la base de données et retourner un tableau d'objets Quiz
  }

  public function getQuizById($idQuiz) {
    // Code pour récupérer un quiz spécifique à partir de son ID depuis la base de données et retourner un objet Quiz correspondant
  }

  public function createQuiz($titreQuiz, $descriptionQuiz) {
    // Code pour créer un nouveau quiz dans la base de données et retourner l'objet Quiz créé
  }

  public function updateQuiz($idQuiz, $titreQuiz, $descriptionQuiz) {
    // Code pour mettre à jour un quiz existant dans la base de données et retourner l'objet Quiz mis à jour
  }

  public function deleteQuiz($idQuiz) {
    // Code pour supprimer un quiz existant de la base de données 
  }
}
?>