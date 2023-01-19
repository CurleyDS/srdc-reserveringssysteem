<?php
// Check if data isset and valid. Generate error if not true.
$errors = [];

if (isset($_POST['id'])) {
    if ($id == "") {
        $errors['id'] = 'No id set';
    }
}

if (isset($_POST['lesson_id'])) {
    if ($lesson_id == "") {
        $errors['lesson_id'] = 'Lesson must be chosen';
    }
}

// If trial_lesson is not mysqli_escape_string($db, boolean), generate error.
if (isset($_POST['trial_lesson'])) {
    if ($trial_lesson != mysqli_escape_string($db, true)) {
        if ($trial_lesson != mysqli_escape_string($db, false)) {
            $errors['trial_lesson'] = 'Trial invalid';
        }
    }
}

if (isset($_POST['name'])) {
    if ($name == "") {
        $errors['name'] = 'Name cannot be empty';
    }
}

// If phone contains letters, generate error.
if (isset($_POST['phone'])) {
    if (!is_numeric(preg_replace('/[\s]+/', '', $phone))) {
        $errors['phone'] = 'Phone cannot contain letters';
    }

    if ($phone == "") {
        $errors['phone'] = 'Phone cannot be empty';
    }
}

// If email contains invalid emailadres, generate error.
if (isset($_POST['email'])) {
    if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) {
        $errors['email'] = 'Email invalid';
    }

    if ($email == "") {
        $errors['email'] = 'Email cannot be empty';
    }
}

if (isset($_POST['password'])) {
    if ($password == "") {
        $errors['password'] = 'Password cannot be empty';
    }
}

// If register_password does not contain uppercase letters, lowercase letters, numbers, or is shorter than 8, generate error.
if (isset($_POST['register_password'])) {
    if (!preg_match('@[A-Z]@', $registerPassword)) {
        $errors['register_password'] = 'No uppercase in the password';
    }
    
    if (!preg_match('@[a-z]@', $registerPassword)) {
        $errors['register_password'] = 'No lowercase in the password';
    }
    if (!preg_match('@[0-9]@', $registerPassword)) {
        $errors['register_password'] = 'No numbers in the password';
    }
    if (strlen($registerPassword) < 8) {
        $errors['register_password'] = 'Password needs to be longer than 8';
    }
    if ($registerPassword == "") {
        $errors['register_password'] = 'Password cannot be empty';
    }
}