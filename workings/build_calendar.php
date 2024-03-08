<?php

function build_calendar($month, $year)
{


    $mysqli = new mysqli('localhost', 'root', '', 'bookingcalendar');
    $stmt = $mysqli->prepare('select * from bookings where MONTH(date)=? AND YEAR(date)=?');
    $stmt->bind_param('ss', $month, $year);
    $bookings = array();
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row['date'];
            }
            $stmt->close();
        }
    }


    $daysOfWeek = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    //what is the index value (0-6) of the first day of the month in question
    $dayOfWeek = $dateComponents['wday'];

    //Create the table tag opener and day headers
    $dateToday = date('Y-m-d');

    $calendar = '';

    $calendar .= "<h2><center>$monthName $year</center></h2>";

    $prev_month = date('m', mktime(0, 0, 0, $month - 1, 1, $year));
    $prev_year = date('Y', mktime(0, 0, 0, $month - 1, 1, $year));
    $next_month = date('m', mktime(0, 0, 0, $month + 1, 1, $year));
    $next_year = date('Y', mktime(0, 0, 0, $month + 1, 1, $year));



    $calendar .= "<center><a class='btn-action-yfk' href='?month=" . date('m', mktime(0, 0, 0, $month - 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month - 1, 1, $year)) . "'>Prev Month</a>";

    $calendar .= "<a class='btn-action-yfk' href='?month=" . date('m') . "&year=" . date('Y') . "'>Curr Month</a>";

    $calendar .= "<a class='btn-action-yfk' href='?month=" . date('m', mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month + 1, 1, $year)) . "'>Next Month</a></center></br>";

    $calendar .= "<table class='table-calendar'>";


    $calendar .= "<tr>";

    //create the calendar headers

    foreach ($daysOfWeek as $day) {
        $calendar .= "<th><center><h2>$day</h2></center></th>";
    }

    $calendar .= "</tr><tr>";
    $currentDay = 1;
    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calendar .= "<td class='empty'></td>";
        }
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    while ($currentDay <= $numberDays) {
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        // $p = date('Y-m-d');
        // echo "</br> " . $p . " ";

        $currentDayRel =
            str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        $eventNum = 0;
        $dayName = strtolower(date('l', strtotime($date)));
        $today = $date == date('Y-m-d') ? "today" :
            "day";

        if ($dateToday == $date) {
            $calendar .= "<td class='today' rel='$date'>";
        } else {
            $calendar .= "<td class='day' rel='$date'>";
        }

        // $p = $bookings[0];
        // echo "</br> " . $p . " ";
        if ($date <= date('Y-m-d')) {
            $calendar .= "<h3 class='$today btn btn-dark-yfke'>$currentDay</br>N/A</h3></td>";
            // } elseif (in_array($date, $bookings)) {
            //     $calendar .= "<h4 class='$today btn btn-booking-yfke'>$currentDay</br><a class='btn-info'href='./workings/book.php?date=" . $date . "'>Book</a></h3></td>";
            // } elseif (in_array($date, $bookings)) {
            //     $calendar .= "<h3 class='$today btn btn-danger-yfke'>$currentDay</br>Full</></h3></td>";
        } else {
            $calendar .= "<h3 class='$today btn btn-info-yfke'> $currentDay </br><a href='./workings/book.php?date=" . $date . "' class='btn-info'>Book  </a></h3></td>";
        }




        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek < 7) {
        $remainingDays = 7 - $dayOfWeek;
        for ($i = 0; $i < $remainingDays; $i++) {
            $calendar .= "<td class='empty'></td>";
        }
    }
    $calendar .= "</tr></table>";

    return $calendar;
}
