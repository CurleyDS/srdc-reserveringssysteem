<?php
//Require DB settings with connection variable
require_once "includes/database.php";

// If user is logged in, redirect to index.php
if(isset($_SESSION['user'])){
    header('Location:' . $base_url . '/auth/user');
    exit;
}

// Check if id is set
if (!isset($_GET['id']) || $_GET['id'] === '')
{
    header('Location:' . $base_url . '/');
    exit;
}

// Get id of lesson
$lessonId = mysqli_escape_string($db, $_GET['id']);

// Get lesson from database table
$result = getLesson($db, $lessonId);

if (mysqli_num_rows($result) != 1)
{
    header('Location: ' . $base_url . '/');
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
            <div class="col p-2">
                <a class="btn btn-maroon" href="./">Terug</a>
            </div>
        </div>
        <div class="row">
            <div>
                <h2><?= date('l d F | H:i', strtotime($lesson['start_datetime'])) . ' - ' . date('H:i', strtotime($lesson['end_datetime'])); ?></h2>
                <p>Deze les wordt gehouden door <?= $lesson['id'] ?></p>
                <form method="post" action="./signup.php">
                    <input type="hidden" name="selected_id" value="<?= $lesson['id'] ?>">
                    <input type="submit" name="selected_lesson" class="btn btn-link text-maroon p-0" value="Aanmelden">
                </form>
            </div>
        </div>
    </div>
</body>
</html>