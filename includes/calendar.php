<?php
// Set your timezone!!
date_default_timezone_set('Europe/Amsterdam');

$date = new DateTime;
if (isset($_GET['year']) && isset($_GET['week'])) {
    if ($_GET['year'] == $date->format('o') && $_GET['week'] == $date->format('W')) {
        header('Location:' . $base_url);
        exit;
    } else {
        $date->setISODate($_GET['year'], $_GET['week']);
    }
} else {
    $date->setISODate($date->format('o'), $date->format('W'));
}

$year = $date->format('o');
$yw = $date->format('W');

$today = $date->format('d M Y');

$titles = [
    'week' => 'Week ' . $date->format('W'),
    'yearmonth' => $date->format('F o')
];

$prev = ['week' => $yw-1, 'year' => $year];
$next = ['week' => $yw+1, 'year' => $year];

$day_count = 7;
$hour_count = 23;

$week = [];
$day = [];

for ($x=1; $x <= $day_count; $x++) {
    $day['day'] = $date->format('l');
    $day['date'] = $date->format('j');
    $day['full_date'] = $date->format('Y-m-j');

    $hour = [];
    $lessons = getAllLessons($db);
    for ($y=0; $y <= $hour_count; $y++) { 
        $hour['time'] = date("H:i", mktime($y, 0, 0, 0, 0, 0));
        foreach ($lessons as $lesson) {
            if ($day['date'] == date('j', strtotime($lesson['start_datetime'])) && 
                $y == date('H', strtotime($lesson['start_datetime']))) {
                $hour['lessons'][] = $lesson;
            }
        }

        $day['hours'][] = $hour;
        $hour = [];
    }
    
    array_push($week, $day);
    $day = [];
    
    $date->modify('+1 day');
}
?>