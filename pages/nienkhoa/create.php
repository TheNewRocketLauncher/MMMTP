
<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/nienkhoa_model.php');

// require_once('../factory.php');

class simplehtml_form extends moodleform
{
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/nienkhoa/create.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add(get_string('label_nienkhoa', 'block_educationpgrs'));
// Title.
$PAGE->set_title(get_string('label_nienkhoa', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('head_nienkhoa', 'block_educationpgrs'));
echo $OUTPUT->header();


 require_once('../../form/nienkhoa/nien_khoa_form.php');
 $mform = new nien_khoa_form();

 if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if($mform->no_submit_button_pressed()) {
    //
    $mform->display();

} else if ($fromform = $mform->get_data()) {
    //In this case you process validated data. $mform->get_data() returns data posted in form.
    // Thực hiện insert
    $param1 = new stdClass();
    $index_mabac = $mform->get_data()->mabac;
    // $param
    $param1->ma_bac = $mform->get_data()->mabac;    
    $allbacdts = $DB->get_records('block_edu_bacdt', []);
    $param1->ma_bac = $allbacdts[$index_mabac + 1 ]->ma_bac;

    $index_mahe = $mform->get_data()->mahe;
    // $param
    $param1->ma_he = $mform->get_data()->mahe;    
    $allhedts = $DB->get_records('block_edu_hedt', []);
    $param1->ma_he = $allhedts[$index_mahe + 1 ]->ma_he;

    $param1->ma_nienkhoa = $mform->get_data()->ma_nienkhoa;

    $param1->ten_nienkhoa = $mform->get_data()->ten_nienkhoa;
    $param1->mota = $mform->get_data()->mota;
    insert_nienkhoa($param1);
    // Hiển thị thêm thành công
    echo '<h2>Thêm mới thành công!</h2>';
    echo '<br>';
    //link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/nienkhoa/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_nienkhoa', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
    // $mform->display();


} else if ($mform->is_submitted()) {
    //
} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form. 
    //Set default data (if any)
    $mform->set_data($toform);
    // displays the form
    $mform->display();
}

 // Footere
echo $OUTPUT->footer();
?>
 























