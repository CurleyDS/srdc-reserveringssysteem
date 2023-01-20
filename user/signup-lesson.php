<?php
//Require DB settings with connection variable
require_once "../includes/database.php";

// If user is not logged in, redirect to index.php
if(!isset($_SESSION['user'])){
    header('Location:' . $base_url . '/../');
    exit;
} else {
    $name = $_SESSION['user']['name'];
    $phone = $_SESSION['user']['phone'];
    $email = $_SESSION['user']['email'];
}

$lessons = getLessons($db);

// Check if id is set
if (isset($_POST['selected_lesson']))
{
    if (isset($_POST['selected_id'])) {
        $id = $_POST['selected_id'];

        // Get lesson from database table
        $result = getLesson($db, $id);
    
        if (mysqli_num_rows($result) == 1)
        {
            $selectedLesson = mysqli_fetch_assoc($result);
        }
    }
}

// Check if form is submitted
if (isset($_POST['submit']))
{
    
    // if trial_lesson is given, set trial_lesson true
    $lesson_id = mysqli_escape_string($db, $_POST['lesson_id']);
    $name = mysqli_escape_string($db, $name);
    $phone = mysqli_escape_string($db, $phone);
    $email = mysqli_escape_string($db, $email);
    
    // Require form-validations
    require_once "../includes/form-validation.php";

    if (empty($errors)) {
        // insert reservation into database table
        $result = insertReservation($db, $lesson_id, $name, $phone, $email);

        if ($result) {
            header('Location:' . $base_url . '/');
            exit;
        } else {
            $errors['db'] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }

    }
}

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
        <div class="row">
            <div class="col p-2">
                <a class="btn btn-maroon" href="./">Terug</a>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <h2>Aanmelden</h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- Lesson input -->
                    <div class="mb-3">
                        <label for="lessons" class="form-label">Selecteer de les waar u voor wilt reserveren</label>
                        <select name="lesson_id" class="form-select" id="lessons">
                            <?php foreach ($lessons as $lesson) { ?>
                                <option value="<?= $lesson['id']; ?>" <?= isset($selectedLesson['id']) && $lesson['id'] == $selectedLesson['id'] ? 'selected' : '' ?>><?= date('l d F | H:i', strtotime($lesson['start_datetime'])) . ' - ' . date('H:i', strtotime($lesson['end_datetime'])); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- Name input -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" value="<?= isset($name) ? htmlentities($name) : '' ?>" disabled>
                        <span class="text-danger"><?= isset($errors['name']) ? $errors['name'] : ''; ?></span>
                    </div>
                    <!-- Email input -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="text" name="email" class="form-control" id="email" value="<?= isset($email) ? htmlentities($email) : '' ?>" disabled>
                        <span class="text-danger"><?= isset($errors['email']) ? $errors['email'] : ''; ?></span>
                    </div>
                    <!-- Phone input -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="phone" value="<?= isset($phone) ? htmlentities($phone) : '' ?>" disabled>
                        <span class="text-danger"><?= isset($errors['phone']) ? $errors['phone'] : ''; ?></span>
                    </div>
                    <!-- Submit form -->
                    <div class="mb-3">
                        <input type="submit" name="submit" class="btn btn-primary" value="Submit" aria-describedby="contactHelp">
                        <div id="contactHelp" class="form-text">We'll never share your contact info with anyone else.</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>