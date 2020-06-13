<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../model/global_model.php');
// require_once('../../model/global_model.php');
// require_once('../../factory.php');

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
$PAGE->navbar->add(get_string('label_ctdt', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/block_edu.php'));
$PAGE->navbar->add(get_string('label_khoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php'));
$PAGE->navbar->add(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/newkkt.php'));
// Title.
$PAGE->set_title(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
echo $OUTPUT->header();


///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/khoikienthuc/newkkt_form.php');

$table_kkt;
$table_monhoc;
$mform = new newkkt_form();

// $table = get_monhoc_table();
// echo html_writer::table($table);

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($mform->no_submit_button_pressed()) {
    // if($mform->get_submit_value('btn_cancle')){
        
    // } else if ($mform->get_submit_value('btn_addmonhoc')) {
    //     $newmonhoc = $mform->get_submit_value('select_ma_monhoc');
    //     if(!areadyAddMonhoc($newmonhoc)){

    //     }
    // }

    $mform->display();
    // if ($mform->get_submit_value('btn_newkkt')) {
    //     redirect("$CFG->wwwroot/blocks/educationpgrs/pages/ctdt/newctdt.php");
    // }

} else if ($fromform = $mform->get_data()) {

    $param_khoi = new stdClass();
    $param_khoi->ma_khoi = $mform->get_submit_value('txt_makhoi');
    if($mform->get_submit_value('select_loaikhoi') == 0){
        $param_khoi->co_dieukien = 0;
        $param_khoi->id_loai_kkt = 212;
        $param_khoi->ma_dieukien = "0";
    } else if($mform->get_submit_value('select_loaikhoi') == 1){
        $param_khoi->co_dieukien = 1;
        $param_khoi->id_loai_kkt = 1;
        $param_khoi->ma_dieukien = "daniiwdn";
    } else{
        $param_khoi->co_dieukien = 1;
        $param_khoi->id_loai_kkt = 1;
        $param_khoi->ma_dieukien = "daniiwdn";
    }
    $param_khoi->ten_khoi = $mform->get_submit_value('txt_tenkkt');
    $param_khoi->mota = $mform->get_submit_value('txt_mota');
    
    $arr_mon = null;
    //$arr_mon = get_global($USER->id)["list_mon"];

    insert_kkt($param_khoi, $arr_mon);
    $mform->display();

} else {
    // $datatest = array(
    //     txt_khoa => array(
    //         'lewd', 'mlem'
    //     ),
    //     txt_nganh => 'yes'
    // );

    $mform->set_data($datatest);

    // displays the form
    $mform->display();
}

function get_current_data(){
    get_global($USER->id);
}

function validatedata(){
    
    // $str = get_global($USER->id);
    // if(empty($str)){}
    return true;
}

function get_monthuockhoi_table(){
    $arr = get_global($USER->id);


}

function addMonTable($ma_monhoc){

}

function removeMonTable($ma_monhoc){

}

function areadyAddMonhoc($newmonhoc){

}



 // Footere
echo $OUTPUT->footer();


?>
