<?php
include 'db.php';

// Fetch the record to edit
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Use prepared statements to fetch the record safely
    $stmt = $conn->prepare("SELECT * FROM staff WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
} else {
    die("No ID provided for editing.");
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $department = $_POST['department'];
    $salary = $_POST['salary'];
    $contact = $_POST['contact'];
    $hire_date = $_POST['hire_date'];

    // Use prepared statements for the update query to prevent SQL injection
    $stmt = $conn->prepare("UPDATE staff SET name = ?, role = ?, department = ?, salary = ?, contact = ?, hire_date = ? WHERE id = ?");
    $stmt->bind_param("sssdsdi", $name, $role, $department, $salary, $contact, $hire_date, $id);

    if ($stmt->execute()) {
        echo "Staff member updated successfully.";
        header("Location: staff_management.php"); // Redirect after update
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff</title>
</head>
<body>
    <h1>Edit Staff Details</h1>
    <form method="POST" action="edit_staff.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required><br>

        <label for="role">Role:</label>
        <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($row['role']); ?>" required><br>

        <label for="department">Department:</label>
        <input type="text" id="department" name="department" value="<?php echo htmlspecialchars($row['department']); ?>" required><br>

        <label for="salary">Salary:</label>
        <input type="number" id="salary" name="salary" value="<?php echo $row['salary']; ?>" step="0.01" required><br>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($row['contact']); ?>"><br>

        <label for="hire_date">Hire Date:</label>
        <input type="date" id="hire_date" name="hire_date" value="<?php echo $row['hire_date']; ?>" required><br>

        <button type="submit" name="update">Update Staff</button>
    </form>
</body>
</html>
