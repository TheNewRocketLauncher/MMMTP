<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
function clone_bacdt($id)
{
    global $DB, $USER, $CFG, $COURSE;
    // Clone param
    $param = $DB->get_record('eb_bacdt', array('id' => $id));
    // Config param
    $param->id = null;
    $param->ma_bac = $param->ma_bac . '_copy';
    $DB->insert_record('eb_bacdt', $param);
}
// Clone bậc đào tạo có id truyền vào
clone_bacdt($id);
// return
$output = "Clone BDT has ID = " . $id . " successfully!";
echo $output;
exit;
