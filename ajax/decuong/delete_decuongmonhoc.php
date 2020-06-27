<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);

function delete_decuongmonhoc($id) {
    global $DB, $USER, $CFG, $COURSE;
    $DB->delete_records('block_edu_decuong', array('id' => $id));
}
delete_decuongmonhoc($id);

    // return
    $output = "Deleted MTMH has ID = " . $id . " successfully!";
    echo $output;
    exit;
 
