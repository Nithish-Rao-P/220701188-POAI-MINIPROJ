<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";  // Update with your DB username
$password = "";  // Update with your DB password
$dbname = "typewriting_test_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming session username is available
$session_username = $_SESSION['username'];  // Use session or user-specific data

// Query to fetch user data and typing statistics
$sql = "
SELECT 
    u.username, 
    u.email,
    AVG(l.wpm) as avg_wpm,
    MAX(l.wpm) as highest_wpm,
    MIN(l.wpm) as lowest_wpm,
    AVG(l.accuracy) as avg_accuracy
FROM 
    user_registration u
JOIN 
    leaderboard l ON u.username = l.username
WHERE 
    u.username = '$session_username'
GROUP BY 
    u.username
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the result and store in session variables
    while ($row = $result->fetch_assoc()) {
        $_SESSION['username'] = $row["username"];
        $_SESSION['email'] = $row["email"];
        $_SESSION['avg_wpm'] = round($row["avg_wpm"], 2);
        $_SESSION['highest_wpm'] = $row["highest_wpm"];
        $_SESSION['lowest_wpm'] = $row["lowest_wpm"];
        $_SESSION['avg_accuracy'] = round($row["avg_accuracy"], 2);
    }
} else {
    // If no data, store default values
    $_SESSION['error_message'] = "No statistics available.";
}

$sql_typing_history = "
SELECT 
    l.date, 
    l.wpm 
FROM 
    leaderboard l 
JOIN 
    user_registration u ON u.username = l.username 
WHERE 
    u.username = '$session_username'
ORDER BY 
    l.date ASC
";

$result_history = $conn->query($sql_typing_history);

$dates = [];
$wpm_values = [];

if ($result_history->num_rows > 0) {
    while ($row = $result_history->fetch_assoc()) {
        $dates[] = $row["date"]; // Assuming `date` is in a format that can be converted
        $wpm_values[] = $row["wpm"];
    }
} else {
    // If no typing history, handle accordingly
    $_SESSION['error_message'] = "No typing history available.";
}

// Convert dates for the JavaScript
$dates_js = json_encode($dates);
$wpm_values_js = json_encode($wpm_values);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="profile.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="button-container">
        <!-- 1st button - redirects to index.php -->
        <button title="Home Page" class="button" onclick="window.location.href='index.php';">
            <svg
                class="bi bi-person-fil"
                stroke="currentColor"
                fill="currentColor"
                stroke-width="0"
                viewBox="0 0 1024 1024"
                height="1em"
                width="1em"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M946.5 505L560.1 118.8l-25.9-25.9a31.5 31.5 0 0 0-44.4 0L77.5 505a63.9 63.9 0 0 0-18.8 46c.4 35.2 29.7 63.3 64.9 63.3h42.5V940h691.8V614.3h43.4c17.1 0 33.2-6.7 45.3-18.8a63.6 63.6 0 0 0 18.7-45.3c0-17-6.7-33.1-18.8-45.2zM568 868H456V664h112v204zm217.9-325.7V868H632V640c0-22.1-17.9-40-40-40H432c-22.1 0-40 17.9-40 40v228H238.1V542.3h-96l370-369.7 23.1 23.1L882 542.3h-96.1z"></path>
            </svg>
        </button>

        <!-- 3rd button - redirects to profile.php -->
        <button class="button" onclick="window.location.href='profile.php';">
            <svg
                class="icon"
                stroke="currentColor"
                fill="currentColor"
                stroke-width="0"
                viewBox="0 0 24 24"
                height="1em"
                width="1em"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12 2.5a5.5 5.5 0 0 1 3.096 10.047 9.005 9.005 0 0 1 5.9 8.181.75.75 0 1 1-1.499.044 7.5 7.5 0 0 0-14.993 0 .75.75 0 0 1-1.5-.045 9.005 9.005 0 0 1 5.9-8.18A5.5 5.5 0 0 1 12 2.5ZM8 8a4 4 0 1 0 8 0 4 4 0 0 0-8 0Z"></path>
            </svg>
        </button>
        <!-- Leaderboard Button - redirects to leaderboard.php -->
        <button class="button" onclick="window.location.href='leaderboard.php';">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                <path d="M160-200h160v-320H160v320Zm240 0h160v-560H400v560Zm240 0h160v-240H640v240ZM80-120v-480h240v-240h320v320h240v400H80Z" />
            </svg>
        </button>

        <!-- 4th button - redirects to logout.php -->
        <button class="button" onclick="window.location.href='login.html';">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
            </svg>
        </button>

    </div>
    <div class="container">
        <div class="allContent">
            <aside>
            </aside>
            <aside id="statistics" class="sectioncontent">
                <div class="tab">
                    <button class="tablinks" onclick="openCity(event, 'progress')"></button>
                </div>

                <div id="progress" class="tabcontent">
                    <br><br><br>
                    <h3>User Statistics:</h3><br>
                    <div class="data-cards">
                        <div class="card">
                            <i style="color: rgb(13, 241, 146); background-color: black;" class="fa-regular fa-keyboard"></i>
                            <div><span><?php echo isset($_SESSION['avg_wpm']) ? $_SESSION['avg_wpm'] : 'N/A'; ?></span>Average WPM</div>
                        </div>
                        <div class="card">
                            <i style="color: rgb(13, 241, 146); background-color: black;" class="fa-solid fa-circle-chevron-up"></i>
                            <div><span><?php echo isset($_SESSION['highest_wpm']) ? $_SESSION['highest_wpm'] : 'N/A'; ?></span>Highest WPM</div>
                        </div>
                        <div class="card">
                            <i style="color: rgb(13, 241, 146); background-color: black;" class="fa-solid fa-circle-chevron-down"></i>
                            <div><span><?php echo isset($_SESSION['lowest_wpm']) ? $_SESSION['lowest_wpm'] : 'N/A'; ?></span>Lowest WPM</div>
                        </div>
                        <div class="card">
                            <i style="color: rgb(13, 241, 146); background-color: black;" class="fa-solid fa-square-check"></i>
                            <div><span><?php echo isset($_SESSION['avg_accuracy']) ? $_SESSION['avg_accuracy'] : 'N/A'; ?></span>Average Accuracy</div>
                        </div>
                    </div>
                    <h3>User Progress:</h3>
                    <div class="chartContainer">
                        <div class="lineChart">
                            <canvas id="chart5"></canvas>
                        </div>
                    </div>

                </div>
            </aside>
        </div>
    </div>
    <script src="profile.js"></script>
</body>

</html>

<script>
    // Convert PHP arrays to JavaScript arrays
    const dates = <?php echo $dates_js; ?>;
    const wpmValues = <?php echo $wpm_values_js; ?>;

    // Function to initialize the chart
    function initChart() {
        new Chart("chart5", {
            type: "line",
            data: {
                labels: dates,
                datasets: [{
                    label: "Typing History (WPM)",
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "#0287CD",
                    borderColor: "#0099ff",
                    data: wpmValues
                }]
            },
            options: {
                legend: {
                    display: true
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'WPM'
                        }
                    }
                }
            }
        });
    }

    // Call the function to initialize the chart
    initChart();
</script>