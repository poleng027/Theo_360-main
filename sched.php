<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Calendar</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('./assets/imgs/bg.png');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .calendar-container {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            width: 90%;
            max-width: 800px;
            padding: 20px;
        }
        .navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .navigation button {
            background-color: #69185B;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
        .navigation h2 {
            margin: 0;
        }
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        .day {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .day.header {
            background-color: #69185B;
            color: white;
            font-weight: bold;
        }
        .day.not-available {
            background-color: #ffcccc;
        }
    </style>
</head>
<body>
<?php include("navbar-u.php");?>   
    <div class="calendar-container">
        <h1 style="text-align:center; margin-top:0;">Reservation Calendar</h1>
        <div class="navigation">
            <button id="prev-month">Previous</button>
            <h2 id="current-month"></h2>
            <button id="next-month">Next</button>
        </div>
        <div id="calendar" class="calendar"></div>
    </div>

    <script>
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();

        function renderCalendar(bookedDates) {
            const calendar = document.getElementById('calendar');
            calendar.innerHTML = '';
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const monthStartDay = new Date(currentYear, currentMonth, 1).getDay();

            document.getElementById('current-month').innerText = `${monthNames[currentMonth]} ${currentYear}`;

            const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            days.forEach(day => {
                const dayHeader = document.createElement('div');
                dayHeader.classList.add('day', 'header');
                dayHeader.innerText = day;
                calendar.appendChild(dayHeader);
            });

            for (let i = 0; i < monthStartDay; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.classList.add('day');
                calendar.appendChild(emptyDay);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.classList.add('day');
                const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                if (bookedDates.includes(dateStr)) {
                    dayElement.classList.add('not-available');
                }
                dayElement.innerText = day;
                calendar.appendChild(dayElement);
            }

            for (let i = (monthStartDay + daysInMonth) % 7; i < 7 && i != 0; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.classList.add('day');
                calendar.appendChild(emptyDay);
            }
        }

        function fetchBookedDates(year, month) {
            fetch(`fetch_bookings.php?year=${year}&month=${month + 1}`)
                .then(response => response.json())
                .then(data => {
                    renderCalendar(data.bookedDates);
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchBookedDates(currentYear, currentMonth);

            document.getElementById('prev-month').addEventListener('click', function() {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                fetchBookedDates(currentYear, currentMonth);
            });

            document.getElementById('next-month').addEventListener('click', function() {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                fetchBookedDates(currentYear, currentMonth);
            });
        });
    </script>
</body>
</html>
