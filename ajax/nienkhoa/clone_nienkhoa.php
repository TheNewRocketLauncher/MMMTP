<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
function clone_nienkhoa($id) {
    global $DB, $USER, $CFG, $COURSE;    
    $param = $DB->get_record('block_edu_nienkhoa', array('id' => $id));
    $param->id = null;
    $param->full_name = $param->ten_nienkhoa . '_copy';
    $DB->insert_record('block_edu_nienkhoa',$param);
}
clone_nienkhoa($id);
    exit;

