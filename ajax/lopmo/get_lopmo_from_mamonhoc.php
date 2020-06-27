<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$mamonhoc = required_param('mamonhoc', PARAM_ALPHA);
$courseid = required_param('course', PARAM_INT);
function get_lopmo_from_mamonhoc($mamonhoc) {
    global $DB, $USER, $CFG, $COURSE;
    $lopmo = $DB->get_records('block_edu_lop_mo', array('mamonhoc' => $mamonhoc));
    return $lopmo;
}
    // Lấy ra các hệ ĐT
    $rows = get_lopmo_from_mamonhoc($mamonhoc);
    // Tạo mảng chứa danh sách mã hệ
    $arr_lopmo = array();
    foreach ($rows as $item) {
        $arr_lopmo[] =& $item->full_name;
      }
    // Trả về kết quả với json_encode
    echo json_encode($arr_lopmo);
    exit;
 
