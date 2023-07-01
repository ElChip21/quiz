<?php
class Quiz {
  private $id_quiz;
  private $titreQuiz;
  private $descriptionQuiz;

  public function __construct($titreQuiz, $descriptionQuiz) {
    $this->titreQuiz = $titreQuiz;
    $this->descriptionQuiz = $descriptionQuiz;
  }

  // Getters
  public function getIdQuiz() {
    return $this->id_quiz;
  }

  public function getTitreQuiz() {
    return $this->titreQuiz;
  }

  public function getDescriptionQuiz() {
    return $this->descriptionQuiz;
  }

  // Setters
  public function setIdQuiz($id_quiz) {
    $this->id_quiz = $id_quiz;
  }

  public function setTitreQuiz($titreQuiz) {
    $this->titreQuiz = $titreQuiz;
  }

  public function setDescriptionQuiz($descriptionQuiz) {
    $this->descriptionQuiz = $descriptionQuiz;
  }
}
?>