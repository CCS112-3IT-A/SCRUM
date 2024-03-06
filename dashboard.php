<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="dashStyle.css">
    <script src="dashScript.js"></script>
    <script src="modal.js"></script>
</head>

<body>
<?php

include_once("config.php");
$result = mysqli_query($conn, "Select * From tblTask ");
?>

<div class="wrapper">
        <div class="sidebar">
            <ul>
                <li class="logo"><i class="fas fa-list-check"></i></li>
            </ul>
        </div>

        <div class="main_content">

            <div class="row stats-container">
                <div class="col s4">
                    <div class="card blue-grey darken-1 hoverable">
                        <div class="card-content white-text">
                            <span class="card-title">To-Do</span>
                            <p id="todo-count">0 tasks</p>
                        </div>
                    </div>
                </div>
                <div class="col s4">
                    <div class="card blue-grey darken-1 hoverable">
                        <div class="card-content white-text">
                            <span class="card-title">Pending</span>
                            <p id="pending-count">0 tasks</p>
                        </div>
                    </div>
                </div>
                <div class="col s4">
                    <div class="card blue-grey darken-1 hoverable">
                        <div class="card-content white-text">
                            <span class="card-title">Finished</span>
                            <p id="finished-count">0 tasks</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="search-container">
                <input type="text" id="searchInput" oninput="searchTask()" placeholder="Search Task Name...">
                <div class="input-field filter-dropdown">
                    <select class="filter-select">
                        <option value="" disabled selected>Filter By</option>
                        <option value="dueDate">Due Date</option>
                        <option value="status">Status</option>
                    </select>
                </div>
                <div class="input-field sort-dropdown">
                    <select class="sort-select" onchange="sortTasks()">
                        <option value="" disabled selected>Sort By</option>
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
            </div>

            <div class="action-buttons">
                <button id="AddModal" class="btn waves-effect waves-light modal-trigger" type="button" >Add Task</button>
            </div>

            <div class="table-container">
                <table id="task-table" class="highlight">
                    <thead>
                        <tr class="fixed-header">
                            <th>ID</th>
                            <th>name</th>
                            <th>Task Name</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['userId'] . "</td>"; 
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['taskName'] . "</td>";
                            echo "<td>" . $row['dueDate'] . "</td>";
                            echo "<td>" . $row['taskStatus'] . "</td>";
                            echo "<td>" . $row['taskDescription'] . "</td>";
                            echo "<td>";
                            echo "<button class='updateBtn' data-userid='" . $row['userId'] . "' data-name='" . htmlspecialchars($row['name']) . "' data-taskname='" . htmlspecialchars($row['taskName']) . "' data-duedate='" . htmlspecialchars($row['dueDate']) . "' data-taskstatus='" . htmlspecialchars($row['taskStatus']) . "' data-taskdescription='" . htmlspecialchars($row['taskDescription']) . "'>Update</button>";

                            echo "<button class='deleteBtn' data-userid='" . $row['userId'] . "'>Delete</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="addTaskModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New Task</h2>
            <form id="taskForm" action="add.php" method="post">
                <div class="input-field">
                    <input type="text" id="name" name="name" required>
                    <label for="name">Name</label>
                </div>
                <div class="input-field">
                    <input type="text" id="taskName" name="taskName" required>
                    <label for="taskName">Task Name</label>
                </div>
                <div class="input-field">
                    <input type="date" id="dueDate" name="dueDate" required>
                    <label for="dueDate">Due Date</label>
                </div>
                <div class="input-field">
                    <select id="taskStatus" name="taskStatus" required>
                        <option value="" disabled selected>Choose status</option>
                        <option value="pending">Pending</option>
                        <option value="inprogress">In Progress</option>
                    </select>
                    <label for="taskStatus">Task Status</label>
                </div>
                <div class="input-field">
                    <textarea id="taskDescription" name="taskDescription" class="materialize-textarea" required></textarea>
                    <label for="taskDescription">Task Description</label>
                </div>
                <button type="submit" class="waves-effect waves-light btn">Add Task</button>
            </form>
        </div>
    </div>


    <!-- UPDATE Task Modal -->
<div id="updateTaskModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeUpdateModal()">&times;</span>
        <h2>Update Task</h2>
        <form id="updateTaskForm" action="update.php" method="post">
                <div class="input-field">
                <input type="text" id="updateUserID" name="updateUserID" readonly>
                <label for="updateUserID">User ID</label>
            </div>
            <div class="input-field">
                <input type="text" id="updateName" name="updateName" required>
                <label for="updateName">Name</label>
            </div>
            <div class="input-field">
                <input type="text" id="updateTaskName" name="updateTaskName" required>
                <label for="updateTaskName">Task Name</label>
            </div>
            <div class="input-field">
                <input type="date" id="updateDueDate" name="updateDueDate" required>
                <label for="updateDueDate">Due Date</label>
            </div>
            <div class="input-field">
                <select id="updateTaskStatus" name="updateTaskStatus" required>
                    <option value="" disabled selected>Choose status</option>
                    <option value="pending">Pending</option>
                    <option value="inprogress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
                <label for="updateTaskStatus">Task Status</label>
            </div>
            <div class="input-field">
                <textarea id="updateTaskDescription" name="updateTaskDescription" class="materialize-textarea" required></textarea>
                <label for="updateTaskDescription">Task Description</label>
            </div>
            <button type="submit" class="waves-effect waves-light btn">Update Task</button>
        </form>
    </div>
