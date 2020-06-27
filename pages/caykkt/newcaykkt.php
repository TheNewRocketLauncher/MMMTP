<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../model/global_model.php');

global $DB, $USER, $CFG, $COURSE;

$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}



///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/newkkt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_caykhoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/caykkt/index.php'));
$PAGE->navbar->add('Thêm cây mới');
$PAGE->navbar->add('Chọn danh sách khối');
// Title.
$PAGE->set_title('Thêm cây mới');
$PAGE->set_heading('Thêm cây mới');
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
echo $OUTPUT->header();


///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/caykkt/newcaykkt_form.php');

$mform = new newcaykkt_form1();
$confirmFrom = new newcaykkt_form2();

if(!is_global_defined()){
    $mform->display();
} else{
    $confirmFrom->display();
}

//FORM Xác nhận
if ($confirmFrom->is_cancelled()) {
} else if ($confirmFrom->no_submit_button_pressed()) {
    if($confirmFrom->get_submit_value('btn_caykkt_no')){
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/caykkt/index.php");
    } else if($confirmFrom->get_submit_value('btn_caykkt_createnew')){
        reset_global();
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/caykkt/index.php");
        $confirmFrom->display();
    }
} else if ($fromform = $confirmFrom->get_data()) {
    redirect("$CFG->wwwroot/blocks/educationpgrs/pages/caykkt/newcaykkt_confirm.php");
} 

//FORM tạo mới khối kiến thức
if ($mform->is_cancelled()) {
} else if ($mform->no_submit_button_pressed()) {
    if($mform->get_submit_value('btn_cancle')){
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/caykkt/index.php");
        $mform->display();
    }
} else if ($fromform = $mform->get_data()) {
    $newList = $mform->get_submit_value('area_mamonhoc');
    if(!empty($newList)){
        init_newcaykkt($newList);
    } else{
        // Form có tự động kiếm tra newList có giá trị, vì thế newList rỗng là lỗi
        echo 'Hello Something wrong';
    }
} 
 // Footere
echo $OUTPUT->footer();


///-------------------------------------------------------------------------------------------------------///
//FUNCTION

function reset_global(){
    global $USER;
    $arr = get_global($USER->id);
    unset($arr['newcatkkt']);
    set_global($USER->id, $arr);
}

function is_global_defined(){
    global $USER;
    $arr = get_global($USER->id);
    if($arr == NULL){
        return false;
    } else if(!array_key_exists('newcaykkt', $arr)){
        return false;
    } else{
        if(!empty($arr['newcaykkt'])){
            return true;
        }
    }
    return false;
}

function define_new_global(){
    global $USER;
    $arr = get_global($USER->id);
    if($arr == NULL){
        $arr = array('newcaykkt' => array());
        set_global($USER->id, $arr);
    } else if(!array_key_exists('newcaykkt', $arr)){
        $arr[] = ['newcaykkt' => array()];
        set_global($USER->id, $arr);
    }
}

function init_newcaykkt($arr){
    $result = array();
    $index = 1;
    foreach($arr as $item){
        $result[] = array(
            'name' => $item,
            'index' => $index,
        );
        $index ++;
    }
    update_caykkt_toGlobal($result);
}

function update_caykkt_toGlobal($arrcay){
    global $USER;
    define_new_global();
    $current_global = get_global($USER->id);
    $current_global['newcaykkt'] = $arrcay;
    set_global($USER->id, $current_global);
}
?>
