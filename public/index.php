<?php

function human_readable_time_diff($datetime1, $datetime2) {
    $datetime1 = new DateTime($datetime1);
    $datetime2 = new DateTime($datetime2);
    $interval = $datetime1->diff($datetime2);

    $suffix = $datetime1 > $datetime2 ? ' ago' : '';
    $prefix = $datetime1 > $datetime2 ? '' : 'in ';

    if ($interval->y !== 0) {
        return $prefix . $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . $suffix;
    } elseif ($interval->m !== 0) {
        return $prefix . $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . $suffix;
    } elseif ($interval->d !== 0) {
        return $prefix . $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . $suffix;
    } elseif ($interval->h !== 0) {
        return $prefix . $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . $suffix;
    } elseif ($interval->i !== 0) {
        return $prefix . $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . $suffix;
    } else {
        return $prefix . $interval->s . ' second' . ($interval->s > 1 ? 's' : '') . $suffix;
    }
}

date_default_timezone_set("Asia/Jakarta");
if (!session_id()) session_start();
require_once '../config/config.php';
require_once '../core/App.php';
require_once '../core/Controller.php';
require_once '../core/Model.php';
require_once '../core/View.php';

$app = new App();
?>
