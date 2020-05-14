<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../config.php');
require($CFG->dirroot.'/local/mr/bootstrap.php');

global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
// =>> $courseid nhận giá trị từ ?courseid=2, hoặc nhận giá trị mặc định là SITEID (id của course hiện tại)



// Setting up the page.

// $idnew = required_param('id', PARAM_INT);
// $PAGE->set_url(new moodle_url('/blocks/educationpgrs/view_eduprogram.php',['id' => $idnew]));
// $PAGE->set_url('/blocks/configurable_reports/viewreport.php', ['id' => $id]);
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/view_eduprogram.php',['courseid' => $courseid]));
// $PAGE->set_context(context_system::instance());
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid);
} // => tạo instance dựa vào $courseid. Suy nghĩ ý nghĩa của dòng 7 và 24?
$PAGE->set_context($context);
$PAGE->set_pagelayout('incourse');

// PART

$PAGE->navbar->add(get_string('educationprogram', 'block_educationpgrs'));

// PART

$PAGE->set_title($COURSE->id);
$PAGE->set_heading(get_string('educationprogramdetail', 'block_educationpgrs'));



// Ouput the page header.
echo $OUTPUT->header();




// Output your custom HTML.
// In the future, read about templates and renderers so you don't have to echo HTML like this.
$gpa = 7.5;
echo "<p>1. GPA: ",$gpa,"</p>";
echo "<p>2. CourseId: ",$courseid,"</p>";
echo "<p>3. COURSES->id: ",$COURSE->id,"</p>";
echo "<p>----------------------------------------------------------------------------------------------------------------</p>";

$tag = new mr_html_tag();
echo $h = $tag->a('hello');



// $id = required_param('id', PARAM_INT);
// echo $id;

// echo $COURSE->id;

// Output the page footer.
echo $OUTPUT->footer();