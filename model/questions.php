<?php
class Question {
  private $idQuestion;
  private $questionTexte;
  private $questionType;

  public function __construct($idQuestion, $questionTexte, $questionType) {
    $this->idQuestion = $idQuestion;
    $this->questionTexte = $questionTexte;
    $this->questionType = $questionType;
  }

  // Getters
  public function getIdQuestion() {
    return $this->idQuestion;
  }

  public function getQuestionTexte() {
    return $this->questionTexte;
  }

  public function getQuestionType() {
    return $this->questionType;
  }

  // Setters
  public function setIdQuestion($idQuestion) {
    $this->idQuestion = $idQuestion;
  }

  public function setQuestionTexte($questionTexte) {
    $this->questionTexte = $questionTexte;
  }

  public function setQuestionType($questionType) {
    $this->questionType = $questionType;
  }
}
?>