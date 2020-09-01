<?php
error_reporting(0);

function checkData($x, $y, $r) {
    return in_array($x, array(-2, -1.5, -1, -0.5, 0, 0.5, 1, 1.5, 2)) &&
        is_numeric($y) && ($y > -3 && $y < 5) &&
        in_array($r, array( 1, 2, 3, 4, 5));
}

function atRectangle($x, $y, $r) {
    if (($x <= 0) && ($x >= -$r/2) && ($y >= 0) && ($y <= $r)) return true;
    else return false;
}

function atTriangle($x, $y, $r) {
    if (($y <= -$x + $r/2) && ($x >= 0) && ($x <= $r/2) && ($y >= 0) && ($y <= $r/2))
        return true;
    else return false;
}

function atQuarterCircle($x, $y, $r) {
    if (($x >= 0) && ($y <= 0) && (($x*$x + $y*$y) <= $r*$r)) return true;
    else return false;
}

function checkCoordinates($x, $y, $r) {
    if (atRectangle($x, $y, $r) || atTriangle($x, $y, $r) || atQuarterCircle($x, $y, $r)) {
        return "Да";
    }
    else return "Нет";
}

@session_start();
if (!isset($_SESSION["tableRows"])) $_SESSION["tableRows"] = array();
date_default_timezone_set($_GET["Europe/Moscow"]);
$x = (float) $_GET["x"];
$y = (float) $_GET["y"];
$r = (float) $_GET["r"];

if (checkData($x, $y, $r)) {
    $coordsStatus = checkCoordinates($x, $y, $r);
    $currentTime = date("H : i : s");
    $benchmarkTime = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    array_push($_SESSION["tableRows"], "<tr>
    <td>$x</td>
    <td>$y</td>
    <td>$r</td>
    <td>$coordsStatus</td>
    <td>$currentTime</td>
    <td>$benchmarkTime</td>
    </tr>");
    echo "<table id='outputTable'>
        <tr>
            <th>x</th>
            <th>y</th>
            <th>r</th>
            <th>Точка входит в ОДЗ</th>
            <th>Текущее время</th>
            <th>Время работы скрипта</th>
        </tr>";
    foreach ($_SESSION["tableRows"] as $tableRow) echo $tableRow;
    echo "</table>";
} else {
    http_response_code(400);
    return;
}