<?php
class Question {
  private $id;
  private $questionTexte;
  private $questionType;

  public function __construct($questionTexte, $questionType) {
    $this->questionTexte = $questionTexte;
    $this->questionType = $questionType;
  }

  // Getters
  public function getIdQuestion() {
    return $this->id;
  }

  public function getQuestionTexte() {
    return $this->questionTexte;
  }

  public function getQuestionType() {
    return $this->questionType;
  }

  // Setters
  public function setIdQuestion($id) {
    $this->id = $id;
  }

  public function setQuestionTexte($questionTexte) {
    $this->questionTexte = $questionTexte;
  }

  public function setQuestionType($questionType) {
    $this->questionType = $questionType;
  }
}
?>