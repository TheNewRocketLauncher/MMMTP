<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$bdt = required_param('bdt', PARAM_ALPHA);
$courseid = required_param('course', PARAM_INT);
function get_hdt_from_bdt($ma_bac) {
    global $DB, $USER, $CFG, $COURSE;
    $hdt = $DB->get_records('block_edu_hedt', array('ma_bac' => $ma_bac));
    return $hdt;
}
    // Lấy ra các hệ ĐT
    $allhedts = get_hdt_from_bdt($bdt);
    // Tạo mảng chứa danh sách mã hệ
    $arr_mahe = array();
    foreach ($allhedts as $ihedt) {
        $arr_mahe[] =& $ihedt->ma_he;
      }
    // Trả về kết quả với json_encode
    echo json_encode($arr_mahe);
    exit;
 
