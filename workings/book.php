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
    //     $stmt = $mysqli->prepare("INSERT INTO bookings(name, email, date, timeslot, paid, student, subject, grpInd )VALUES(?,?,?,?,?,?,?,?)");
    //     $stmt->bind_param('ssssssss', $name, $email, $date, $timeslot, $paid, $student, $subject, $grpInd);
    //     $stmt->execute();
    //     $msg = "<div class='alert alert-sucess'>Booking Successfull</div> ";
    //     $stmt->close();
    //     $mysqli->close();
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
        $slots[] = $intStart->format("H:iA") . "-" . $endPeriod->format("H:iA");
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
                <?php $timeslots = timeslots($duration, $cleanup, $start, $end);
                foreach ($timeslots as $ts) {
                ?>
                    <div class="form-group">
                        <button class="btn btn-success book" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?></button>

                    </div>
            </div>
        <?php } ?>
        </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Booking<span id="slot"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="">Timeslot</label>
                                    <input required="text" readonly name="timeslot" id="timeslot" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input required type="text" readonly name="name" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="">Student</label>
                                    <input required type="text" readonly name="student" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input required type="text" readonly name="email" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="">Subject</label>
                                    <input required type="text" readonly name="subject" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="">Type of class</label>
                                    <input required type="text" readonly name="grpInd" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="">Payment method</label>
                                    <input required type="text" readonly name="paid" class="form-control" />
                                </div>
                                <div class="form-group pull-right">
                                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <h3>Modal Footer</h3>
                </div> -->
            </div>
        </div>

    </div>


    <footer>
        <?php require_once 'footer.php'; ?>

    </footer>

</body>

</html>
<script>
    $('.book').click(function() {
        var timeslot = $(this).attr('data-timeslot');
        $('#slot').html(timeslot);
        $('#timeslot').val(timeslot);
        $('#myModal').modal('show');
    })
</script>
</body>

</html>