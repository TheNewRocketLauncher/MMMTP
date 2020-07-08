<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$bdt = trim(required_param('bdt', PARAM_NOTAGS));
$courseid = required_param('course', PARAM_INT);
function get_hdt_from_bdt($bdt) {
    global $DB, $USER, $CFG, $COURSE;
    $hdt = $DB->get_records('block_edu_hedt', array('ma_bac' => $bdt));
    return $hdt;
}
    $data = array();
    $allhedts = get_hdt_from_bdt($bdt);
    
    $data['hedt'] = array();
    $data['hedt'][0]= "";

    foreach ($allhedts as $ihedt) {
      $data['hedt'][]=& $ihedt->ma_he;
      }

    $tenbac = $DB->get_record('block_edu_bacdt', ['ma_bac' =>$bdt]);
    $data['tenbac'] =& $tenbac->ten;
    // Trả về kết quả với json_encode

    echo json_encode($data);
    exit;
 
