<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/nienkhoa/nienkhoa_model.php');

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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/xsdasdasdem_nienkhoa.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add(get_string('label_nienkhoa', 'block_educationpgrs'));
// Title.
$PAGE->set_title(get_string('label_nienkhoa', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('head_nienkhoa', 'block_educationpgrs'));
echo $OUTPUT->header();

// Insert data if table is empty
if (!$DB->count_records('block_edu_nienkhoa', ['mota' => 'Niên khóa Đại học HCMUS'])) {
    $param1 = new stdClass();
    $param2 = new stdClass();
    $param3 = new stdClass();
    // $param->id = 1;
    $param1->ma_he = '3';
    $param1->ma_bac = '3';
    $param1->ma_nienkhoa='AB';
    $param1->ten_nienkhoa='phong dep trai';
    $param1->mota = 'hello';
    // $param->id = 1;
    
    insert_nienkhoa($param1);
    
}


if (1) {


    $btn = html_writer::tag('button', 'Thêm niên khóa', array  ('onClick' => "window.location.href='create.php'"  ));
    echo $btn;
}



$mybtn2 = button_method_post('btnEdit', 'Sửa Niên Khóa');
echo $mybtn2;
$mybtn2 = button_method_post('btnDelete', 'Xóa Niên Khóa');
echo $mybtn2;


// Catch event click btnAdd (method post)
$count = 1;
if(array_key_exists('btnAdd',$_POST)){
    $param = new stdClass();    
    $str_count = (string)$count;
    
    

    $param1->ma_he = '3';
    $param1->ma_bac = '3';
    $param1->ma_nienkhoa='AB';
    $param1->ten_nienkhoa='phong dep trai';
    $param1->mota = 'hello';
    
    // insert
    insert_nienkhoa($param);
    
 }

$table = get_nienkhoa();
echo html_writer::table($table);





 // Footere
echo $OUTPUT->footer();
