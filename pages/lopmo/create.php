<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/lopmo_model.php');

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

// // Create button with method post
// function button_method_post($btn_name, $btn_value) {
//     $btn = html_writer::start_tag('form', array('method' => "post"))
//     .html_writer::tag('input', ' ', array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
//     .html_writer::end_tag('form');
//     return $btn;
// }

// // Create button with method get
// function button_method_get($btn_name, $btn_value) {
//     $btn = html_writer::start_tag('form', array('method' => "get"))
//     .html_writer::tag('input', null, array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
//     .html_writer::end_tag('form');
//     return $btn;
// }
// class simplehtml_form extends moodleform
// {
//     //Add elements to form
//     public function definition()
//     {
//         global $CFG;
//         $mform = $this->_form;
//         $mform->addElement('html', '        


//         ');
//     }
//     //Custom validation should be added here
//     function validation($data, $files)
//     {
//         return array();
//     }
// }
// global $COURSE;


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/lopmo/create.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add("Danh sách lớp mở", new moodle_url('/blocks/educationpgrs/pages/lopmo/index.php'));
$PAGE->navbar->add('Mở lớp học');
// Title.
$PAGE->set_title("Mở lớp học" );
$PAGE->set_heading(get_string('head_molopmo', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

echo $OUTPUT->header();




//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/lopmo/mo_lopmo_form.php');
$mform = new mo_lopmo_form();

if ($mform->is_cancelled()) {
    echo '<h2>Thêm không thành công</h2>';
} else if($mform->no_submit_button_pressed()) {
    //
    $mform->display();

} else if ($fromform = $mform->get_data()) {
    //In this case you process validated data. $mform->get_data() returns data posted in form.
    // Thực hiện insert
    $param1 = new stdClass();
    // $param
    $param1->id = $fromform>id;
    $param1->ma_ctdt = $fromform->ma_ctdt;
    $param1->mamonhoc = $fromform->mamonhoc;
    $param1->full_name = $fromform->fullname;
    $param1->short_name = $fromform->shortname;
    $param1->start_date = $fromform->sta_date;
    $param1->end_date = $fromform->end_date;
    $param1->assign_to = $fromform->assign_to;
    $param1->mota = $fromform->mota;
    insert_lopmo($param1);

    // Hiển thị thêm thành công
    echo '<h2>Thêm mới thành công!</h2>';
    echo '<br>';
    //link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', []);
    $linktext = get_string('label_lopmo', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
    


} else if ($mform->is_submitted()) {
    echo '<h2>Nhập sai thông tin</h2>';
    $url = new \moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', []);
    $linktext = get_string('label_lopmo', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else {
    
    $mform->set_data($toform);
    $mform->display();
}

 // Footere
echo $OUTPUT->footer();

 ?>
