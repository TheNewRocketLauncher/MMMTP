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
require_permission("monhoc", "edit");

$id = optional_param('id', 0, PARAM_INT);
$chitietmh = get_monhoc_by_id_monhoc($id);

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/xsdasdasdem_bacdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_monhoc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php'));
$PAGE->navbar->add($chitietmh->tenmonhoc_vi, new moodle_url('/blocks/educationpgrs/pages/monhoc/chitiet_monhoc.php?id=' . $chitietmh->id));

// Title.
$PAGE->set_title('Chi tiết môn học');
$PAGE->set_heading('[' . $chitietmh->mamonhoc . ']' . $chitietmh->tenmonhoc_vi);
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/decuongmonhoc/chitiet_monhoc_form.php');

// Thêm đề cương
$url = new \moodle_url('them_decuongmonhoc.php', ['id' => $id]);
echo \html_writer::link($url, 'Thêm đề cương môn học');
echo '<br>';
// // Button xóa đề cương
// echo html_writer::tag('button', 'Xóa đề cương môn học', array('id' => 'btn_delete_decuong'));
// $url1 = new \moodle_url('update_monhoc.php', ['id' => $id]);

// Cập nhật nội dụng
$url1 = new \moodle_url('upate_monhoc.php', ['id' => $id]);
echo \html_writer::link($url1, 'Cập nhật nội dung môn học');
echo '<br>';
$mform = new chitiet_monhoc_form();

// Form processing
if ($mform->is_cancelled()) {
    // Handle form cancel operation
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Thực hiện insert */
    // Param
    $param1 = new stdClass();
    $param1->id = $mform->get_data()->idhe; // The data object must have the property "id" set.
    $index_mabac = $mform->get_data()->mabac;
    $allbacdts = $DB->get_records('eb_bacdt', []);
    $param1->ma_bac = $allbacdts[$index_mabac + 1]->ma_bac;
    $param1->ma_he = $mform->get_data()->mahe;
    $param1->ten = $mform->get_data()->tenhe;
    $param1->mota = $mform->get_data()->mota;
    update_hedt($param1);
    // Hiển thị thêm thành công
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    // Edit file index.php tương ứng trong thư mục page, link đến đường dẫn
    $url = new \moodle_url('/blocks/educationpgrs/pages/hedt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_hedt', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    // Button submit
} else {
    //Set default data from DB
    $toform;
    $toform->id_monhoc = $chitietmh->id;
    $toform->mamonhoc = $chitietmh->mamonhoc;
    $toform->tenmonhoc_vi = $chitietmh->tenmonhoc_vi;
    $toform->tenmonhoc_en = $chitietmh->tenmonhoc_en;
    $toform->sotinchi = $chitietmh->sotinchi;
    $toform->sotiet_LT = $chitietmh->sotietlythuyet;
    $toform->sotiet_TH = $chitietmh->sotietthuchanh;
    $toform->sotiet_BT = $chitietmh->sotiet_baitap;
    $toform->loaihocphan = $chitietmh->loaihocphan;
    $toform->ghichu = $chitietmh->ghichu;
    $toform->mota = $chitietmh->mota;
    
    $mform->set_data($toform);
    $mform->display();
}

// Print footer
echo $OUTPUT->footer();