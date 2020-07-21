<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');

$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);
function delete_lopmo($id) {
    global $DB, $USER, $CFG, $COURSE;
    $lopmo = $DB->get_record('eb_lop_mo' , ['id' => $id]);
    $lopmos = $DB->get_records('eb_lop_mo' , array('mamonhoc' => $lopmo->mamonhoc));
    $dem = 0;
    foreach($lopmos as $ilop)
    {
        $dem = $dem + 1;
    }
    if ($dem == 1 ){
        $monhoc = $DB->get_record('eb_monhoc' , ['mamonhoc' => $lopmo->mamonhoc]);
        $monhoc->lopmo = 0 ;
        $DB->update_record('eb_monhoc', $monhoc, $bulk = false);
    }
        // $mamonhoc = $lopmo->mamonhoc; 
        $course_id = $lopmo->course_id;
        $DB->delete_records('eb_lop_mo', array('id' => $id));
        $course = $DB->get_record('course', array('id' => $course_id), '*', MUST_EXIST);
        delete_course($course);
        fix_course_sortorder();

    

}
    delete_lopmo($id);
    exit;

