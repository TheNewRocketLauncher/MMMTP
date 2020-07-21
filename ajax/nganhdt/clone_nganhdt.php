<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
function clone_nganhdt($id)
{
    global $DB, $USER, $CFG, $COURSE;
    // Clone param
    $param = $DB->get_record('eb_nganhdt', array('id' => $id));
    // Config param
    $param->id = null;
    $param->ma_nganh = $param->ma_nganh . '_copy';
    $DB->insert_record('eb_nganhdt', $param);
}
// Clone bậc đào tạo có id truyền vào
clone_nganhdt($id);
// return
$output = "Clone ngành có ID = " . $id . " successfully!";
echo $output;
exit;
