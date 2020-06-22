<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/ctdt_model.php');
require_once('../../js.php');

///-------------------------------------------------------------------------------------------------------///
global $COURSE, $USER;
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/ctdt/newctdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_ctdt', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/ctdt/index.php'));
$PAGE->navbar->add(get_string('themctdt_lable', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/ctdt/newctdt.php'));

// Title.
$PAGE->set_title(get_string('themctdt_title', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('themctdt_head', 'block_educationpgrs'));

// Print header
echo $OUTPUT->header();

// Require js_call_amd
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
///-------------------------------------------------------------------------------------------------------///
// Tạo form
require_once('../../form/ctdt/newctdt_form.php');
$mform = new newctdt_form();

// mform processing
if ($mform->is_cancelled()) {
    // Button cancel    
} else if ($mform->no_submit_button_pressed()) {
    if ($mform->_form->get_submit_value('btnchoosetree')) {
        // Something here
    }
    $mform->display();
} else if ($fromform = $mform->get_data()) {
} else {
    $mform->set_data($toform);
    $mform->display();
}

printCaykkt($ma_cay_kkt);

$mformImport = new newctdt_form_import();

// mformImport processing
if ($mformImport->is_cancelled()) {
    // Button cancel    
} else if ($mform->no_submit_button_pressed()) {
    if ($mformImport->_form->get_submit_value('btn_review')) {
        $mformImport->display();
        ReviewCTDT();
    }
} else if ($mformImport->get_data()) {
    $fromform = $mformImport->get_data();
    if (validateData()) {
        $param = new stdClass();
        $ma_ctdt = $fromform->select_bacdt .
            $fromform->select_hedt .
            $fromform->select_khoatuyen .
            $fromform->select_nganhdt .
            $fromform->select_chuyenganh;
        $param->ma_ctdt = $ma_ctdt;
        $param->ma_chuyennganh = $fromform->select_chuyenganh;
        $param->ma_nganh = $fromform->select_nganhdt;
        $param->ma_nienkhoa = $fromform->select_khoatuyen;
        $param->ma_he = $fromform->select_hedt;
        $param->ma_bac = $fromform->select_bacdt;
        $param->muctieu_daotao = $fromform->editor_muctieu_daotao['text'];
        $param->thoigian_daotao = $fromform->txt_tgdt;
        $param->khoiluong_kienthuc = $fromform->txt_klkt;
        $param->doituong_tuyensinh = $fromform->txt_dtts;
        $param->quytrinh_daotao = $fromform->editor_qtdt['text'];
        $param->ma_cay_khoikienthuc = $fromform->select_caykkt;
        if($param->ma_cay_khoikienthuc == null){
            $param->ma_cay_khoikienthuc = 'hello';
        }
        $param->mota = "null";
        insert_ctdt($param);
        echo '<h2>Thêm mới thành công!</h2>';
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/ctdt/index.php");
    }
    $mformImport->display();
} else {
    $mformImport->set_data($toform);
    $mformImport->display();
}

function validateData()
{
    return true;
}

// Footer
echo $OUTPUT->footer();


function printCaykkt($ma_cay_kkt){
    if($ma_cay_kkt == NULL){
        echo 'Chưa có cây khối kiến thức nào được chọn';
        return;
    }

    
}

function ReviewCTDT(){

}