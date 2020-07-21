<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);
function delete_kehoachgiangday($id) {
    global $DB, $USER, $CFG, $COURSE;
    $DB->delete_records('eb_kh_giangday_lt', array('id' => $id));
}
    delete_kehoachgiangday($id);
    // return
    $output = "Deleted KHGD has ID = " . $id . " successfully!";
    echo $output;
    exit;
 
