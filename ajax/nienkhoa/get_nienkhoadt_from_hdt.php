<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$hdt = trim(required_param('hdt', PARAM_NOTAGS));
$courseid = required_param('course', PARAM_INT);
function get_nienkhoadt_from_hdt($ma_he) {
    global $DB, $USER, $CFG, $COURSE;
    $nienkhoadt = $DB->get_records('block_edu_nienkhoa', array('ma_he' => $ma_he));
    return $nienkhoadt;
}
    $data = array();
    $allnienkhoadts = get_nienkhoadt_from_hdt($hdt);
    
    $data['nienkhoadt']=array();
    $data['nienkhoadt'][0]="";
    foreach ($allnienkhoadts as $inienkhoadt) {
      $data['nienkhoadt'][] =& $inienkhoadt->ma_nienkhoa;
      }

    $tenhe = $DB->get_record('block_edu_hedt', ['ma_he' =>$hdt]);
    $data['tenhe'] =& $tenhe->ten;
    // Trả về kết quả với json_encode
    echo json_encode($data);
    exit;
 
