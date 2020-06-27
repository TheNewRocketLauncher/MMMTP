<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/ctdt_model.php');

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
$PAGE->set_title(get_string('themctdt_title', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('themctdt_head', 'block_educationpgrs'));

// Print header
echo $OUTPUT->header();

///-------------------------------------------------------------------------------------------------------///
// Tạo form
require_once('../../form/ctdt/newctdt_form.php');
$mform = new newctdt_form();

// Form processing
if ($mform->is_cancelled()) {
    // Button cancel    
} else if ($mform->no_submit_button_pressed()) {
    if ($mform->_form->get_submit_value('btnchoosetree')) {
        // Something here
    }
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    if (validateData()) {
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
        $param->muctieu_daotao = "a";
        $param->thoigian_daotao = $fromform->tgdt;
        $param->khoiluong_kienthuc = $fromform->klkt;
        $param->doituong_tuyensinh = $fromform->dtts;
        $param->quytrinh_daotao = "a";
        $param->dienkien_totnghiep = $fromform->bacdt;
        $param->ma_cay_khoikienthuc = "dda";
        $param->mota = "ad";
        insert_ctdt($param);
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/ctdt/index.php");
    }
    $mform->display();
} else {
    $mform->set_data($toform);
    $mform->display();
}

function validateData()
{
    return true;
}

// Footer
echo $OUTPUT->footer();