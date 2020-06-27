<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');
require_once("$CFG->libdir/formslib.php");

///-------------------------------------------------------------------------------------------------------///
global $COURSE, $USER;
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/main.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));

// Title.
$PAGE->set_title('Các danh mục quản lý chung' . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading('Các danh mục quản lý chung');

// Print header
echo $OUTPUT->header();

///-------------------------------------------------------------------------------------------------------///



// Footer
echo $OUTPUT->footer();

