<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('function.php');
// // Bootstrap Blackboard Open LMS Framework
// require($CFG->dirroot.'/local/mr/bootstrap.php');
class simplehtml_form extends moodleform
{
    //Add elements to form
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;
        $mform->addElement('html', '<table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;Course Code</td><td>&nbsp;&nbsp;&nbsp;&nbsp;Subject</td><td>&nbsp;&nbsp;&nbsp;&nbsp;Credit</td><td>&nbsp;&nbsp;&nbsp;&nbsp;Grade</td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;CSC13003</td><td>&nbsp;&nbsp;&nbsp;&nbsp;Kiểm chứng phần mềm</td><td>&nbsp;&nbsp;&nbsp;&nbsp;4</td><td>&nbsp;&nbsp;&nbsp;&nbsp;7.5</td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;CSC10004</td><td>&nbsp;&nbsp;&nbsp;&nbsp;Cấu trúc dữ liệu và giải thuật</td><td>&nbsp;&nbsp;&nbsp;&nbsp;4</td><td>&nbsp;&nbsp;&nbsp;&nbsp;7.0</td></tr></table>');
    }
    //Custom validation should be added here
    function validation($data, $files)
    {
        return array();
    }
}
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/managereport.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('incourse');
// Navbar..
$PAGE->navbar->add(get_string('manageeducationprograms', 'block_educationpgrs'));
// Title..
$PAGE->set_title(get_string('manageeducationprograms', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('manageeducationprograms', 'block_educationpgrs'));

// Ouput the page header.
echo $OUTPUT->header();

//Instantiate simplehtml_form 
$mform = new simplehtml_form();
//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
    //In this case you process validated data. $mform->get_data() returns data posted in form.
} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form. 
    //Set default data (if any)
    $mform->set_data($toform);
    // displays the form
    // $mform->display();
}

// // Output
// $tag = new mr_html_tag();
// echo $tag->b('Use BlackBoard Open LMS Framework');

insertSubject(); // Nhap lieu
$table = getAllSubject();
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