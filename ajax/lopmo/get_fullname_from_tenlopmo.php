<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$mamonhoc = required_param('mamonhoc', PARAM_ALPHA);
$ma_ctdt = required_param('ma_ctdt', PARAM_ALPHA);
$courseid = required_param('course', PARAM_INT);


function get_fullname_from_tenlopmo($mamonhoc) {
  global $DB, $USER, $CFG, $COURSE;
  $mamonhoc = $DB->get_record('block_edu_monhoc', ['mamonhoc' => $mamonhoc]);

  return $mamonhoc;
}

    // Lấy ra các hệ ĐT
    $monhoc = get_fullname_from_tenlopmo($mamonhoc);
    
    $result = $monhoc->tenmonhoc_vi;
    // Trả về kết quả với json_encode
    echo json_encode($result);
    exit;
 
