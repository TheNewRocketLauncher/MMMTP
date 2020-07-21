<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$ma_ctdt = optional_param('ma_ctdt', '', PARAM_NOTAGS);



function getMonhocByMaCTDT($ma_ctdt) {
   global $DB, $USER, $CFG, $COURSE;
   $arr = array();
   
   $ma_cay_khoikienthuc = $DB->get_record('eb_ctdt', array('ma_ctdt' => $ma_ctdt))->ma_cay_khoikienthuc;
    
   $list_makhoi = $DB->get_records('eb_cay_khoikienthuc', array('ma_cay_khoikienthuc' => $ma_cay_khoikienthuc));
   
   foreach($list_makhoi as $item){
   
      $list_mon_thuockhoi =  $DB->get_records('eb_monthuockhoi', array('ma_khoi' => $item->ma_khoi));

      foreach($list_mon_thuockhoi as $j){
         $arr[] =& $j->mamonhoc;
      }
   }

   return $arr;
}


    $allMons = getMonhocByMaCTDT($ma_ctdt);
    
    echo json_encode($allMons);
    exit;
 
