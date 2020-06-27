<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
function clone_lopmo($id) {
    global $DB, $USER, $CFG, $COURSE;    
    $param = $DB->get_record('block_edu_lop_mo', array('id' => $id));
    $param->id = null;
    $param->full_name = $param->full_name . '_copy';
    $param->short_name = $param->short_name . '_copy';
    $DB->insert_record('block_edu_lop_mo',$param);
}
clone_lopmo($id);
    exit;

