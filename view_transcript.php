<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../config.php');
global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Setting up the page.
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid);
}
// Body..
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/view_transcript.php',['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar..
$PAGE->navbar->add(get_string('gpatranscript', 'block_educationpgrs'));
// Title..
$PAGE->set_title($COURSE->id);
$PAGE->set_heading(get_string('gpatranscriptdetail', 'block_educationpgrs'));

// Ouput the page header.
echo $OUTPUT->header();

// Output your custom HTML.
// In the future, read about templates and renderers so you don't have to echo HTML like this.
$gpa = 7.5;
echo "<p>GPA: ",$gpa,"</p>";
// echo "<p>courseid: ",$courseid,"</p>";
// echo "<p>COURSES->id: ",$COURSE->id,"</p>";
$table = new html_table();
$tmp1 = ['CSC10004', 'Cấu trúc dữ liệu và giải thuật', '4', '7.0'];
$tmp2 = ['CSC13003', 'Kiểm chứng phần mềm', '4', '7.5'];
$tmp3 = ['MTH00050', 'Toán học tổ hợp', '4', '8.0'];
$tmp4 = ['CSC10007', 'Hệ điều hành', '4', '7.0'];
$tmp5 = ['CSC13112', 'Thiết kế giao diện', '4', '8.0'];

$table->head = array('Course Code', 'Subject', 'Credit', 'Grade');
// $table->data[] = array($tmpstr,$tmpstr,$tmpstr);
$table->data[] = $tmp1;
$table->data[] = $tmp2;
$table->data[] = $tmp3;
$table->data[] = $tmp4;
$table->data[] = $tmp5;


echo html_writer::table($table);
// $id = required_param('id', PARAM_INT);
// echo $id;

// echo $COURSE->id;

// Output the page footer.
echo $OUTPUT->footer();