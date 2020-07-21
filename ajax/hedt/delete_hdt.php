<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
function delete_bacdt($id) {
    global $DB, $USER, $CFG, $COURSE;
    $DB->delete_records('eb_hedt', array('id' => $id));
}
    delete_bacdt($id);
    // return
    $output = "Deleted HDT has ID = " . $id . " successfully!";
    echo $output;
    exit;
 
