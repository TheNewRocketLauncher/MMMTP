<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);
function delete_nganhdt($id) {    
    global $DB, $USER, $CFG, $COURSE;
    $DB->delete_records('block_edu_nganhdt', array('id' => $id));
}
    // Xóa ngành đào tạo có id truyền vào
    delete_nganhdt($id);
    // return
    $output = "Deleted  NDT has ID = " . $id . " successfully!";
    echo $output;
    exit;
 
