<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoahoc_model.php');
require_once('../../js.php');

global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoahoc/danhsach_khoahoc.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_khoahoc', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_khoahoc', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('head_khoahoc', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Lấy mã môn học trước
$btn_mo_khoahoc = html_writer::tag('button', 'Mở khóa học', array('onClick' => "window.location.href='mo_khoahoc.php'"));
echo $btn_mo_khoahoc;
echo '<br>';

// Print table
$table = get_khoahoc_checkbox($courseid);
echo html_writer::table($table);

// Xóa
echo '  ';
echo \html_writer::tag(
    'button',
    'Xóa khóa học',
    array('id' => 'btn_delete_khoahoc')
);
echo '<br>';

// Form
$mform = new simplehtml_form();

// Form processing and displaying is done here
if ($mform->is_cancelled()) {
    // Handle form cancel operation
} else if ($fromform = $mform->get_data()) {
    // Process validated data
} else {
    // Set default data
    $mform->set_data($toform);
    $mform->display();
}

// Footer
echo $OUTPUT->footer();