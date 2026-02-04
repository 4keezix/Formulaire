<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Maintenance Applicative</title>
</head>

<body>
    <h1>Maintenance Applicative Basile Parrain</h1>

    <?php
    $tirage = null;
    if ($_POST) {
        $valeurs = array_filter($_POST);
        if ($valeurs) {
            $tirage = array_rand(array_flip($valeurs));
            echo htmlspecialchars($tirage);

            try {
                $pdo = new PDO(
                    'mysql:host=db;dbname=formulaire;charset=utf8',
                    'user',
                    'password'
                );
                $stmt = $pdo->prepare("INSERT INTO tirages (choix, date_heure) VALUES (?, NOW())");
                $stmt->execute([$tirage]);
            } catch (PDOException $e) {
                echo "<br>Erreur BDD : " . htmlspecialchars($e->getMessage());
            }
        }
    }
    ?>

    <form method="post">
        <input type="text" name="champ1" placeholder="Champ 1"><br>
        <input type="text" name="champ2" placeholder="Champ 2"><br>
        <input type="text" name="champ3" placeholder="Champ 3"><br>
        <input type="text" name="champ4" placeholder="Champ 4"><br>
        <input type="text" name="champ5" placeholder="Champ 5"><br>
        <input type="text" name="champ6" placeholder="Champ 6"><br>
        <input type="text" name="champ7" placeholder="Champ 7"><br>
        <input type="text" name="champ8" placeholder="Champ 8"><br>
        <input type="text" name="champ9" placeholder="Champ 9"><br>
        <input type="text" name="champ10" placeholder="Champ 10"><br>
        <br>
        <button type="submit">Tirer au sort</button>
    </form>
    <p>Crée par Basile Parrain ensuite modifier par :</p>
    <ul>
        <li>Mamadou</li>
        <li>Amen</li>
        <li>Léo</li>
        <li>tom</li>
        <li>Eden</li>
    </ul>
</body>

</html>