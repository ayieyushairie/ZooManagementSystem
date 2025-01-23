<?php
include 'db.php'; // Include the database connection

// Handle form submission for new adoption
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['adopt'])) {
    $animalName = $_POST['animalName'];
    $adopterName = $_POST['adopterName'];
    $monthlyFee = $_POST['monthlyFee'];

    // Insert adoption record
    $sql = "INSERT INTO adoptions (animal_name, adopter_name, monthly_fee) VALUES ('$animalName', '$adopterName', '$monthlyFee')";
    if ($conn->query($sql) === TRUE) {
        echo "New adoption record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle deletion of an adoption record
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM adoptions WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Adoption record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch adoption records
$sql = "SELECT * FROM adoptions";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Animal: " . $row["animal_name"]. " - Adopter: " . $row["adopter_name"]. " - Monthly Fee: " . $row["monthly_fee"]. " 
        <form method='POST' action='edit.php' style='display:inline;'>
            <input type='hidden' name='id' value='" . $row["id"] . "'>
            <input type='submit' value='Edit'>
        </form>
        <form method='POST' action='adoption.php' style='display:inline;'>
            <input type='hidden' name='id' value='" . $row["id"] . "'>
            <input type='submit' name='delete' value='Delete'>
        </form><br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>