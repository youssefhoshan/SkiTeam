<?php
include 'db.php'; // Include the database connection file

// Define an associative array to hold the response data
$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $rugnummer = $_POST["rugnummer"];
    $voornaam = $_POST["voornaam"];
    $achternaam = $_POST["achternaam"];
    $geslacht = $_POST["geslacht"];
    $geboortejaar = $_POST["geboortejaar"];
    $categorie = $_POST["categorie"];

    // SQL query to insert the racer into the database
    $sql = "INSERT INTO racers (rugnummer, voornaam, achternaam, geslacht, geboortejaar, categorie)
            VALUES (:rugnummer, :voornaam, :achternaam, :geslacht, :geboortejaar, :categorie)";

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':rugnummer' => $rugnummer,
            ':voornaam' => $voornaam,
            ':achternaam' => $achternaam,
            ':geslacht' => $geslacht,
            ':geboortejaar' => $geboortejaar,
            ':categorie' => $categorie
        ]);

        // Set success response
        $response["success"] = true;
    } catch (PDOException $e) {
        // Set error response with message
        $response["success"] = false;
        $response["message"] = "Error: " . $e->getMessage();
    }
} else {
    // Invalid request method
    // Set error response with message
    $response["success"] = false;
    $response["message"] = "Invalid request method";
}

// Send JSON response
header("Content-type: application/json");
echo json_encode($response);


?>
