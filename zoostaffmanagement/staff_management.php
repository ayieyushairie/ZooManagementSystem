<?php
include 'db.php'; // Include the database connection

// Handle adding staff
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $department = $_POST['department'];
    $salary = $_POST['salary'];
    $contact = $_POST['contact'];
    $hire_date = $_POST['hire_date'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO staff (name, role, department, salary, contact, hire_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdsd", $name, $role, $department, $salary, $contact, $hire_date);

    if ($stmt->execute()) {
        echo "New staff member added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle deletion
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Use prepared statements for deletion
    $stmt = $conn->prepare("DELETE FROM staff WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Staff member deleted successfully.";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch all staff
$sql = "SELECT * FROM staff";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Staff Management</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Zoo Staff Management</h1>

    <!-- Add Staff Form -->
    <h2>Add New Staff</h2>
    <form method="POST" action="staff_management.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="role">Role:</label>
        <input type="text" id="role" name="role" required><br>

        <label for="department">Department:</label>
        <input type="text" id="department" name="department" required><br>

        <label for="salary">Salary:</label>
        <input type="number" id="salary" name="salary" step="0.01" required><br>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact"><br>

        <label for="hire_date">Hire Date:</label>
        <input type="date" id="hire_date" name="hire_date" required><br>

        <button type="submit" name="add">Add Staff</button>
    </form>

    <!-- Staff List -->
    <h2>Staff List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Role</th>
            <th>Department</th>
            <th>Salary</th>
            <th>Contact</th>
            <th>Hire Date</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['role']}</td>
                    <td>{$row['department']}</td>
                    <td>{$row['salary']}</td>
                    <td>{$row['contact']}</td>
                    <td>{$row['hire_date']}</td>
                    <td>
                        <form method='POST' action='edit_staff.php' style='display:inline;'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <button type='submit'>Edit</button>
                        </form>
                        <form method='POST' action='staff_management.php' style='display:inline;'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <button type='submit' name='delete'>Delete</button>
                        </form>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No staff members found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
