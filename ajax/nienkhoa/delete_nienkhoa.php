<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);
function delete_nienkhoa($id) {
    global $DB, $USER, $CFG, $COURSE;
    $DB->delete_records('eb_nienkhoa', array('id' => $id));
}
delete_nienkhoa($id);
    exit;

