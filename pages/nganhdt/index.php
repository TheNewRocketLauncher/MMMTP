<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/nganhdt_model.php');
require_once('../../js.php');
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/nganhdt/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add(get_string('label_nganh', 'block_educationpgrs'));
// Title.
$PAGE->set_title(get_string('label_nganh', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('head_nganh', 'block_educationpgrs'));
// Require js amd
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
echo $OUTPUT->header();

// Insert data if table is empty
if (!$DB->count_records('block_edu_nganhdt', [])) {
    $param1 = new stdClass();
    $param2 = new stdClass();
    $param3 = new stdClass();
    // $param->id_bac = 1;
    $param1->ma_bac = 'DH';
    $param1->ma_he = 'CQ';
    $param1->ma_nganh = '7480101';
    $param1->ten = 'Khoa học máy tính';
    $param1->mota = 'Đại học,chính quy,niên khóa: 2016 - 2020';
    // $param->id_bac = 2;
    $param2->ma_bac = 'DH';
    $param2->ma_he = 'CQ';
    $param2->ma_nganh = '7480103';
    $param2->ten = 'Kỹ thuật phần mềm';
    $param2->mota = 'Đại học,chính quy,niên khóa: 2016 - 2020';
    // $param->id_bac = 3;
    $param3->ma_bac = 'DH';
    $param3->ma_he = 'CNTN';
    $param3->ma_nganh = '7480104';
    $param3->ten = 'Hệ thống thông tin';
    $param3->mota = 'Đại học,chính quy,niên khóa: 2016 - 2020';
    insert_nganhdt($param1);
    insert_nganhdt($param2);
    insert_nganhdt($param3);
}

 // Thêm mới
 $url = new \moodle_url('/blocks/educationpgrs/pages/nganhdt/add_nganhdt.php', ['courseid' => $courseid]);
 $ten_url = \html_writer::link($url, '<u><i>Thêm mới </i></u>');
 echo  \html_writer::link($url, $ten_url);
 echo '<br>';
 echo '<br>';
 
 // Create table
 $table = get_nganhdt_checkbox($courseid);
 echo html_writer::table($table);
 
 // Xóa
 echo '  ';
 echo \html_writer::tag(
     'button',
     'Xóa  ngành DT',
     array('id' => 'btn_delete_nganhdt'));
 
 echo '<br>';


// Catch event click btnAdd (method post)
$count = 1;
if(array_key_exists('mmmy',$_POST)){
    echo 'the s';
    // xoa by id, id= ???
    // echo htmlspecialchars($_SESSION["test"]);
    
    echo 'the end';


    // $param = new stdClass();    
    // $str_count = (string)$count;
    // // while($str_count.strlen()<3) {
    // //     $str_count = '0'.$str_count;
    // // }
    // // $param->ma_bac = 'NEWBDT'.$str_count;
    // // $param->ten = 'Bậc '.$param->ma_bac;
    // // $param->mota = $param->ten.' HCMUS';
    

    // $param->ma_bac = 'NEWBDT';
    // $param->ten = 'Bậc NEWBDT';
    // $param->mota = 'Bậc NEWBDT HCMUS';

    
    // // insert
    // insert_bacdt($param);
    foreach ($table->data as $data) {
        // $checkbox_unchecked = html_writer::tag('input', ' ', array('type' => "checkbox", 'name' => 'checkbok_name', 'id' => 'checkbok_name', 'value' => 'checkbok_value', 'checked' => 'true'));   
        // if($data[0]==$checkbox_unchecked) {
        //     echo 'true';
        // }
        // else {
        //     echo 'false';
        //     $data[0]=$checkbox_unchecked;
        // }
        // echo $data[0];
    }
    
    
 }


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

?>
