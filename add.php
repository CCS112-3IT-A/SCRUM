<?php
include_once("config.php");
include_once("GaS.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create a new UserTask object
    $task = new UserTask();

    // Set properties using the setter methods
    $name = $_POST['name'];
    $taskName = $_POST['taskName'];
    $dueDate = $_POST['dueDate'];
    $taskStatus = $_POST['taskStatus'];
    $taskDescription = $_POST['taskDescription'];

    $task->set_name($name);
    $task->set_taskname($taskName);
    $task->set_duedate($dueDate);
    $task->set_taskstatus($taskStatus);
    $task->set_Description($taskDescription);

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO tblTask (name, taskName, dueDate, taskStatus, taskDescription) VALUES (?, ?, ?, ?, ?)");

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sssss", $name, $taskName, $dueDate, $taskStatus, $taskDescription);

    // Execute prepared statement
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit(); 
    } else {
        echo "Error: " . $conn->error;
    }

    
    $stmt->close();
}


$conn->close();
?>
