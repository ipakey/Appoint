<?php
include 'workings/build_calendar.php';
include 'workings/book.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta name="description" content="SEO info" />
    <?php include 'workings/head.php';
    require_once 'workings/head-all.php'; ?>

    <title>Appointments</title>
</head>

<body>
    <h1>
        <center>Tutor Bookings </center>
    </h1>
    <div class="container-page">
        <div class="container-calendar">
            <div class="row">
                <div class="column">
                    <?php
                    $dateComponents = getdate();


                    // echo "check dateComponents : ";
                    // echo print_r($dateComponents);

                    if (isset($_GET['month']) && isset($_GET['year'])) {
                        $month = $_GET['month'];
                        $year = $_GET['year'];
                    } else {
                        $month = $dateComponents['mon'];
                        $year = $dateComponents['year'];
                    }

                    $day = $dateComponents['mday'];
                    echo ("<br> Date " . $day . " : " . $month . " : " . $year . "</br>");

                    echo build_calendar($month, $year);
                    ?>
                </div>
            </div>
        </div>

        <div class="container-bookings">
            <?php

            echo retrieveBookings($month, $year, $day);
            // bookingForm($month, $year, $day);
            // echo book($month, ' - ', $year, ' - ', $day)
            ?><div class="form-body">
                <div class="row">
                    <div class="message">
                        <?php echo isset($msg) ? $msg : ""; ?>
                    </div>

                    <?php
                    // echo $dat0;
                    $timeslots = timeslots($duration, $cleanup, $start, $end, $maxGroup); ?>


                    <?php
                    foreach ($timeslots as $ts) {
                    ?>
                        <div class="col-md-4">
                            <div class="btn-action-yfke book" data-timeslot="<?php echo $ts['slot']; ?>"><?php echo $ts['slot']; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>


    </div>

    <footer>
        <?php include 'workings/footer.php'; ?>
    </footer>
</body>

</html>