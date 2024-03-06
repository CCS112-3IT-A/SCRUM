// SEARCH BAR
function searchTask() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase(); // Convert input to lowercase for case-insensitive search
    const taskTable = document.getElementById('task-table');
    const rows = taskTable.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {  // Start from 1 to skip header row
        const cells = rows[i].getElementsByTagName('td');
        const taskNameCell = cells[2]; // First column contains task names
        const taskName = taskNameCell.textContent.toLowerCase(); // Get text content of the task name cell

        if (taskName.includes(searchInput)) {
            rows[i].style.display = ''; // Show the row if the task name contains the search input
        } else {
            rows[i].style.display = 'none'; // Hide the row otherwise
        }
    }
}


// COUNT TASK 
document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems);
});

function countTasks() {
    const tableRows = document.querySelectorAll("#task-table tbody tr");
    let pendingCount = 0;
    let finishedCount = 0;

    tableRows.forEach(row => {
        const status = row.cells[2].textContent;
        if (status === "In Progress") {
            pendingCount++;
        } else if (status === "Finished") {
            finishedCount++;
        }
    });
    document.getElementById("pending-count").textContent = pendingCount + " tasks";
    document.getElementById("finished-count").textContent = finishedCount + " tasks";
}

function countToDoTasks() {
    const tableRows = document.querySelectorAll("#task-table tbody tr");
    const todoCount = tableRows.length;
    document.getElementById("todo-count").textContent = todoCount + " tasks";
}

countToDoTasks();
countTasks();


document.addEventListener('DOMContentLoaded', function () {
    // Initialize dropdowns
    var filterDropdowns = document.querySelectorAll('.filter-select');
    var sortDropdown = document.querySelector('.sort-select');
    var taskTable = document.getElementById('task-table');

    // Initialize table rows
    var rows = document.querySelectorAll('#task-table tbody tr');

    // Event listener for filter dropdowns
    filterDropdowns.forEach(function (dropdown) {
        dropdown.addEventListener('change', function () {
            var columnIndex = getColumnIndex(dropdown.value);
            var sortBy = sortDropdown.value;
            if (sortBy !== '') {
                sortTable(columnIndex, sortBy);
            }
        });
    });

    // Event listener for sort dropdown
    sortDropdown.addEventListener('change', function () {
        var columnIndex = getColumnIndex(document.querySelector('.filter-select').value);
        var sortBy = sortDropdown.value;
        if (sortBy !== '') {
            sortTable(columnIndex, sortBy);
        }
    });

    // Sort table function
    function sortTable(columnIndex, sortBy) {
        var rowsArray = Array.from(rows);

        rowsArray.sort(function (a, b) {
            var aValue = a.children[columnIndex].innerText.trim();
            var bValue = b.children[columnIndex].innerText.trim();

            if (columnIndex === 3) { // Due Date column
                var aDate = parseDate(aValue);
                var bDate = parseDate(bValue);
                return (sortBy === 'asc') ? aDate - bDate : bDate - aDate;
            } else if (columnIndex === 4) { // Status column
                return (sortBy === 'asc') ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
            } else { // For other columns, compare as strings
                return (sortBy === 'asc') ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
            }
        });

        // Reorder rows in the table
        rowsArray.forEach(function (row) {
            taskTable.querySelector('tbody').appendChild(row);
        });
    }

    // Function to parse date string to Date object
    function parseDate(dateString) {
        var dateParts = dateString.split(' ');
        var monthIndex = {
            'January': 0,
            'February': 1,
            'March': 2,
            'April': 3,
            'May': 4,
            'June': 5,
            'July': 6,
            'August': 7,
            'September': 8,
            'October': 9,
            'November': 10,
            'December': 11
        }[dateParts[0]];
        var day = parseInt(dateParts[1].replace(',', ''));
        var year = parseInt(dateParts[2]);
        return new Date(year, monthIndex, day);
    }

    // Function to get column index based on filter value
    function getColumnIndex(filterValue) {
        switch (filterValue) {
            case 'ID':
                return 0;
            case 'name':
                return 1;
            case 'taskName':
                return 2;
            case 'dueDate':
                return 3;
            case 'status':
                return 4;
            case 'description':
                return 5;
            default:
                return 6;
        }
    }
});






