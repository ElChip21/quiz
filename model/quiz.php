<?php
class Quiz {
  private $id_quiz;
  private $titre_quiz;
  private $description_quiz;

  public function __construct($titre_quiz, $description_quiz) {
    $this->titre_quiz = $titre_quiz;
    $this->description_quiz = $description_quiz;
  }

  // Getters
  public function getIdQuiz() {
    return $this->id_quiz;
  }

  public function getTitreQuiz() {
    return $this->titre_quiz;
  }

  public function getDescriptionQuiz() {
    return $this->description_quiz;
  }

  // Setters
  public function setIdQuiz($id_quiz) {
    $this->id_quiz = $id_quiz;
  }

  public function setTitreQuiz($titre_quiz) {
    $this->titre_quiz = $titre_quiz;
  }

  public function setDescriptionQuiz($description_quiz) {
    $this->description_quiz = $description_quiz;
  }
}
?>