</div>


<div id="deleteTaskModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDeleteModal()">&times;</span>
        <h2>Delete Task</h2>
        <p>Are you sure you want to delete this task?</p>
        <form id="deleteTaskForm" action="delete.php" method="post">
            
            <input type="hidden" id="deleteUserID" name="deleteUserID" value="">
            <button type="submit" class="waves-effect waves-light btn">Delete Task</button>
        </form>
    </div>
</div>






    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modals = document.querySelectorAll('.modal');
            M.Modal.init(modals);

            var addButton = document.getElementById('AddModal');
            var addTaskModal = document.getElementById('addTaskModal');
            var closeButtons = document.querySelectorAll('.close');

            addButton.addEventListener('click', function () {
                M.Modal.getInstance(addTaskModal).open();
            });

            closeButtons.forEach(function (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    M.Modal.getInstance(addTaskModal).close();
                });
            });
        });

        // Event listener to handle clicking the update button
document.addEventListener('DOMContentLoaded', function() {
    var updateButtons = document.querySelectorAll('.updateBtn');
    updateButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var userID = button.getAttribute('data-userid'); // Get the userID
            var name = button.getAttribute('data-name');
            var taskName = button.getAttribute('data-taskname');
            var dueDate = button.getAttribute('data-duedate');
            var taskStatus = button.getAttribute('data-taskstatus');
            var taskDescription = button.getAttribute('data-taskdescription');

            // Set values in the update modal
            document.getElementById('updateUserID').value = userID;
            document.getElementById('updateName').value = name;
            document.getElementById('updateTaskName').value = taskName;
            document.getElementById('updateDueDate').value = dueDate;
            document.getElementById('updateTaskStatus').value = taskStatus;
            document.getElementById('updateTaskDescription').value = taskDescription;

            // Open the update modal
            document.getElementById('updateTaskModal').style.display = 'block';
        });
    });
});

// Function to close the update modal
function closeUpdateModal() {
    document.getElementById('updateTaskModal').style.display = 'none';
}

            // Event listener to handle clicking the update button
            document.addEventListener('DOMContentLoaded', function() {
                var updateButtons = document.querySelectorAll('.updateBtn');
                updateButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        var name = button.getAttribute('data-name');
                        var taskName = button.getAttribute('data-taskname');
                        var dueDate = button.getAttribute('data-duedate');
                        var taskStatus = button.getAttribute('data-taskstatus');
                        var taskDescription = button.getAttribute('data-taskdescription');

                        openUpdateModal(name, taskName, dueDate, taskStatus, taskDescription);
                    });
                });
            });

            function closeUpdateModal() {
    document.getElementById('updateTaskModal').style.display = 'none';
}


                // Function to open the delete task modal
                function openDeleteModal() {
                    document.getElementById('deleteTaskModal').style.display = 'block';
                }

                // Function to close the delete task modal
                function closeDeleteModal() {
                    document.getElementById('deleteTaskModal').style.display = 'none';
                }

                // Event listener to handle clicking the delete button
                document.addEventListener('DOMContentLoaded', function() {
                    var deleteButtons = document.querySelectorAll('.deleteBtn');
                    deleteButtons.forEach(function(button) {
                        button.addEventListener('click', function() {
                            openDeleteModal();
                            // If you need to pass data to the delete modal, you can do it here
                        });
                    });
                });

                document.addEventListener('DOMContentLoaded', function() {
    var deleteButtons = document.querySelectorAll('.deleteBtn');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var userID = button.getAttribute('data-userid'); // Get the userID
            if (userID) { // Check if userID is not null or undefined
                document.getElementById('deleteUserID').value = userID; // Set the userID in the hidden input field
                openDeleteModal();
            } else {
                console.error("userID not specified");
            }
        });
    });
});

//// DITO KOO NAPUTOL

document.addEventListener('DOMContentLoaded', function () {
    // Function to count tasks in different states
    function countTasks() {
        var todoCount = 0;
        var pendingCount = 0;
        var finishedCount = 0;

        var rows = document.querySelectorAll('#task-table tbody tr');

        rows.forEach(function (row) {
            var status = row.cells[4].innerText.trim().toLowerCase();

            if (status === 'inprogress') {
                todoCount++;
            } else if (status === 'pending') {
                pendingCount++;
            } else if (status === 'completed') {
                finishedCount++;
            }
        });

        // Update counts in the UI
        document.getElementById('todo-count').innerText = todoCount + " tasks";
        document.getElementById('pending-count').innerText = pendingCount + " tasks";
        document.getElementById('finished-count').innerText = finishedCount + " tasks";
    }

    // Initial count
    countTasks();
});




               


    </script>



        

</body>
</html>
