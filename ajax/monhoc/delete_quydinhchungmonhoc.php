<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("monhoc", "edit");
function delete_quydinhchungmonhoc($id)
{
    global $DB, $USER, $CFG, $COURSE;
    $DB->delete_records('eb_quydinhchung', array('id' => $id));
}
    delete_quydinhchungmonhoc($id);
    // return
    $output = "Deleted QDC has ID = " . $id . " successfully!";
    echo $output;
    exit;
 
