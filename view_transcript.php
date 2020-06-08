<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../config.php');
require_once('factory.php');
// // Bootstrap Blackboard Open LMS Framework
// require($CFG->dirroot.'/local/mr/bootstrap.php');
global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $couâsrseid
}
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/view_transcript.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add(get_string('gpatranscript', 'block_educationpgrs'));
// Title.
$PAGE->set_title(get_string('gpatranscriptdetail', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('gpatranscriptdetail', 'block_educationpgrs'));

// Ouput the page header.
echo $OUTPUT->header();

// Output custom content.
$gpa = 7.5;
// echo "<p> GPA: ", $gpa, "</p>";

// // Output
// $tag = new mr_html_tag();
// echo $tag->b('GPA: ' . (string)$gpa);

// Print Table
insertSubject(); // Nhap lieu
$table = getAllSubject();
echo html_writer::table($table);

// Output the page footer.
echo $OUTPUT->footer();

// Set table.
// $table = new html_table();
// $tmp1 = ['CSC10004', 'Cấu trúc dữ liệu và giải thuật', '4', '7.0'];
// $tmp2 = ['CSC13003', 'Kiểm chứng phần mềm', '4', '7.5'];
// $tmp3 = ['MTH00050', 'Toán học tổ hợp', '4', '8.0'];
// $tmp4 = ['CSC10007', 'Hệ điều hành', '4', '7.0'];
// $tmp5 = ['CSC13112', 'Thiết kế giao diện', '4', '8.0'];
// $table->head = array('Course Code', 'Subject', 'Credit', 'Grade');
// $table->data[] = $tmp1;
// $table->data[] = $tmp2;
// $table->data[] = $tmp3;
// $table->data[] = $tmp4;
// $table->data[] = $tmp5;
// // Print table
// echo html_writer::table($table);
