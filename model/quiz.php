<?php
class Quiz {
  private $idQuiz;
  private $titreQuiz;
  private $descriptionQuiz;

  public function __construct($titreQuiz, $descriptionQuiz) {
    $this->titreQuiz = $titreQuiz;
    $this->descriptionQuiz = $descriptionQuiz;
  }

  // Getters
  public function getIdQuiz() {
    return $this->idQuiz;
  }

  public function getTitreQuiz() {
    return $this->titreQuiz;
  }

  public function getDescriptionQuiz() {
    return $this->descriptionQuiz;
  }

  // Setters
  public function setIdQuiz($idQuiz) {
    $this->idQuiz = $idQuiz;
  }

  public function setTitreQuiz($titreQuiz) {
    $this->titreQuiz = $titreQuiz;
  }

  public function setDescriptionQuiz($descriptionQuiz) {
    $this->descriptionQuiz = $descriptionQuiz;
  }
}
?>