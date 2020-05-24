<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../model/bacdt_model.php');
// require('function.php');
// // Bootstrap Blackboard Open LMS Framework
// require($CFG->dirroot.'/local/mr/bootstrap.php');
function hello(){
    alert('Hello I am alert');
}
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

// $miurl = new \moodle_url('/blocks/educationpgrs/pages/view_bacdt.php', ['courseid' => $courseid]);
// $milinktext = get_string('label_bacdt', 'block_educationpgrs');
// $exitlink = html_writer::link($miurl, $milinktext);
// $PAGE->set_button($exitlink);

// Ouput the page header.
echo $OUTPUT->header();

// Print Table

if (!$DB->count_records('block_edu_bacdt', ['mota' => 'Bậc Đại học HCMUS'])) {
    $param1 = new stdClass();
    $param2 = new stdClass();
    $param3 = new stdClass();


    // $param->id_bac = 1;
    $param1->ma_bac = 'DH';
    $param1->ten = 'Đại học';
    $param1->mota = 'Bậc Đại học HCMUS';
    // $param->id_bac = 1;
    $param2->ma_bac = 'CD';
    $param2->ten = 'Cao đẳng';
    $param2->mota = 'Bậc Cao đẳng HCMUS';
    // $param->id_bac = 1;
    $param3->ma_bac = 'DTTX';
    $param3->ten = 'Đào tạo từ xa';
    $param3->mota = 'Bậc Đào tạo từ xa HCMUS';
    insert_bacdt($param1);
    insert_bacdt($param2);
    insert_bacdt($param3);

}
$table = get_bacdt();

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
echo html_writer::table($table);
// if (1) {
//     $url = new \moodle_url('/blocks/educationpgrs/pages/xem_bacdt.php', ['courseid' => $courseid]);
//     $linktext = get_string('label_bacdt', 'block_educationpgrs');
//     echo html_writer::link($url, $linktext);
// }
// echo '<a>Chuyenhuong</a>';

//echo html_writer::tag('button', 'ggwp', array('onclick' => hello()));

$btnurl = new \moodle_url('/blocks/educationpgrs/pages/view_hedt.php', ['courseid' => $courseid]);
$btnlbl = get_string('btn_helloworld', 'block_educationpgrs');
echo $OUTPUT->single_button($btnurl, $btnlbl, $get);

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
?>