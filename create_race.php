<?php
// Include the database connection
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $race_naam = $_POST['race_naam'];
    $wedstrijd_format = $_POST['wedstrijd_format'];
    $datum = $_POST['datum'];

    try {
        // Voeg de racegegevens toe aan de database
        $query = "INSERT INTO races (naam, wedstijd_format, datum) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $race_naam, PDO::PARAM_STR);
        $stmt->bindParam(2, $wedstrijd_format, PDO::PARAM_STR);
        $stmt->bindParam(3, $datum, PDO::PARAM_STR);

        $stmt->execute();
        echo "<p>Race aangemaakt!</p>";
    } catch (PDOException $e) {
        echo "Fout bij het aanmaken van de race: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Race Aanmaken</title>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <h1>Race Aanmaken</h1>
    <form method="POST" action="create_race.php">
        <label for="race_naam">Naam race:</label>
        <input type="text" name="race_naam" required><br>
        <label for="wedstrijd_format">Wedstrijd format:</label>
        <select name="wedstrijd_format">
            <option value="1">Format 1</option>
            <option value="2">Format 2</option>
            <option value="3">Format 3</option>
        </select><br>
        <label for="datum">Datum:</label>
        <input type="date" name="datum" required><br>
        <input type="submit" value="Maak Race">
    </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
