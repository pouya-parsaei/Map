<?php
include '../bootstrap/init.php';

if (!isAjaxRequest()) {
    diePage('Invalid Request');
}
//request is ajax and ok
/* print_r($_POST); */
$north = $_POST['north'];
$south = $_POST['south'];
$west = $_POST['west'];
$east = $_POST['east'];

$locations = getLocations(['coordinates' =>
[
    'north' => $north,
    'south' => $south,
    'west' => $west,
    'east' => $east
]]);

print_r(json_encode($locations));
