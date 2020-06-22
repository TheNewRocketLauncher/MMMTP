<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$ma_nienkhoa = required_param('ma_nienkhoa', PARAM_ALPHA);
$courseid = required_param('course', PARAM_INT);
function get_nganh_from_nienkhoa($ma_nienkhoa) {
  global $DB, $USER, $CFG, $COURSE;
  $list = $DB->get_records('block_edu_nganhdt', array('ma_nienkhoa' => $ma_nienkhoa));
  return $list;
}

$allnganhs = get_nganh_from_nienkhoa($ma_nienkhoa);
$arr_manganh = array();
foreach ($allnganhs as $i) {
  $arr_manganh[] =& $i->ma_nganh;
}
echo json_encode($arr_manganh);
exit;
 
