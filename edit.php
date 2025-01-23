<?php
include 'db.php'; // Include the database connection

// Fetch the record to be edited
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM adoptions WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
} else {
    die("No ID provided for editing.");
}

// Handle form submission for updating the record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $animalName = $_POST['animalName'];
    $adopterName = $_POST['adopterName'];
    $monthlyFee = $_POST['monthlyFee'];

    $sql = "UPDATE adoptions SET animal_name='$animalName', adopter_name='$adopterName', monthly_fee='$monthlyFee' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Adoption record updated successfully";
        header("Location: index.html"); // Redirect back to the main page
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Adoption Record</title>
</head>
<body>
    <h1>Edit Adoption Record</h1>
    <form method="POST" action="edit.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="animalName">Animal Name:</label>
        <input type="text" id="animalName" name="animalName" value="<?php echo $row['animal_name']; ?>" required>

        <label for="adopterName">Your Name:</label>
        <