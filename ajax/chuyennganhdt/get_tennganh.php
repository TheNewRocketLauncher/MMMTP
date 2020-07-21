<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
//$search = trim(optional_param('search', '', PARAM_NOTAGS));
$nganhdt = trim(required_param('nganhdt', PARAM_NOTAGS));
$courseid = required_param('course', PARAM_INT);

$tenganh = $DB->get_record('eb_nganhdt', ['ma_nganh' =>$nganhdt]);
$data=& $tenganh->ten;
    // Trả về kết quả với json_encode
    echo $data;
    exit;
 
