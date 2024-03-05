<?php
include_once("config.php");
include_once("GaS.php"); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["deleteUserID"]) && !empty($_POST["deleteUserID"])) {
       
        $userID = $_POST["deleteUserID"];

        
        $userTask = new UserTask();

      
        $userTask->set_userId($userID);

        
        $userID = $userTask->get_userId();

        
        $sql = "DELETE FROM tblTask WHERE userId = ?";

        
        $stmt = $conn->prepare($sql);

        
        $stmt->bind_param("i", $userID);

        
        if ($stmt->execute()) {
            
            header("Location: dashboard.php");
        exit();
            


        } else {
            // Deletion failed
            echo "Error deleting record: " . $conn->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // If deleteUserID is not set or empty, display an error message
        echo "Error: userID not specified";
    }
} else {
    // If the form is not submitted via POST method, redirect to the main page or perform any other action
    header("Location: dashboard.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
