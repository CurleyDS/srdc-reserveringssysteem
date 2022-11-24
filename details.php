<?php
// Require DB settings with connection variable
require_once "./includes/database.php";

// Check if id is set
if (!isset($_GET['id']) || $_GET['id'] === '')
{
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/Salsa-Rica-Dance-Company/schedule/');
    exit;
}

// Get id of lesson
$lessonId = mysqli_escape_string($db, $_GET['id']);

// Get lesson from database table
$result = getLesson($db, $lessonId);

if (mysqli_num_rows($result) != 1)
{
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/Salsa-Rica-Dance-Company/schedule/');
    exit;
}

$lesson = mysqli_fetch_assoc($result);

//Close connection
mysqli_close($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <title>Salsa Rica Dance Company</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row bg-black">
            <!-- navigation-bar -->
            <?php require_once "./includes/navigation-bar.php"; ?>
        </div>
        <div class="row">
            <a href="./">Terug</a>
        </div>
        <div class="row">
            <h2><?= date('l jS F Y \o\n H:i', strtotime($lesson['start_datetime'])) . ' - ' . date('H:i', strtotime($lesson['end_datetime'])); ?></h2>
            <ul class="list-group">
                <li class="list-group-item"><b>Datum en tijd:</b> <?= date('l jS F Y \o\n H:i', strtotime($lesson['start_datetime'])) . ' - ' . date('H:i', strtotime($lesson['end_datetime'])) ?></li>
            </ul>
        </div>
    </div>
</body>
</html>