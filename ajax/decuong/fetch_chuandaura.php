<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$ma_decuong = optional_param('ma_decuong','', PARAM_ALPHANUMEXT);



function fetch($ma_decuong) {
   global $DB, $USER, $CFG, $COURSE;
   
   
    $all_cdr = $DB->get_records('eb_chuandaura', array('ma_decuong' => $ma_decuong));
    $arr_cdr = array();
    $stt = 1;
    foreach ($all_cdr as $icdr) {
        $arr_cdr[] = $icdr->ma_cdr;
        $stt = $stt + 1;
    }
   

   return $arr_cdr;
}


    $All_cdr = fetch($ma_decuong);
    
    echo json_encode($All_cdr);
    exit;
 
