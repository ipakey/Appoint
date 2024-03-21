<?php

function retrieveBookings($month, $year, $day)
{
    $mysqli = new mysqli('localhost', 'root', '', 'bookingcalendar');
    $stmt = $mysqli->prepare('select * from bookings where MONTH(date)=? AND YEAR(date)=? AND DAY(date)=? ORDER BY timeslot');
    $stmt->bind_param('sss', $month, $year, $day);
    $bookingsRetrieved = '';
    $bookings = array();
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row['date'];
                $bookingsRetrieved .= '<div class="pre-booked-list" >' . $row['grpInd'] . ' : ' . $row['location'] . ' : ' . $row['student']  . ' <br> ' . $row['subject']  . ' <br> ' . $row['timeslot'] . '</div>';
            }
            $stmt->close();
        }
    }
    // echo $bookingsRetrieved;
    return $bookingsRetrieved;
}


function booked($slots)
{
    foreach ($slots as $slot) {
        // $month = $slot['date.[mon]'];
    }
}

function book($month, $year, $day)
{
    // $date = $year . "-" . $month . "-" . $day;
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $student = $_POST['student'];
        $subject = $_POST['subject'];
        $paid = $_POST['paid'];
        $email = $_POST['email'];
        $grpInd = $_POST['grpInd'];
        $timeslot = '19:30';
        $mysqli = new mysqli('localhost', 'root', '', 'bookingcalendar');
        $stmt = $mysqli->prepare("INSERT INTO bookings(name, email, date, timeslot, paid, student, subject, grpInd )VALUES(?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssssss', $name, $email, $date, $timeslot, $paid, $student, $subject, $grpInd);
        $stmt->execute();
        $msg = "<div class='alert alert-sucess'>Booking Successfull</div> ";
        $stmt->close();
        $mysqli->close();
    }
}


?>

<?php
// $dat0 = $_GET('month');
$duration = 30;
$cleanup = 0;
$start = "15:00";
$end = "21:00";
$maxGroup = 5;


function timeslots($duration, $cleanup, $start, $end, $maxGroup)
{
    // echo $maxGroup;
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT" . $duration . "M");
    $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
    $slots = array();
    $s = array();

    for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if ($endPeriod > $end) {
            break;
        }
        $s['slot'] = $intStart->format("H:ia") . "-" . $endPeriod->format("H:ia");
        $s['grp'] = "Grp";
        $s['maxGrp'] = $maxGroup;
        array_push($slots, $s);
    }
    booked($slots);
    return $slots;
}

?>



</div>
</div>

<div>
    <div>
        <!-- Modal content -->
        <div class="modal" id="myModal">
            <div class="header">
                <button type="button" class="close btn btn-close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Booking<span id="slot"></span></h3>
            </div>
            <div class="body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="timeslot">Timeslot</label>
                        <input readonly type="text" name="timeslot" id="timeslot">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input readonly type="text" name="name" id="name" autocomplete>
                    </div>
                    <div class="form-group">
                        <label for="student">Student</label>
                        <input readonly type="text" name="student" id="student">
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input readonly type="text" name="subject" id="subject">
                    </div>
                    <div class="form-type-group">
                        <div class="form-group">
                            <label for="iGi">Individual </label>
                            <input readonly type="radio" name="indGroup" id="iGi" value="I">
                        </div>
                        <div class="form-group">
                            <label for="iGg">Group</label>
                            <input readonly type="radio" name="indGroup" id="iGg" value="G">
                        </div>
                    </div>
                    <div class="form-type-group">
                        <div class="form-group">
                            <label for="locO">Online</label>
                            <input readonly type="radio" name="location" id="locO" value="OL">
                        </div>
                        <div class="form-group">
                            <label for="locD">The Den</label>
                            <input readonly type="radio" name="location" id="locD" value="Dn">
                        </div>
                        <div class="form-group">
                            <label for="locA">Your place</label>
                            <input readonly type="radio" name="location" id="locA" value="Aw">
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    }