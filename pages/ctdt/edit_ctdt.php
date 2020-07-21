<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/ctdt_model.php');
require_once('../../model/khoikienthuc_model.php');
require_once('../../controller/export.php');
require_once('../../vendor/autoload.php');


///-------------------------------------------------------------------------------------------------------///
global $COURSE, $USER, $DB;
define("EDIT_MODE_EDIT", 1);
define("EDIT_MODE_CLONE", 0);

$courseid = optional_param('courseid', SITEID, PARAM_INT);
$tree = optional_param('tree', SITEID, PARAM_INT);
$qtdt = optional_param('qtdt', SITEID, PARAM_INT);

$idctdt = optional_param('id', NULL, PARAM_ALPHANUMEXT);
$edit_mode = optional_param('edit_mode', EDIT_MODE_CLONE, PARAM_INT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);

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
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

///-------------------------------------------------------------------------------------------------------///
// Tạo form
require_once('../../form/ctdt/newctdt_form.php');
$mform = new editctdt_form();

// Form processing
if ($mform->is_cancelled()) {
    // Button cancel    
} else if ($mform->no_submit_button_pressed()) {
    if ($mform->get_submit_value('btn_review')) {
        // Something here

        exportmdf($mform->get_value());
        $mform->display();
    } else if ($mform->get_submit_value('btn_create_tree')) {
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/ctdt/index.php");
        $mform->display();
    } else if ($mform->get_submit_value('btn_cancle')) {
        //open add_caykkt.php in new pages

        $mform->display();
    }
} else if ($fromform = $mform->get_data()) {
    // echo json_encode($fromform);
    if (validateData()) {
        if($fromform->edit_mode == EDIT_MODE_EDIT){
            $param = new stdClass();
            $new_ma_ctdt = $fromform->mabac .
                $fromform->mahe .
                $fromform->manienkhoa .
                $fromform->manganh .
                $fromform->machuyennganh;
            $param->ma_ctdt = $new_ma_ctdt;

            $param->ma_chuyennganh = $fromform->machuyennganh;
            $param->ma_nganh = $fromform->manganh;
            $param->ma_nienkhoa = $fromform->manienkhoa;
            $param->ma_he = $fromform->mahe;
            $param->ma_bac = $fromform->mabac;    
    
            $param->muctieu_daotao = $fromform->editor_muctieudt_chung['text'];
            $param->muctieu_cuthe = $fromform->editor_muctieudt_cuthe['text'];
            $param->chuandaura = $fromform->select_cdr;
            $param->cohoi_nghenghiep = $fromform->editor_muctieudt_chnn['text'];    
    
            $param->thoigian_daotao = $fromform->txt_tgdt;
            $param->khoiluong_kienthuc = $fromform->txt_klkt;
            $param->doituong_tuyensinh = $fromform->txt_dtts;
    
            $param->quytrinh_daotao = $fromform->editor_qtdt['text'];
            $param->dieukien_totnghiep = $fromform->editor_dktn['text'];
    
            $param->ma_cay_khoikienthuc = $fromform->select_caykkt;
            $param->mota = $fromform->txt_tct;
    
            // echo json_encode($param);
            update_ctdt($fromform->ma_ctdt, $param);

            echo '<h2>Đã lưu thay đổi!</h2>';
            echo '<br>';
            $url = new \moodle_url('/blocks/educationpgrs/pages/ctdt/index.php', ['courseid' => $courseid]);
            $linktext = get_string('label_ctdt', 'block_educationpgrs');
            echo \html_writer::link($url, $linktext);

            // $mform->display();

        } else if($fromform->edit_mode == EDIT_MODE_CLONE){
            $param = new stdClass();
            $ma_ctdt = $fromform->mabac .
                $fromform->mahe .
                $fromform->manienkhoa .
                $fromform->manganh .
                $fromform->machuyennganh;
            $param->ma_ctdt = $ma_ctdt;
            $param->ma_chuyennganh = $fromform->machuyennganh;
            $param->ma_nganh = $fromform->manganh;
            $param->ma_nienkhoa = $fromform->manienkhoa;
            $param->ma_he = $fromform->mahe;
            $param->ma_bac = $fromform->mabac;
    
    
            $param->muctieu_daotao = $fromform->editor_muctieudt_chung['text'];
            $param->muctieu_cuthe = $fromform->editor_muctieudt_cuthe['text'];
            // $param->chuandaura = 'cayhelloworld';
            $param->chuandaura = $fromform->select_cdr;
            $param->cohoi_nghenghiep = $fromform->editor_muctieudt_chnn['text'];
    
    
            $param->thoigian_daotao = $fromform->txt_tgdt;
            $param->khoiluong_kienthuc = $fromform->txt_klkt;
            $param->doituong_tuyensinh = $fromform->txt_dtts;
    
            $param->quytrinh_daotao = $fromform->editor_qtdt['text'];
            $param->dieukien_totnghiep = $fromform->editor_dktn['text'];
    
            // $param->ma_cay_khoikienthuc = 'cayhelloworld';
            $param->ma_cay_khoikienthuc = $fromform->select_caykkt;
            $param->mota = $fromform->txt_tct;
    
            // echo json_encode($param);
            insert_ctdt($param);
            echo '<h2>Thêm mới thành công!</h2>';
            echo '<br>';
            $url = new \moodle_url('/blocks/educationpgrs/pages/ctdt/index.php', ['courseid' => $courseid]);
            $linktext = get_string('label_ctdt', 'block_educationpgrs');
            echo \html_writer::link($url, $linktext);
        }

        // redirect("$CFG->wwwroot/blocks/educationpgrs/pages/ctdt/index.php");
        // $mform->display();
    }
} else {
    if($idctdt != NULL){
        $ctdt = get_ctdt_byID($idctdt);

        $defaultData = new stdClass();

        $defaultData->ma_ctdt = $ctdt->ma_ctdt;
        
        if($edit_mode == EDIT_MODE_EDIT){
            // echo 'EDIT_MODE_EDIT';
            $defaultData->bacdt = 'Một cái text gì đó ở đây';
            
            $defaultData->edit_mode = EDIT_MODE_EDIT;
            $defaultData->mabac = $ctdt->ma_bac;
            $DB->get_record('eb_bacdt', ['ma_bac' => $ctdt->ma_bac]);

            $defaultData->mahe = $ctdt->ma_he;
            $DB->get_record('eb_hedt', ['ma_bac' => $ctdt->ma_bac]);

            $defaultData->manienkhoa = $ctdt->ma_nienkhoa;
            $DB->get_record('eb_badt', ['ma_bac' => $ctdt->ma_bac]);

            $defaultData->manganh = $ctdt->ma_nganh;
            $DB->get_record('eb_badt', ['ma_bac' => $ctdt->ma_bac]);

            $defaultData->machuyennganh = $ctdt->ma_chuyennganh;
            $DB->get_record('eb_badt', ['ma_bac' => $ctdt->ma_bac]);

        } else if($edit_mode == EDIT_MODE_CLONE){
            // echo 'EDIT_MODE_CLONE';
            $defaultData->edit_mode = EDIT_MODE_CLONE;
        }

        $defaultData->editor_muctieudt_chung['text'] = $ctdt->muctieu_daotao;
        $defaultData->editor_muctieudt_cuthe['text'] = $ctdt->muctieu_cuthe;
        $defaultData->chuandaura = $ctdt->select_cdr;
        $defaultData->editor_muctieudt_chnn['text'] = $ctdt->cohoi_nghenghiep;

        $defaultData->txt_tgdt = $ctdt->thoigian_daotao;
        $defaultData->txt_klkt = $ctdt->khoiluong_kienthuc;
        $defaultData->txt_dtts = $ctdt->doituong_tuyensinh;
        $defaultData->editor_qtdt['text'] = $ctdt->quytrinh_daotao;
        $defaultData->editor_dktn['text'] = $ctdt->dieukien_totnghiep;

        $defaultData->txt_tct = $ctdt->mota;
        $defaultData->select_caykkt = $ctdt->ma_cay_khoikienthuc;

        $mform->set_data($defaultData);

        $mform->display();
    } else if($mform->get_submit_value('ma_ctdt') == NULL){
        echo 'Không tìm thấy mã CTDT';
        echo '<br>';
        $url = new \moodle_url('/blocks/educationpgrs/pages/ctdt/index.php', ['courseid' => $courseid]);
        $linktext = 'Trở về';
        echo \html_writer::link($url, $linktext);
    }
    
    // $mform->display();
}

function validateData()
{
    return true;
}


// Print footer
echo $OUTPUT->footer();
