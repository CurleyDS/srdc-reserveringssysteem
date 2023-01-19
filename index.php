<?php
// Require DB settings with connection variable
require_once "./includes/database.php";

// If user is logged in, redirect to index.php
if(isset($_SESSION['user'])){
    header('Location:' . $base_url . '/user');
    exit;
}

//Get lessons from the database with an SQL query
$trialLessons = getTrialLessons($db);

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
    <link rel="stylesheet" href="./css/style.css">
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
                <table class="table table-borderless">
                    <tbody>
                        <?php foreach ($trialLessons as $lesson) { ?>
                            <tr>
                                <td class="border"><p><?= formatToDate($lesson['start_datetime']) . " | " . formatToTime($lesson['start_datetime']) . " - " . formatToTime($lesson['end_datetime']); ?></p></td>
                                <td><a class="text-maroon" href="./details.php?id=<?= $lesson['id'] ?>">Details</a></td>
                                <td>
                                    <form method="post" action="./signup.php">
                                        <input type="hidden" name="selected_id" value="<?= $lesson['id'] ?>">
                                        <input type="submit" name="selected_lesson" class="btn btn-link text-maroon p-0" value="Aanmelden">
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>