<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);
function delete_muctieu_monhoc($id) {
     /*
      $param = new stdClass();
      $param->ma_bac = 'DH';
      $param->ten = 'Đại học';
      $param->mota = 'Bậc Đại học HCMUS'
     */
    global $DB, $USER, $CFG, $COURSE;
    $DB->delete_records('block_edu_muctieu_monhoc', array('id' => $id));
}
    // Xóa bậc đào tạo có id truyền vào
    delete_muctieu_monhoc($id);
    // return
    $output = "Deleted MTMH has ID = " . $id . " successfully!";
    echo $output;
    exit;
 
