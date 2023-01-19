<?php
// Require DB settings with connection variable
require_once "../includes/database.php";

// If user is not logged in, redirect to index.php
if(!isset($_SESSION['user'])){
    header('Location:' . $base_url . '/../');
    exit;
}

//Get lessons from the database with an SQL query
$essons = getLessons($db);

//Get reservations from the database with an SQL query
$reservations = getReservations($db);

for ($x=0; $x < count($reservations); $x++) {
    // Get lesson from database
    $result = getLesson($db, $reservations[$x]['lesson_id']);
    
    if (mysqli_num_rows($result) == 1) {
        $reservations[$x]['lesson'] = mysqli_fetch_assoc($result);
    } else {
        $reservations[$x]['lesson'] = '';
    }
}

require_once "../includes/calendar.php";

//Close connection
mysqli_close($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Salsa Rica Dance Company</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row bg-black">
            <!-- navigation-bar -->
            <?php require_once "../includes/navigation-bar.php"; ?>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-9 d-flex justify-content-between">
                <span class="btn text-maroon"><?= $titles['yearmonth']; ?></span>

                <div class="btn-group border border-maroon rounded-pill" role="group">
                    <a href="?year=<?=$prev['year'];?>&week=<?=$prev['week'];?>" class="btn btn-outline-maroon"><</a>
                    <button type="button" class="btn btn-outline-maroon"><?= $titles['week']; ?></button>
                    <a href="?year=<?=$next['year'];?>&week=<?=$next['week'];?>" class="btn btn-outline-maroon">></a>
                </div>
                
                <a href="create.php" class="btn btn-maroon rounded-pill">Cursussen</a>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-9">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th></th>
                            <?php foreach ($week as $day) { ?>
                                <th class="text-center"><?= $day['day']; ?><br><?= $day['date']; ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($x=0; $x <= $hour_count; $x++) { ?>
                            <tr>
                                <td class="text-center">
                                    <?= formatStrToTime($x); ?>
                                </td>
                                <?php foreach ($week as $day) { ?>
                                    <td>
                                        <?php foreach ($day['hours'] as $hour) {
                                            if (formatStrToTime($x) == $hour['time']) {
                                                if (isset($hour['lessons'])) { ?>
                                                    <a class="btn text-center border border-maroon rounded-pill"><?= $hour['time']; ?></a>
                                                <? }
                                            }
                                        } ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>