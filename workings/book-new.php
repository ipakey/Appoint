<?php
if (isset($_GET['date'])) {
    $date = $_GET['date'];
}

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
?>


<?php

$duration = 30;
$cleanup = 0;
$start = "09:00";
$end = "15:00";

function timeslots($duration, $cleanup, $start, $end)
{
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT" . $duration . "M");
    $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
    $slots = array();


    for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if ($endPeriod > $end) {
            break;
        }
        $slots[] = $intStart->format("H:ia") . "-" . $endPeriod->format("H:ia");
    }
    return $slots;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'head-all.php'; ?>
</head>

<body>
    <div class="container container-booking-form ">

        <center>
            <h2 class="form-heading text-center">
                Book for <?php echo date('d F Y', strtotime($date)); ?></h2>
            <hr>
        </center>

        <div class="form-body">
            <div class="row">
                <?php $timeslots = timeslots($duration, $cleanup, $start, $end); ?>


                <?php
                foreach ($timeslots as $ts) {
                ?>
                    <div class="col-md-12">
                        <div class="btn btn-action-yfke book" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close btn btn-close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Booking<span id="slot"></span></h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="timeslot">Timeslot</label>
                                    <input readonly type="text" name="timeslot" id="timeslot">
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="student">Student</label>
                                    <input type="text" name="student" id="student">
                                </div>
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" name="subject" id="subject">
                                </div>
                                <div class="form-type-group">
                                    <div class="form-group">
                                        <label for="ind">Indivi"dual </label>
                                        <input type="radio" name="indGroup" id="ind" value="I">
                                    </div>
                                    <div class="form-group">
                                        <label for="grp">Group</label>
                                        <input type="radio" name="indGroup" id="grp" value="G">
                                    </div>
                                </div>
                                <div class="form-type-group">
                                    <div class="form-group">
                                        <label for="online">Online</label>
                                        <input type="radio" name="location" id="online" value="OL">
                                    </div>
                                    <div class="form-group">
                                        <label for="home">The Den</label>
                                        <input type="radio" name="location" id="home" value="Dn">
                                    </div>
                                    <div class="form-group">
                                        <label for="away">Your place</label>
                                        <input type="radio" name="location" id="away" value="Aw">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <footer>
            <?php require_once 'footer.php'; ?>

        </footer>

</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript">
    $('.book').click(function() {
        var timeslot = $(this).attr("data-timeslot");
        $('#slot').html(timeslot);
        $('#timeslot').val(timeslot);
        $('#myModal').modal('show');
    })
</script>
</body>

</html>