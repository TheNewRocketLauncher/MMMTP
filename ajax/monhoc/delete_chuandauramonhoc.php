<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);
function delete_chuandauramonhoc($id) {
     /*
      $param = new stdClass();
      $param->ma_bac = 'DH';
      $param->ten = 'Đại học';
      $param->mota = 'Bậc Đại học HCMUS'
     */
    global $DB, $USER, $CFG, $COURSE;
    $DB->delete_records('block_edu_chuandaura', array('id' => $id));
}
    // Xóa bậc đào tạo có id truyền vào
    delete_chuandauramonhoc($id);
    // return
    $output = "Deleted CDR has ID = " . $id . " successfully!";
    echo $output;
    exit;
 
