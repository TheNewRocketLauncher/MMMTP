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
global $COURSE;
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
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/khoikienthuc/newkkt_form.php");
        //get_submit_value này lấy được bất kì thông tin nào đang có trên form lmao :D 
        //echo $mform->get_submit_value();
    }
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    if(validateData()){
        $param = new stdClass();
        $ma_ctdt = $mform->get_submit_value('bacdt') . 
                    $mform->get_submit_value('hedt') . 
                    $mform->get_submit_value('khoatuyen') . 
                    $mform->get_submit_value('nganhdt') . 
                    $mform->get_submit_value('chuyenganh');
        $param->ma_ctdt = $mform->get_submit_value('bacdt');
        $param->ma_chuyennganh = $mform->get_submit_value('chuyenganh');
        $param->ma_nganh = $mform->get_submit_value('nganhdt');
        $param->ma_nienkhoa = $mform->get_submit_value('khoatuyen');
        $param->ma_he = $mform->get_submit_value('hedt');
        $param->ma_bac = $mform->get_submit_value('bacdt');
        $param->thoigia_daotao = $mform->get_submit_value('tgdt');
        $param->khoiluong_kienthuc = $mform->get_submit_value('klkt');
        $param->doituong_tuyensinh = $mform->get_submit_value('dtts');
        $param->quytrinh_daotao = $mform->get_submit_value('bacdt');
        $param->dienkien_totnghiep = $mform->get_submit_value('bacdt');
        //$param->ma_cay_khoikienthuc = $tree;
        $param->mota = $mform->get_submit_value('bacdt');
        insert_ctdt($param);
    }

    $mform->display();
} else {
    
    $mform->set_data($toform);
    // displays the form
    $mform->display();
}

function validateData(){
    // if(validata_bacdt(get_submit_value('tct')) && 

        // get_submit_value('bacdt') != NULL && 
        // get_submit_value('hedt') != NULL && 
        // get_submit_value('khoatuyen') != NULL && 
        // get_submit_value('nganhdt') != NULL && 
        // get_submit_value('chuyenganh') != NULL && 

        // get_submit_value('tdgt') != NULL && 
        // get_submit_value('klkt') != NULL && 
        // get_submit_value('dtts') != NULL && 
        // get_submit_value('qtdt') != NULL && 
        // get_submit_value('chuyenganh') != NULL && 
        // get_submit_value('chuyenganh') != NULL && 
        // get_submit_value('chuyenganh') != NULL
    // ){

    return true;
}

 // Footere
echo $OUTPUT->footer();
?>
