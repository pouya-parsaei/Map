<?php defined('BASE_PATH') OR die('Permission Denied');
function getCurrentUrl(){
    return 1;
}

function diePage($msg){
    echo "<div style='color:#842029;background-color:#f8d7da;border-color:#f5c2c7;position:relative;padding:1rem 1rem;margin-bottom:1rem;border:1px solid transparent;border-radius:.25rem;'>{$msg}</div>";
    die();
}


function message($msg,$cssClass = 'info'){
    echo "<div class='$cssClass' style='color:#842029;background-color:#f8d7da;border-color:#f5c2c7;position:relative;padding:1rem 1rem;margin-bottom:1rem;border:1px solid transparent;border-radius:.25rem;'>{$msg}</div>";
} 

function isAjaxRequest(){
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
        return true;
    }
    return false;
}

function dd($var){
    echo "<pre style='color:#055160;background-color:#cff4fc;border-color:#b6effb;z-index: 999; position: absolute;    direction: ltr;z-index: 1000;'>";
    var_dump($var);
    echo "</pre>";
}

function site_url($uri  = ''){
    return BASE_URL . $uri;
}

function redirect($url){
    header("location: {$url}");
    die();
}