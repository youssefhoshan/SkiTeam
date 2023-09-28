<?php
// Include the database connection
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Haal de geselecteerde race ID op
    $race_id = $_POST['race_id'];

    // Controleer of alle vereiste velden zijn ingevuld
    if (
        isset($_POST['racer_id']) &&
        isset($_POST['race_format']) &&
        isset($_POST['time_1']) &&
        isset($_POST['time_2']) &&
        isset($_POST['time_3']) &&
        isset($_POST['run_num'])
    ) {
        $racer_id = $_POST['racer_id'];
        $race_format = $_POST['race_format'];
        $time_1 = $_POST['time_1'];
        $time_2 = $_POST['time_2'];
        $time_3 = $_POST['time_3'];
        $run_num = $_POST['run_num'];

        // Check of er een DSQ (Disqualification) is
        $status = 'OK';
        if ($time_1 == 'DSQ' || $time_2 == 'DSQ' || $time_3 == 'DSQ') {
            $status = 'DSQ';
        }

        // Bereken de totale tijd op basis van het wedstrijdformaat
        if ($race_format == '1') {
            $times = [$time_1, $time_2, $time_3];
            sort($times);
            $total_time = $times[0] + $times[1];
        } elseif ($race_format == '2') {
            $total_time = min($time_1, $time_2, $time_3);
        } elseif ($race_format == '3') {
            $total_time = $time_1 + $time_2 + $time_3;
        }

        try {
            // Voeg de racetijd toe aan de database
            $query = "INSERT INTO race_racers (race_id, racer_id, run_num, tijd, status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(1, $race_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $racer_id, PDO::PARAM_INT);
            $stmt->bindParam(3, $run_num, PDO::PARAM_INT);
            $stmt->bindParam(4, $total_time, PDO::PARAM_STR);
            $stmt->bindParam(5, $status, PDO::PARAM_STR);

            $stmt->execute();
            echo "<script>alert('Race times recorded successfully!');</script>";
        } catch (PDOException $e) {
            echo "Error recording race times: " . $e->getMessage();
        }
    } else {
        echo "Niet alle vereiste velden zijn ingevuld.";
    }
}

// Haal de lijst met racers op
try {
    $racers = $pdo->query("SELECT id, voornaam, achternaam FROM racers");
} catch (PDOException $e) {
    echo "Fout bij het ophalen van racers: " . $e->getMessage();
}

// Haal de lijst met races op
try {
    $races = $pdo->query("SELECT id, naam FROM races");
} catch (PDOException $e) {
    echo "Fout bij het ophalen van races: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Race Formulier</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

    <h1>Race Formulier</h1>
    <form method="post" action="verwerk_gegevens.php">
        <label for="racer_id">Selecteer een Racer:</label>
        <select name="racer_id" id="racer_id">
            <?php foreach ($racers as $racer): ?>
                <option value="<?= $racer['id'] ?>"><?= $racer['voornaam'] . ' ' . $racer['achternaam'] ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="race_id">Selecteer een Race:</label>
        <select name="race_id" id="race_id">
            <?php foreach ($races as $race): ?>
                <option value="<?= $race['id'] ?>"><?= $race['naam'] ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="race_format">Wedstrijd Formaat:</label>
        <select name="race_format" id="race_format">
            <option value="1">Format 1</option>
            <option value="2">Format 2</option>
            <option value="3">Format 3</option>
        </select>
        <br>
        <label for="time_1">Tijd 1:</label>
        <input type="number" name="time_1" step="0.01" id="time_1"><br>
        <label for="time_2">Tijd 2:</label>
        <input type="number" name="time_2" step="0.01" id="time_2"><br>
        <label for="time_3">Tijd 3:</label>
        <input type="number" name="time_3" step="0.01" id="time_3"><br>
        <label for="run_num">Run Nummer:</label>
        <input type="number" name="run_num" value="1" id="run_num"><br>
        <input type="submit" value="Registreer Tijden">
    </form>
    
    <a href="index.php">Terug naar de homepage</a>

    </div>

        <?php include 'footer.php'; ?>
</body>
</html>
