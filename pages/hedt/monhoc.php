<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/bacdt_model.php');
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/xsdasdasdem_bacdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add(get_string('label_bacdt', 'block_educationpgrs'));
// Title.
$PAGE->set_title(get_string('label_bacdt', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('head_bacdt', 'block_educationpgrs'));
echo $OUTPUT->header();



//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
 require_once('../../form/decuongmonhoc/thongtinchung.php');
 $mform = new thongtinchung_form();


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
     $mform->display();
 }

 // Footere
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




    // <?php
    //     require_once(`../model/bacdt_model.php`);
    //     require_once(__DIR__ . `/../../../config.php`);

    //     function click(){

    //         $param1 = new stdClass()
    //         $param1->ma_bac = `DH`;
    //         $param1->ten = `Đại học`;
    //         $param1->mota = `Bậc Đại học HCMUS`;
            
    //         insert_bacdt(param1);
                    
    //     }

    // ?>
