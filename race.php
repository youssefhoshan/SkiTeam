

<?php include 'db.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
// Include the database connection
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process racer selection
    if (isset($_POST['racer_id'])) {
        $racer_id = $_POST['racer_id'];
        // Display a form to record race times
        echo "<h2>Racer $racer_id</h2>";
        echo "<form method='post' action='race.php'>";
        echo "<input type='hidden' name='racer_id' value='$racer_id'>";
        for ($i = 1; $i <= 3; $i++) {
            echo "Time $i: <input type='number' name='time_$i' step='0.01'><br>";
        }
        echo "<input type='submit' value='Record Times'>";
        echo "</form>";
    }

    // Process race time recording
    elseif (isset($_POST['time_1']) && isset($_POST['time_2']) && isset($_POST['time_3'])) {
        $racer_id = $_POST['racer_id'];
        $time_1 = $_POST['time_1'];
        $time_2 = $_POST['time_2'];
        $time_3 = $_POST['time_3'];

        // Calculate the total time (sum of the two fastest times)
        $times = [$time_1, $time_2, $time_3];
        sort($times);
        $total_time = $times[0] + $times[1];

        try {
            // Insert the race data into the database
            $query = "INSERT INTO race_racers (race_id, racer_id, tijd, status) VALUES (?, ?, ?, 'OK')";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(1, $race_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $racer_id, PDO::PARAM_INT);
            $stmt->bindParam(3, $total_time, PDO::PARAM_STR);

            // Replace $race_id with the ID of the main race you want to associate the racer with
            $race_id = 1; // Change this to the actual race ID

            $stmt->execute();
            echo "<p>Race times recorded successfully!</p>";
        } catch (PDOException $e) {
            echo "Error recording race times: " . $e->getMessage();
        }
    }
}

// Fetch and display the list of racers to choose from
try {
    $result = $pdo->query("SELECT id, voornaam, achternaam FROM racers");
    if ($result->rowCount() > 0) {
        echo "<h2>Select a Racer:</h2>";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<p>";
            echo "{$row['voornaam']} {$row['achternaam']} ";
            echo "<form method='post' action='race.php'>";
            echo "<input type='hidden' name='racer_id' value='{$row['id']}'>";
            echo "<input type='submit' value='Start Race'>";
            echo "</form>";
            echo "</p>";
        }
    } else {
        echo "No racers found in the database.";
    }
} catch (PDOException $e) {
    echo "Error fetching racers: " . $e->getMessage();
}

?>



    
</body>
</html>



