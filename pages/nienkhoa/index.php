<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/nienkhoa_model.php');
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/nienkhoa/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_nienkhoa', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_nienkhoa', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

/// Button mở niên khóa
$btn_mo_khoahoc = html_writer::tag('button', 'Mở niên khóa', array('onClick' => "window.location.href='create.php'"));
echo $btn_mo_khoahoc;
echo '<br>';

// Print table
$table = get_nienkhoa_checkbox($courseid);
echo html_writer::table($table);

// Button xóa niên khóa
echo ' ';
echo \html_writer::tag(
    'button',
    'Xóa niên khóa',
    array('id' => 'btn_delete_nienkhoa')
);
echo '<br>';

// Footer
echo $OUTPUT->footer();