<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$ma_decuong = optional_param('ma_decuong', '', PARAM_NOTAGS);
require_once('../../controller/auth.php');
require_permission("decuong", "edit");



function fetch($ma_decuong) {
   global $DB, $USER, $CFG, $COURSE;
   
   
    $allmuctieu = $DB->get_records('eb_muctieumonhoc', array('ma_decuong' => $ma_decuong));
    $arr_muctieu = array();
    $stt = 1;
    foreach ($allmuctieu as $imuctieu) {
        $arr_muctieu[] = $imuctieu->muctieu;
        $stt = $stt + 1;
    }
   

   return $arr_muctieu;
}


    $Allmuctieu = fetch($ma_decuong);
    
    echo json_encode($Allmuctieu);
    exit;
 
