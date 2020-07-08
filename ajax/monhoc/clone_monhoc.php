<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
function clone_monhoc($id)
{
    global $DB, $USER, $CFG, $COURSE;
    // Clone param
    $param = $DB->get_record('block_edu_monhoc', array('id' => $id));
    // Config param
    $param->id = null;
    $param->mamonhoc = $param->mamonhoc . '_copy';
    $DB->insert_record('block_edu_monhoc', $param);
}
// Clone môn học có id truyền vào
clone_monhoc($id);
// return
$output = "Clone môn học có ID = " . $id . " successfully!";
echo $output;
exit;
