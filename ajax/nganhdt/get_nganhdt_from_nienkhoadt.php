<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$nienkhoadt = trim(required_param('nienkhoadt', PARAM_NOTAGS));
$courseid = required_param('course', PARAM_INT);
function get_nganhdt_from_nienkhoadt($nienkhoadt) {
    global $DB, $USER, $CFG, $COURSE;
    $nganhdt = $DB->get_records('block_edu_nganhdt', array('ma_nienkhoa' => $nienkhoadt));
    return $nganhdt;
}
    $data = array();
    $allnganhdts = get_nganhdt_from_nienkhoadt($nienkhoadt);
    
    $data['nganhdt'] = array();
    $data['nganhdt'][0] = "";
    foreach ($allnganhdts as $inganhdt) {
      $data['nganhdt'][] =& $inganhdt->ma_nganh;
      }

    $tennienkhoa = $DB->get_record('block_edu_nienkhoa', ['ma_nienkhoa' =>$nienkhoadt]);
    $data['tennienkhoa'] =& $tennienkhoa->ten_nienkhoa;
    // Trả về kết quả với json_encode
    echo json_encode($data);
    exit;
 
