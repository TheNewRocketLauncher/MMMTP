<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../js.php');

global $USER;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_ctdt', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/block_edu.php'));
$PAGE->navbar->add(get_string('label_khoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php'));

// Title.
$PAGE->set_title(get_string('label_khoikienthuc', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('label_khoikienthuc', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/newkkt', 'init');
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/khoikienthuc/index_form.php');
$mform = new index_form();

// Thêm mới
$url = new \moodle_url('/blocks/educationpgrs/pages/khoikienthuc/newkkt.php', ['courseid' => $courseid]);
$ten_url = \html_writer::link($url, '<u><i>Thêm mới </i></u>');
echo  \html_writer::link($url, $ten_url);
echo '<br><br>';

// Form processing
if ($mform->is_cancelled()) {
    
} else if ($mform->no_submit_button_pressed()) {
} else if ($fromform = $mform->get_data()) {
} else if ($mform->is_submitted()) {
} else {
    $mform->set_data($toform);
    $mform->display();
}

// Print table
$table = get_kkt_checkbox($courseid); 
echo html_writer::table($table);

// Button delete KKT
echo ' ';
echo \html_writer::tag(
    'button',
    'Xóa kkt',
    array('id' => 'btn_delete_kkt'));
echo '<br>';

 // Footer
echo $OUTPUT->footer();