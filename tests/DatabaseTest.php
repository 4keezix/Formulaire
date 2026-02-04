<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PDO;

class DatabaseTest extends TestCase
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

    public function testInsertTirage(): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO tirages (choix, date_heure) VALUES (?, NOW())");
        $stmt->execute(['TEST_Value']);

        $stmt = $this->pdo->prepare("SELECT * FROM tirages WHERE choix = ?");
        $stmt->execute(['TEST_Value']);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('TEST_Value', $row['choix']);
        $this->assertNotNull($row['date_heure']);
    }
}
