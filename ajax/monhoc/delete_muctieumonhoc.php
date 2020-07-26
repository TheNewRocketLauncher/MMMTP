<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("monhoc", "edit");
function delete_muctieumonhoc($id)
{
    global $DB, $USER, $CFG, $COURSE;
    $DB->delete_records('eb_muctieumonhoc', array('id' => $id));
}
    delete_muctieumonhoc($id);

    // return
    $output = "Deleted MTMH has ID = " . $id . " successfully!";
    echo $output;
    exit;
 
