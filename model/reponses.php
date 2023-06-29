<?php
class Reponse {
  private $reponseId;
  private $quizId;
  private $questionId;
  private $reponse;

  public function __construct($reponseId, $quizId, $questionId, $reponse) {
    $this->reponseId = $reponseId;
    $this->quizId = $quizId;
    $this->questionId = $questionId;
    $this->reponse = $reponse;
  }

  // Getters
  public function getReponseId() {
    return $this->reponseId;
  }

  public function getQuizId() {
    return $this->quizId;
  }

  public function getQuestionId() {
    return $this->questionId;
  }

  public function getReponse() {
    return $this->reponse;
  }

  // Setters
  public function setReponseId($reponseId) {
    $this->reponseId = $reponseId;
  }

  public function setQuizId($quizId) {
    $this->quizId = $quizId;
  }

  public function setQuestionId($questionId) {
    $this->questionId = $questionId;
  }

  public function setReponse($reponse) {
    $this->reponse = $reponse;
  }
}
?>