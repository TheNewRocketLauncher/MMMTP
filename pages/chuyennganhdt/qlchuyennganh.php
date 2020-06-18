<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuyennganhdt_model.php');

global $COURSE;
$id = optional_param('id', 0, PARAM_INT);
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/xsdasdasdem_chuyennganhdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$chuyennganhdt = get_chuyennganhdt_byID($id);
$PAGE->navbar->add($chuyennganhdt->ten_chuyennganh);

// Title.
$PAGE->set_title('Quản lý chuyên ngành ' . $chuyennganhdt->ten_chuyennganh);
$PAGE->set_heading('Quản lý chuyên ngành ' . $chuyennganhdt->ten_chuyennganh);

// Print header
echo $OUTPUT->header();

// Print table
$table = get_table_chuyennganhdt_byID($id);
echo html_writer::table($table);
echo '<br>';

// Form
require_once('../../form/chuyennganhdt/qlchuyennganh_form.php');
$mform = new qlchuyennganh_form();

// Form processing
if ($mform->is_cancelled()) {
    // Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
    // Process validated data
} else {
    $mform->set_data($toform);
    $mform->display();
}

// Footer
echo $OUTPUT->footer();