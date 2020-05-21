<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../config.php');
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/view_eduprogram.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('incourse');
// Navbar.
$PAGE->navbar->add(get_string('educationprogram', 'block_educationpgrs'));
// Title.
$PAGE->set_title(get_string('educationprogramdetail', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('educationprogramdetail', 'block_educationpgrs'));

// Ouput the page header.
echo $OUTPUT->header();

// Output custom content.

$table = new html_table();
$table->head = array('ID', 'Name', 'Format', 'Start Date', 'End Date');
$acs = $DB->get_records('course', ['category' => '1']);
$sn = 1;
echo $acs->shortname;
foreach ($acs as $ac) {
    echo '<p>'. $ac->fullname . '</p>';
    // $table->data[] = [(string)$allcourse->id, $allcourse->fullname,(string)$allcourse->format,(string)$allcourse->startdate,(string)$allcourse->enddate];
}
echo html_writer::table($table);

$gpa = 7.5;
echo "<p></p>";
echo "<p>------------------------------------------------------------------------------</p>";
echo "<p></p>";
echo "<p>1. GPA: ", $gpa, "</p>";
echo "<p>2. Course Id: ", $courseid, "</p>";
echo "<p>------------------------------------------------------------------------------</p>";

// Output the page footer.
echo $OUTPUT->footer();
