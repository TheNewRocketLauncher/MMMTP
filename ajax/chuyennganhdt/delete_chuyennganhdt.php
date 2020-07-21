<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);
function delete_chuyennganhdt($id) {
    global $DB, $USER, $CFG, $COURSE;
    $DB->delete_records('eb_chuyennganhdt', array('id' => $id));
}
    // Xóa chuyên ngành đào tạo có id truyền vào
    delete_chuyennganhdt($id);
    // return
    $output = "Xóa chuyên ngành có ID = " . $id . " thành công!";
    echo $output;
    exit;
 
