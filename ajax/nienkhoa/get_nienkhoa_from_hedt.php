<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$ma_he = required_param('bdt', PARAM_ALPHA);
$courseid = required_param('course', PARAM_INT);
function get_nienkhoa_from_hedt($ma_he) {
    global $DB, $USER, $CFG, $COURSE;
    $list_maNienkhoa = $DB->get_records('block_edu_nienkhoa', array('ma_he' => $ma_he));
    return $list_maNienkhoa;
}

$allnienkhoas = get_nienkhoa_from_hedt($ma_he);
$arr_manienkhoa = array();
foreach ($allnienkhoas as $i) {
  $arr_manienkhoa[] =& $i->ma_nienkhoa;
}
echo json_encode($arr_manienkhoa);
exit;
 
