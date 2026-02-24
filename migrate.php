<?php

$pdo = new PDO(
    'mysql:host=db;dbname=formulaire;charset=utf8',
    'user',
    'password',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// Charger le JSON
$json = json_decode(file_get_contents('migrations.json'), true);
$migrations = $json['migrations'];

// Récupérer les migrations déjà exécutées
$stmt = $pdo->query("SELECT id FROM migrations");
$executed = $stmt->fetchAll(PDO::FETCH_COLUMN);

// exec init migration
$pdo->exec($migration[0]);

// exec other migrations
foreach ($migrations as $migration) {

    $id = $migration['id'];

    // Déjà exécutée ?
    if (in_array($id, $executed)) {
        echo "Migration déjà exécutée : $id\n";
        continue;
    }

    echo "Exécution de la migration : $id\n";

    // Exécuter toutes les requêtes SQL de cette migration
    foreach ($migration['sql'] as $sql) {
        try {
            $pdo->exec($sql);
        } catch (PDOException $e) {
            echo "Erreur dans la migration $id : " . $e->getMessage() . "\n";
            exit;
        }
    }

    // Enregistrer la migration comme exécutée
    $stmt = $pdo->prepare("INSERT INTO migrations (id, executed_at) VALUES (?, NOW())");
    $stmt->execute([$id]);

    echo "Migration exécutée avec succès : $id\n";
}

echo "Toutes les migrations sont à jour.\n";
