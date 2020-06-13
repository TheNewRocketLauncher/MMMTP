<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');
// require_once('/../factory.php');

// Create button with method post
function button_method_post($btn_name, $btn_value) {
    $btn = html_writer::start_tag('form', array('method' => "post"))
    .html_writer::tag('input', ' ', array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
    .html_writer::end_tag('form');
    return $btn;
}

// Create button with method get
function button_method_get($btn_name, $btn_value) {
    $btn = html_writer::start_tag('form', array('method' => "get"))
    .html_writer::tag('input', null, array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
    .html_writer::end_tag('form');
    return $btn;
}
class simplehtml_form extends moodleform{
    //Add elements to form
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;
        $mform->addElement('html', '        


        ');
    }
    //Custom validation should be added here
    function validation($data, $files)
    {
        return array();
    }
}
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/xsdasdasdem_bacdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add(get_string('label_monhoc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php'));
// Title.
$PAGE->set_title(get_string('label_monhoc', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('head_monhoc', 'block_educationpgrs'));
echo $OUTPUT->header();


// echo html_writer::tag( 'button', 'Thêm môn học', array('onClick'=>'window.location.href=them_monhoc.php'));

$url = new \moodle_url('them_monhoc.php', []);
echo \html_writer::link($url, 'Thêm môn học');

echo '<br>';

$table = get_monhoc_table();
echo html_writer::table($table);

//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
// require_once('../../form/decuongmonhoc/danhsach_monhoc_form.php');
// $mform = new danhsach_monhoc_form();


//  //Form processing and displaying is done here
//  if ($mform->is_cancelled()) {
//      //Handle form cancel operation, if cancel button is present on form
//  } else if ($fromform = $mform->get_data()) {
//      //In this case you process validated data. $mform->get_data() returns data posted in form.
//  } else {
//      // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
//      // or on the first display of the form. 
//      //Set default data (if any)
//      $mform->set_data($toform);
//      // displays the form
//      $mform->display();
//  }

 // Footere
echo $OUTPUT->footer();

 ?>
