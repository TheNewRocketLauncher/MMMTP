<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);
function delete_tainguyenmonhoc($id) {
    global $DB, $USER, $CFG, $COURSE;
    $DB->delete_records('block_edu_tainguyenmonhoc', array('id' => $id));
}
    delete_tainguyenmonhoc($id);
    // return
    $output = "Deleted tainguyenmonhoc has ID = " . $id . " successfully!";
    echo $output;
    exit;
 