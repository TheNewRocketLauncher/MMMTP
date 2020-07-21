<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');

global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/xsdasdasdem_bacdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_decuong', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_decuong', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('head_decuong', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
$id = optional_param('id', 0, PARAM_INT);
$ma_decuong = optional_param('ma_decuong', '', PARAM_ALPHANUMEXT);
$ma_ctdt = optional_param('ma_ctdt', '', PARAM_ALPHANUMEXT);
$mamonhoc = optional_param('mamonhoc', '', PARAM_ALPHANUMEXT);
$ma_cdr = get_chuandaura_from_id($id);
//echo($ma_cdr);
//echo($ma_decuong);
require_once('../../form/decuongmonhoc/them_decuongmonhoc_form.php');
$chitietmh = get_chuandaura_monhoc_by_madc_ma_cdr($ma_decuong, $ma_cdr);
//echo json_encode($chitietmh);
//echo'<br>';
$mform = new update_chuandaura_decuongmonhoc_form();

// Process form
if ($mform->is_cancelled()) {
    // Handle form cancel operation
} else if($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    $param1 = new stdClass();

    $param1->id = $fromform->id;
    $param1->ma_cdr = $chitietmh->ma_cdr;
    $param1->mamonhoc = $fromform->mamonhoc;
    $param1->ma_decuong = $fromform->ma_decuong;
    $param1->mota = $fromform->mota_chuandaura;
    $param1->mucdo_introduce = 1;
    $param1->mucdo_teach = 1;
    $param1->mucdo_utilize = $fromform->mucdo_itu_chuandaura;
    //echo json_encode($param1);

    update_chuandaura_monhoc_table($param1);
    
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    // Link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/them_decuongmonhoc.php', ['ma_ctdt'=>$ma_ctdt, 'mamonhoc'=>$mamonhoc, 'ma_decuong'=>$ma_decuong]);
    echo \html_writer::link($url, 'Trở về trang trước');
} else if ($mform->is_submitted()) {
    // Button submit
} else {
    //Set default data from DB
    $toform;
    $toform->id = $chitietmh->id;
    $toform->chuandaura = $chitietmh->ma_cdr;
    $toform->mamonhoc = $mamonhoc;
    $toform->ma_decuong = $ma_decuong;
    $toform->mota_chuandaura = $chitietmh->mota;
    //$toform->ma_ctdt = $ma_ctdt;
    $toform->mucdo_itu_chuandaura = $chitietmh->mucdo_utilize;    
    //echo json_encode($toform);
    $mform->set_data($toform);  
    $mform->display();
}

// Print footer
echo $OUTPUT->footer();
