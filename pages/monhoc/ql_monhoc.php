<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');
// require_once('../factory.php');

// Create button with method post
function button_method_post($btn_name, $btn_value) {
    $btn = html_writer::start_tag('form', array('method' => "post"))
    .html_writer::tag('input', ' ', array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
    .html_writer::end_tag('form');
    return $btn;
}

// Create button with method get
function button_method_get($btn_name, $btn_value) {
    $btn = html_writer::start_tag('form', array('method' => "get"))
    .html_writer::tag('input', null, array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
    .html_writer::end_tag('form');
    return $btn;
}
 

global $COURSE;

// Định dang courseid, item_id
$id = 1; // default
if(optional_param('id', 0, PARAM_INT))
{
    $id = optional_param('id', 0, PARAM_INT);
}
$courseid = optional_param('courseid', SITEID, PARAM_INT) || 1;


// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/xsdasdasdem_monhoc.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$monhoc = get_monhoc_byID($id);
$PAGE->navbar->add($monhoc->ten_monhoc);
// Title.
$PAGE->set_title('Quản lý môn học ' . $monhoc->ten_monhoc);
$PAGE->set_heading('Quản lý môn học ' . $monhoc->ten_monhoc);
echo $OUTPUT->header();
// $mform = new 

echo $OUTPUT->footer();


 ?>
