<?php
// Require DB settings with connection variable
$host       = "localhost";
$database   = "srdc_database";
$user       = "root";
$password   = "mysql";

// Get base_url
$base_url = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
$base_url .= $_SERVER["SERVER_NAME"];
$uri_dir = dirname($_SERVER["PHP_SELF"]);
if ($uri_dir != "\\") 
{
    $base_url .= $uri_dir;
}

// Functions that are used in other files
function formatToDate($datetime) {
    return date('d-m-Y', strtotime($datetime));
}

function formatToTime($datetime) {
    return date("H:i", strtotime($datetime));
}

function formatStrToTime($str) {
    return date("H:i", mktime($str, 0, 0, 0, 0, 0));
}

// Start session
session_start();

// Create connection to the database
$db = mysqli_connect($host, $user, $password, $database)
    or die("Error: " . mysqli_connect_error());;

    /**
     * Function: login
     * Description: This function logs in the user by 
     * verifying the given password.
     */
    function login(mysqli $db, $email, $password) {
        // Prepare query and execute
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($db, $query) or die ('Error: ' . $query );

        if (mysqli_num_rows($result) == 1) {
            // Get user data from result
            $user = mysqli_fetch_assoc($result);

            // Check if the provided password matches the stored password in the database
            echo $password;
            if (password_verify($password, $user['password'])) {
                // Store the user in the session
                $_SESSION['user'] = [
                    'id'    => $user['id'],
                    'name'  => $user['name'],
                    'phone' => $user['phone'],
                    'email' => $user['email'],
                ];

                // Redirect to secure page
            } else {
                //error incorrect log in
                $user = 'Login failed';
            }
        } else {
            //error incorrect log in
            $user = 'Login failed';
        }
        
        return $user;
    }
    
    /**
     * Function: register
     * Description: This function registers a new user.
     */
    function register(mysqli $db, $name, $registerPassword, $phone, $email) {
        // Hash password
        $password = password_hash($registerPassword, PASSWORD_DEFAULT);
        
        // Prepare query and execute
        $query = "INSERT INTO users (name, password, phone, email)
                      VALUES ('$name', '$password', '$phone', '$email')";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

        return $result;
    }

    /**
     * Function: getAllLessons
     * Description: This function gets all the lessons
     * from the database table starting from current date.
     */
    function getAllLessons(mysqli $db) {
        // Prepare query and execute
        $query = "SELECT * FROM `lessons`";
        $result = mysqli_query($db, $query) or die ('Error: ' . $query );
        
        $lessons = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $lessons[] = $row;
        }

        return $lessons;
    }

    /**
     * Function: getTrialLessons
     * Description: This function gets all the trial-lessons
     * from the database table starting from current date.
     */
    function getTrialLessons(mysqli $db) {
        // Prepare query and execute
        $query = "SELECT * FROM `lessons` WHERE trial_lesson = 1 AND start_datetime >= CURDATE()";
        $result = mysqli_query($db, $query) or die ('Error: ' . $query );
        
        $trialLessons = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $trialLessons[] = $row;
        }

        return $trialLessons;
    }

    /**
     * Function: getLessons
     * Description: This function gets all the lessons
     * from the database table starting from current date.
     */
    function getLessons(mysqli $db) {
        // Prepare query and execute
        $query = "SELECT * FROM `lessons` WHERE trial_lesson = 0 AND start_datetime >= CURDATE()";
        $result = mysqli_query($db, $query) or die ('Error: ' . $query );
        
        $lessons = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $lessons[] = $row;
        }

        return $lessons;
    }

    /**
     * Function: getLesson
     * Description: This function gets the lesson with the 
     * given lessonId from the database table.
     */
    function getLesson(mysqli $db, $lessonId) {
        // Prepare query and execute
        $query = "SELECT * FROM lessons WHERE id = '$lessonId'";
        $result = mysqli_query($db, $query) or die ('Error: ' . $query );

        return $result;
    }

    /**
     * Function: insertLesson
     * Description: This function inserts a new lesson into the database table.
     */
    function insertLesson(mysqli $db, $trial_lesson, $start_datetime, $end_datetime) {
        // Prepare query and execute
        $query = "INSERT INTO lessons (trial_lesson, start_datetime, end_datetime)
                VALUES (null, '$lesson_id', '$name', '$phone', '$email')";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

        return $result;
    }

    /**
     * Function: updateLesson
     * Description: This function updates the lesson 
     * with the given id from the database table.
     */
    function updateLesson(mysqli $db, $id, $trial_lesson, $start_datetime, $end_datetime) {
        // Prepare query and execute
        $query = "UPDATE lesson
                  SET trial_lesson='$trial_lesson', start_datetime='$start_datetime', end_datetime='$end_datetime'
                  WHERE id=$id";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

        return $result;
    }

    /**
     * Function: deleteLesson
     * Description: This function deletes the lesson 
     * with the given id from the database table.
     */
    function deleteLesson(mysqli $db, $id) {
        // Prepare query and execute
        $query = "DELETE FROM lessons WHERE id = '$id'";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

        return $result;
    }

    /**
     * Function: getReservations
     * Description: This function gets all the reservations 
     * from the database table.
     */
    function getReservations(mysqli $db) {
        // Prepare query and execute
        $query = "SELECT * FROM `reservations`";
        $result = mysqli_query($db, $query) or die ('Error: ' . $query );
        
        $reservations = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $reservations[] = $row;
        }

        return $reservations;
    }

    /**
     * Function: getReservation
     * Description: This function gets the reservation with the 
     * given reservationId from the database table.
     */
    function getReservation(mysqli $db, $reservationId) {
        // Prepare query and execute
        $query = "SELECT * FROM reservations WHERE id = '$reservationId'";
        $result = mysqli_query($db, $query) or die ('Error: ' . $query);

        return $result;
    }

    /**
     * Function: insertReservation
     * Description: This function inserts a new reservation into the database table.
     */
    function insertReservation(mysqli $db, $lesson_id, $name, $phone, $email) {
        // Prepare query and execute
        $query = "INSERT INTO reservations (course_id, lesson_id, name, phone, email)
                VALUES (null, '$lesson_id', '$name', '$phone', '$email')";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

        return $result;
    }

    /**
     * Function: updateReservation
     * Description: This function updates the reservation 
     * with the given id from the database table.
     */
    function updateReservation(mysqli $db, $id, $lesson_id, $name, $phone, $email) {
        // Prepare query and execute
        $query = "UPDATE reservations
                  SET lesson_id='$lesson_id', name='$name', phone='$phone', email='$email'
                  WHERE id=$id";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

        return $result;
    }

    /**
     * Function: deleteReservation
     * Description: This function deletes the reservation 
     * with the given id from the database table.
     */
    function deleteReservation(mysqli $db, $id) {
        // Prepare query and execute
        $query = "DELETE FROM reservations WHERE id = '$id'";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

        return $result;
    }
    
// Set the timezone!!
date_default_timezone_set('Europe/Amsterdam');
