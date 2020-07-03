<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
function clone_hedt($id)
{
    global $DB, $USER, $CFG, $COURSE;
    // Clone param
    $param = $DB->get_record('block_edu_hedt', array('id' => $id));
    // Config param
    $param->id = null;
    $param->ma_he = $param->ma_he . '_copy';
    $DB->insert_record('block_edu_hedt', $param);
}
// Clone bậc đào tạo có id truyền vào
clone_hedt($id);
// return
$output = "Clone HDT has ID = " . $id . " successfully!";
echo $output;
exit;
