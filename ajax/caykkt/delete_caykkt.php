<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/caykkt_model.php');

$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);

function get_leaves_from_branch($ma_cay_khoikienthuc) {
  global $DB, $USER, $CFG, $COURSE;
  $mk = $DB->get_records('block_edu_cay_khoikienthuc', array('ma_cay_khoikienthuc' => $ma_cay_khoikienthuc));
  return $mk;
}

function delete_caykkt($id) {
  global $DB, $USER, $CFG, $COURSE;
  $cay_khoi_kien_thuc = get_caykkt_byID($id);
  $ma_cay_khoi_kien_thuc = $cay_khoi_kien_thuc->ma_cay_khoikienthuc;
  echo $ma_cay_khoi_kien_thuc;
  $DB->delete_records('block_edu_cay_khoikienthuc', array('ma_cay_khoikienthuc' => $ma_cay_khoi_kien_thuc));
}

delete_caykkt($id);
echo 'deleted';
exit;


