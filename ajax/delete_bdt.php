<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');
$id_bac = required_param('id_bac', PARAM_INT);
$courseid = required_param('course', PARAM_INT);
function delete_bacdt($id_bac) {
     
    global $DB, $USER, $CFG, $COURSE;
    $DB->delete_records('block_edu_bacdt', array('id_bac' => $id_bac));
}
// Xóa bậc đào tạo có id_bac truyền vào
delete_bacdt($id_bac);
// return
$output = "Delete successfully!";
echo $output;
exit;
 
