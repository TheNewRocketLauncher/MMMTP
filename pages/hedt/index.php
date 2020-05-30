<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/hedt_model.php');
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/xsdasdasdem_hedt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add(get_string('label_hedt', 'block_educationpgrs'));
// Title.
$PAGE->set_title(get_string('label_hedt', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('head_hedt', 'block_educationpgrs'));
echo $OUTPUT->header();

// Insert data if table is empty
if (!$DB->count_records('block_edu_hedt', [])) {
    $param1 = new stdClass();
    $param2 = new stdClass();
    $param3 = new stdClass();
    // $param->id_he = 1;
    $param1->ma_bac = 'DH';
    $param1->ma_he = 'DHCQ';
    $param1->ten = 'Đại học - Chính quy';
    $param1->mota = 'Bậc Đại học - Hệ Chính quy HCMUS';
    // $param
    $param2->ma_bac = 'DH';
    $param2->ma_he = 'DHCNTT';
    $param2->ten = 'Đại học - Cử nhân tài năng';
    $param2->mota = 'Bậc Đại học - Hệ Cử nhân tài năng HCMUS';
    // $param
    $param3->ma_bac = 'DH';
    $param3->ma_he = 'DHTC';
    $param3->ten = 'Đại học - Tại chức';
    $param3->mota = 'Bậc Đại học - Hệ Tại Chức HCMUS';
    insert_hedt($param1);
    insert_hedt($param2);
    insert_hedt($param3);
}
// Get and print table
// $table = get_hedt();
// echo html_writer::table($table);

// Create button insert data, function import from factory.php
$mybtn = button_method_post('btnAdd', 'Thêm mới');
echo $mybtn;
echo '<br>';
// $newBtn = html_writer::tag('button', array('onClick' => "www.google.com"), 'XXX');

// Catch event click btnAdd (method post)
$count = 1;
if(array_key_exists('btnAdd',$_POST)){
    $param = new stdClass();    
    $str_count = (string)$count;   
    
    $param->ma_bac = 'NEWBDT';
    $param->ma_he = 'NEWHDT';
    $param->ten = 'Hệ NEWHDT';
    $param->mota = 'Hệ NEWHDT HCMUS';
    
    // insert
    insert_hedt($param);
    
    
 }

$table = get_hedt($courseid);
echo html_writer::table($table);

 // Form
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
    //     require_once(`../model/hedt_model.php`);
    //     require_once(__DIR__ . `/../../../config.php`);

    //     function click(){

    //         $param1 = new stdClass()
    //         $param1->ma_bac = `DH`;
    //         $param1->ten = `Đại học`;
    //         $param1->mota = `Bậc Đại học HCMUS`;
            
    //         insert_hedt(param1);
                    
    //     }

    // ?>