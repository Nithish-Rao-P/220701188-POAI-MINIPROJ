<?php
// Database connection (replace with your connection details)
$servername = "localhost";
$username = "root"; // or your SQL username
$password = ""; // or your SQL password
$dbname = "typewriting_test_db"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch leaderboard data
$sql = "SELECT username, wpm, accuracy 
        FROM leaderboard 
        WHERE accuracy > 90 
        ORDER BY wpm DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap"
        rel="stylesheet" />
    <link id="theme" rel="stylesheet" href="leaderboard.css" />
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
    <main>
        <div id="header">
            <br>
            <h1>Ranking</h1>
        </div>

        <div id="leaderboard">
            <div class="ribbon"></div>
            <table>
                <?php
                // Check if there are any results
                if ($result->num_rows > 0) {
                    // Output data for each row
                    $rank = 1; // Initialize rank counter
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='number'>" . $rank . "</td>";
                        echo "<td class='name'>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td class='points'>" . htmlspecialchars($row['wpm']) . "</td>";
                        echo "</tr>";
                        $rank++; // Increment rank counter
                    }
                } else {
                    echo "<tr><td colspan='3'>No data available</td></tr>";
                }
                ?>
            </table>

        </div>
    </main>

    <?php
    // Close the database connection
    $conn->close();
    ?>

</body>

</html>