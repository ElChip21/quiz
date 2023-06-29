<?php
class QuizQuestion {
  private $quizId;
  private $questionId;

  public function __construct($quizId, $questionId) {
    $this->quizId = $quizId;
    $this->questionId = $questionId;
  }

  // Getters
  public function getQuizId() {
    return $this->quizId;
  }

  public function getQuestionId() {
    return $this->questionId;
  }

  // Setters
  public function setQuizId($quizId) {
    $this->quizId = $quizId;
  }

  public function setQuestionId($questionId) {
    $this->questionId = $questionId;
  }
}
?>