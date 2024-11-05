<?php
session_start(); // Start the session

// Check if a username exists in the session
if (isset($_SESSION['username'])) {
    // If the username is set, the button will link to profile.php and show "Profile"
    $user = $_SESSION['username'];   
} else {
    // If no username, the button will link to login.html and show "Login"
    $user = "Guest";
}
if (isset($_SESSION['wpm'])) {
  $wpm = $_SESSION['wpm'];
} else {
  $wpm = 0; // Default to 0 if not set
}

if (isset($_SESSION['accuracy'])) {
  $accuracy = $_SESSION['accuracy'];
} else {
  $accuracy = 0; // Default to 0 if not set
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>typings</title>

  <meta name="description" content="typings.gg is a sleek and modern typing test website. it support many custom themes" />
  <link rel="stylesheet" href="style.css" />
  <link id="theme" rel="stylesheet" href="themes/light.css" />
  <link id="theme" rel="stylesheet" href="index.css" />
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

    <!-- 2nd button - triggers showThemeCenter function -->
    <button title="Themes" class="button" onclick="showThemeCenter();">
    <svg xmlns="http://www.w3.org/2000/svg" height="1em" width="1em" stroke="currentColor" fill="currentColor" viewBox="0 0 512 512"><path d="M512 256c0 .9 0 1.8 0 2.7c-.4 36.5-33.6 61.3-70.1 61.3L344 320c-26.5 0-48 21.5-48 48c0 3.4 .4 6.7 1 9.9c2.1 10.2 6.5 20 10.8 29.9c6.1 13.8 12.1 27.5 12.1 42c0 31.8-21.6 60.7-53.4 62c-3.5 .1-7 .2-10.6 .2C114.6 512 0 397.4 0 256S114.6 0 256 0S512 114.6 512 256zM128 288a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm0-96a32 32 0 1 0 0-64 32 32 0 1 0 0 64zM288 96a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm96 96a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
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
    <path d="M160-200h160v-320H160v320Zm240 0h160v-560H400v560Zm240 0h160v-240H640v240ZM80-120v-480h240v-240h320v320h240v400H80Z"/>
  </svg>
</button>

    <!-- 4th button - redirects to logout.php -->
    <button class="button" onclick="window.location.href='login.html';">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
  <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
</svg>
    </button>

</div>

<br><br><br>
  <h2 id="header">Welcome <?php echo $user; ?></h2>
  <div id="command-center" class="">
    <div class="bar">
      <div id="left-wing">
        <span id="word-count">
          <span id="wc-10" onclick="setWordCount(10)">10</span>
          <text> / </text>
          <span id="wc-25" onclick="setWordCount(25)">25</span>
          <text> / </text>
          <span id="wc-50" onclick="setWordCount(50)">50</span>
          <text> / </text>
          <span id="wc-100" onclick="setWordCount(100)">100</span>
          <text> / </text>
          <span id="wc-250" onclick="setWordCount(250)">250</span>
        </span>
        <span id="time-count">
          <span id="tc-15" onclick="setTimeCount(15)">15</span>
          <text> / </text>
          <span id="tc-30" onclick="setTimeCount(30)">30</span>
          <text> / </text>
          <span id="tc-60" onclick="setTimeCount(60)">60</span>
          <text> / </text>
          <span id="tc-120" onclick="setTimeCount(120)">120</span>
          <text> / </text>
          <span id="tc-240" onclick="setTimeCount(240)">240</span>
        </span>
      </div>
      <div id="right-wing">WPM: <?php echo $wpm; ?> / ACC: <?php echo $accuracy; ?></div>
    </div>
    <div id="typing-area">
      <div id="text-display"></div>
      <div class="bar">
        <input id="input-field" type="text" spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off" tabindex="1" />
        <button id="redo-button" onclick="setText(event)" tabindex="2">redo</button>
      </div>
    </div>
  </div>
  <div id="theme-center" class="hidden">
    <div id="left-wing" onClick="hideThemeCenter();">
      < back</div>
        <div id="theme-area"></div>
    </div>
    <div id="footer">
      <div id="show-themes" class="button" onClick="showThemeCenter();" tabindex="4"></div>
    </div>
    <script src="main.js"></script>
</body>

</html>