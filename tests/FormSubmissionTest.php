<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PDO;

class FormSubmissionTest extends TestCase
{
    private ?PDO $pdo = null;

    protected function setUp(): void
    {
        $this->pdo = new PDO(
            'mysql:host=db;dbname=formulaire;charset=utf8',
            'user',
            'password',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        $this->pdo->exec("DELETE FROM tirages WHERE choix LIKE 'TEST_%'");
    }

    protected function tearDown(): void
    {
        $this->pdo->exec("DELETE FROM tirages WHERE choix LIKE 'TEST_%'");
        $this->pdo = null;
    }

    public function testFormSubmissionInsertsInDatabase(): void
    {
        $_POST = ['champ1' => 'TEST_Option1', 'champ2' => 'TEST_Option2', 'champ3' => ''];

        ob_start();
        include __DIR__ . '/../index.php';
        ob_get_clean();

        $stmt = $this->pdo->query("SELECT * FROM tirages WHERE choix LIKE 'TEST_%'");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($row);
        $this->assertContains($row['choix'], ['TEST_Option1', 'TEST_Option2']);

        $_POST = [];
    }
}
