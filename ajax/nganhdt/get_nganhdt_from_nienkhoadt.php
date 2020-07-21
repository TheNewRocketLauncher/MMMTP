<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$bdt = trim(required_param('bdt', PARAM_NOTAGS));
$hdt = trim(required_param('hdt', PARAM_NOTAGS));
$nienkhoadt = trim(required_param('nienkhoadt', PARAM_NOTAGS));
$courseid = required_param('course', PARAM_INT);
function get_nganhdt_from_nienkhoadt($ma_bac, $ma_he, $ma_nienkhoa) {
    global $DB, $USER, $CFG, $COURSE;
    $nganhdt = $DB->get_records('eb_nganhdt', array('ma_bac' => $ma_bac, 'ma_he' => $ma_he, 'ma_nienkhoa' => $ma_nienkhoa));
    return $nganhdt;
}
    $data = array();
    $allnganhdts = get_nganhdt_from_nienkhoadt($bdt, $hdt, $nienkhoadt);
    
    $data['nganhdt'] = array();
    $data['nganhdt'][0] = "";
    foreach ($allnganhdts as $inganhdt) {
      $data['nganhdt'][] =& $inganhdt->ma_nganh;
      }

    $tennienkhoa = $DB->get_record('eb_nienkhoa', ['ma_nienkhoa' =>$nienkhoadt]);
    $data['tennienkhoa'] =& $tennienkhoa->ten_nienkhoa;
    // Trả về kết quả với json_encode
    echo json_encode($data);
    exit;
 
