<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');




function fetch() {
   global $DB, $USER, $CFG, $COURSE;
   
   
    $all_ctdt = $DB->get_records('block_edu_ctdt', array(), '');
    $arr_ctdt = array();
    $stt = 1;
    foreach ($all_ctdt as $ictdt) {
        $arr_ctdt[] = ['ma_ctdt' => $ictdt->ma_ctdt, 'ma_bac'=> $ictdt->ma_bac, 'ma_he'=> $ictdt->ma_he , 'ma_nienkhoa'=> $ictdt->ma_nienkhoa, 'ma_nganh'=> $ictdt->ma_nganh , 'ma_chuyennganh'=> $ictdt->ma_chuyennganh];
        $stt = $stt + 1;
    }
   

   return $arr_ctdt;
}


    $All_ctdt = fetch();
    
    echo json_encode($All_ctdt);
    exit;
 
