<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);
function delete_lopmo($id) {
    global $DB, $USER, $CFG, $COURSE;
    $lopmo = $DB->get_record('block_edu_lop_mo' , ['id' => $id]);
    $lopmos = $DB->get_records('block_edu_lop_mo' , array('mamonhoc' => $lopmo->mamonhoc));
    $dem = 0;
    foreach($lopmos as $ilop)
    {
        $dem = $dem + 1;
    }
    if ($dem == 1 ){
        $monhoc = $DB->get_record('block_edu_monhoc' , ['mamonhoc' => $lopmo->mamonhoc]);
        $monhoc->lopmo = 0 ;
        $DB->update_record('block_edu_monhoc', $monhoc, $bulk = false);
    }
    $mamonhoc = $lopmo->mamonhoc; 
    $DB->delete_records('block_edu_lop_mo', array('id' => $id));
}
    delete_lopmo($id);
    exit;

