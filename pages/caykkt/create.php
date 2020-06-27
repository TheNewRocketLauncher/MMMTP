<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');
require_once('../../model/khoahoc_model.php');
// require_once('../factory.php');

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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/caykkt/create.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add("Cây khối kiến thức");
// Title.
$PAGE->set_title("Tạo cây khối kiến thức" . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading("Tạo cây khối kiến thức");
echo $OUTPUT->header();




//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/caykkt/tao_caykkt_form.php');
$mform = new tao_caykkt_form();

if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if($mform->no_submit_button_pressed()) {
    //
    $mform->display();

} else if ($fromform = $mform->get_data()) {
    //In this case you process validated data. $mform->get_data() returns data posted in form.
    // Thực hiện insert
    $param1 = new stdClass();
    // $param
    $param1->id_monhoc = $mform->get_data()->id_monhoc;
    $param1->ten_khoahoc = $mform->get_data()->ten_khoahoc;
    $param1->giaovien_phutrach = $mform->get_data()->giaovien_phutrach;
    $param1->mota = $mform->get_data()->mota;
    insert_khoahoc($param1);
    // Hiển thị thêm thành công
    echo '<h2>Thêm mới thành công!</h2>';
    echo '<br>';
    //link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/khoahoc/danhsach_khoahoc.php', ['courseid' => $courseid]);
    $linktext = get_string('label_khoahoc', 'block_educationpgrs');
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
