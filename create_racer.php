<?php include 'db.php';
$sql = "SELECT * FROM racers";
$result = $pdo->query($sql);

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Racer Aanmaken</title>
    <link rel="stylesheet" type="text/css" href="style.css"> <!-- Link to your CSS file -->
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">

<h1>Racer Aanmaken</h1>
    <form action="process_racer.php" method="POST">
        <label for="rugnummer">Rugnummer:</label>
        <input type="text" id="rugnummer" name="rugnummer" required><br>

        <label for="voornaam">Voornaam:</label>
        <input type="text" id="voornaam" name="voornaam" required><br>

        <label for="achternaam">Achternaam:</label>
        <input type="text" id="achternaam" name="achternaam" required><br>

        <label for="geslacht">Geslacht:</label>
        <select id="geslacht" name="geslacht" required>
            <option value="M">Man</option>
            <option value="V">Vrouw</option>
        </select><br>

        <label for="geboortejaar">Geboortejaar:</label>
        <input type="number" id="geboortejaar" name="geboortejaar" required><br>

        <label for="categorie">Categorie:</label>

        <select id="categorie" name="categorie" required>
            <option value="U8">U8</option>
            <option value="U10">U10</option>
            <option value="U12">U12</option>
            <option value="U14">U14</option>
            <option value="U16">U16</option>
            <option value="U18">U18</option>
            <option value="U21">U21</option>
        </select><br>

        <input type="submit" value="Opslaan">
    </form>
    <a href="index.php">Terug naar overzicht</a>

    <h2>Racers Table</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Rugnummer</th>
            <th>Voornaam</th>
            <th>Achternaam</th>
            <th>Geslacht</th>
            <th>Geboortejaar</th>
            <th>Categorie</th>
        </tr>
        <?php
        if ($result) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["rugnummer"] . "</td>";
                echo "<td>" . $row["voornaam"] . "</td>";
                echo "<td>" . $row["achternaam"] . "</td>";
                echo "<td>" . $row["geslacht"] . "</td>";
                echo "<td>" . $row["geboortejaar"] . "</td>";
                echo "<td>" . $row["categorie"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "0 results";
        }
        ?>
    </table>
    <script src="script.js"></script> <!-- Link to your JavaScript file -->
    
</div>
    
<footer>
    <p>&copy; <?php echo date("Y"); ?> Skiteam Hoofddorp</p>
</footer>

</body>


</html>


