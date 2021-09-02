<?php
include '../bootstrap/init.php';

usleep(500000);
if (!isAjaxRequest()) {
    diePage('Invalid Request');
}
//request is ajax and ok

$keyword = $_POST['keyword'];
if (!isset($keyword) || empty($keyword)) {
    die('نتیجه ای یافت نشد');
}
$locations = getLocations(['keyword' => $keyword]);
if (sizeof($locations) == 0) {
    die('نتیجه ای یافت نشد');
}
foreach ($locations as $loc) {
    echo "<a href='".BASE_URL."?loc={$loc->id}'><div class='result-item' data-lat='{$loc->lat}' data-lng='{$loc->lng} data-loc='{$loc->id}''>
    <span class='loc-type'>".locationTypes[$loc->type]."</span>
    <span class='loc-title'>{$loc->title}</span>
</div></a>";
}


# better solution
//send header content type json
//echo json_encode($locations);
