<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
function clone_chuyennganhdt($id)
{
    global $DB, $USER, $CFG, $COURSE;
    // Clone param
    $param = $DB->get_record('block_edu_chuyennganhdt', array('id' => $id));
    // Config param
    $param->id = null;
    $param->ma_chuyennganh = $param->ma_chuyennganh . '_copy';
    $DB->insert_record('block_edu_chuyennganhdt', $param);
}
// Clone bậc đào tạo có id truyền vào
clone_chuyennganhdt($id);
// return
$output = "Clone chuyên ngành đt has ID = " . $id . " successfully!";
echo $output;
exit;
