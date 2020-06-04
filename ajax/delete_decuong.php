<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');
$ma_monhoc = required_param('ma_monhoc', PARAM_INT);
//$id_chuandaura_monhoc = required_param('id_chuandaura_monhoc', PARAM_INT);
//$id_kehoach_giangday = required_param('id_kehoach_giangday', PARAM_INT);
$courseid = required_param('course', PARAM_INT);
function delete_decuong($ma_monhoc) {
    
    global $DB, $USER, $CFG, $COURSE;
    $DB->delete_records('block_edu_muctieu_monhoc', array('ma_monhoc' => $ma_monhoc));
    $DB->delete_records('block_edu_chuandaura', array('ma_monhoc' => $ma_monhoc));
    $DB->delete_records('block_edu_kehoach_giangday', array('ma_monhoc' => $ma_monhoc));
}
    // Xóa bậc đào tạo có id_bac truyền vào
    delete_decuong($ma_monhoc);
    // return
    $output = "Delete successfully!";
    echo $output;
    exit;
 
