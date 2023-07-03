<?php
use PHPUnit\Framework\TestCase;

class QuizControllerTest extends TestCase {
    public function testGetAllQuizzes() {
        // Création d'un double du PDO pour simuler la connexion à la base de données
        $dbMock = $this->createMock(PDO::class);
        // Définition du comportement attendu pour la méthode query()
        $dbMock->expects($this->once())
            ->method('query')
            ->with('SELECT * FROM quiz LIMIT 10')
            ->willReturn($this->returnValue(true));

        $quizController = new QuizController();
        // Injection du double du PDO dans la classe QuizController
        $quizController->setDB($dbMock);

        // Appel de la méthode à tester
        $result = $quizController->getAllQuizzes();

        // Vérification du résultat
        $this->assertTrue($result);
    }

    public function testGetQuizById() {
        // Création d'un double du PDO pour simuler la connexion à la base de données
        $dbMock = $this->createMock(PDO::class);
        // Définition du comportement attendu pour la méthode query()
        $dbMock->expects($this->once())
            ->method('query')
            ->with('SELECT * FROM quiz WHERE id_quiz = :id_quiz')
            ->willReturn($this->returnValue(true));

        $quizController = new QuizController();
        // Injection du double du PDO dans la classe QuizController
        $quizController->setDB($dbMock);

        // Appel de la méthode à tester
        $result = $quizController->getQuizById(1);

        // Vérification du résultat
        $this->assertTrue($result);
    }

    public function testAddEditQuiz() {
        // Création d'un double du PDO pour simuler la connexion à la base de données
        $dbMock = $this->createMock(PDO::class);
        // Définition du comportement attendu pour la méthode prepare()
        $dbMock->expects($this->once())
            ->method('prepare')
            ->willReturn($this->returnValue(true));

        $quizController = new QuizController();
        // Injection du double du PDO dans la classe QuizController
        $quizController->setDB($dbMock);

        // Appel de la méthode à tester
        $result = $quizController->add_edit_quiz('Titre', 'Description');

        // Vérification du résultat
        $this->assertNotNull($result);
    }

    public function testDeleteQuiz() {
        // Création d'un double du PDO pour simuler la connexion à la base de données
        $dbMock = $this->createMock(PDO::class);
        // Définition du comportement attendu pour la méthode prepare()
        $dbMock->expects($this->once())
            ->method('prepare')
            ->willReturn($this->returnValue(true));

        $quizController = new QuizController();
        // Injection du double du PDO dans la classe QuizController
        $quizController->setDB($dbMock);

        // Appel de la méthode à tester
        $result = $quizController->deleteQuiz(1);

        // Vérification du résultat
        $this->assertNotNull($result);
    }
}