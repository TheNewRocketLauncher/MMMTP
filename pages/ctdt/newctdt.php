<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/ctdt_model.php');
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


///-------------------------------------------------------------------------------------------------------///

global $COURSE, $USER;


$courseid = optional_param('courseid', SITEID, PARAM_INT);
$tree = optional_param('tree', SITEID, PARAM_INT);
$qtdt = optional_param('qtdt', SITEID, PARAM_INT);

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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/ctdt/newctdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add(get_string('label_ctdt', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/ctdt/index.php'));
$PAGE->navbar->add(get_string('themctdt_lable', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/ctdt/newctdt.php'));
// Title.
$PAGE->set_title(get_string('themctdt_title', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('themctdt_head', 'block_educationpgrs'));
echo $OUTPUT->header();


///-------------------------------------------------------------------------------------------------------///
// Tạo form
require_once('../../form/ctdt/newctdt_form.php');
$mform = new newctdt_form();

if ($mform->is_cancelled()) {
    
} else if ($mform->no_submit_button_pressed()) { 
    if ($mform->_form->get_submit_value('btnchoosetree')) {
        // get_submit_value này lấy được bất kì thông tin nào đang có trên form lmao :D 
        // echo $mform->get_submit_value();
    }
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    if(validateData()){
        $param = new stdClass();
        $ma_ctdt = $fromform->bacdt . 
                    $fromform->hedt . 
                    $fromform->khoatuyen . 
                    $fromform->nganhdt . 
                    $fromform->chuyenganh;
        $param->ma_ctdt = $ma_ctdt;

        $param->ma_chuyennganh = $fromform->chuyenganh;
        $param->ma_nganh = $fromform->nganhdt;
        $param->ma_nienkhoa = $fromform->khoatuyen;
        $param->ma_he = $fromform->hedt;
        $param->ma_bac = $fromform->bacdt;
        // $param->muctieu_daotao = $fromform->editor_muctieu_daotao['text'];
        $param->muctieu_daotao = "a";
        $param->thoigian_daotao = $fromform->tgdt;
        $param->khoiluong_kienthuc = $fromform->klkt;
        $param->doituong_tuyensinh = $fromform->dtts;
        // $param->quytrinh_daotao = $fromform->qtdt['text'];
        $param->quytrinh_daotao = "a";
        $param->dienkien_totnghiep = $fromform->bacdt;
        // $param->ma_cay_khoikienthuc = $fromform->select_ktt;
        $param->ma_cay_khoikienthuc = "dda";
        $param->mota = "ad";
        insert_ctdt($param);
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/ctdt/index.php");
    }

    $mform->display();
} else {
    
    $mform->set_data($toform);
    // displays the form
    $mform->display();
}

function validateData(){
    // if( 
    //     $mform->get_submit_value('bacdt') != NULL && 
    //     $mform->get_submit_value('hedt') != NULL && 
    //     $mform->get_submit_value('khoatuyen') != NULL && 
    //     $mform->get_submit_value('nganhdt') != NULL && 
    //     $mform->get_submit_value('chuyenganh') != NULL && 

    //     $mform->get_submit_value('tdgt') != NULL && 
    //     $mform->get_submit_value('klkt') != NULL && 
    //     $mform->get_submit_value('dtts') != NULL && 
    //     $mform->get_submit_value('qtdt') != NULL && 
    //     $mform->get_submit_value('chuyenganh') != NULL && 
    //     $mform->get_submit_value('chuyenganh') != NULL && 
    //     $mform->get_submit_value('chuyenganh') != NULL
    // ){
    //     echo "null found";
    //     return false;
    // }
    return true;
}

 // Footere
echo $OUTPUT->footer();
?>
