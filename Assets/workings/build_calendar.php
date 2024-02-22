<?php

function build_calendar($month, $year)
{
    $daysOfWeek = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    //what is the index value (0-6) of the first day of the month in question
    $dayOfWeek = $dateComponents['wday'];

    //Create the table tag opener and day headers
    $dateToday = date('Y-m-d');

    $calendar = "<h2><center>$monthName $year</center></h2>";
    $prev_month = date('m', mktime(0, 0, 0, $month - 1, 1, $year));
    $prev_year = date('Y', mktime(0, 0, 0, $month - 1, 1, $year));
    $next_month = date('m', mktime(0, 0, 0, $month + 1, 1, $year));
    $next_year = date('Y', mktime(0, 0, 0, $month + 1, 1, $year));

    $calendar .= '';

    $calendar .= "<center><a class='btn-action-yfk' href='?month=" . date('m', mktime(0, 0, 0, $month - 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month - 1, 1, $year)) . "'>Prev Month</a>";

    $calendar .= "<a class='btn-action-yfk' href='?month=" . date('m') . "&year=" . date('Y') . "'>Curr Month</a>";

    $calendar .= "<a class='btn-action-yfk' href='?month=" . date('m', mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month + 1, 1, $year)) . "'>Next Month</a></center>";

    $calendar .= "<table class='table'>";
    $calendar .= "<tr>";

    foreach ($daysOfWeek as $day) {
        $calendar .= "<th>$day</th>";
    }
    $calendar .= "<tr><tr>";
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

        $p = date('Y-m-d');
        echo "</br> " . $p . " ";

        $currentDayRel =
            str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        $dayName = strtolower(date('l', strtotime($date)));
        $today = $date == date('Y-m-d') ? "today" :
            "day";
        echo ' ' . ($date == date('Y-m-d') ? 'true' : 'false') . ' ';
        echo (" " . $today . " " . $date);
        $calendar .= "<td><h3 class='$today'>$currentDayRel</h3></td>";
        $currentDay++;
        $dayOfWeek++;
    }

    return $calendar;
}
