<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');

$id = required_param('id', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("bacdt", "edit");
function delete_hedt($id)
{
    global $DB, $USER, $CFG, $COURSE;
    $DB->delete_records('eb_bacdt', array('id' => $id));
}
// Xóa bậc đào tạo có id truyền vào
delete_hedt($id);
// return
$output = "Deleted HDT has ID = " . $id . " successfully!";
echo $output;
exit;
