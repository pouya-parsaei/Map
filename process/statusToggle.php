<?php
include '../bootstrap/init.php';

if (!isAjaxRequest()) {
  diePage('Invalid Request');
}

if (is_null($_POST['loc']) || !is_numeric($_POST['loc'])) {
  echo "Invalid Location";
}
//request is ajax and ok

echo toggleStatus($_POST['loc']);