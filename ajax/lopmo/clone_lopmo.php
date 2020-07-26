<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/lopmo_model.php');
$id = required_param('id', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("lopmo", "edit");
function clone_lopmo($id) {
    global $DB, $USER, $CFG, $COURSE;    
    $param = $DB->get_record('eb_lop_mo', array('id' => $id));
    $param->id = null;

    $mamonhoc= $param->mamonhoc;
    $ma_ctdt= $param->ma_ctdt;
    
        $result = get_lopmo_from_mamonhoc($mamonhoc,$ma_ctdt);
        $monhoc = $DB->get_record('eb_monhoc',array('mamonhoc' => $mamonhoc));
        $param->full_name = $monhoc->tenmonhoc_vi . $result;
        $param->short_name = $monhoc->mamonhoc . $result;
        // $DB->insert_record('eb_lop_mo',$param);
        insert_lopmo($param);

    }



function get_lopmo_from_mamonhoc($mamonhoc , $ma_ctdt) {

    global $DB, $USER, $CFG, $COURSE;
    $ctdt = $DB->get_record('eb_ctdt',array('ma_ctdt' => $ma_ctdt));

    $lopmo = $DB->get_records('eb_lop_mo', array('mamonhoc' => $mamonhoc , 'ma_nienkhoa' => $ctdt->ma_nienkhoa, 'ma_nganh'=> $ctdt->ma_nganh, 'ma_ctdt' => $ctdt->ma_ctdt ));

    usort($lopmo, function($a, $b)
    {
       return strcmp($a->full_name, $b->full_name);
    });


    $len2 = 1 ; 
    if (count($lopmo)  >= 1){
      $maxOld = 0 ;
      $maxResult = 0 ;
      $maxNew = 0 ;
      foreach ($lopmo as $item ){
        $fullname_split = explode("_",$item->full_name);
        $stt = intval($fullname_split[1][1]) ;
        // echo " stt " . $stt;  
        $maxOld = $maxNew;
        if($stt > $maxNew){
          $maxNew = $stt ; 
        }
        if (($maxNew-$maxOld)>1 && $maxResult == 0 ){
          $maxResult = $maxOld  + 1 ; 
        }
      }
      $maxNew = $maxNew + 1;
      $len2 = ($maxResult == 0 ? $maxNew : $maxResult) ;
    }
    
    $chuyennganhdts = $DB->get_records('eb_chuyennganhdt' ,['ma_nganh' => $ctdt->ma_nganh]);
    $temparray = array();

    foreach($chuyennganhdts as $item){
      $temparray [] =& $item->ma_chuyennganh;
    }
    $currentchuyennganhdt = $DB->get_record('eb_chuyennganhdt',array('ma_chuyennganh' => $ctdt->ma_chuyennganh));
    $index = array_search($currentchuyennganhdt->ma_chuyennganh,$temparray);
    $index = $index + 1 ;

    $rsx =  ' ' . $ctdt->ma_nienkhoa . '_' . $index . $len2;
    // echo "Rsx" . $rsx;
    return $rsx;
    
}

clone_lopmo($id);

    exit;

