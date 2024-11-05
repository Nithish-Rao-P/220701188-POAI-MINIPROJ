document.querySelector("#statistics .tablinks:first-child").click();
document.querySelector("aside nav ul:first-child").click();

function openCity(evt, cityName) {
    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

function openSection(evt, sectionName) {
    var i, sectioncontent, sectionlinks;

    sectioncontent = document.getElementsByClassName("sectioncontent");
    for (i = 0; i < sectioncontent.length; i++) {
        sectioncontent[i].style.display = "none";
    }

    sectionlinks = document.getElementsByClassName("sectionlinks");
    for (i = 0; i < sectionlinks.length; i++) {
        sectionlinks[i].className = sectionlinks[i].className.replace(" active", "");
    }

    document.getElementById(sectionName).style.display = "block";
    evt.currentTarget.className += " active";
}

Chart.defaults.font.family = "ubuntu";

// Fetch WPM and dates from session variables
const typingHistory = <?php echo json_encode($_SESSION['typing_history']); ?>; // Assuming you store user typing history as an array of objects in session
const labels = typingHistory.map(entry => entry.date); // Assuming 'date' is a property in the entry
const dataPoints = typingHistory.map(entry => entry.wpm); // Assuming 'wpm' is a property in the entry

new Chart("chart5", {
    type: "line",
    data: {
        labels: labels,
        datasets: [{
            label: "Typing Speed (WPM)",
            fill: false,
            lineTension: 0,
            backgroundColor: "#0287CD",
            borderColor: "#0099ff",
            data: dataPoints
        }]
    },
    options: {
        legend: { display: true },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
