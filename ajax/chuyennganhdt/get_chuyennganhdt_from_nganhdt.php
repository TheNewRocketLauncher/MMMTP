<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$bdt = trim(required_param('bdt', PARAM_NOTAGS));
$hdt = trim(required_param('hdt', PARAM_NOTAGS));
$nienkhoadt = trim(required_param('nienkhoadt', PARAM_NOTAGS));
$ma_nganh = trim(required_param('ma_nganh', PARAM_NOTAGS));
$courseid = required_param('course', PARAM_INT);

function get_chuyennganhdt_from_nganhdt($ma_bac, $ma_he, $ma_nienkhoa, $ma_nganh){
  global $DB, $USER, $CFG, $COURSE;
  $chuyennganhdt = $DB->get_records('eb_chuyennganhdt', array('ma_bac' => $ma_bac, 'ma_he' => $ma_he, 'ma_nienkhoa' => $ma_nienkhoa, 'ma_nganh' => $ma_nganh));
  return $chuyennganhdt;
}


$data = array();
$allchuyennganhdts = get_chuyennganhdt_from_nganhdt($bdt, $hdt, $nienkhoadt, $ma_nganh);

$data['chuyennganhdt'] = array();
$data['chuyennganhdt'][0] = "";
foreach ($allchuyennganhdts as $item) {
  $data['chuyennganhdt'][] = $item->ma_chuyennganh;
}

$nganh = $DB->get_record('eb_nganhdt', ['ma_nganh' =>$ma_nganh]);
$data['ten_chuyennganh'] =& $nganh->ten;
// Trả về kết quả với json_encode
echo json_encode($data);
exit;
 
