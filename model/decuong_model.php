<?php
require_once(__DIR__ . '/../../../config.php');
require_once('../../controller/support.php');
 


function get_list_decuong_byMaCTDT($ma_ctdt){
   global $DB, $USER, $CFG, $COURSE;
   $list = $DB->get_records('eb_decuong', ['ma_ctdt' => $ma_ctdt]);
   return $list;
}

function get_name_khoikienthuc($ma_ctdt, $mamonhoc){
   global $DB;
   $listkhoi = $DB->get_records('eb_monthuockhoi', ['mamonhoc' => $mamonhoc]);

   foreach($listkhoi as $ikhoi){
      $listcay = $DB->get_records('eb_cay_khoikienthuc', ['ma_khoi' => $ikhoi->ma_khoi]);

      foreach($listcay as $icay){
         $ctdt_ss =  $DB->get_record('eb_ctdt', ['ma_cay_khoikienthuc' => $icay->ma_cay_khoikienthuc]);
         if($ctdt_ss->ma_ctdt == $ma_ctdt){
               
               $khoikienthuc = $DB->get_record('eb_khoikienthuc', ['ma_khoi' => $ikhoi->ma_khoi]);

               return $khoikienthuc->ten_khoi;
         }
      }
   }

}
