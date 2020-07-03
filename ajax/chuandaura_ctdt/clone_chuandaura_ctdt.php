<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
function clone_chuandaura_ctdt($id) {
    global $DB, $USER, $CFG, $COURSE;    
    $param = $DB->get_record('block_edu_chuandaura_ctdt', array('id' => $id));
    $param->id = null;
    $param->ten = $param->ten . '_copy';
    
    $DB->insert_record('block_edu_chuandaura_ctdt',$param);
}
clone_chuandaura_ctdt($id);
    exit;

