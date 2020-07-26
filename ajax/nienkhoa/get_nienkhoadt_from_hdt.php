<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$bdt = trim(required_param('bdt', PARAM_NOTAGS));
$hdt = trim(required_param('hdt', PARAM_NOTAGS));
$courseid = required_param('course', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("nienkhoa", "edit");
function get_nienkhoadt_from_hdt($ma_bac, $ma_he) {
    global $DB, $USER, $CFG, $COURSE;
    $nienkhoadt = $DB->get_records('eb_nienkhoa', array('ma_bac' => $ma_bac, 'ma_he' => $ma_he));
    return $nienkhoadt;
}

    $data = array();
    $allnienkhoadts = get_nienkhoadt_from_hdt($bdt, $hdt);
    
    $data['nienkhoadt']=array();
    $data['nienkhoadt'][0]="";
    foreach ($allnienkhoadts as $inienkhoadt) {
      $data['nienkhoadt'][] =& $inienkhoadt->ma_nienkhoa;
      }

    $tenhe = $DB->get_record('eb_hedt', ['ma_he' =>$hdt]);
    $data['tenhe'] =& $tenhe->ten;
    // Trả về kết quả với json_encode
    echo json_encode($data);
    exit;
 
