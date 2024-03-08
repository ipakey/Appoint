<?php
include 'workings/build_calendar.php';
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
            <div class="sidebar">
                <h3 class="sidebar-bookings">
                    <center><?php echo ("  ** " . $day . " : " . $month . " : " . $year . " <br> timetable for <br> User Name:  **");
                            ?></center>
                </h3>
            </div>


        </div>
    </div>

    <footer>
        <?php include 'workings/footer.php'; ?>
    </footer>
</body>

</html>