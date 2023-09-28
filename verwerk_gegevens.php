

<?php
// Include the database connection
include 'db.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Controleer of alle vereiste velden zijn ingevuld
    if (
        isset($_POST['racer_id']) &&
        isset($_POST['race_id']) &&
        isset($_POST['run_num']) &&
        isset($_POST['time_1']) &&
        isset($_POST['time_2']) &&
        isset($_POST['time_3']) &&
        isset($_POST['race_format'])
    ) {
        $racer_id = $_POST['racer_id'];
        $race_id = $_POST['race_id'];
        $run_num = $_POST['run_num'];
        $time_1 = $_POST['time_1'];
        $time_2 = $_POST['time_2'];
        $time_3 = $_POST['time_3'];
        $race_format = $_POST['race_format'];

        // Controleer of er een DSQ (Disqualification) is
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
            echo "<p>Race times recorded successfully!</p>";
        } catch (PDOException $e) {
            echo "Error recording race times: " . $e->getMessage();
        }
    } else {
        echo "Niet alle vereiste velden zijn ingevuld.";
    }
} else {
    echo "Dit script is alleen toegankelijk via een POST-verzoek.";
}
?>
