<?php
include_once("config.php");
include_once("GaS.php"); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create a new UserTask object
    $task = new UserTask();

    // Set properties using setter methods
    $userId = $_POST["updateUserID"];
    $name = $_POST["updateName"];
    $taskName = $_POST["updateTaskName"];
    $dueDate = $_POST["updateDueDate"];
    $taskStatus = $_POST["updateTaskStatus"];
    $taskDescription = $_POST["updateTaskDescription"];


    $task->set_userId($userId);
    $task->set_name($name);
    $task->set_taskname($taskName);
    $task->set_duedate($dueDate);
    $task->set_taskstatus($taskStatus);
    $task->set_Description($taskDescription);

    // Update the row in the database
    $sql = "UPDATE tblTask SET 
            name = '{$task->get_name()}', 
            taskName = '{$task->get_taskname()}', 
            dueDate = '{$task->get_duedate()}', 
            taskStatus = '{$task->get_taskstatus()}', 
            taskDescription = '{$task->get_Description()}'
            WHERE userID = '{$task->get_userId()}'";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the page where the update was made successfully
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
