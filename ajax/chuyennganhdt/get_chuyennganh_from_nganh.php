<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$ma_nganh = required_param('bdt', PARAM_ALPHA);
$courseid = required_param('course', PARAM_INT);
function get_chuyennganh_from_nganh($ma_nganh) {
  global $DB, $USER, $CFG, $COURSE;
  $list = $DB->get_records('block_edu_chuyennganhdt', array('ma_nganh' => $ma_nganh));
  return $list;
}

$allchuyennganh = get_chuyennganh_from_nganh($ma_nganh);
$arr_chuyennganh = array();
foreach ($allchuyennganh as $i) {
  $arr_chuyennganh[] =& $i->ma_chuyennganh;
}
echo json_encode($arr_chuyennganh);
exit;
 
